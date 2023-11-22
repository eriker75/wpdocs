jQuery(document).ready(function ($) {
	// Mark Featured - 3.0.1
	if ($("#wcfm_product_translations").length > 0) {
		var data = {
			action: "wcfm_product_translations",
			proid: $("#wcfm_product_translations").data("product_id"),
			wcfm_ajax_nonce: wcfm_params.wcfm_ajax_nonce,
		};
		jQuery.ajax({
			type: "POST",
			url: wcfm_params.ajax_url,
			data: data,
			success: function (response) {
				jQuery("#wcfm_product_translations").html(response);
				init_wcfm_product_new_translation();
			},
		});
	}

	function init_wcfm_product_new_translation() {
		$(".wcfm_product_new_translation").click(function (e) {
			e.preventDefault();
			jQuery("#wcfm_products_manage_form").block({
				message: null,
				overlayCSS: {
					background: "#fff",
					opacity: 0.6,
				},
			});
			var data = {
				action: "wcfm_product_new_translation",
				proid: $(this).data("proid"),
				trid: $(this).data("trid"),
				source_lang: $(this).data("source_lang"),
				lang: $(this).data("lang"),
				wcfm_ajax_nonce: wcfm_params.wcfm_ajax_nonce,
			};
			jQuery.ajax({
				type: "POST",
				url: wcfm_params.wc_ajax_url,
				data: data,
				success: function (response) {
					if (response) {
						if (response.status) {
							if (response.redirect) {
								window.location = response.redirect;
							}
						}
						jQuery("#wcfm_products_manage_form").unblock();
					}
				},
			});
			return false;
		});
	}
});
