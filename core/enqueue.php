<?php
add_action('wp_enqueue_scripts','msfb_enqueue_scripts');
function msfb_enqueue_scripts(){
	//js
	wp_enqueue_script( 'msfb_localize', MSFB_URL.'admin/js/localize.js' );
	$localize_data = array(
		'ajax_url' => admin_url( 'admin-ajax.php' ),
		'translate' => array(
			'form_data_successfully_submitted' => get_option('form_data_successfully_submitted','Form data successfully submitted.'),
			'this_option_did_not_point_to_any_other_question' => get_option('this_option_did_not_point_to_any_other_question','This option did not point to any other question.'),
			'select_an_option_first' => get_option('select_an_option_first','Select an option first.'),
			'field_is_required' => get_option('field_is_required','Field is required.'),
			'this_step_is_required' => get_option('this_step_is_required','This step is required'),
			'msfb_select_from_dropdown' => get_option('msfb_select_from_dropdown','Select from dropdown'),
			'finish' => get_option('msfb_translate_finish','Finish'),
		)
	);
	wp_localize_script( 'msfb_localize', 'msfb', $localize_data);
	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'msfb_jquery_step', MSFB_URL.'admin/js/jquery.steps.min.js' );
	// wp_enqueue_script( 'msfb_admin_swal2', 'https://cdn.jsdelivr.net/npm/sweetalert2@9' );
	wp_enqueue_script( 'msfb_admin_swal2_offline', MSFB_URL.'admin/js/swal2offline.js' );
	// wp_enqueue_script( 'msfb_waypoints', 'http://cdnjs.cloudflare.com/ajax/libs/waypoints/2.0.3/waypoints.min.js' );
	wp_enqueue_script( 'msfb_waypoints_offline', MSFB_URL.'admin/js/waypoints.js' );
	wp_enqueue_script( 'msfb_countup', MSFB_URL.'admin/js/countup.min.js' );
	wp_enqueue_script( 'msfb-jquery-ui', MSFB_URL.'admin/js/jquery-ui.js' );
	wp_enqueue_script( 'msfb_jquery_ui_touch_punch', MSFB_URL.'admin/js/jquery.ui.touch-punch.min.js' );
	wp_enqueue_script( 'msfb_main', MSFB_URL.'admin/js/main.js' );
	wp_enqueue_script( 'msfb_multiselect-nav', MSFB_URL.'admin/js/multistep-nav.js' );
	//css
	wp_register_style( 'msfb_admin_tailwind', MSFB_URL.'admin/css/tailwind.css' );
	wp_enqueue_style( 'msfb_jquery_steps_css', MSFB_URL.'assets/css/jquery.steps.css' );
	wp_enqueue_style( 'msfb_style', MSFB_URL.'assets/css/style.css' );
	wp_register_style( 'msfb_admin_fontawesome', 'https://pro.fontawesome.com/releases/v5.10.0/css/all.css' );
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
	// added those from the frontend
	wp_enqueue_script( 'msfb_waypoints_offline', MSFB_URL.'admin/js/waypoints.js' );
	wp_enqueue_script( 'msfb_countup', MSFB_URL.'admin/js/countup.min.js' );
	wp_enqueue_script( 'msfb_multiselect-nav', MSFB_URL.'admin/js/multistep-nav.js' );
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
	$localize_data = array(
		'ajax_url' => admin_url( 'admin-ajax.php' ),
		'max_rows' => get_option('msfb_row_count') ?: 5,
		'all_questions' => $all_questions,
		'all_forms' => $all_forms,
		'translate' => array(
			'form_data_successfully_submitted' => get_option('form_data_successfully_submitted','Form data successfully submitted.'),
			'this_option_did_not_point_to_any_other_question' => get_option('this_option_did_not_point_to_any_other_question','This option did not point to any other question.'),
			'select_an_option_first' => get_option('select_an_option_first','Select an option first.'),
			'field_is_required' => get_option('field_is_required','Field is required.'),
			'this_step_is_required' => get_option('this_step_is_required','This step is required'),
			'msfb_select_from_dropdown' => get_option('msfb_select_from_dropdown','Select from dropdown'),
			'finish' => get_option('msfb_translate_finish','Finish'),
			'cannot_create_mul_con' => get_option('cannot_create_mul_con',"Cannot create multiple connection from one output."),
		)
	);
	if( isset($_GET['formulation_id']) && sanitize_text_field( $_GET['formulation_id'] ) != "" ) {
		global $wpdb;
		$table_name = $wpdb->prefix.'msfb_formulations';
		$formula_id = sanitize_text_field( $_GET['formulation_id'] );
		$this_formula_data = $wpdb->get_results("SELECT * FROM $table_name WHERE id='$formula_id'",ARRAY_A);
		if( $wpdb->num_rows > 0){
			$has_data = true;
			$this_formula_data = $this_formula_data[0];
			$this_formula_data['formulation_data'] = json_decode( stripslashes( $this_formula_data['formulation_data'] ),true);
			$localize_data['raw_data'] = json_decode( stripslashes( $this_formula_data['raw_data'] ),true);
			// echo '<pre>';
			// print_r($this_form_data);
			// echo '</pre>';
		}
	}
	wp_localize_script( 'msfb_admin_localize', 'msfb', $localize_data);
	wp_enqueue_script( 'msfb_admin_main', MSFB_URL.'admin/js/main.js', array(), false, true );
	wp_enqueue_script( 'msfb_admin_form_builder', MSFB_URL.'admin/js/form-builder.js', array(), false, true );
	wp_enqueue_script( 'msfb_admin_formulation_builder', MSFB_URL.'admin/js/formulation-builder.js', array(), false, true );
	wp_enqueue_script( 'msfb_admin_ajax', MSFB_URL.'admin/js/ajax.js', array(), false, true );
	wp_enqueue_script( 'msfb_fontawesome_icons', MSFB_URL.'admin/js/fontawesome.js', array(), false, false );
	wp_enqueue_script( 'msfb_admin_select2', MSFB_URL.'admin/js/select2.min.js' );
	// wp_enqueue_script( 'msfb_admin_swal2', 'https://cdn.jsdelivr.net/npm/sweetalert2@9' );
	wp_enqueue_script( 'msfb_admin_swal2_offline', MSFB_URL.'admin/js/swal2offline.js' );
	// wp_enqueue_script( 'msfb_admin_drawflow_js', 'https://cdn.jsdelivr.net/gh/jerosoler/Drawflow/dist/drawflow.min.js' );
	wp_enqueue_script( 'msfb_admin_drawflow_js', MSFB_URL.'admin/src/drawflow_lib.js', array(), false, true );
	wp_enqueue_script( 'msfb_admin_micromodal', 'https://unpkg.com/micromodal/dist/micromodal.min.js' );
	wp_enqueue_script( 'msfb_admin_drawflow_script_js', MSFB_URL.'admin/js/drawflow.js', array(), false, true );
	//css
	wp_register_style( 'msfb_admin_global', MSFB_URL.'admin/css/global.css' );
	wp_register_style( 'msfb_admin_tailwind', MSFB_URL.'admin/css/tailwind.css' );
	wp_register_style( 'msfb_admin_fontawesome', 'https://pro.fontawesome.com/releases/v5.10.0/css/all.css' );
	wp_register_style( 'msfb_admin_jquery_ui_css', MSFB_URL.'admin/css/jquery-ui.css' );
	wp_register_style( 'msfb_admin_jquery_steps', MSFB_URL.'admin/css/jquery.steps.css' );
	wp_register_style( 'msfb_admin_select2', MSFB_URL.'admin/css/select2.min.css' );
	wp_register_style( 'msfb_admin_style', MSFB_URL.'admin/css/style.css' );
	// addes this style from the frontend
	wp_register_style( 'msfb_admin_question_style', MSFB_URL.'admin/css/question-style.css' );
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