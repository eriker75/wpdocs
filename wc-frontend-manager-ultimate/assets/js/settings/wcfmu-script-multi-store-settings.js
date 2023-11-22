"use strict";

var vendorMultiStoreHandler = (function($, D) {
    var _el = {};
    var _pvt = {
        cacheDom: function cacheDom() {
            _el.$body                   = $(D.body);
            _el.$multiStoreContainer    = $( '.wcfm_marketplace_store_multi_location_settings' );
            _el.$multiStoreHeader       = _el.$multiStoreContainer.find( '.wcfm_vendor_settings_heading' );
            _el.$locationTableContainer = _el.$multiStoreContainer.find('#wcfmmp_settings_branch_list');
            _el.$locationTable          = _el.$locationTableContainer.find('.store-locations-table');
            _el.$editLocationContainer  = _el.$locationTableContainer.find('#vendor_edit_branch');

            _el.$addLocation     = _el.$multiStoreHeader.find('#wcfm_add_branch');
            _el.$editLocation    = _el.$locationTable.find('.wcfm_store_branch_edit');
            _el.$deleteLocation  = _el.$locationTable.find('.wcfm_store_branch_delete');
            _el.$markMainBranch  = _el.$locationTable.find('.mark-main-branch');
            _el.$offersShipping  = _el.$locationTable.find('.branch-offers-shipping');
            _el.$offersPickup    = _el.$locationTable.find('.branch-offers-pickup');
            _el.$pageCollapsible = $( '#wcfm_settings_form .page_collapsible:not(#wcfm_settings_multi_location_head)' );
            return this;
        },
        bindEvents: function bindEvents() {
            _el.$addLocation.on( 'click', _pvt.manageLocation );
            _el.$locationTable.on('click', '.wcfm_store_branch_edit', _pvt.manageLocation );
            _el.$locationTable.on('click', '.wcfm_store_branch_delete', _pvt.deleteLocation );
            _el.$locationTable.on('click', '.mark-main-branch', _pvt.markMainBranch );
            _el.$locationTable.on('change', '.branch-offers-shipping', _pvt.canShipFromBranch );
            _el.$locationTable.on('change', '.branch-offers-pickup', _pvt.canPickupFromBranch );

            _el.$editLocationContainer.on( 'click', '.branch-header-wrap a.back', _pvt.goBackToBranchList );
            _el.$editLocationContainer.on( 'click', '.branch-header-wrap a.submit', _pvt.submitBranch );
            _el.$editLocationContainer.on( 'change', '#b_country', _pvt.reloadState );
            
            _el.$body.on('wcfm_store_branch_edit_screen_loaded', _pvt.addressInit);
            _el.$body.on('wcfm_store_branch_edit_screen_loaded', _pvt.mapInit);
            _el.$body.on('wcfm_store_branch_map_init_complete', _pvt.resetCollapsHeightWrapper);
            _el.$body.on('marker_position_updated', _pvt.updateSearchFields);

            _el.$pageCollapsible.on('click', _pvt.restoreSaveBtnState);

            return this;
        },
        manageLocation: function manageLocation(e) {
            e.preventDefault();
            _el.$multiStoreContainer.block({
                message: null,
                overlayCSS: {
                    background: '#fff',
                    opacity: 0.6
                }
            });
            var reqData = $(this).data('branch'); 
            if($(this).data('vendorId')) {
                var reqData = {'store_id': $(this).data('vendorId')};
            }
            var data = {
                action         : 'wcfmu_store_branch_html',
                data           : reqData,
                wcfm_ajax_nonce: wcfm_params.wcfm_ajax_nonce,
            };
            $.ajax({
                type: 'post',
                url: wcfm_params.ajax_url,
                data: data,
                success: function (response) {
					$('.wcfm-message').html('').removeClass('wcfm-error').removeClass('wcfm-success').slideUp();
                    if (response.success) {
                        _el.$editLocationContainer.html(response.data);
                        _el.$multiStoreHeader.hide();
                        _el.$locationTable.hide();
                        _el.$editLocationContainer.show();
			            _el.$body.trigger( 'wcfm_store_branch_edit_screen_loaded', [_el.$multiStoreContainer] );
                    } else {
                        $("#wcfm_settings_form .wcfm-message, #wcfm_settings_form_store_multi_location_expander .wcfm-message")
						.html(
							'<span class="wcicon-status-cancelled"></span>' +
								response.data
						)
						.addClass("wcfm-error")
                        .slideDown();
                        wcfmMessageHide();
                    }
                    _el.$multiStoreContainer.unblock();
                    $('#wcfm_settings_save_button').prop('disabled', true);
                }
            });
            resetCollapsHeight( _el.$multiStoreContainer );
        },
        deleteLocation: function deleteLocation(e) {
            e.preventDefault();
            var confirmationMessage = wcfmu_mb.i18n.confirm_delete;
            if($(e.target).closest('tr').find('.main-branch').length) {
                confirmationMessage = wcfmu_mb.i18n.confirm_main_branch_delete;
            }
            var confirmAction = confirm(confirmationMessage);
            if(!confirmAction) return;
            _el.$multiStoreContainer.block({
                message: null,
                overlayCSS: {
                    background: '#fff',
                    opacity: 0.6
                }
            });
            var $record = $(this).closest('tr');
            var data = {
                action         : 'wcfmu_store_delete_branch',
                data           : { branch_id: $(this).data('branchId'), store_id: _el.$locationTable.data('vendorId') },
                wcfm_ajax_nonce: wcfm_params.wcfm_ajax_nonce,
            };
            $.ajax({
                type: 'post',
                url: wcfm_params.ajax_url,
                data: data,
                success: function (response) {
					$('.wcfm-message').html('').removeClass('wcfm-error').removeClass('wcfm-success').slideUp();
                    if (response.success) {
                        var bCount = $record.closest('tbody').find('tr').length;
                        $record.remove();
                        if(bCount>1) {
                            var mBranchId = response.data.branch.main_branch;
                            var prevmBranchId = _el.$locationTable.find('.mark-main-branch.main-branch').data('branchId');
                            if(mBranchId != prevmBranchId) {
                                _el.$locationTable.find('.mark-main-branch').filter('.main-branch').html('&#9734;').removeClass('main-branch');
                                _el.$locationTable.find('.mark-main-branch').filter('[data-branch-id="' + mBranchId + '"]').html('&#9733;').addClass('main-branch');
                            }
                        } else {
                            var tr = '<tr>' +
                            '<td colspan="3">' + wcfmu_mb.i18n.no_branch + '</td>' +
                            '</tr>';
                            _el.$locationTable.append(tr);
                        }
                        $("#wcfm_settings_form .wcfm-message, #wcfm_settings_form_store_multi_location_expander .wcfm-message")
						.html(
							'<span class="wcicon-status-completed"></span>' +
								response.data.msg
						)
						.addClass("wcfm-success")
                        .slideDown();
                    } else {
                        $("#wcfm_settings_form .wcfm-message, #wcfm_settings_form_store_multi_location_expander .wcfm-message")
						.html(
							'<span class="wcicon-status-cancelled"></span>' +
								response.data
						)
						.addClass("wcfm-error")
                        .slideDown();
                    }
                    wcfmMessageHide();
                    _el.$multiStoreContainer.unblock();
                }
            });
        },
        markMainBranch: function markMainBranch(e) {
            e.preventDefault();
            if($(this).hasClass('main-branch')) {
                alert(wcfmu_mb.i18n.is_main_branch);
            } else {
                var confirmAction = confirm(wcfmu_mb.i18n.switch_main_branch);
                if(!confirmAction) return;
                _el.$multiStoreContainer.block({
                    message: null,
                    overlayCSS: {
                        background: '#fff',
                        opacity: 0.6
                    }
                });
                var data = {
                    action         : 'wcfmu_mark_branch_as_main',
                    data           : { branch_id: $(this).data('branchId'), store_id: _el.$locationTable.data('vendorId') },
                    wcfm_ajax_nonce: wcfm_params.wcfm_ajax_nonce,
                };
                $.ajax({
                    type: 'post',
                    url: wcfm_params.ajax_url,
                    data: data,
                    success: function (response) {
                        $('.wcfm-message').html('').removeClass('wcfm-error').removeClass('wcfm-success').slideUp();
                        if (response.success) {
                            _el.$locationTable.find('.mark-main-branch').filter('.main-branch').html('&#9734;').removeClass('main-branch');
                            _el.$locationTable.find('.mark-main-branch').filter('[data-branch-id="' + data.data.branch_id + '"]').html('&#9733;').addClass('main-branch');
                            $("#wcfm_settings_form .wcfm-message, #wcfm_settings_form_store_multi_location_expander .wcfm-message")
                            .html(
                                '<span class="wcicon-status-completed"></span>' +
                                    response.data
                            )
                            .addClass("wcfm-success")
                            .slideDown();
                        } else {
                            $("#wcfm_settings_form .wcfm-message, #wcfm_settings_form_store_multi_location_expander .wcfm-message")
                            .html(
                                '<span class="wcicon-status-cancelled"></span>' +
                                    response.data
                            )
                            .addClass("wcfm-error")
                            .slideDown();
                        }
                        wcfmMessageHide();
                        _el.$multiStoreContainer.unblock();
                    }
                });
            }
        },
        canShipFromBranch: function canShipFromBranch(e) {
            e.preventDefault();
            var confirmAction = confirm(wcfmu_mb.i18n.toggle_shipping);
            if(!confirmAction) {
                $(e.target).prop('checked', !e.target.checked);
                return;
            } 
            _el.$multiStoreContainer.block({
                message: null,
                overlayCSS: {
                    background: '#fff',
                    opacity: 0.6
                }
            });
            var data = {
                action         : 'wcfmu_toggle_branch_shipping',
                data           : { branch_id: $(e.target).val(), store_id: _el.$locationTable.data('vendorId'), can_ship: Number(e.target.checked) },
                wcfm_ajax_nonce: wcfm_params.wcfm_ajax_nonce,
            };
            $.ajax({
                type: 'post',
                url: wcfm_params.ajax_url,
                data: data,
                success: function (response) {
                    $('.wcfm-message').html('').removeClass('wcfm-error').removeClass('wcfm-success').slideUp();
                    if (response.success) {
                        $("#wcfm_settings_form .wcfm-message, #wcfm_settings_form_store_multi_location_expander .wcfm-message")
                        .html(
                            '<span class="wcicon-status-completed"></span>' +
                                response.data
                        )
                        .addClass("wcfm-success")
                        .slideDown();
                    } else {
                        $(e.target).prop('checked', !e.target.checked);
                        $("#wcfm_settings_form .wcfm-message, #wcfm_settings_form_store_multi_location_expander .wcfm-message")
                        .html(
                            '<span class="wcicon-status-cancelled"></span>' +
                                response.data
                        )
                        .addClass("wcfm-error")
                        .slideDown();
                    }
                    wcfmMessageHide();
                    _el.$multiStoreContainer.unblock();
                }
            });
        },
        canPickupFromBranch: function canPickupFromBranch(e) {
            e.preventDefault();
            var confirmAction = confirm(wcfmu_mb.i18n.toggle_pickup);
            if(!confirmAction) {
                $(e.target).prop('checked', !e.target.checked);
                return;
            } 
            _el.$multiStoreContainer.block({
                message: null,
                overlayCSS: {
                    background: '#fff',
                    opacity: 0.6
                }
            });
            var data = {
                action         : 'wcfmu_toggle_branch_pickup',
                data           : { branch_id: $(e.target).val(), store_id: _el.$locationTable.data('vendorId'), can_pickup: Number(e.target.checked) },
                wcfm_ajax_nonce: wcfm_params.wcfm_ajax_nonce,
            };
            $.ajax({
                type: 'post',
                url: wcfm_params.ajax_url,
                data: data,
                success: function (response) {
                    $('.wcfm-message').html('').removeClass('wcfm-error').removeClass('wcfm-success').slideUp();
                    if (response.success) {
                        $("#wcfm_settings_form .wcfm-message, #wcfm_settings_form_store_multi_location_expander .wcfm-message")
                        .html(
                            '<span class="wcicon-status-completed"></span>' +
                                response.data
                        )
                        .addClass("wcfm-success")
                        .slideDown();
                    } else {
                        $(e.target).prop('checked', !e.target.checked);
                        $("#wcfm_settings_form .wcfm-message, #wcfm_settings_form_store_multi_location_expander .wcfm-message")
                        .html(
                            '<span class="wcicon-status-cancelled"></span>' +
                                response.data
                        )
                        .addClass("wcfm-error")
                        .slideDown();
                    }
                    wcfmMessageHide();
                    _el.$multiStoreContainer.unblock();
                }
            });
        },
        goBackToBranchList: function goBackToBranchList(e) {
            e.preventDefault();
            _el.$editLocationContainer.hide();
            _el.$editLocationContainer.html('');
            _el.$multiStoreHeader.show();
            _el.$locationTable.show();
            $('#wcfm_settings_save_button').prop('disabled', false);
            resetCollapsHeight( _el.$locationTableContainer );
        },
        submitBranch: function submitBranch(e) {
            e.preventDefault();
            _el.$multiStoreContainer.block({
                message: null,
                overlayCSS: {
                    background: '#fff',
                    opacity: 0.6
                }
            });
            var branchData = {};
            $('#vendor_edit_branch').find('input,select').each( function() {
                if(this.name) {
                    branchData[this.name] = this.value;
                }
            });
            var data = {
                action         : 'wcfmu_store_submit_branch',
                data           : branchData,
                wcfm_ajax_nonce: wcfm_params.wcfm_ajax_nonce,
            };
            $.ajax({
                type: 'post',
                url: wcfm_params.ajax_url,
                data: data,
                success: function (response) {
					$('.wcfm-message').html('').removeClass('wcfm-error').removeClass('wcfm-success').slideUp();
                    if (response.success) {
                        var branchData = response.data.branch;
                        var branchFormattedAddress = response.data.branch_address;
                        var $branchCol = _el.$locationTable.find('.mark-main-branch[data-branch-id="'+branchData.ID+'"]');
                        if($branchCol.length) {
                            var $branchRow = $branchCol.closest('tr'),
                                tableColumns = _el.$locationTable.find('thead tr th').length;
                            $branchRow.find('td:nth-Child(1)').html(branchData.name || wcfmu_mb.i18n.name_placeholder);
                            $branchRow.find('td:nth-Child('+(tableColumns - 1)+')').html(branchFormattedAddress);
                            $branchRow.find('.wcfm_store_branch_edit').data('branch', branchData);
                        } else {
                            var rowCount = _el.$locationTable.find('tbody tr').length;
                            var mainBranchContent = '&#9734;';
                            var mainBranchClass = 'mark-main-branch';
                            if(rowCount == 1 && _el.$locationTable.find('tbody tr td').length == 1) {
                                _el.$locationTable.find('tbody tr').remove();
                                mainBranchContent = '&#9733;';
                                mainBranchClass += ' main-branch';
                            }
                            var tr = '<tr>' +
                                '<td>' + (branchData.name || wcfmu_mb.i18n.name_placeholder) + '</td>' +
                                '<td>' +
                                    '<a href="#" class="'+mainBranchClass+'" data-branch-id="'+branchData.ID+'" title="'+wcfmu_mb.i18n.mark_main_hint+'">'+mainBranchContent+'</a>' +
                                '</td>' +
                                (wcfmu_mb.is_allowed_shipping ? '<td>' + 
                                    '<input type="checkbox" class="wcfm-checkbox branch-offers-shipping input-checkbox" value="'+branchData.ID+'" title="'+wcfmu_mb.i18n.shipping_hint+'">' +
                                '</td>' : '') +
                                (wcfmu_mb.is_allowed_pickup ? '<td>' + 
                                    '<input type="checkbox" class="wcfm-checkbox branch-offers-pickup input-checkbox" value="'+branchData.ID+'" title="'+wcfmu_mb.i18n.pickup_hint+'">' +
                                '</td>' : '') +
                                '<td>' + branchFormattedAddress + '</td>' +
                                '<td>' + 
                                    '<a class="wcfm-action-icon wcfm_store_branch_edit" href="#" data-branch-id="'+branchData.ID+'" data-branch=\''+JSON.stringify(branchData)+'\'><span class="wcfmfa fa-edit text_tip" data-tip="'+wcfmu_mb.i18n.edit+'"></span></a>' +
                                    '<a class="wcfm-action-icon wcfm_store_branch_delete" href="#" data-branch-id="'+branchData.ID+'"><span class="wcfmfa fa-trash-alt text_tip" data-tip="'+wcfmu_mb.i18n.delete+'"></span></a>' +
                                '</td>' +
                                '</tr>';
                            _el.$locationTable.append(tr);
                        }
                        _pvt.initTip(_el.$locationTable.find('tr:last-child'));
                        _el.$editLocationContainer.find('#branch_id').val(branchData.ID);
                        _el.$editLocationContainer.find('a.add_new_wcfm_ele_dashboard span.text').text(wcfmu_mb.i18n.update);
                        _el.$editLocationContainer.find('a.add_new_wcfm_ele_dashboard').data('tip', wcfmu_mb.i18n.update);
                        
                        $("#wcfm_settings_form .wcfm-message, #wcfm_settings_form_store_multi_location_expander .wcfm-message")
						.html(
							'<span class="wcicon-status-completed"></span>' +
								response.data.msg
						)
						.addClass("wcfm-success")
                        .slideDown();
                    }  else {
                        $("#wcfm_settings_form .wcfm-message, #wcfm_settings_form_store_multi_location_expander .wcfm-message")
						.html(
							'<span class="wcicon-status-cancelled"></span>' +
								response.data
						)
						.addClass("wcfm-error")
                        .slideDown();
                    }
                    wcfmMessageHide();
                    _el.$multiStoreContainer.unblock();
                }
            });
        },
        initTip: function initTip($row) {
            $row.find('.wcfm-action-icon .text_tip').each( function() {
                $(this).qtip({
                    content: $(this).attr('data-tip'),
                    position: {
                        my: 'top center',
                        at: 'bottom center',
                        viewport: $(window)
                    },
                    show: {
                        solo: true,
                    },
                    hide: {
                        inactive: 60000,
                        fixed: true
                    },
                    style: {
                        classes: 'qtip-dark qtip-shadow qtip-rounded qtip-wcfm-css qtip-wcfm-core-css'
                    }
                });
            });
        },
        addressInit: function addressInit(e) {
            _el.$editLocationContainer.find('#b_country').select2().trigger('change');
        },
        reloadState: function reloadState(e) {
            var statesJson = wc_country_select_params.countries.replace( /&quot;/g, '"' ),
                states = $.parseJSON( statesJson ),
                $statebox = _el.$editLocationContainer.find( '#b_state' ),
                value = $statebox.val(),
                country = _el.$editLocationContainer.find('#b_country').val(),
                stateRequired = $statebox.data('required');

            if ( states[ country ] ) {
                if ( $.isEmptyObject( states[ country ] ) ) {
                    if ( $statebox.is( 'select' ) ) {
                        if( typeof stateRequired != 'undefined') {
                            $( 'select#b_state' ).replaceWith( '<input type="text" class="wcfm-text wcfm_ele" name="branch_state" id="b_state" data-required="1" data-required_message="'+wcfmu_mb.i18n.state_mandatory+'" />' );
                        } else {
                            $( 'select#b_state' ).replaceWith( '<input type="text" class="wcfm-text wcfm_ele" name="branch_state" id="b_state" />' );
                        }
                    }
                } else {
                    var options = '',
                        state = states[ country ],
                        selectedValue = '';

                    for ( var index in state ) {
                        if ( state.hasOwnProperty( index ) ) {
                            if ( value == index ) {
                                selectedValue = 'selected="selected"';
                            } else {
                                selectedValue = '';
                            }
                            options = options + '<option value="' + index + '"' + selectedValue + '>' + state[ index ] + '</option>';
                        }
                    }

                    if ( $statebox.is( 'select' ) ) {
                        $( 'select#b_state' ).html( '<option value="">' + wc_country_select_params.i18n_select_state_text + '</option>' + options );
                    }
                    if ( $statebox.is( 'input' ) ) {
                        if( typeof stateRequired != 'undefined') {
                            $( 'input#b_state' ).replaceWith( '<select class="wcfm-select wcfm_ele" name="branch_state" id="b_state" data-required="1" data-required_message="'+wcfmu_mb.i18n.state_mandatory+'"></select>' );
                        } else {
                            $( 'input#b_state' ).replaceWith( '<select class="wcfm-select wcfm_ele" name="branch_state" id="b_state"></select>' );
                        }
                        $( 'select#b_state' ).html( '<option value="">' + wc_country_select_params.i18n_select_state_text + '</option>' + options );
                    }
                }
            } else {
                if ( $statebox.is( 'select' ) ) {
                    if( typeof stateRequired != 'undefined') {
                        $( 'select#b_state' ).replaceWith( '<input type="text" class="wcfm-text wcfm_ele" name="branch_state" id="b_state" data-required="1" data-required_message="'+wcfmu_mb.i18n.state_mandatory+'" />' );
                    } else {
                        $( 'select#b_state' ).replaceWith( '<input type="text" class="wcfm-text wcfm_ele" name="branch_state" id="b_state" />' );
                    }
                }
            }
        },
        mapInit: function mapInit(e, $wrapperDiv) {
            var mapDivID  = 'wcfm-marketplace-branch-map';
            var branchLat = $wrapperDiv.find("#store_branch_lat").val();
            var branchLng = $wrapperDiv.find("#store_branch_lng").val();
            var mapOptions = typeof wcfm_marketplace_setting_map_options !== 'undefined' ? wcfm_marketplace_setting_map_options : {};
            wcfmLocation.init(mapOptions);
            wcfmLocation.map(mapDivID, branchLat, branchLng);
            wcfmLocation.search(_el.$editLocationContainer.find('#branch_find_address'));
            _el.$body.trigger( 'wcfm_store_branch_map_init_complete', [_el.$multiStoreContainer] );
        },
        resetCollapsHeightWrapper: function resetCollapsHeightWrapper(e, container) {
            resetCollapsHeight( container );
        },
        updateSearchFields: function updateSearchFields(e, type, coords, addrTxt, map) {
            if(type=='dragend') {
                if(map=='osm') {
                    _el.$editLocationContainer.find('.search-input').val(addrTxt);
                } else {
                    _el.$editLocationContainer.find('#branch_find_address').val(addrTxt);
                }
            }
            _el.$editLocationContainer.find('#branch_map_address').val(addrTxt);
            _el.$editLocationContainer.find('#store_branch_lat').val(coords.lat);
            _el.$editLocationContainer.find('#store_branch_lng').val(coords.lng);
        },
        restoreSaveBtnState: function restoreSaveBtnState() {
            if(_el.$editLocationContainer.find('.branch-header-wrap a.back').length) {
                setTimeout(function() {
                    _el.$editLocationContainer.find('.branch-header-wrap a.back').trigger('click');
                }, 501);
            }
        }
    };
    var _public = {
        init: function init( ) {
          _pvt.cacheDom().bindEvents();
        }
      }
      return _public;
})(jQuery, document);

var wcfmLocation = (function($) {
    var _lib = null;
    var _map    = null;
    var _marker = null;
    var _infowindow = null;
    var _default = {
        lat: null,
        lng: null,
        zoom: null,
        icon: null,
        iHeight: null,
        iWidth: null,
    };
    var _pvt = {
        setMapDefaults: function setMapDefaults(mapOptions) {
            _default.lat = mapOptions.default_lat || 0;
            _default.lng = mapOptions.default_lng || 0;
            _default.zoom = parseInt(mapOptions.default_zoom) || 15;
            _default.icon = mapOptions.store_icon || null;
            _default.iHeight = parseInt(mapOptions.icon_height) || 57;
            _default.iWidth = parseInt(mapOptions.icon_width) || 40;
        },
        setupLib: function setupLib(mapOptions) {
            this.setMapDefaults(mapOptions);
            _lib = wcfm_maps.lib === 'google' ? this.gMap() : this.osMap();
            return this;
        },
        gMap: function gMap() {
            return {
                getLatLng: function getLatLng(lat, lng) {
                    if (lat && lng) {
                        return new google.maps.LatLng( lat, lng );
                    }
                    return new google.maps.LatLng( _default.lat, _default.lng );
                },
                newMap: function newMap(divId, lat, lng) {
                    var latLng = this.getLatLng(lat, lng);
                    _map = new google.maps.Map(document.getElementById(divId), {
                        center: latLng,
                        mapTypeId: google.maps.MapTypeId.ROADMAP,
                        zoom: _default.zoom
                    });
                    _marker = this.addMarker(_map, latLng);
                    return _map;
                },
                addMarker: function addMarker(m, coords) {
                    var icon = _default.icon ? ({
                        url: _default.icon,
                        scaledSize: new google.maps.Size( _default.iWidth, _default.iHeight ), // scaled size
                    }) : null;
                    var marker = new google.maps.Marker({
                        map: m,
                        position: coords,
                        animation: google.maps.Animation.DROP,
                        icon: icon,
                        draggable: true,
                    });
                    _infowindow = new google.maps.InfoWindow();
                    google.maps.event.addListener(marker, 'click', this.showInfoWindow.bind(marker, m, _infowindow, 'click'));
                    google.maps.event.addListener(marker, 'dragend', this.showInfoWindow.bind(marker, m, _infowindow, 'dragend'));
                    return marker;
                },
                showInfoWindow: function showInfoWindow(map, infowindow, eventType) {
                    var geocoder = new google.maps.Geocoder();
                    var marker = this;
                    geocoder.geocode( {latLng: marker.getPosition()}, function(results, status) {
                        if (status == google.maps.GeocoderStatus.OK) {
                            if (results[0]) {    
                                infowindow.close();
                                infowindow.setContent(results[0].formatted_address);
                                infowindow.open({ anchor: marker, map: map, });
                                var position = { lat: marker.getPosition().lat(), lng: marker.getPosition().lng() };
                                $(document.body).trigger('marker_position_updated', [eventType, position, results[0].formatted_address, 'gmap']);
                            }
                        }
                    });
                },
                addSearch: function addSearch($searchInput) {
                    var $currentLocation = $searchInput.parent().find('i.wcfm-current-location');
                    $currentLocation.on('click', this.getCurrentLocation);

                    var autocomplete = new google.maps.places.Autocomplete($searchInput[0]);
                    autocomplete.bindTo('bounds', _map);
                    autocomplete.addListener('place_changed', this.onAutocomplete);
                },
                onAutocomplete: function onAutocomplete() {
                    var place = this.getPlace();
                    if (!place.geometry) { //@TODO support translation
                        _marker.setVisible(false);
                        window.alert(wcfmu_mb.i18n.autocomplete_failed);
                        return;
                    }
                    if (place.geometry.viewport) {
                        _map.fitBounds(place.geometry.viewport);
                    } else {
                        _map.setCenter(place.geometry.location);
                        _map.setZoom(_default.zoom);
                    }
                    _marker.setPosition(place.geometry.location);
                    _marker.setVisible(true);

                    _infowindow.close();
                    _infowindow.setContent(place.formatted_address);
                    _infowindow.open(_map, _marker);
                    var position = { lat: place.geometry.location.lat(), lng: place.geometry.location.lng() };
                    $(document.body).trigger('marker_position_updated', ['click', position, place.formatted_address, 'gmap']);
                },
                getCurrentLocation: function getCurrentLocation(e) {
                    var $container = $(this).closest('.wcfm-content');
                    $container.block({
                        message: null,
                        overlayCSS: {
                            background: '#fff',
                            opacity: 0.6
                        }
                    });
                    navigator.geolocation.getCurrentPosition( function( position) {
                        var geocoder = new google.maps.Geocoder();
                        var latLng = _lib.getLatLng(position.coords.latitude, position.coords.longitude);
                        geocoder.geocode( {latLng: latLng}, function(results, status) {
                            if (status == google.maps.GeocoderStatus.OK) {
                                if (results[0]) {    
                                    _marker.setPosition(latLng);
									_marker.setVisible(true);
                                    _infowindow.close();
                                    _infowindow.setContent(results[0].formatted_address);
                                    _infowindow.open({ anchor: _marker, map: _map, });
                                    var position = { lat: _marker.getPosition().lat(), lng: _marker.getPosition().lng() };
                                    $(document.body).trigger('marker_position_updated', ['dragend', position, results[0].formatted_address, 'gmap']);
                                }
                            }
                        });
                        $container.unblock();
                    },
                    function(err) {
                        alert(err.message);
                        $container.unblock();
                    });
                },
            }
        },
        osMap: function osMap() {
            return {
                getLatLng: function getLatLng(lat, lng) {
                    return (lat && lng) ? [lat, lng] : [_default.lat, _default.lng];
                },
                newMap: function newMap(divId, lat, lng) {
                    var latLng = this.getLatLng(lat, lng);
                    _map = new L.Map( divId, {
                        zoom: _default.zoom,
                        center: new L.latLng(latLng) 
                    });
                    _map.addLayer(new L.TileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png'));	//base layer
                    _marker = this.addMarker(_map, latLng);
                    return _map;
                },
                addMarker: function addMarker(m, coords) {
                    var marker = L.marker(coords, {draggable: 'true'}).addTo(m);
                    marker.on('click', this.showInfoWindow);
                    marker.on('dragend', this.showInfoWindow);
                    return marker;
                },
                showInfoWindow: function showInfoWindow(e) {
                    var position = e.target.getLatLng();
                    var jsonQuery = "https://nominatim.openstreetmap.org/reverse?format=json&lat=" + position.lat + "&lon=" + position.lng;
                    $.getJSON(jsonQuery).done(function(result_data) {
                        var addressTxt = result_data.display_name;
            			_marker.bindPopup(addressTxt).openPopup(position);
                        $(document.body).trigger('marker_position_updated', [e.type, position, addressTxt, 'osm'])
                    });
                },
                addSearch: function addSearch($searchInput) {
                    var $wrapper = $searchInput.parent();
                    var mapAddress = $searchInput.val();
                    var $currentLocation = $wrapper.find('i.wcfm-current-location');
                    $currentLocation.on('click', this.getCurrentLocation);
                    $searchInput.replaceWith( '<div id="leaflet_find_search_address" style="width: 60%; display: inline-block;"></div>' );
                    var searchControl = new L.Control.Search({
                        container: 'leaflet_find_search_address',
                        url: 'https://nominatim.openstreetmap.org/search?format=json&q={s}',
                        jsonpParam: 'json_callback',
                        propertyName: 'display_name',
                        propertyLoc: ['lat','lon'],
                        marker: _marker,
                        moveToLocation: function(latLng, title, map) {
                            _map.setView(latLng, _default.zoom);
                            _marker.closePopup().setLatLng(latLng).bindPopup(title).openPopup(latLng);
                            $(document.body).trigger('marker_position_updated', ['click', latLng, title, 'osm']);
                        },
                        initial: false,
                        collapsed:false,
                        autoType: false,
                        minLength: 2
                    });
                    _map.addControl( searchControl );  //inizialize search control
                    $wrapper.find('input.search-input').attr('name', 'branch_find_address').val(mapAddress);
                },
                getCurrentLocation: function getCurrentLocation(e) {
                    var $container = $(this).closest('.wcfm-content');
                    $container.block({
                        message: null,
                        overlayCSS: {
                            background: '#fff',
                            opacity: 0.6
                        }
                    });
                    navigator.geolocation.getCurrentPosition( function( position ) {
                        var jsonQuery = "https://nominatim.openstreetmap.org/reverse?format=json&lat=" + position.coords.latitude + "&lon=" + position.coords.longitude;
                        $.getJSON(jsonQuery).done(function(result_data) {
                            var addressTxt = result_data.display_name;
                            var latLng = {lat: position.coords.latitude, lng: position.coords.longitude};
                            _map.setView(latLng, _default.zoom);
                            _marker.closePopup().setLatLng(latLng).bindPopup(addressTxt).openPopup(latLng);
                            $(document.body).trigger('marker_position_updated', ['dragend', latLng, addressTxt, 'osm']);
                        });
                        $container.unblock();
                    },
                    function(err) {
                        alert(err.message);
                        $container.unblock();
                    });
                },
            }
        },
    };
    var _public = {
        init: function init(mapOptions) {
            _pvt.setupLib(mapOptions);
        },
        map: function map(divId, lat, lng) {
            _lib.newMap(divId, lat, lng);
        },
        search: function search($searchInput) {
            _lib.addSearch($searchInput);
        }
    }
    return _public;
})(jQuery);

jQuery( vendorMultiStoreHandler.init.bind( vendorMultiStoreHandler ) );
