<?php
global $wpdb;
$el_type = $this->list_type;
$prefix = $wpdb->prefix;
$table_data = [];
if( $el_type == "leads" ) {
    $struct = [
        'id'     => 'ID',
    ];
    $table_data['struct'] = apply_filters('msfb_lead_columns', $struct);
    $table_name = $prefix.'msfb_leads';
    $sql = "";
    if( isset($_GET['formulation_id']) && sanitize_text_field( $_GET['formulation_id'] ) != "" ) {
        $formulation_id = sanitize_text_field( $_GET['formulation_id'] );
        $sql = "SELECT * FROM $table_name WHERE formulation_id='$formulation_id'";
    } else {
        $sql = "SELECT * FROM {$table_name}";
    }
    $questions = $wpdb->get_results($sql,ARRAY_A);
    $table_data['data'] = $wpdb->num_rows > 0 ? $questions : false;
} elseif ( $el_type == "forms" ) {
    $struct = [
        'form_name'     => 'Form name'
    ];
    $table_data['struct'] = apply_filters('msfb_form_columns', $struct);
    $table_name = $prefix.'msfb_forms';
    $questions = $wpdb->get_results("SELECT * FROM $table_name",ARRAY_A);
    $table_data['data'] = $wpdb->num_rows > 0 ? $questions : false;
} elseif ( $el_type == "questions" ) {
    $struct = [
        'question_name' => 'Question name',
        'question_type' => 'Question type',
    ];
    $table_data['struct'] = apply_filters('msfb_question_columns', $struct);
    $table_name = $prefix.'msfb_questions';
    $questions = $wpdb->get_results("SELECT * FROM $table_name",ARRAY_A);
    $table_data['data'] = $wpdb->num_rows > 0 ? $questions : false;
} elseif ( $el_type == "formulations" ) {
    $struct = [
        'formulation_name'  => 'Formulation name',
        'shortcode'  => 'Shortcode',
    ];
    $table_data['struct'] = apply_filters('msfb_formulation_columns', $struct);
    $table_name = $prefix.'msfb_formulations';
    $formulations = $wpdb->get_results("SELECT * FROM $table_name",ARRAY_A);
    $table_data['data'] = $wpdb->num_rows > 0 ? $formulations : false;
}
?>
<table class="sk-table skfb-table-question">
    <thead>
        <tr>
            <th><input type="checkbox" id="msfb-sel-all" class="sk-custom-checkbox"></th>
            <?php $i=1; foreach($table_data['struct'] as $t_id => $t_value){ ?>
                <th><?php echo $t_value; ?></th>
            <?php $i++; } ?>
            <?php if( $el_type == "leads" && $table_data['data'] != false ) {
                $table_head_data = $table_data['data'][0];
                $table_head_data = json_decode( stripcslashes( $table_head_data['lead_data'] ), true );
                $table_head_data = $table_head_data[count($table_head_data) - 1];
                $table_head_data = $table_head_data['lead_map'];
                foreach($table_head_data as $a_head_data){
                    printf('<th>%s</th>',$a_head_data);
                }
            }
            ?>
            <?php if($this->has_category && $this->get_cates()){ ?>
            <th>
                <?php if($el_type == "leads") {
                    _e('Lead of','msfb');
                } else {
                    _e('Category','msfb');
                }
                ?>
            </th>
            <?php } ?>
            <th><?php _e('Action','msfb'); ?></th>
        </tr>
    </thead>
    <tbody id="msfb-table-item-holder">
        <?php
        if($table_data['data'] != false){
            foreach($table_data['data'] as $item_data){ ?>
            <tr>
                <td><input type="checkbox" data-sel-id="msfb-select-all" data-msfb-item-id="<?php echo $item_data['id']; ?>" class="msfb-sel-field sk-custom-checkbox"></td>
                    <?php $i=1; foreach($table_data['struct'] as $t_id => $t_value){ ?>
                        <?php
                        $qtn_types = $this->get_question_type();
                        if( isset($item_data[$t_id]) && in_array($item_data[$t_id], $qtn_types) ){
                            $field_type = $this->get_question_type($item_data[$t_id]);
                            printf("<td>%s</td>",$field_type);
                        } else {
                            if( strpos($t_id,'name') !== false ){
                                $name_attr = "data-msfb-row-name='{$item_data[$t_id]}'";
                                printf("<td %s>%s</td>",$name_attr,$item_data[$t_id]);
                            } elseif( strpos($t_id,'shortcode') !== false ) {
                                printf("<td><code>[msfb_multistep_form id='%s']</code></td>",$item_data['id']);
                            } else {
                                printf("<td>%s</td>",$item_data[$t_id]);
                                if(isset($item_data['lead_data'])){
                                    $lead_data = json_decode( stripcslashes( $item_data['lead_data'] ), true );
                                    $lead_form_data = $lead_data[count($lead_data) - 1];
                                    $lead_map = $lead_form_data['lead_map'];
                                    $lead_data = $lead_form_data['form_data'];
                                    // echo '<pre>';
                                    // print_r($lead_map);
                                    // echo '</pre>';
                                    foreach($lead_map as $lead_key => $lead_val){
                                        if( isset($lead_data[$lead_key]) ) {
                                            printf("<td>%s</td>",implode(',',$lead_data[$lead_key]['value']));
                                        } else {
                                            printf("<td>-</td>");
                                        }
                                    }
                                }
                            }
                        }
                        ?>
                    <?php $i++; } ?>
                <?php if($this->has_category && $this->get_cates()){ ?>
                    <?php $item_data['cat_id'] = $el_type == "leads" ? $item_data['formulation_id'] : $item_data['cat_id']; ?>
                    <td>
                        <select <?php echo $el_type == "leads" ? "disabled" : null;  ?> data-msfb-item-type="<?php echo $el_type; ?>" data-msfb-item-id="<?php echo $item_data['id']; ?>" data-msfb-cat-id="<?php echo $item_data['cat_id']; ?>">
                            <?php echo $this->get_cates("Select a category",$item_data['cat_id']); ?>
                        </select>
                    </td>
                <?php } ?>
                <td class="sk-table-action">
                    <i data-msfb-delete-id="<?php echo $item_data['id']; ?>" data-msfb-item-type="<?php echo $el_type; ?>" class="fa fa-trash"></i>
                    <?php if($el_type != "leads"){ ?>
                        <a href="<?php echo $this->add_new_url.'='.$item_data['id']; ?>"><i class="fa fa-edit"></i></a>
                    <?php } ?>
                </td>
            </tr>
        <?php }
        } else {
            ?>
            <tr id="msfb-row-not-found2">
                <?php
                $col_count = count($table_data['struct']) + 3;
                if( !$this->has_category ) {
                    $col_count--;
                }
                ?>
                <td colspan="<?php echo $col_count; ?>"><?php _e('No data found.','msfb'); ?></td>
            </tr>
            <?php
        }
        ?>
    </tbody>
    <tfoot>
        <tr id="msfb-row-not-found">
            <?php
            $col_count = count($table_data['struct']) + 3;
            if( !$this->has_category ) {
                $col_count--;
            }
            ?>
            <td colspan="<?php echo $col_count; ?>"><?php _e('No data found.','msfb'); ?></td>
        </tr>
    </tfoot>
</table>