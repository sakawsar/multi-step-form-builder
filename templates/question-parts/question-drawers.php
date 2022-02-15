<?php
function msfb_mendatory_fields( $id, $question_data ){
    $has_data = !empty($question_data) ?: false;
    if( $id == "msfb-multiselect-ans" ){
        ?>
        <div class="skfb__field-box __2">
            <label for="msfb-qtn-name">Answer</label>
            <input type="text" class="msfb_answer" placeholder="Answer" id="msfb-answer" />
        </div>
        <div class="skfb__field-box __2">
            <label for="msfb-pick-icon">Pick answer icon</label>
            <div class="skfb__icon_select_field skfb__overflow_scroll"> 
                <?php
                include('icon_list.php');
                foreach($msfb_icons as $icon){
                    echo '<i class="'.$icon.'"></i>';
                }
                ?>
            </div>
        </div>
        <?php
        return false;
    }
    ?>
    <div class="skfb__field-box __2">
        <label for="msfb-qtn-name">Question Name</label>
        <input type="text" value="<?php echo $has_data ? $question_data['question_name'] : ""; ?>" placeholder="Question Name" class="msfb-qtn-name" />
    </div>
    <div class="skfb__field-box __2">
        <label for="msfb-title">Title</label>
        <input type="text" placeholder="Title" value="<?php echo $has_data ? $question_data['question_title'] : ""; ?>" class="msfb-title" />
    </div>
    <div class="skfb__field-box __2">
        <label for="msfb-desc">Description</label>
        <textarea class="msfb-desc" placeholder="Description"><?php echo $has_data ? $question_data['question_desc'] : ""; ?></textarea>
    </div>
    <div class="skfb__field-box __2">
        <label for="msfb-price">Price</label>
        <input type="number" placeholder="Price" value="<?php echo $has_data ? $question_data['question_price'] : ""; ?>" class="msfb-price" />
    </div>
    <div class="skfb__field-box __2">
        <label for="msfb-required">Required</label>
        <input type="checkbox" <?php echo $has_data && $question_data['question_required'] ? "checked" : ""; ?> class="sk-custom-checkbox msfb-required" />
    </div>
    <?php 
    $has_placeholder = [
        "msfb-text-field",
        "msfb-textarea-field",
        "msfb-date-field"
    ];
    if( in_array($id,$has_placeholder) ){ ?>
        <div class="skfb__field-box __2">
            <label for="msfb-placeholder">Placeholder</label>
            <input type="text" placeholder="Placeholder" value="<?php echo $has_data && $question_data['question_type'] == $id ? $question_data['question_data']['placeholder'] : ""; ?>" class="msfb-placeholder" />
        </div>
    <?php }
    if( $id == "msfb-date-field"){
        $date_format = $has_data && $question_data['question_type'] == "msfb-date-field" ? $question_data['question_data']['date_format'] : false;
        ?>
        <div class="skfb__field-box __2">
            <label for="formName">Date format</label>
            <select class="sk-form-control sk-custom-select skfb__custom-select skfb__date_format">
                <option value="">Choose a date format</option>
                <option <?php echo $date_format == "Y-m-d" ? "selected" : ""; ?> value="Y-m-d"><?php echo date('Y-m-d',current_time( 'timestamp' )); ?></option>
                <option <?php echo $date_format == "d m, Y" ? "selected" : ""; ?> value="d m, Y"><?php echo date('d m, Y',current_time( 'timestamp' )); ?></option>
                <option <?php echo $date_format == "m-d-Y" ? "selected" : ""; ?> value="m-d-Y"><?php echo date('m-d-Y',current_time( 'timestamp' )); ?></option>
                <option <?php echo $date_format == "M d, Y" ? "selected" : ""; ?> value="M d, Y"><?php echo date('M d, Y',current_time( 'timestamp' )); ?></option>
            </select>
        </div>
        <?php
    }
    if( $id == "msfb-dropdown-field" ){
    ?>
       <div class="skfb__field-box __2">
            <label for="msfb-dropdown-values">Dropdown option data</label>
            <div class="msfb-dropdown-value-fields" data-dropdown-row-no="1">
                <?php
                $i = 1;
                $total_options = $has_data && $id == "msfb-dropdown-field" && isset($question_data['question_data']['option_data']) ? count($question_data['question_data']['option_data']) : false;
                // $total_options = 2;
                // $total_options = !$has_data && !isset($question_data['question_data']['option_data']) ?: count($question_data['question_data']['option_data']);
                if( $has_data ){
                foreach($question_data['question_data']['option_data'] as $option_data){
                ?>
                <div class="msfb-dropdown-value-field" data-dropdown-row-no="<?php echo $i; ?>">
                    <input type="text" value="<?php echo $option_data['value']; ?>" data-msfb-field-type="value" data-dropdown-row-no="<?php echo $i; ?>" class="msfb_dropdown_data_value" placeholder="Value"/>
                    <input type="text" value="<?php echo $option_data['option']; ?>" data-msfb-field-type="option" data-dropdown-row-no="<?php echo $i; ?>" class="msfb_dropdown_data_option" placeholder="Option"/>
                    <i class="fa fa-<?php echo $i == $total_options ? "plus" : "times"; ?>-circle"></i>
                </div>
                <?php $i++; } 
                } else {
                    ?>
                    <div class="msfb-dropdown-value-field" data-dropdown-row-no="1">
                        <input type="text" value="" data-msfb-field-type="value" data-dropdown-row-no="1" class="msfb_dropdown_data_value" placeholder="Value"/>
                        <input type="text" value="" data-msfb-field-type="option" data-dropdown-row-no="1" class="msfb_dropdown_data_option" placeholder="Option"/>
                        <i class="fa fa-plus-circle"></i>
                    </div>
                    <?php
                }?>
            </div>
        </div>
    <?php 
    }
    if( $id == "msfb-slider-field" ) {
        $slider_data = $has_data && $question_data['question_type'] == "msfb-slider-field" ? $question_data['question_data'] : false;
    ?>
        <div class="skfb__field-box __2">
            <label for="msfb-slider-default-value">Default value</label>
            <input type="number" value="<?php echo $slider_data && isset($slider_data['default_val']) ? $slider_data['default_val'] : ""; ?>" placeholder="Default value" class="msfb-slider-default-value" />
        </div>
        <div class="skfb__field-box __2">
            <label for="msfb-slider-max-value">Maximum value</label>
            <input type="number" value="<?php echo $slider_data && isset($slider_data['max_val']) ? $slider_data['max_val'] : ""; ?>" placeholder="Maximum value" class="msfb-slider-max-value" />
        </div>
        <div class="skfb__field-box __2">
            <label for="msfb-slider-min-value">Minimum value</label>
            <input type="number" value="<?php echo $slider_data && isset($slider_data['min_val']) ? $slider_data['min_val'] : ""; ?>" placeholder="Minimum value" class="msfb-slider-min-value" />
        </div>
        <div class="skfb__field-box __2">
            <label for="msfb-slider-step">Step</label>
            <input type="number" value="<?php echo $slider_data && isset($slider_data['step']) ? $slider_data['step'] : ""; ?>" placeholder="Step" step="0.01" class="msfb-slider-step" />
        </div>
    <?php
    }
}
?>
<!-- multiselect drawer -->
<div class="skfb-right-options msfb-multiselect" data-drawer-type="msfb-multiselect">
    <div class="sk-text-right">
        <button class="skfb-right-sidebar-close">
        <i class="fa fa-times"></i>
        </button>
    </div>
    <h5 class="sk-head __2 sk-text-white">Multiselect options</h5>
    <div class="skfb__field-opt__boxes skfb__overflow_scroll">
        <?php msfb_mendatory_fields('msfb-multiselect',$question_data); ?>
    </div> <!-- /.skfb__field-opt__boxes skfb__overflow_scroll -->
</div>
<!-- select options -->
<div class="skfb-right-options msfb-single-select-field" data-drawer-type="msfb-single-select-field">
    <div class="sk-text-right">
        <button class="skfb-right-sidebar-close">
        <i class="fa fa-times"></i>
        </button>
    </div>
    <h5 class="sk-head __2 sk-text-white">Single Select options</h5>
    <div class="skfb__field-opt__boxes skfb__overflow_scroll">
        <?php msfb_mendatory_fields('msfb-single-select',$question_data); ?>
    </div> <!-- /.skfb__field-opt__boxes skfb__overflow_scroll -->
</div>
<!-- Map options -->
<div class="skfb-right-options msfb-map-field" data-drawer-type="msfb-map-field">
    <div class="sk-text-right">
        <button class="skfb-right-sidebar-close">
        <i class="fa fa-times"></i>
        </button>
    </div>
    <h5 class="sk-head __2 sk-text-white">Map options</h5>
    <div class="skfb__field-opt__boxes skfb__overflow_scroll">
        <?php msfb_mendatory_fields('msfb-map-field',$question_data); ?>
    </div> <!-- /.skfb__field-opt__boxes skfb__overflow_scroll -->
</div>
<!-- Dropdown options -->
<div class="skfb-right-options msfb-dropdown-field" data-drawer-type="msfb-dropdown-field">
    <div class="sk-text-right">
        <button class="skfb-right-sidebar-close">
            <i class="fa fa-times"></i>
        </button>
    </div>
    <h5 class="sk-head __2 sk-text-white">Dropdown options</h5>
    <div class="skfb__field-opt__boxes skfb__overflow_scroll">
        <?php msfb_mendatory_fields('msfb-dropdown-field',$question_data); ?>
    </div> <!-- /.skfb__field-opt__boxes skfb__overflow_scroll -->
</div>
<!-- single select op    tions -->
<div class="skfb-right-options msfb-single-select-field" data-drawer-type="msfb-single-select-field">
    <div class="sk-text-right">
        <button class="skfb-right-sidebar-close">
        <i class="fa fa-times"></i>
        </button>
    </div>
    <h5 class="sk-head __2 sk-text-white">Single select options</h5>
    <div class="skfb__field-opt__boxes skfb__overflow_scroll">
        <?php msfb_mendatory_fields('msfb-single-select-field',$question_data); ?>
    </div> <!-- /.skfb__field-opt__boxes skfb__overflow_scroll -->
</div>
<!-- Slider options -->
<div class="skfb-right-options msfb-slider-field" data-drawer-type="msfb-slider-field">
    <div class="sk-text-right">
        <button class="skfb-right-sidebar-close">
        <i class="fa fa-times"></i>
        </button>
    </div>
    <h5 class="sk-head __2 sk-text-white">Slider options</h5>
    <div class="skfb__field-opt__boxes skfb__overflow_scroll">
        <?php msfb_mendatory_fields('msfb-slider-field',$question_data); ?>
    </div> <!-- /.skfb__field-opt__boxes skfb__overflow_scroll -->
</div>
<!-- text options -->
<div class="skfb-right-options msfb-text-field" data-drawer-type="msfb-text-field">
    <div class="sk-text-right">
        <button class="skfb-right-sidebar-close">
        <i class="fa fa-times"></i>
        </button>
    </div>
    <h5 class="sk-head __2 sk-text-white">Text options</h5>
    <div class="skfb__field-opt__boxes skfb__overflow_scroll">
        <?php msfb_mendatory_fields('msfb-text-field',$question_data); ?>
    </div> <!-- /.skfb__field-opt__boxes skfb__overflow_scroll -->
</div>
<!-- textarea options -->
<div class="skfb-right-options msfb-textarea-field" data-drawer-type="msfb-textarea-field">
    <div class="sk-text-right">
        <button class="skfb-right-sidebar-close">
        <i class="fa fa-times"></i>
        </button>
    </div>
    <h5 class="sk-head __2 sk-text-white">Textarea options</h5>
    <div class="skfb__field-opt__boxes skfb__overflow_scroll">
        <?php msfb_mendatory_fields('msfb-textarea-field',$question_data); ?>
    </div> <!-- /.skfb__field-opt__boxes skfb__overflow_scroll -->
</div>
<!-- file upload options -->
<div class="skfb-right-options msfb-upload-field" data-drawer-type="msfb-upload-field">
    <div class="sk-text-right">
        <button class="skfb-right-sidebar-close">
        <i class="fa fa-times"></i>
        </button>
    </div>
    <h5 class="sk-head __2 sk-text-white">File upload options</h5>
    <div class="skfb__field-opt__boxes skfb__overflow_scroll">
        <?php msfb_mendatory_fields('msfb-upload-field',$question_data); ?>
    </div> <!-- /.skfb__field-opt__boxes skfb__overflow_scroll -->
</div>
<!-- date options -->
<div class="skfb-right-options msfb-date-field" data-drawer-type="msfb-date-field">
    <div class="sk-text-right">
        <button class="skfb-right-sidebar-close">
        <i class="fa fa-times"></i>
        </button>
    </div>
    <h5 class="sk-head __2 sk-text-white">Date options</h5>
    <div class="skfb__field-opt__boxes skfb__overflow_scroll">
        <?php msfb_mendatory_fields('msfb-date-field',$question_data); ?>
    </div> <!-- /.skfb__field-opt__boxes skfb__overflow_scroll -->
</div>
<!-- date options -->
<div class="skfb-right-options msfb-multiselect-ans" data-drawer-type="msfb-multiselect-ans">
    <div class="sk-text-right">
        <button class="skfb-right-sidebar-close">
        <i class="fa fa-times"></i>
        </button>
    </div>
    <h5 class="sk-head __2 sk-text-white">Answer options</h5>
    <div class="skfb__field-opt__boxes skfb__overflow_scroll">
        <?php msfb_mendatory_fields('msfb-multiselect-ans',$question_data); ?>
    </div> <!-- /.skfb__field-opt__boxes skfb__overflow_scroll -->
</div>