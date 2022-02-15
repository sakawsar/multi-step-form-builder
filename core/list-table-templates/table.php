<?php
global $wpdb;
$el_type = $this->list_type;
$prefix = $wpdb->prefix;
$table_data = [];
if( $el_type == "leads" ) {
    $struct = [
        'lead_date'     => 'Lead date',
    ];
    $table_data['struct'] = apply_filters('msfb_lead_columns', $struct);
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
        'shortcode_'  => 'Formulation name',
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
            <?php if($this->has_category && $this->get_cates()){ ?>
            <th>Category</th>
            <?php } ?>
            <th>Action</th>
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
                        if( in_array($item_data[$t_id], $qtn_types) ){
                            $field_type = $this->get_question_type($item_data[$t_id]);
                            printf("<td>%s</td>",$field_type);
                        } else {
                            if( strpos($t_id,'name') !== false ){
                                $name_attr = "data-msfb-row-name='{$item_data[$t_id]}'";
                                printf("<td %s>%s</td>",$name_attr,$item_data[$t_id]);
                            } else {
                                printf("<td>%s</td>",$item_data[$t_id]);
                            }
                        }
                        ?>
                    <?php $i++; } ?>
                <?php if($this->has_category && $this->get_cates()){ ?>
                    <td>
                        <select data-msfb-item-type="<?php echo $el_type; ?>" data-msfb-item-id="<?php echo $item_data['id']; ?>" data-msfb-cat-id="<?php echo $item_data['cat_id']; ?>">
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