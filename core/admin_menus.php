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
        if(isset($_GET['settings'])){
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