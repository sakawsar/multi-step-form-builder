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
add_shortcode('msfb_multistep_form','msfb_ui_callback');
function msfb_ui_callback( $atts ){
	$atts = shortcode_atts( array(
		'id' => '',
		'disabled' => 'no'
	), $atts );
	if( !$atts['id'] ){
		return __('Formulation id is required','msfb');
	}
	ob_start();
	global $wpdb;
	$formulation_id = $atts['id'];
	$is_disabled = $atts['disabled'] == "yes" ? true : false;
	$table_name = $wpdb->prefix.'msfb_formulations';
	$results = $wpdb->get_results("SELECT * FROM $table_name WHERE id='$formulation_id'");
	$json_data = $results[0]->raw_data;
	$json_data = json_decode(stripslashes( $json_data ),true);
	$json_data = isset($json_data['drawflow']['Home']['data']) ? $json_data['drawflow']['Home']['data'] : false;
	if( !$json_data ) {
		return __('No Q-Flow data found','msfb');
	}
	$formulation = $json_data;
	$formulation_data = json_decode(stripslashes($results[0]->formulation_data),true);
	// echo '<pre>';
	// print_r($formulation);
	// echo '</pre>';
    wp_enqueue_style( 'msfb_admin_tailwind' );
    wp_enqueue_style( 'msfb_admin_fontawesome' );
	?>
	<style>
		:root {
			--msfb-color: <?php echo $formulation_data['color_scheme']; ?>;
		}
	</style>
	<div class="tw-msfb-container" data-formulation-id="<?php echo $formulation_id; ?>">
	<!-- <div class="tw-msfb-container" data-formulation-data="<?php echo base64_encode(serialize($qtns)); ?>"> -->
		<div class="tw-msfb-progress-bar">
			<div class="tw-msfb-progress-bar__status" style="width:0%;"></div>
        </div>

		<?php $price_display = "style='display:none;'"; if(isset($formulation_data['show_price'])){ 
			$price_display = "style='display:block;'";
		 } ?>
		<h2 class="tw-msfb-total-price" <?php echo $price_display; ?>><?php echo get_option('msfb_translate_estimated_cost') ?: 'Estimated cost:'; ?> <span>0</span><?php echo get_option('msfb_currency_symb') ?: '$'; ?></h2>
		<?php
		$map = [];
		$root = 0;
		foreach($formulation as $key => $a_qtn){
			if( $root == 0){
				$root = empty($a_qtn['inputs']['input_1']['connections']) ? $key : 0;
			}
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
				'step' => empty($a_qtn['inputs']['input_1']['connections']) ? 1 : 0,
				'redirect' => isset($formulation_data['redirect']) ? $formulation_data['redirect'] : home_url( '/' ),
				'is_disabled' => $is_disabled
			];
			if( isset($formulation_data['msfb_nav_menu_position']) ) {
				$qtn_data['nav_position'] = $formulation_data['msfb_nav_menu_position'];
			}
			msfb_get_the_step($qtn_data);
			$nodes = [];
			foreach( $a_qtn['outputs'] as $a_output){
				if( count($a_output['connections']) ) {
					foreach($a_output['connections'] as $connection){
						$nodes[] = $connection['node'];
					}
				}
			}
			// foreach( $a_qtn['inputs'] as $a_output){
			// 	if( count($a_output['connections']) ) {
			// 		foreach($a_output['connections'] as $connection){
			// 			$nodes[] = $connection['node'];
			// 		}
			// 	}
			// }
			$map[$key] = array_unique($nodes);
			$edges = [];
			foreach($map as $key => $edge){
				if( count($edge) > 0) {
					foreach($edge as $a_edge){
						$edges[] = [$key,$a_edge];
					}
				}
			}
		}
		$dfs_data = msfb_chain_diver($map,[$root]);
		$max = 0;
		foreach($dfs_data as $a_path){
			if( $max < count($a_path) ) {
				$max = count($a_path);
			}
		}
		?>
		<div id="msfb-progressbar-step" data-current-step="0" data-step="<?php echo 100 / $max; ?>"></div>
		<?php
		// echo '<pre>';
		// print_r($max);
		// print_r($dfs_data);
		// echo '</pre>';
		?>
	</div>
	<?php
	return ob_get_clean();
}
function msfb_chain_diver( $graph, array $start, $require_back_track = [], $path = [], $paths = []){
	$start = array_shift($start);
	$vertax = $graph[$start];
	$vertax_children = count($vertax);
	$path[] = $start;
	$tracked_path = [];
	if( $vertax_children > 0 ) {
		$current_pointer = $vertax[$vertax_children - 1];
		if( $vertax_children > 1 ) {
			array_pop($vertax);
			if( !in_array($start,$require_back_track) ){
				$require_back_track[] = $start;
			}
			$tracked_path = $path;
		} else {
			if( in_array($start,$require_back_track) ){
				array_shift($require_back_track);
			}
		}
		$graph[$start] = $vertax;
		return msfb_chain_diver( $graph, [$current_pointer], $require_back_track, $path, $paths );
	} else {
		$paths[] = $path;
		if( $require_back_track ) {
			return msfb_chain_diver( $graph, $require_back_track, $require_back_track, $tracked_path, $paths );
		} else {
			return $paths;
		}
	}
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
		$data['item_id'] = $dataset['item_id'];
		$data['step_data'] = $dataset;
		$data['step'] = $dataset['step'];
		$data['redirect'] = $dataset['redirect'];
		$data['is_disabled'] = $dataset['is_disabled'];
		if( isset($dataset['nav_position'])) {
			$data['nav_position'] = $dataset['nav_position'];
		}
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
		// if nav position changed
		if( isset($data['nav_position']) && $data['nav_position'] != 'bottom' ) {
			echo '</div>';
		} else {
			msfb_step_navigation( $data );
		}
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
		<?php if( $step_data['type'] != "question" && get_option('msfb_recap_sitekey') ) { ?>
			<div style="margin:16px auto;" id="msfb-recaptcha"></div>
		<?php } ?>
		<?php if( $step_data['type'] != "question" && get_option('msfb_gdpr_page') && get_option('msfb_gdpr_page_anchor_text') ) { ?>
			<label style="margin:auto;">
				<input type="checkbox" name="" id="msfb_gdpr_checkbox">
				<span><?php echo get_option('msfb_gdpr_policy_accept_text') ?: __('I have read and understood the privacy statement. You can read the privacy policy ','msfb'); ?></span>
				<span><a target="_blank" href="<?php echo get_permalink( get_option('msfb_gdpr_page') ) ?: '#'; ?>"><?php echo get_option('msfb_gdpr_page_anchor_text') ?: __('here.','msfb'); ?></a></span>
			</label>
		<?php } ?>
		<div <?php echo $required; ?> class="tw-msfb-btn-container" <?php echo isset($data['nav_position']) && $data['nav_position'] == 'top' ? 'style="margin:32px 0px;"' : ''; ?> <?php echo $root_node; ?> data-step-type="<?php echo $step_data['type']; ?>">
			<?php if( $data['step'] != 1 ) { ?>
				<button data-msfb-prev=""><?php echo get_option('msfb_translate_back') ?: 'Back'; ?></button>
			<?php } ?>
			<?php if( !empty($step_data['outputs']['output_1']['connections']) ) { ?>
				<?php $next_node = count($step_data['outputs']) == 1 ? $step_data['outputs']['output_1']['connections'][0]['node'] : ""; ?>
				<button data-msfb-next="<?php echo $next_node; ?>"><?php echo get_option('msfb_translate_next') ?: 'Next'; ?></button>
				<?php if( !$required && $is_skippable ) { ?>
					<button class="msfb-skip-step" data-msfb-next="<?php echo $next_node; ?>"><?php echo get_option('msfb_translate_skip') ?: 'Skip'; ?></button>
				<?php } ?>
			<?php } else { ?>
				<button <?php echo $data['is_disabled'] ? 'disabled' : ''; ?> data-msfb-redirect="<?php echo $data['redirect']; ?>"><?php echo get_option('msfb_translate_finish') ?: 'Finish'; ?></button>
			<?php }?>
		</div>
	<?php echo !isset($data['nav_position']) || $data['nav_position'] != 'top' ? '</div>' : ''; ?> <!-- end of the wrapper -->
	<?php
}