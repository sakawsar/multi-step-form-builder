<?php
add_shortcode('msfb_ui','msfb_ui_callback');
function msfb_ui_callback(){
	ob_start();
	global $wpdb;
	$table_name = $wpdb->prefix.'msfb_formulations';
	$results = $wpdb->get_results("SELECT * FROM $table_name");
	$json_data = $results[0]->raw_data;
	// $json_data = $results[0]->formulation_data;
	$json_data = json_decode(stripslashes( $json_data ),true);
	$json_data = $json_data['drawflow']['Home']['data'];
	$json_data = array_map(function($data){
		unset($data['html']);
		return $data;
	},$json_data);
	$json_data = json_decode(stripslashes( $results[0]->formulation_data ),true);
	echo '<pre>';
	print_r( $json_data );
	echo '</pre>';
    wp_enqueue_style( 'msfb_admin_tailwind' );
	include(MSFB_PATH.'core/shortcode-templates/text-field.php');
	return ob_get_clean();
}