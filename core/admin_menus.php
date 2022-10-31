<?php
function msfb_menu_callback(){
   msfb_enqueue_style();
    if(isset($_GET['lead_id'])){
        include(MSFB_PATH.'templates/leads-details.php');
    }else{
        include(MSFB_PATH.'templates/leads.php');
    }
}
function contact_form_builder_callback(){
   msfb_enqueue_style();
    if(isset($_GET['form_id'])){
        if($_GET['form_id'] != "" && isset($_GET['settings'])){
            include(MSFB_PATH.'templates/form-settings.php');
        }else{
            include(MSFB_PATH.'templates/form-builder.php');
        }
    }else{
        include(MSFB_PATH.'templates/contact-forms.php');
    }
}
function questions_builder_callback(){
   msfb_enqueue_style();
    if(isset($_GET['question_id'])){
        include(MSFB_PATH.'templates/questions-builder.php');
    }else{
        include(MSFB_PATH.'templates/questions.php');
    }
}
function formula_builder_callback(){
   msfb_enqueue_style();
    if(isset($_GET['formulation_id'])){
        include(MSFB_PATH.'templates/formula-builder.php');
    }else{
        wp_enqueue_script( 'msfb_admin_drawflow_script_js' );
        wp_enqueue_script( 'msfb_admin_drawflow_js' );
        include(MSFB_PATH.'templates/formulations.php');
    }
}
function msfb_help_center_callback(){
   msfb_enqueue_style();
    wp_redirect( 'https://google.com', 301 );
    exit();
}
function msfb_support_callback(){
   msfb_enqueue_style();
    wp_redirect( 'https://youtube.com', 301 );
    exit();
}
function msfb_settings_callback(){
    printf('<h1>%s</h1>',__('Multistep form builder settings','msfb'));
    if(isset($_POST['save_settings'])){
        $row_count = sanitize_text_field( $_POST['msfb_row_count'] );
        update_option('msfb_row_count',$row_count);
        update_option('form_data_successfully_submitted',sanitize_text_field( $_POST['form_data_successfully_submitted'] ));
        update_option('this_option_did_not_point_to_any_other_question',sanitize_text_field( $_POST['this_option_did_not_point_to_any_other_question'] ));
        update_option('select_an_option_first',sanitize_text_field( $_POST['select_an_option_first'] ));
        update_option('field_is_required',sanitize_text_field( $_POST['field_is_required'] ));
        update_option('this_step_is_required',sanitize_text_field( $_POST['this_step_is_required'] ));
        printf("<div class='is-dismissible notice notice-success'><p>%s</p></div>",__('Settings has been saved.','msfb'));
    }
    ?>
    <table class="form-table">
        <form method="post">
            <tr>
                <th><?php _e('Row limit for each page','msfb'); ?></th>
                <td>
                    <input type="number" name="msfb_row_count" value="<?php echo get_option('msfb_row_count') ?: ""; ?>" placeholder="Row count"/>
                </td>
            </tr>
            <tr>
                <th><h2>Translations of word and sentences</h2></th>
            </tr>
            <tr>
                <th><?php _e('Form data successfully submitted.','msfb'); ?></th>
                <td>
                    <input type="text" name="form_data_successfully_submitted" value="<?php echo get_option('form_data_successfully_submitted','Form data successfully submitted.') ?: ""; ?>"/>
                </td>
            </tr>
            <tr>
                <th><?php _e('This option did not point to any other question.','msfb'); ?></th>
                <td>
                    <input type="text" name="this_option_did_not_point_to_any_other_question" value="<?php echo get_option('this_option_did_not_point_to_any_other_question','This option did not point to any other question.') ?: ""; ?>"/>
                </td>
            </tr>
            <tr>
                <th><?php _e('Select an option first.','msfb'); ?></th>
                <td>
                    <input type="text" name="select_an_option_first" value="<?php echo get_option('select_an_option_first','Select an option first.') ?: ""; ?>"/>
                </td>
            </tr>
            <tr>
                <th><?php _e('Field is required.','msfb'); ?></th>
                <td>
                    <input type="text" name="field_is_required" value="<?php echo get_option('field_is_required','Field is required.') ?: ""; ?>"/>
                </td>
            </tr>
            <tr>
                <th><?php _e('This step is required.','msfb'); ?></th>
                <td>
                    <input type="text" name="this_step_is_required" value="<?php echo get_option('this_step_is_required','This step is required.') ?: ""; ?>"/>
                </td>
            </tr>
            <tr>
                <th>
                    <input type="submit" class="button button-primary" value="<?php _e('Save Settings','msfb'); ?>" name="save_settings"/>
                </th>
            </tr>
        </form>
    </table>
    <?php
}