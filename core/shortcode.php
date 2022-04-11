<?php
include(MSFB_PATH.'core/shortcode-templates/multiselect-field.php');
include(MSFB_PATH.'core/shortcode-templates/select-field.php');
include(MSFB_PATH.'core/shortcode-templates/text-field.php');
include(MSFB_PATH.'core/shortcode-templates/textarea-field.php');
include(MSFB_PATH.'core/shortcode-templates/date-field.php');
include(MSFB_PATH.'core/shortcode-templates/upload-field.php');
include(MSFB_PATH.'core/shortcode-templates/dropdown-field.php');
include(MSFB_PATH.'core/shortcode-templates/slider-field.php');
include(MSFB_PATH.'core/shortcode-templates/form.php');
add_shortcode('msfb_ui','msfb_ui_callback');
function msfb_ui_callback( $atts ){
	$atts = shortcode_atts( array(
		'id' => ''
	), $atts );
	if( !$atts['id'] && false ){
		return __('Formulation id is required','msfb');
	}
	ob_start();
	global $wpdb;
	$table_name = $wpdb->prefix.'msfb_formulations';
	$results = $wpdb->get_results("SELECT * FROM $table_name");
	$json_data = $results[0]->raw_data;
	$json_data = json_decode(stripslashes( $json_data ),true);
	$json_data = $json_data['drawflow']['Home']['data'];
	$formulation = $json_data;
	// echo '<pre>';
	// print_r($formulation);
	// echo '</pre>';
    wp_enqueue_style( 'msfb_admin_tailwind' );
	?>
	<div class="tw-msfb-container" data-formulation-data="<?php echo base64_encode(serialize($qtns)); ?>">
		<div class="tw-msfb-progress-bar">
			<div class="tw-msfb-progress-bar__status"></div>
        </div>
		<?php
		foreach($formulation as $key => $a_qtn){
			unset($a_qtn['html']);
			$key = $a_qtn['id'];
			$name = explode('-',$a_qtn['name']);
			$id = $name[1];
			$qtn_data = [
				'id' => $key, // this the node id
				'item_id' =>  $id, // this is the element id from database
				'type' => $name[0],
				'name' => $a_qtn['name'],
				'inputs' => $a_qtn['inputs'],
				'outputs' => $a_qtn['outputs'],
				'step' => empty($a_qtn['inputs']['input_1']['connections']) ? 1 : 0
			];
			msfb_get_the_step($qtn_data);
			// echo '<pre>';
			// print_r($qtn_data);
			// echo '</pre>';
		}
		?>
	</div>
	<?php
	return ob_get_clean();
}
function msfb_get_the_step( $dataset ) {
	$type = $dataset['type'];
	$id = $dataset['item_id'];
	global $wpdb;
	$table_name = $wpdb->prefix;
	$table_name .= $type == "form" ? "msfb_forms" : "msfb_questions";
	$results = $wpdb->get_results("SELECT * FROM $table_name WHERE id='$id'",ARRAY_A);
	if( !empty($results) ) {
		$data = $results[0];
		// the element id replaced by node id & element id passed under step data as item_id
		$data['id'] = $dataset['id'];
		$data['step_data'] = $dataset;
		$data['step'] = $dataset['step'];
		$data_type = $dataset['type'];
		if( $data_type == "question" ) {
			$qtn_type = $data['question_type'];
			if( $qtn_type == 'msfb-multiselect' ) {
				// include(MSFB_PATH.'core/shortcode-templates/multiselect-field.php');
				msfb_multiselect_step( $data );
			} elseif( $qtn_type == 'msfb-single-select-field' ) {
				// include(MSFB_PATH.'core/shortcode-templates/select-field.php');
				msfb_select_step( $data );
			} elseif( $qtn_type == 'msfb-text-field' ) {
				// include(MSFB_PATH.'core/shortcode-templates/text-field.php');
				msfb_text_step( $data );
			} elseif( $qtn_type == 'msfb-textarea-field' ) {
				// include(MSFB_PATH.'core/shortcode-templates/textarea-field.php');
				msfb_textarea_step( $data );
			} elseif( $qtn_type == 'msfb-date-field' ) {
				// include(MSFB_PATH.'core/shortcode-templates/date-field.php');
				msfb_date_step( $data );
			} elseif( $qtn_type == 'msfb-upload-field' ) {
				// include(MSFB_PATH.'core/shortcode-templates/upload-field.php');
				msfb_upload_step( $data );
			} elseif( $qtn_type == 'msfb-dropdown-field' ) {
				// include(MSFB_PATH.'core/shortcode-templates/dropdown-field.php');
				msfb_dropdown_step( $data );
			} elseif( $qtn_type == 'msfb-slider-field' ) {
				// include(MSFB_PATH.'core/shortcode-templates/slider-field.php');
				msfb_slider_step( $data );
			}
		} else {
			// include(MSFB_PATH.'core/shortcode-templates/form.php');
			msfb_form_step( $data );
		}
		msfb_step_navigation( $data );
	}
}
function msfb_step_navigation( $data ) {
	$step_data = $data['step_data'];
	$node_id = $data['id'];
	$root_node = $data['step'] == 1 ? "data-msfb-root='".$node_id."'" : "";
	$is_skippable = true;
	$is_skippable = $step_data['type'] == 'form' || in_array($data['question_type'],['msfb-single-select-field','msfb-dropdown-field']) ? false : true;
	$required = "";
	if( $step_data['type'] == "question" ) {
		$required = $data['question_required'] == 1 ? "data-msfb-required='true'" : "";
	}
	?>
		<div <?php echo $required; ?>" class="tw-msfb-btn-container" <?php echo $root_node; ?>>
			<?php if( $data['step'] != 1 ) { ?>
				<button data-msfb-prev="">Back</button>
				<!-- <button data-msfb-prev="<?php echo $step_data['inputs']['input_1']['connections'][0]['node']; ?>">Back</button> -->
			<?php } ?>
			<?php if( !empty($step_data['outputs']['output_1']['connections']) ) { ?>
				<?php $next_node = count($step_data['outputs']) == 1 ? $step_data['outputs']['output_1']['connections'][0]['node'] : ""; ?>
				<button data-msfb-next="<?php echo $next_node; ?>">Next</button>
				<?php if( !$required && $is_skippable ) { ?>
					<button class="msfb-skip-step" data-msfb-next="<?php echo $next_node; ?>">Skip</button>
				<?php } ?>
			<?php } else { ?>
				<button data-msfb-redirect="">Finish</button>
			<?php }?>
		</div>
	</div> <!-- end of the wrapper -->
	<?php
}