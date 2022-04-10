<?php
add_shortcode('msfb_ui','msfb_ui_callback');
function msfb_ui_callback(){
	ob_start();
    wp_enqueue_style( 'msfb_admin_tailwind' );
	include(MSFB_PATH.'core/shortcode-templates/text-field.php');
	return ob_get_clean();
}