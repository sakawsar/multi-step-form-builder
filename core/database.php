<?php
function msfb_create_the_database() {
	global $wpdb;
	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	$qtn_table            = $wpdb->prefix . 'msfb_questions';
	$category_table       = $wpdb->prefix . 'msfb_category';
	$form_table           = $wpdb->prefix . 'msfb_forms';
	$formula_table        = $wpdb->prefix . 'msfb_formulations';
	$charset_collate = $wpdb->get_charset_collate();
	if ( $wpdb->get_var( "SHOW TABLES LIKE " . $qtn_table ) != $qtn_table ) {
		$sql = "CREATE TABLE $qtn_table (
            id INT(11) NOT NULL AUTO_INCREMENT,
            question_name TEXT NOT NULL,
            cat_id TEXT NOT NULL,
            question_title TEXT NOT NULL,
            question_desc TEXT NOT NULL,
            question_price TEXT NOT NULL,
            question_required TEXT NOT NULL,
            question_type TEXT NOT NULL,
            question_data TEXT NOT NULL,
            PRIMARY KEY (id)
        ) $charset_collate;";
		dbDelta( $sql );
	};
    if ( $wpdb->get_var( "SHOW TABLES LIKE " . $category_table ) != $category_table ) {
		$sql = "CREATE TABLE $category_table (
            id INT(11) NOT NULL AUTO_INCREMENT,
            cat_name TEXT NOT NULL,
            cat_type TEXT NOT NULL,
            PRIMARY KEY (id)
        ) $charset_collate;";
		dbDelta( $sql );
	};
    if ( $wpdb->get_var( "SHOW TABLES LIKE " . $form_table ) != $form_table ) {
		$sql = "CREATE TABLE $form_table (
            id INT(11) NOT NULL AUTO_INCREMENT,
            cat_id TEXT NOT NULL,
            form_name TEXT NOT NULL,
            form_data TEXT NOT NULL,
            PRIMARY KEY (id)
        ) $charset_collate;";
		dbDelta( $sql );
	};
    if ( $wpdb->get_var( "SHOW TABLES LIKE " . $formula_table ) != $formula_table ) {
		$sql = "CREATE TABLE $formula_table (
            id INT(11) NOT NULL AUTO_INCREMENT,
            cat_id TEXT NOT NULL,
            formulation_name TEXT NOT NULL,
            formulation_data TEXT NOT NULL,
            raw_data TEXT NOT NULL,
            settings TEXT NOT NULL,
            PRIMARY KEY (id)
        ) $charset_collate;";
		dbDelta( $sql );
	};
    // if ( $wpdb->get_var( "SHOW TABLES LIKE " . $entry_table_name ) != $entry_table_name ) {
	// 	$sql = "CREATE TABLE $entry_table_name (
    //         entry_id INT(11) NOT NULL AUTO_INCREMENT,
    //         import_id TEXT NOT NULL,
    //         _id TEXT NOT NULL,
    //         _county TEXT,
    //         _auction_date TEXT,
    //         _tax_deed_no TEXT,
    //         _cert_no TEXT,
    //         _parcel TEXT,
    //         _starting_bid TEXT,
    //         _high_bid TEXT,
    //         _surplus TEXT,
    //         _owner TEXT,
    //         _address TEXT,
    //         _phone_1 TEXT,
    //         _phone_2 TEXT,
    //         _book TEXT,
    //         _page TEXT,
    //         _total_lines TEXT,
    //         _notes TEXT,
    //         _status TEXT,
    //         PRIMARY KEY (entry_id)
    //     ) $charset_collate;";
	// 	dbDelta( $sql );
	// };
}