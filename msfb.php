<?php
/**
 * 
 * Plugin Name: Multi-step form builder
 * Description: Multi step form builder - smart inquiry forms incl. pricing calculator via Drag & Drop
 * Author: Dwayne Advertising
 * Version: 1.0
 * 
 */
if( !defined('ABSPATH') ) {
    exit;
}
if( !class_exists('MSFB_Object') ){
    final class MSFB_Object{
        protected static $instance;
        public static function get_instance(){
            if( self::$instance == NULL ){
                self::$instance = new self();
            }
            return self::$instance;
        }
        function __construct(){
            $this->get_consts();
            $this->get_includes();
            add_action('admin_menu',array($this,'msfb_admin_menu'));
            // add_action( 'plugins_loaded', array($this,'msfb_load_plugin_textdomain', 12 ));
            register_activation_hook(__FILE__, array($this,'msfb_activate'));
        }
        function msfb_activate(){
            msfb_create_the_database();
            flush_rewrite_rules();
        }
        function msfb_enqueue_question_style(){
            wp_enqueue_style( 'msfb_admin_question_style' );
        }
        function msfb_enqueue_formula_style(){
            wp_enqueue_style( 'msfb_admin_tailwind' );
            wp_enqueue_style( 'msfb_admin_fontawesome' );
        }
        public function msfb_admin_menu(){
            add_menu_page( __('Multistep form builder','msfb'), __('Multistep form builder','msfb'), 'manage_options', 'multistep_form_builder', 'msfb_menu_callback', '', 10 );
            // All leads
            add_submenu_page( 'multistep_form_builder', __('Leads','msfb'), __('Leads','msfb'), 'manage_options', 'multistep_form_builder', 'msfb_menu_callback' );
            // Contact forms
            add_submenu_page( 'multistep_form_builder', __('Contact forms','msfb'), __('Contact forms','msfb'), 'manage_options', 'contact_form_builder', 'contact_form_builder_callback' );
            // Questions
            $question_builder_hook = add_submenu_page( 'multistep_form_builder', __('Questions','msfb'), __('Questions','msfb'), 'manage_options', 'questions_builder', 'questions_builder_callback' );
            add_action('admin_print_styles-'.$question_builder_hook,[$this,'msfb_enqueue_question_style']);
            // Formula
            $formula_builder_hook = add_submenu_page( 'multistep_form_builder', __('Formula','msfb'), __('Formula','msfb'), 'manage_options', 'formula_builder', 'formula_builder_callback' );
            add_action('admin_print_styles-'.$formula_builder_hook,[$this,'msfb_enqueue_formula_style']);
            // Settings
            add_submenu_page( 'multistep_form_builder', __('Settings','msfb'), __('Settings','msfb'), 'manage_options', 'msfb_settings', 'msfb_settings_callback' );
            // Help center
            add_submenu_page( 'multistep_form_builder', __('Help center','msfb'), __('Help center','msfb'), 'manage_options', 'msfb_help_center', 'msfb_help_center_callback' );
            // Support
            add_submenu_page( 'multistep_form_builder', __('Support','msfb'), __('Support','msfb'), 'manage_options', 'msfb_support', 'msfb_support_callback' );
        }
        public function get_consts(){
            define('MSFB_URL',plugin_dir_url( __FILE__ ));
            define('MSFB_PATH',plugin_dir_path( __FILE__ ));
        }
        public function get_includes(){
            // include(MSFB_PATH.'core/phpmailer.php');
            include(MSFB_PATH.'core/enqueue.php');
            include(MSFB_PATH.'core/shortcode.php');
            include(MSFB_PATH.'core/admin_menus.php');
            include(MSFB_PATH.'core/database.php');
            include(MSFB_PATH.'core/ajax_handle.php');
            include(MSFB_PATH.'core/list_table.php');
        }
        function msfb_load_plugin_textdomain() {
            $locale = apply_filters( 'plugin_locale', get_locale(), 'msfb' );
            load_textdomain( 'msfb', WP_LANG_DIR . "/msfb-$locale.mo" );
            load_plugin_textdomain( 'msfb', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
        }
    }
    MSFB_Object::get_instance();
}
