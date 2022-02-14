<?php
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
        if($action == "delete"){
            global $wpdb;
            $table_name = $wpdb->prefix.$suffx;
            $table_name = 'wp_msfb_questions';
            // $item_ids = implode( ',', array_map( 'absint', $item_ids ) );
            // $response = $wpdb->query( "DELETE FROM $table_name WHERE id IN ($item_ids)" );
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