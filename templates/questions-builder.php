<?php
$question_id = "";
if(isset($_GET['question_id']) && $_GET['question_id'] != ""){
  $question_id = sanitize_text_field( $_GET['question_id'] );
}
function msfb_get_question($question_id){
  if($question_id != ""){
    global $wpdb;
    $qtn_table_name = $wpdb->prefix.'msfb_questions';
    $get_question = $wpdb->get_results("SELECT * FROM $qtn_table_name WHERE id='$question_id'",ARRAY_A);
    $get_question[0]['question_data'] = json_decode( stripslashes( $get_question[0]['question_data'] ), true);
    return $get_question[0];
  }else{
    return false;
  }
}
$question_data = msfb_get_question($question_id) ?: [];
function msfb_question_body_show($question_id, $id = "") {
  if($question_id == "" && $id == "msfb-multiselect" ) {
    echo "display:block;";
  }elseif( $question_id != "") {
    $get_question = msfb_get_question($question_id);
    $field_type = $get_question['question_type'];
    if( $field_type == $id ){
      echo "display:block;";
    } else {
      echo 'display:none;';
    }
  }elseif($question_id == "" && $id != "msfb-multiselect" ){
    echo "display:none;";
  }
}
$is_update = $question_id != "" ? "data-qtn-id='{$question_id}'" : "";
?>
<div class="app">
  <div class="skfb-container-with-sidebar skfb--no-drawer">
    <div class="skfb-header">
      <div class="sk-container">
        <div class="sk-row sk-align-items-center">
          <div class="sk-col-12">
            <div class="sk-d-flex sk-align-items-center sk-flex-wrap sk-column-gap">
              <div class="skfb-nav-logo">
                <h3>Question builder</h3>
              </div>
              <div>
                <button class="skfb-btn" <?php echo $is_update; ?> id="msfb_save_question"><i class="fas fa-save"></i> Save</button>
                <a href="<?php echo admin_url('admin.php?page=questions_builder&question_id'); ?>" class="skfb-btn"><i class="fas fa-plus"></i> Add new</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="skfb-content">
      <div class="sk-container">
        <div class="sk-row">
          <div class="sk-col-md-3 sk-col-lg-2 msfb-question-type-holders">
            <div class="skfb-feilds-panel">
              <h6 class="sk-head skfb-bb-primary sk-text-primary">Click to select field</h6>
              <?php include('question-parts/question-tools.php'); ?>
            </div>
          </div> <!-- /.col- -->
          <?php
          // echo '<pre>';
          // print_r($question_data);
          // echo '</pre>';
          ?>
          <?php include('question-parts/question-body.php'); ?>
        </div> <!-- /.row -->
      </div>
    </div>
  </div>
  <?php include('question-parts/question-drawers.php'); ?>
</div>
</div>