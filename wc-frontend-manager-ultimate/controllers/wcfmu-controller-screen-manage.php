<?php
/**
 * WCFMu plugin controllers
 *
 * Plugin Screen Manage Controller
 *
 * @author  WC Lovers
 * @package wcfmu/controllers
 * @version 2.3.7
 */

class WCFMu_Screen_Manage_Controller
{


    public function __construct()
    {
        global $WCFM, $WCFMu;

        $this->processing();

    }//end __construct()


    public function processing()
    {
        global $WCFM, $WCFMu, $wpdb, $_POST;

        $wcfm_screen_manager_form_data = [];
        parse_str($_POST['wcfm_screen_manager_form'], $wcfm_screen_manager_form_data);

        $wcfm_screen = '';
        if (isset($wcfm_screen_manager_form_data['wcfm_screen'])) {
            $wcfm_screen = $wcfm_screen_manager_form_data['wcfm_screen'];
            if ($wcfm_screen) {
                $wcfm_screen_manager = (array) get_option('wcfm_screen_manager');
                if (isset($wcfm_screen_manager_form_data['wcfm_screen_manager']) && isset($wcfm_screen_manager_form_data['wcfm_screen_manager'][$wcfm_screen])) {
                    if (! isset($wcfm_screen_manager_form_data['wcfm_screen_manager'][$wcfm_screen]['admin'])) {
                        $wcfm_screen_manager_form_data['wcfm_screen_manager'][$wcfm_screen]['admin'] = [];
                    }

                    if (! isset($wcfm_screen_manager_form_data['wcfm_screen_manager'][$wcfm_screen]['vendor'])) {
                        $wcfm_screen_manager_form_data['wcfm_screen_manager'][$wcfm_screen]['vendor'] = [];
                    }

                    $wcfm_screen_manager[$wcfm_screen] = $wcfm_screen_manager_form_data['wcfm_screen_manager'][$wcfm_screen];
                    update_option('wcfm_screen_manager', $wcfm_screen_manager);
                    echo '{"status": true, "message": "'.__('Screen update successfully', 'wc-frontend-manager-ultimate').'"}';
                } else {
                    $wcfm_screen_manager[$wcfm_screen] = [];
                    update_option('wcfm_screen_manager', $wcfm_screen_manager);
                    echo '{"status": true, "message": "'.__('Screen update successfully', 'wc-frontend-manager-ultimate').'"}';
                }
            } else {
                echo '{"status": false, "message": "'.__('Screen update failed', 'wc-frontend-manager-ultimate').'"}';
            }//end if
        } else {
            echo '{"status": false, "message": "'.__('Screen update failed', 'wc-frontend-manager-ultimate').'"}';
        }//end if

        die;

    }//end processing()


}//end class
