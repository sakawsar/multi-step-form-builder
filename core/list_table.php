<?php
class MSFB_List_Table{
    public $list_type;
    public $title = null;
    public $details_url;
    public $add_new_url = false;
    public $has_category = true;
    public $has_search = true;
    function __construct($el_type){
        $this->list_type = $el_type;
        switch($el_type){
            case 'leads':
                $this->title = __('Leads','msfb');
                $this->has_category = false;
                $this->details_url = "";
                $this->add_new_url = false;
                $this->add_button = false;
                $this->has_search = false;
                $this->search_placeholder = "Search lead";
                $this->cat_type = "from";
                break;
            case 'questions':
                $this->title = __('Questions','msfb');
                $this->add_new_url = admin_url( 'admin.php?page=questions_builder&question_id' );
                $this->add_button = "Add question";
                $this->search_placeholder = "Search question by name";
                $this->cat_type = "question";
                break;
            case 'forms':
                $this->title = __('Contact forms','msfb');
                $this->add_new_url = admin_url( 'admin.php?page=contact_form_builder&form_id' );
                $this->add_button = "Add form";
                $this->search_placeholder = "Search form by name";
                $this->cat_type = "from";
                break;
            case 'formulations':
                $this->title = __('Formulations','msfb');
                $this->add_new_url = admin_url( 'admin.php?page=formula_builder&formulation_id' );
                $this->add_button = "Add formulation";
                $this->search_placeholder = "Search formulation by name";
                $this->cat_type = "fromulation";
                break;
        }
    }
    function get_header(){
        include(MSFB_PATH.'/core/list-table-templates/header.php');
    }
    function get_pagination(){
        include(MSFB_PATH.'/core/list-table-templates/pagination.php');
    }
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
    function get_cates( $intial_val = "Filter by category", $selected = null ){
        if($this->has_category && $this->cat_type){
            global $wpdb;
            $table_name = $wpdb->prefix.'msfb_category';
            $cat_type = $this->cat_type;
            $results = $wpdb->get_results("SELECT * FROM $table_name WHERE cat_type='$cat_type'",ARRAY_A);
            if($wpdb->num_rows > 0){
                ob_start();
                printf('<option value="">%s</option>',__($intial_val,'msfb'));
                foreach($results as $cat){
                    $cat_id = $cat['id'];
                    $cat_name = $cat['cat_name'];
                    $selected_txt = $cat_id == $selected ? "selected" : $cat_id;
                    printf("<option %s value='%s'>%s</option>",$selected_txt,$cat_id,$cat_name);
                }
                return ob_get_clean();
            }else{
                return false;
            }
        }
    }
    function get_table(){
        include(MSFB_PATH.'/core/list-table-templates/table.php');
    }
    function get_question_type( $name = "" ){
        if( $name == "" ){
            $qtn_types = [
                "msfb-multiselect","msfb-single-select-field","msfb-text-field","msfb-textarea-field", "msfb-date-field", "msfb-map-field","msfb-slider-field","msfb-dropdown-field", "msfb-upload-field"
            ];
            return $qtn_types;
        }
        $field_type = "";
        switch ( $name ) {
            case 'msfb-multiselect':
                $field_type = "Multiselect";
                break;
            case 'msfb-single-select-field':
                $field_type = "Single select";
                break;
            case 'msfb-text-field':
                $field_type = "Text";
                break;
            case 'msfb-textarea-field':
                $field_type = "Textarea";
                break;
            case 'msfb-map-field':
                $field_type = "Map";
                break;
            case 'msfb-date-field':
                $field_type = "Date";
                break;
            case 'msfb-slider-field':
                $field_type = "Slider";
                break;
            case 'msfb-dropdown-field':
                $field_type = "Dropdown";
                break;
            case 'msfb-upload-field':
                $field_type = "Upload";
                break;
        }
        return $field_type;
    }
    function get_actions(){
        ?>
        <div>
            <select id="msfb-bulk-action" class="sk-form-control sk-custom-select">
                <option value="">Bulk Action</option>
                <option value="delete">Delete</opstion>
            </select>
        </div>
        <div>
            <!-- <button class="skfb-btn" id="msfb-apply-bulk-action"><i class="fa fa-spinner fa-spin"></i><span>Apply</span></button> -->
            <button class="skfb-btn" id="msfb-apply-bulk-action" data-el-type="<?php echo $this->list_type; ?>"><i class="fas fa-check"></i><span>Apply</span></button>
        </div>
        <?php 
    }
}