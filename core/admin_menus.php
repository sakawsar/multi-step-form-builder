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
   ?>
    <script>
        window.location.href = "https://multi-step-form.com/help-center";
    </script>
   <?php
    exit();
}
function msfb_support_callback(){
    ?>
    <script>
        window.location.href = "https://multi-step-form.com/support";
    </script>
   <?php
    exit();
}
function msfb_settings_callback(){
    function get_the_label( $label, $tooltip_title ){
        printf('%s <i title="%s" class="fa fa-question-circle"></i>',$label,$tooltip_title);
    }
    printf('<h1>%s</h1>',__('Multistep form builder settings','msfb'));
    if(isset($_POST['save_settings'])){
        $row_count = sanitize_text_field( $_POST['msfb_row_count'] );
        update_option('msfb_row_count',$row_count);
        update_option('msfb_currency_symb',sanitize_text_field( $_POST['msfb_currency_symb'] ));
        update_option('form_data_successfully_submitted',sanitize_text_field( $_POST['form_data_successfully_submitted'] ));
        // update the site key
        update_option('msfb_recap_sitekey',sanitize_text_field( $_POST['msfb_recap_sitekey'] ));
        // update secret key
        update_option('msfb_recap_secretkey',sanitize_text_field( $_POST['msfb_recap_secretkey'] ));
        update_option('this_option_did_not_point_to_any_other_question',sanitize_text_field( $_POST['this_option_did_not_point_to_any_other_question'] ));
        update_option('select_an_option_first',sanitize_text_field( $_POST['select_an_option_first'] ));
        update_option('field_is_required',sanitize_text_field( $_POST['field_is_required'] ));
        update_option('this_step_is_required',sanitize_text_field( $_POST['this_step_is_required'] ));
        update_option('cannot_create_mul_con',sanitize_text_field( $_POST['cannot_create_mul_con'] ));
        // translate words
        update_option('msfb_select_from_dropdown',sanitize_text_field( $_POST['msfb_select_from_dropdown'] ));
        update_option('msfb_translate_back',sanitize_text_field( $_POST['msfb_translate_back'] ));
        update_option('msfb_translate_next',sanitize_text_field( $_POST['msfb_translate_next'] ));
        update_option('msfb_translate_skip',sanitize_text_field( $_POST['msfb_translate_skip'] ));
        update_option('msfb_translate_finish',sanitize_text_field( $_POST['msfb_translate_finish'] ));
        update_option('msfb_please_verify_recaptcha',sanitize_text_field( $_POST['msfb_please_verify_recaptcha'] ));
        update_option('msfb_translate_estimated_cost',sanitize_text_field( $_POST['msfb_translate_estimated_cost'] ));
        update_option('msfb_form_builder_send_text',sanitize_text_field( $_POST['msfb_form_builder_send_text'] ));
        printf("<div class='is-dismissible notice notice-success'><p>%s</p></div>",__('Settings has been saved.','msfb'));
    }
    ?>
    <table class="form-table">
        <form method="post">
            <tr>
                <th>
                    <?php 
                        get_the_label(__('Row limit for each page','msfb'), __('This row count is to show the number of rows in any table (Lead, question or Q-Flow)','msfb'));
                    ?>
                </th>
                <td>
                    <input type="number" name="msfb_row_count" value="<?php echo get_option('msfb_row_count') ?: ""; ?>" placeholder="Row count"/>
                    <p>
                        <?php _e('This row count is to show the number of rows in any table (Lead, question or Q-Flow)','msfb'); ?>
                    </p>
                </td>
            </tr>
            <tr>
                <th>
                    <?php 
                        get_the_label(__('Currency symbol','msfb'), __('The currency symbol which will show in the pricing of the Q-Flow.','msfb'));
                    ?>
                </th>
                <td>
                    <input type="text" name="msfb_currency_symb" value="<?php echo get_option('msfb_currency_symb','') ?: ""; ?>" placeholder="$"/>
                    <p>
                        <?php _e('The currency symbol which will show in the pricing of the Q-Flow.','msfb') ?>
                    </p>
                </td>
            </tr>
            <tr>
                <th>
                    <?php
                        _e('Google recaptcha site key','msfb');
                    ?>
                </th>
                <td>
                    <input type="text" name="msfb_recap_sitekey" value="<?php echo get_option('msfb_recap_sitekey','') ?: ""; ?>" placeholder="<?php _e('Google recaptcha site key','msfb'); ?>"/>
                    <p>
                        <?php _e('Create google recaptcha v2 checkbox app and put the sitekey of that app.','msfb') ?>
                    </p>
                </td>
            </tr>
            <tr>
                <th>
                    <?php
                        _e('Google recaptcha secret key','msfb');
                    ?>
                </th>
                <td>
                    <input type="text" name="msfb_recap_secretkey" value="<?php echo get_option('msfb_recap_secretkey','') ?: ""; ?>" placeholder="<?php _e('Google recaptcha secret key','msfb'); ?>"/>
                    <p>
                        <?php _e('Create google recaptcha v2 checkbox app and put the secret key of that app.','msfb') ?>
                    </p>
                </td>
            </tr>
            <tr>
                <th>
                    <h2>
                        <?php 
                            _e('Translations of word and sentences','msfb')
                            ?>
                    </h2>
                    <p>
                        <?php _e('Those are the fields to translate the word and sentences which is written in English.','msfb'); ?>
                    </p>
                </th>
            </tr>
            <tr>
                <th><?php _e('Form data successfully submitted.','msfb'); ?></th>
                <td> 
                    <input type="text" name="form_data_successfully_submitted" value="<?php echo get_option('form_data_successfully_submitted'); ?>" placeholder="<?php _e('Form data successfully submitted.'); ?>"/>
                </td>
            </tr>
            <tr>
                <th><?php _e('This option did not point to any other question.','msfb'); ?></th>
                <td>
                    <input type="text" name="this_option_did_not_point_to_any_other_question" value="<?php echo get_option('this_option_did_not_point_to_any_other_question'); ?>" placeholder="This option did not point to any other question."/>
                </td>
            </tr>
            <tr>
                <th><?php _e('Select an option first.','msfb'); ?></th>
                <td>
                    <input type="text" name="select_an_option_first" value="<?php echo get_option('select_an_option_first'); ?>" placeholder="Select an option first."/>
                </td>
            </tr>
            <tr>
                <th><?php _e('Field is required.','msfb'); ?></th>
                <td>
                    <input type="text" name="field_is_required" value="<?php echo get_option('field_is_required'); ?>" placeholder="Field is required."/>
                </td>
            </tr>
            <tr>
                <th><?php _e('This step is required.','msfb'); ?></th>
                <td>
                    <input type="text" name="this_step_is_required" value="<?php echo get_option('this_step_is_required'); ?>" placeholder="This step is required."/>
                </td>
            </tr>
            <tr>
                <th><?php _e('Cannot create multiple connection from one output.','msfb'); ?></th>
                <td>
                    <input type="text" name="cannot_create_mul_con" value="<?php echo get_option('cannot_create_mul_con'); ?>" placeholder="Cannot create multiple connection from one output."/>
                </td>
            </tr>
            <tr>
                <th><?php _e('Select from dropdown','msfb'); ?></th>
                <td>
                    <input type="text" name="msfb_select_from_dropdown" value="<?php echo get_option('msfb_select_from_dropdown'); ?>" placeholder="Select from dropdown"/>
                </td>
            </tr>
            <tr>
                <th><?php _e('Back','msfb'); ?></th>
                <td>
                    <input type="text" name="msfb_translate_back" value="<?php echo get_option('msfb_translate_back'); ?>" placeholder="Back"/>
                </td>
            </tr>
            <tr>
                <th><?php _e('Finish','msfb'); ?></th>
                <td>
                    <input type="text" name="msfb_translate_finish" value="<?php echo get_option('msfb_translate_finish'); ?>" placeholder="Finish"/>
                </td>
            </tr>
            <tr>
                <th><?php _e('Please verify recaptcha','msfb'); ?></th>
                <td>
                    <input type="text" name="msfb_please_verify_recaptcha" value="<?php echo get_option('msfb_please_verify_recaptcha'); ?>" placeholder="Please verify recaptcha"/>
                </td>
            </tr>
            <tr>
                <th><?php _e('Next','msfb'); ?></th>
                <td>
                    <input type="text" name="msfb_translate_next" value="<?php echo get_option('msfb_translate_next'); ?>" placeholder="Next"/>
                </td>
            </tr>
            <tr>
                <th><?php _e('Skip','msfb'); ?></th>
                <td>
                    <input type="text" name="msfb_translate_skip" value="<?php echo get_option('msfb_translate_skip'); ?>" placeholder="Skip"/>
                </td>
            </tr>
            <tr>
                <th><?php _e('Estimated cost:','msfb'); ?></th>
                <td>
                    <input type="text" name="msfb_translate_estimated_cost" value="<?php echo get_option('msfb_translate_estimated_cost'); ?>" placeholder="Estimated cost:"/>
                </td>
            </tr>
            <tr>
                <th><?php _e('Form builder send text:','msfb'); ?></th>
                <td>
                    <input type="text" name="msfb_form_builder_send_text" value="<?php echo get_option('msfb_form_builder_send_text'); ?>" placeholder="Send"/>
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