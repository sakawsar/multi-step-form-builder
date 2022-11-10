<?php
add_action('wp_ajax_msfb_save_forms_settings','msfb_save_forms_settings_callback');
function msfb_save_forms_settings_callback(){
    if(isset($_POST['dataset'])){
        $data = $_POST['dataset'];
        $form_id = $data['form_id'];
        global $wpdb;
        $table_name = $wpdb->prefix.'msfb_forms';
        $result = $wpdb->get_results("SELECT * FROM $table_name WHERE id='$form_id'",ARRAY_A);
        if( $wpdb->num_rows > 0 ) {
            $form_data = json_decode( stripslashes( $result[0]['form_data'] ) , true );
            $form_data['settings'] = $data;
            $wpdb->update($table_name,[
                'form_data' => addslashes( json_encode( $form_data ) )
            ],['id' => $form_id]);
            $form_data['status'] = 'success';
            echo json_encode( $form_data );
        } else {
            echo [
                'status' => 'error',
                'message' => 'No data found'
            ];
        }
        exit;
    }
    exit;
}
function msfb_get_form_data( $form_id ){
    global $wpdb;
    $table_name = $wpdb->prefix.'msfb_forms';
    $results = $wpdb->get_results("SELECT * FROM $table_name WHERE id='$form_id'",ARRAY_A);
    $form_data = json_decode( stripslashes( $results[0]['form_data'] ) , true );
    $form_settings = isset($form_data['settings']) ? $form_data['settings'] : [] ;
    return $form_settings;
}
add_action('wp_ajax_msfb_add_leads','msfb_add_leads_callback');
function msfb_add_leads_callback(){
    if(isset($_POST['dataset'])){
        global $wpdb;
        $data = $_POST['dataset'];
        if( isset($data[count($data) - 1]['form_id']) ) {
            $data[count($data) - 1]['date'] = current_time( 'mysql' );
        }
        $table_name = $wpdb->prefix.'msfb_leads';
        $data['lead_time'] = current_time( 'timestamp' );
        $wpdb->insert($table_name,$data);
        // $data = $_POST['dataset'];
        $data['json_data'] = json_decode( stripslashes( $data['lead_data'] ), true );
        $form_data = json_decode( stripslashes( $data['lead_data'] ), true );
        $form_fields = [];
        foreach($form_data as $row){
            if( isset($row['form_data']) ) {
                $form_fields = $row;
                $data['form_data'] = $form_fields;
                break;
            }
        }
        $field_with_bracket = [];
        foreach($form_fields['form_data'] as $a_field){
            $field_with_bracket['{'.$a_field['title'].'}'] = implode(',',$a_field['value']);
        }
        $form_id = $form_fields['form_id'];
        $form_settings = msfb_get_form_data( $form_id );
        foreach($field_with_bracket as $field_key => $field_val){
            foreach($form_settings as $set_key => $set_value){
                if( strpos($set_value,$field_key) !== false ) {
                    $matched[$field_key] = array($field_key,$field_val,$set_value);
                    $form_settings[$set_key] = str_replace($field_key,$field_val,$set_value);
                }
                if( strpos($set_value,'{totalPrice}') !== false ) {
                    if( isset( $data['form_data']['total_price'] ) ) {
                        $totalPrice = $data['form_data']['total_price'].get_option('msfb_currency_symb','$');
                        $matched[$field_key] = array($field_key,$field_val,$set_value);
                        $form_settings[$set_key] = str_replace('{totalPrice}',$totalPrice,$set_value);
                    }
                }
                if( strpos($set_value,'{leadTime}') !== false ) {
                    if( isset( $data['lead_time'] ) ) {
                        $leadtime = date('d M, Y',$data['lead_time']).' '.date('h:i:s A',$data['lead_time']);
                        $matched[$field_key] = array($field_key,$field_val,$set_value);
                        $form_settings[$set_key] = str_replace('{leadTime}',$leadtime,$set_value);
                    }
                }
                if( strpos($set_value,'{questionAndAnswer}') !== false ) {
                    if( !empty($data['json_data']) ) {
                        $lead_data = $data['json_data'];
                        $lead_qtn_data = [];
                        foreach($lead_data as $a_row){
                            // continue;
                            if( !isset($a_row['title']) || !isset($a_row['value'])) continue;
                            $values = !is_array($a_row['value']) ? $a_row['value'] : null;
                            $values = is_array($a_row['value']) && count($a_row['value']) > 1 ? implode(', ',$a_row['value']) : $a_row['value'][0];
                            $lead_qtn_data[] = $a_row['title'].' - '.$values;
                        }
                        $question_ans = "No question found.";
                        if( !empty($lead_qtn_data) ) {
                            $question_ans = count($lead_qtn_data) > 1 ? implode("<br>",$lead_qtn_data) : $lead_qtn_data[0];
                        }
                        $form_settings[$set_key] = str_replace('{questionAndAnswer}',$question_ans,$set_value);
                    }
                }
            }
        }
        $data['form_settings'] = $form_settings;
        $data['form_fields'] = $field_with_bracket;
        $headers = [];
        if( isset($form_settings['sender_name']) && isset($form_settings['sender_email'])) {
            $headers[] = 'From: '.$form_settings['sender_name'].' <'.$form_settings['sender_email'].'>';
        }
        if( isset($form_settings['msfb_BCCRecipientEmail']) ) {
            $headers[] = 'Bcc: '.$form_settings['msfb_BCCRecipientEmail'];
        }
        if( isset($form_settings['msfb_replyTo']) ) {
            $headers[] = 'reply-to: '.$form_settings['msfb_replyTo'];
        }
        $email = wp_mail( 
                    $form_settings['recipient_email'],
                    $form_settings['msfb_subject'],
                    $form_settings['msfb_mgs'],
                    $headers
                );
        $lead_email = wp_mail( 
                    $form_settings['lead_email'],
                    $form_settings['msfb_lead_subject'],
                    $form_settings['msfb_lead_mgs'],
                    $headers
                );
        $data['email_sent'] = $email;
        $data['lead_email_sent'] = $lead_email;
        echo json_encode($data);
        exit;
    }
    exit;
}
add_action('wp_ajax_msfb_save_questions','msfb_save_questions_callback');
function msfb_save_questions_callback(){
    if(isset($_POST['dataset'])){
        global $wpdb;
        $table_name = $wpdb->prefix.'msfb_questions';
        $qtn_data = $_POST['dataset'];
        if( isset( $qtn_data['question_id'] ) ){
            $qtn_id = $qtn_data['question_id'];
            unset($qtn_data['question_id']);
            $wpdb->update($table_name,$qtn_data,array( 'id' => $qtn_id ));
            $_POST['dataset']['status'] = 'updated';
        } else {
            $wpdb->insert($table_name,$_POST['dataset']);
            $_POST['dataset']['question_id'] = $wpdb->insert_id;
            $_POST['dataset']['status'] = 'created';
        }
        echo json_encode($_POST['dataset']);
        exit;
    }
    exit;
}
add_action('wp_ajax_msfb_save_forms','msfb_save_forms_callback');
function msfb_save_forms_callback(){
    if(isset($_POST['dataset'])){
        global $wpdb;
        $table_name = $wpdb->prefix.'msfb_forms';
        $form_data = $_POST['dataset'];
        if( isset( $form_data['form_id'] ) ){
            $form_id = $form_data['form_id'];
            unset($form_data['form_id']);
            $wpdb->update($table_name,$form_data,array( 'id' => $form_id ));
            $_POST['dataset']['status'] = 'updated';
        } else {
            $wpdb->insert($table_name,$_POST['dataset']);
            $_POST['dataset']['form_id'] = $wpdb->insert_id;
            $_POST['dataset']['status'] = 'created';
            $_POST['dataset']['redirect'] = admin_url( 'admin.php?page=contact_form_builder&form_id='.$wpdb->insert_id );
        }
        echo json_encode($_POST['dataset']);
        exit;
    }
    exit;
}
add_action("wp_ajax_msfb_add_category","msfb_add_category_callback");
function msfb_add_category_callback(){
    if($_POST['dataset']){
        $cat_name = $_POST['dataset'][0];
        $cat_type = $_POST['dataset'][1];
        global $wpdb;
        $table_name = $wpdb->prefix.'msfb_category';
        $wpdb->insert($table_name,array(
            'cat_name' => $cat_name,
            'cat_type' => $cat_type
        ));
        echo json_encode(array(
            'status' => 'success',
            'cat_id' => $wpdb->insertid
        ));
        exit;
    }
    exit;
}
add_action('wp_ajax_msfb_add_formulation','msfb_add_formulation_callback');
function msfb_add_formulation_callback(){
    if(isset($_POST['dataset'])){
        global $wpdb;
        $table_name = $wpdb->prefix.'msfb_formulations';
        $formula_data = $_POST['dataset'];
        if( isset( $formula_data['formula_id'] ) ){
            $formula_id = $formula_data['formula_id'];
            unset($formula_data['formula_id']);
            $wpdb->update($table_name,$formula_data,array( 'id' => $formula_id ));
            $_POST['dataset']['status'] = 'updated';
        } else {
            $wpdb->insert($table_name,$_POST['dataset']);
            $_POST['dataset']['formula_id'] = $wpdb->insert_id;
            $_POST['dataset']['status'] = 'created';
            $_POST['dataset']['redirect'] = admin_url( 'admin.php?page=formula_builder&formulation_id='.$wpdb->insert_id );
        }
        echo json_encode($_POST['dataset']);
        exit;
    }
    exit;
}
add_action('wp_ajax_msfb_save_category','msfb_save_category_callback');
function msfb_save_category_callback(){
    if($_POST['dataset']){
        $cat_id = $_POST['dataset'][0];
        $item_id = $_POST['dataset'][1];
        $item_type = $_POST['dataset'][2];
        global $wpdb;
        $suffix = "";
        switch ($item_type) {
            case 'questions':
                $suffix = "msfb_questions";
                break;
            case 'leads':
                $suffix = "msfb_leads";
                break;
            case 'formulations':
                $suffix = "msfb_formulations";
                break;
            case 'forms':
                $suffix = "msfb_forms";
                break;
        }
        $table_name = $wpdb->prefix.$suffix;
        $wpdb->update($table_name,['cat_id' => $cat_id],['id' => $item_id]);
        echo json_encode(array(
            'status' => 'success'
        ));
        exit;
    }
    exit;
}
add_action('wp_ajax_msfb_delete_item','msfb_delete_item_callback');
function msfb_delete_item_callback(){
    if($_POST['dataset']){
        $item_id = $_POST['dataset'][0];
        $item_type = $_POST['dataset'][1];
        global $wpdb;
        $suffix = msfb_get_suffix($item_type);
        $table_name = $wpdb->prefix.$suffix;
        $wpdb->delete($table_name,['id' => $item_id]);
        echo json_encode(array(
            'status' => 'success'
        ));
        exit;
    }
    exit;
}
function msfb_get_suffix($item_type){
    $suffix = "";
    switch ($item_type) {
        case 'questions':
            $suffix = "msfb_questions";
            break;
        case 'leads':
            $suffix = "msfb_leads";
            break;
        case 'formulations':
            $suffix = "msfb_formulations";
            break;
        case 'forms':
            $suffix = "msfb_forms";
            break;
    }
    return $suffix;
}
add_action('wp_ajax_msfb_bulk_action','msfb_bulk_action_callback');
function msfb_bulk_action_callback(){
    if(isset($_POST['dataset'])){
        $item_ids   = $_POST['dataset']['item_ids'];
        $action     = $_POST['dataset']['action'];
        $el_type    = $_POST['dataset']['el_type'];
        $suffix     = msfb_get_suffix($el_type);
        $response   = false;
        global $wpdb;
        $table_name = $wpdb->prefix.$suffix;
        if($action == "delete"){
            foreach($item_ids as $item_id){
                $response = $wpdb->delete($table_name,array( 'id' => $item_id ));
            }
        }
        $output = $response ? array( 'status' => 'success', 'suffix' => $_POST['dataset'] ) : array( 'error' => 'Couldn\'t perform the action.' );
        echo json_encode($output);
        exit;
    }
    exit;
}
add_action('wp_ajax_msfb_custom_icon_upload','msfb_custom_icon_upload_callback');
// add_action('wp_ajax_nopriv_msfb_image_upload','msfb_image_upload');
function msfb_custom_icon_upload_callback(){
	if(isset($_FILES['main_image'])){
		// $return = [];
		$attach_data = upload_user_file($_FILES['main_image']);
        $id = $attach_data[1];
        $url = $attach_data[0];
		// update_post_meta($id,'_thumbnail_id',$id);
		// $return[] = $attach_id;
	    echo json_encode(array('url' => $url, 'id' => $id));
	}
	exit();
}

function upload_user_file( $file = array() ) {    
    require_once( ABSPATH . 'wp-admin/includes/admin.php' );
    $file_return = wp_handle_upload( $file, array('test_form' => false ) );
    if( isset( $file_return['error'] ) || isset( $file_return['upload_error_handler'] ) ) {
        return $file_return;
    } else {
        $filename = $file_return['file'];
        $attachment = array(
            'post_mime_type' => $file_return['type'],
            'post_title' => preg_replace( '/\.[^.]+$/', '', basename( $filename ) ),
            'post_content' => '',
            'post_status' => 'inherit',
            'guid' => $file_return['url']
        );
        $attachment_id = wp_insert_attachment( $attachment, $file_return['url'] );
        update_post_meta( $attachment_id, 'msfb_custom_icon', true);
        require_once(ABSPATH . 'wp-admin/includes/image.php');
        $attachment_data = wp_generate_attachment_metadata( $attachment_id, $filename );
        wp_update_attachment_metadata( $attachment_id, $attachment_data );
        if( 0 < intval( $attachment_id ) ) {
          // return $attachment_id;
		  // test
          // wp_get_attachment_url( $post_id = 0 )
          return [wp_get_attachment_url( $attachment_id ), $attachment_id];
        }
    }
}