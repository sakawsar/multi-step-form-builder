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
            <label for="msfb-qtn-name">Answer price</label>
            <input type="text" class="msfb_answer_price" placeholder="Price" id="msfb-answer-price" />
        </div>
        <div class="skfb__field-box __2">
            <label for="msfb-pick-icon">Pick answer icon</label>
            <script>
                jQuery(document).ready(function(){
                    let msfb_setTimeout
                    jQuery('#msfb_search_icon').on('input',function(){
                        clearTimeout(msfb_setTimeout)
                        let this_el = jQuery(this)
                        msfb_setTimeout = setTimeout(() => {
                            let search_key = this_el.val()
                            let icons = jQuery('.msfb-icon-field-holder').find('i')
                            console.log(icons)
                            if( search_key ) {
                                icons.hide()
                            } else {
                                icons.show()
                                return
                            }
                            jQuery.each(icons,function(key,value){
                                let icon_class = jQuery(value).attr('class')
                                if( icon_class.indexOf(search_key) > -1 ) {
                                    console.log('Listed class',icon_class)
                                    jQuery(value).show()
                                } else {
                                    console.log('Not listed class')
                                }
                            })
                        }, 500)
                    })
                })
            </script>
            <input type="text" name="" id="msfb_search_icon" placeholder="<?php _e('Search icons','msfb'); ?>">
            <div class="skfb__icon_select_field skfb__overflow_scroll msfb-icon-field-holder"> 
                <?php
                include('icon_list.php');
                foreach($msfb_icons as $icon){
                    echo '<i class="'.$icon.'"></i>';
                }
                ?>
            </div>
        </div>
        <div class="skfb__field-box __2">
            <script>
                function msfb_drag_over(e){
                    e.preventDefault()
                    e.stopPropagation()
                    // console.log('dragging')
                }
            </script>
            <label for="msfb-custom-icon">Upload Custom icons
                <div ondragover="msfb_drag_over(event)" id="msfb-drop-the-file" style="padding:32px;border:4px dotted white;border-radius:8px;margin-top:8px;display: flex;flex-direction:column;gap:8px;align-items: center;justify-content: center;">
                    <i class="fa fa-upload" style="font-size:32px;"></i>
                    <p>Drag and drop</p>
                </div>
            </label>
            
            <div class=""> 
                <input id="msfb-custom-icon" style="display:none;" type="file" accept="image/*"/>
                <!-- <button id="msfb-upload-custom-icon" type="button" style="border:2px solid white;margin-bottom:16px;" class="skfb-btn">Upload</button> -->
            </div>
            <label for="msfb-pick-icon">Custom icons</label>
            <div class="skfb__icon_select_field skfb__custom_icon_select_field skfb__overflow_scroll"> 
                <?php
                $images = new WP_Query(array(
                    'post_type' => 'attachment',
                    'post_status' => 'inherit',
                    'meta_query' => array(
                        array(
                            'key'   => 'msfb_custom_icon',
                            'value' => true
                        )
                    )
                ));
                if( $images->have_posts() ) {
                    while($images->have_posts()){
                        $images->the_post();
                        $id = get_the_ID();
                        $url = wp_get_attachment_url($id);
                        echo '<img class="msfb_custom_icon_image" style="height:50px;width:auto;margin:16px 16px 0px 0px;" src="'.$url.'"/>';
                    }
                }
                ?>
            </div>
        </div>
        <?php
        return false;
    }
    ?>
    <div class="skfb__field-box __2">
        <label for="msfb-qtn-name"><?php _e('Question Name','msfb'); ?> <i class="fa fa-question-circle" title="<?php _e('You can give this question a name or a designation so that you can find it again in the questions overview.','msfb'); ?>"></i></label>
        <input type="text" value="<?php echo $has_data ? $question_data['question_name'] : ""; ?>" placeholder="Question Name" class="msfb-qtn-name" />
    </div>
    <?php 
    $cats = msfb_get_cats('question');
    if( $cats ) {
    ?>
    <div class="skfb__field-box __2">
        <label for="msfb-qtn-name"><?php _e('Question category','msfb'); ?> <i class="fa fa-question-circle" title="<?php _e('You can assign this question to a category so you can filter it later while building the q-flow.','msfb'); ?>"></i></label>
        <select name="" id="msfb-qtn-category-<?php echo $id; ?>">
            <option value=""><?php _e('Select a category','msfb'); ?></option>
            <?php foreach($cats as $a_cat){ ?>
                <option <?php selected($a_cat['id'],$question_data['cat_id'],true); ?> value="<?php echo $a_cat['id']; ?>"><?php echo $a_cat['cat_name']; ?></option>
            <?php } ?>
        </select>
    </div>
    <?php } ?>
    <div class="skfb__field-box __2">
        <label for="msfb-title"><?php _e('Question','msfb'); ?></label>
        <input type="text" placeholder="<?php _e('Question','msfb'); ?>" value="<?php echo $has_data ? $question_data['question_title'] : ""; ?>" class="msfb-title" />
    </div>
    <div class="skfb__field-box __2">
        <label for="msfb-desc">Description</label>
        <textarea class="msfb-desc" placeholder="Description"><?php echo $has_data ? $question_data['question_desc'] : ""; ?></textarea>
    </div>
    <div class="skfb__field-box __2">
        <label for="msfb-price"><?php echo isset($question_data['question_type']) && $question_data['question_type'] == "msfb-slider-field" ? "Price value per Unit" : "Price"; ?></label>
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
                    <input type="text" value="<?php echo isset($option_data['price']) ? $option_data['price'] : ""; ?>" data-msfb-field-type="price" data-dropdown-row-no="<?php echo $i; ?>" class="msfb_dropdown_data_price" placeholder="Price"/>
                    <i class="fa fa-<?php echo $i == $total_options ? "plus" : "times"; ?>-circle"></i>
                </div>
                <?php $i++; } 
                } else {
                    ?>
                    <div class="msfb-dropdown-value-field" data-dropdown-row-no="1">
                        <input type="text" value="" data-msfb-field-type="value" data-dropdown-row-no="1" class="msfb_dropdown_data_value" placeholder="Value"/>
                        <input type="text" value="" data-msfb-field-type="option" data-dropdown-row-no="1" class="msfb_dropdown_data_option" placeholder="Option"/>
                        <input type="text" value="" data-msfb-field-type="price" data-dropdown-row-no="1" class="msfb_dropdown_data_price" placeholder="Price"/>
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