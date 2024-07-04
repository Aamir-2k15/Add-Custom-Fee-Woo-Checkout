<?php 
/*
Plugin Name: Add Custom Fee to woocommerce
Plugin URI: 
Description: Add Custom Fee to woocommerce cart on checkout
Author: Aamir
Version: 1
Author URI: n/a
*/
if(!defined('ABSPATH')){ die(); }

//A. CONTROLS
 
/* 
// Register a custom menu page
function custom_admin_page() {
    add_menu_page(
        'Custom Fee', // Page title 
        'Custom Fee', // Menu title
        'manage_options', // Capability required
        'custom-admin-page', // Menu slug
        'custom_fee_addition_content' // Callback function to display content
    );
}
add_action('admin_menu', 'custom_admin_page');


// Callback function to display content
function custom_fee_addition_content() {
    ?>
<div class="wrap">
    <h1>Add Custom Fee to WooCommerce Checkout</h1>
    <form method="post" id="dex_options">


        <fieldset>
            <legend>Settings</legend>

            <table width="100%">
                <tr>
                    <td><label>Fee Name: </label></td>
                    <td><input type="text" name="fee_name"></td>
                </tr>
                <tr>
                    <td><label>Fee Amount: </label></td>
                    <td><input type="text" name="fee_amount"></td>
                </tr>
                <tr>
                    <td> </td>
                    <td><input type="submit" name="submit_settings" id="submit_settings"></td>
                </tr>
            </table>

        </fieldset>


        <?php 
            do_settings_sections('custom-admin-page');
            submit_button();
            ?>
    </form>
</div>
<?php
}*/


 
//B. FUNCTIONS
add_action('template_redirect', 'my_custom_function');
function my_custom_function() {
    if (is_checkout()) {
        add_action('wp_footer','dex_footer_funct');
        function dex_footer_funct(){
            ob_start();?>
<script>
(function($) {
    $(document).ready(function() {
        // ajax_funct
        function AJAX_function_1(target, admin_ajax_url, action, type, data_type) {
            jQuery.ajax({
                url: admin_ajax_url + '?action=' + action,
                type: type,
                dataType: data_type,
            }).done(function(response) {
                setTimeout(function() {
                    $('body').trigger('update_checkout');
                }, 1800);
            }); //ajax done
        }
        //
        let admin_ajax_url = '<?php echo admin_url('admin-ajax.php'); ?>';

        let type = 'POST';
        let data_type = 'JSON';
        let target = 'tr.cart-subtotal';

        AJAX_function_1(target, admin_ajax_url, 'yes_artwork', type, data_type);



        $(document).on('change', 'input[name="radio-951"]', function() {
            let its_val = $(this).val();
            let the_fee;
            if (its_val == 'Yes') {
                the_fee = 1000;

                AJAX_function_1(target, admin_ajax_url, 'yes_artwork', type, data_type);
            } else {
                the_fee = 8000;
                let data = {
                    fee_name: 'Artwork Fee',
                    fee_amount: the_fee
                };

                AJAX_function_1(target, admin_ajax_url, 'no_artwork', type, data_type);
            }


        }); //ends on change radio



    });
})(jQuery);
</script>
<?php 
            $script = ob_get_clean();
            echo $script;
        }
    } 
}
/////////////////////

add_action('woocommerce_cart_calculate_fees', 'add_artwork_fee');
function add_artwork_fee(){
    if (WC()->session->get('no_artwork') == 'yes') {
        $fee_amount = 1000;
    } else {
        $fee_amount = 8000;
    }
    
    WC()->cart->add_fee( 'Artwork Fee', $fee_amount, false, '' );
}

add_action('wp_ajax_yes_artwork', 'set_artwork_flag');
add_action('wp_ajax_nopriv_yes_artwork', 'set_artwork_flag', 10);

function set_artwork_flag() {
    WC()->session->set('no_artwork', 'yes');
    wp_send_json_success();
}

add_action('wp_ajax_no_artwork', 'unset_artwork_flag');
add_action('wp_ajax_nopriv_no_artwork', 'unset_artwork_flag', 10);

function unset_artwork_flag() {
    WC()->session->set('no_artwork', 'no');
    wp_send_json_success();
}

 









// Plugin activation hook
register_activation_hook( __FILE__, 'my_plugin_activation' );

function my_plugin_activation() {
  update_option( 'dex_custom_woo_fee_plugin_activated', time() );
}

// Plugin deactivation hook
register_deactivation_hook( __FILE__, 'my_plugin_deactivation' );

function my_plugin_deactivation() {
   update_option( 'dex_custom_woo_fee_plugin_activated', time() );
}

register_uninstall_hook( __FILE__,   'uninstall_func' );

function uninstall_func(){
    delete_option('dex_custom_woo_fee_plugin_activated');
    delete_option('dex_custom_woo_fee_plugin_activated');
}