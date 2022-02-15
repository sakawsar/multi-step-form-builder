<?php
add_action('wp_enqueue_scripts','msfb_enqueue_scripts');
function msfb_enqueue_scripts(){
	//js
	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'msfb_jquery_step', MSFB_URL.'assets/js/jquery.steps.min.js' );
	wp_enqueue_script( 'msfb_jquery_ui_touch_punch', MSFB_URL.'assets/js/jquery.ui.touch-punch.min.js' );
	wp_enqueue_script( 'msfb_main', MSFB_URL.'assets/js/main.js' );
	//css
	wp_enqueue_style( 'msfb_jquery_steps_css', MSFB_URL.'assets/css/jquery.steps.css' );
	wp_enqueue_style( 'msfb_style', MSFB_URL.'assets/css/style.css' );
}
// admin enqueue
add_action('admin_enqueue_scripts','msfb_admin_enqueue_scripts');
function msfb_admin_enqueue_scripts(){
	//js
	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'msfb-jquery-ui', MSFB_URL.'admin/js/jquery-ui.js' );
	wp_enqueue_script( 'msfb_admin_jquery_step', MSFB_URL.'admin/js/jquery.steps.min.js' );
	wp_enqueue_script( 'msfb_admin_jquery_ui_touch_punch', MSFB_URL.'admin/js/jquery.ui.touch-punch.min.js' );
	wp_enqueue_script( 'msfb_admin_localize', MSFB_URL.'admin/js/localize.js' );
	global $wpdb;
	$form_table = $wpdb->prefix.'msfb_forms';
	$question_table = $wpdb->prefix.'msfb_questions';
	$all_questions = $wpdb->get_results("SELECT * FROM $question_table",ARRAY_A);
	$all_questions = array_map(function($a_qtn){
		$a_qtn['question_data'] = json_decode( stripcslashes($a_qtn['question_data']), true );
		return $a_qtn;
	}, $all_questions);
	$all_forms = $wpdb->get_results("SELECT * FROM $form_table",ARRAY_A);
	$all_forms = array_map(function($a_frm){
		$a_frm['form_data'] = json_decode( stripcslashes($a_frm['form_data']), true );
		return $a_frm;
	}, $all_forms);
	wp_localize_script( 'msfb_admin_localize', 'msfb', array(
		'ajax_url' => admin_url( 'admin-ajax.php' ),
		'max_rows' => 2,
		'all_questions' => $all_questions,
		'all_forms' => $all_forms
	));
	wp_enqueue_script( 'msfb_admin_main', MSFB_URL.'admin/js/main.js', array(), false, true );
	wp_enqueue_script( 'msfb_admin_form_builder', MSFB_URL.'admin/js/form-builder.js', array(), false, true );
	wp_enqueue_script( 'msfb_admin_ajax', MSFB_URL.'admin/js/ajax.js', array(), false, true );
	wp_enqueue_script( 'msfb_fontawesome_icons', MSFB_URL.'admin/js/fontawesome.js', array(), false, false );
	wp_enqueue_script( 'msfb_admin_select2', MSFB_URL.'admin/js/select2.min.js' );
	wp_enqueue_script( 'msfb_admin_swal2', 'https://cdn.jsdelivr.net/npm/sweetalert2@9' );
	// wp_enqueue_script( 'msfb_admin_drawflow_js', 'https://cdn.jsdelivr.net/gh/jerosoler/Drawflow/dist/drawflow.min.js' );
	wp_enqueue_script( 'msfb_admin_drawflow_js', MSFB_URL.'admin/src/drawflow_lib.js', array(), false, true );
	wp_enqueue_script( 'msfb_admin_micromodal', 'https://unpkg.com/micromodal/dist/micromodal.min.js' );
	wp_enqueue_script( 'msfb_admin_drawflow_script_js', MSFB_URL.'admin/js/drawflow.js', array(), false, true );
	//css
	wp_register_style( 'msfb_admin_global', MSFB_URL.'admin/css/global.css' );
	wp_register_style( 'msfb_admin_fontawesome', 'https://pro.fontawesome.com/releases/v5.10.0/css/all.css' );
	wp_register_style( 'msfb_admin_jquery_ui_css', MSFB_URL.'admin/css/jquery-ui.css' );
	wp_register_style( 'msfb_admin_jquery_steps', MSFB_URL.'admin/css/jquery.steps.css' );
	wp_register_style( 'msfb_admin_select2', MSFB_URL.'admin/css/select2.min.css' );
	wp_register_style( 'msfb_admin_style', MSFB_URL.'admin/css/style.css' );
	wp_register_style( 'msfb_admin_drawflow_style', MSFB_URL.'admin/css/drawflow.css' );
	// wp_register_style( 'msfb_admin_drawflow_style', 'https://cdn.jsdelivr.net/gh/jerosoler/Drawflow@0.0.48/dist/drawflow.min.css' );
	wp_register_style( 'msfb_admin_drawflow_beautiful', MSFB_URL.'admin/css/drawflow-beautiful.css' );
}
function msfb_enqueue_style(){
	wp_enqueue_style( 'msfb_admin_global' );
	wp_enqueue_style( 'msfb_admin_fontawesome' );
	wp_enqueue_style( 'msfb_admin_jquery_ui_css' );
	wp_enqueue_style( 'msfb_admin_jquery_steps' );
	wp_enqueue_style( 'msfb_admin_select2' );
	wp_enqueue_style( 'msfb_admin_style' );
	wp_enqueue_style( 'msfb_admin_drawflow_style' );
}