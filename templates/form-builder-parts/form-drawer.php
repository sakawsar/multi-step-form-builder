<div class="skfb-right-options" style="display:none;" data-drawer-type="default_options">
  <div class="sk-text-right">
    <button class="skfb-right-sidebar-close">
      <i class="fa fa-times"></i>
    </button>
  </div>
  <h5 class="sk-head __2 sk-text-white">Default Options</h5>
  <div class="skfb__field-opt__boxes skfb__overflow_scroll">
    <div class="skfb__field-box __2">
      <label for="formName">Form name</label>
      <input type="text" placeholder="Form name" id="msfb-form-name" />
    </div>
    <div class="skfb__field-box __2">
      <label for="formName">Form title</label>
      <input contenteditable="true" type="text" placeholder="Form title" value="<?php echo $has_data ? $this_form_data['form_data']['form_title'] : ""; ?>" id="msfb-form-title" />
    </div>
    <div class="skfb__field-box __2">
      <label for="formName">Form description</label>
      <textarea placeholder="Form description" id="msfb-form-desc"><?php echo $has_data ? $this_form_data['form_data']['form_desc'] : ""; ?></textarea>
    </div>
    <?php //msfb_form_field_options("slider_form_field"); ?>
  </div> 
</div>
<?php
function msfb_title_placeholder( $id ) {
  $placeholder = "";
  switch($id){
    case "multiselect_form_field":
      $placeholder = "Multiselect";
      break;
    case "select_form_field":
      $placeholder = "Select";
      break;
    case "dropdown_form_field":
      $placeholder = "Dropdown";
      break;
    case "text_form_field":
      $placeholder = "Text";
      break;
    case "upload_form_field":
      $placeholder = "Upload";
      break;
    case "textarea_form_field":
      $placeholder = "Textarea";
      break;
    case "date_form_field":
      $placeholder = "Date";
      break;
    case "slider_form_field":
      $placeholder = "Slider";
      break;
  }
}
function msfb_form_field_options( $id = "" ){
  ?>
  <div class="skfb__field-box __2">
    <label for="formName">Field label</label>
    <input type="text" placeholder="Field label" class="msfb-form-field-label" />
  </div>
  <div class="skfb__field-box __2">
    <label for="msfb-required-<?php echo $id; ?>">Required</label>
    <input type="checkbox" id="msfb-required-<?php echo $id; ?>" class="sk-custom-checkbox msfb-required msfb-form-field-required" />
  </div>
  <div class="skfb__field-box __2">
    <label for="msfb-lead-<?php echo $id; ?>-column">Lead table column?</label>
    <input type="checkbox" id="msfb-lead-<?php echo $id; ?>-column" class="sk-custom-checkbox msfb-required msfb-lead-column-field" />
  </div>
  <?php
  $option_val_data = [
    "multiselect_form_field",
    "select_form_field",
    "dropdown_form_field",
  ];
  if( in_array($id,$option_val_data) ){
    ?>
    <div class="skfb__field-box __2">
        <label for="msfb-dropdown-values">Field option data</label>
        <div class="msfb-dropdown-value-fields" data-dropdown-row-no="1">
            <div class="msfb-dropdown-value-field" data-dropdown-row-no="1">
                <input type="text" data-msfb-field-type="value" data-dropdown-row-no="1" class="msfb_dropdown_data_value" placeholder="Value"/>
                <input type="text" data-msfb-field-type="option" data-dropdown-row-no="1" class="msfb_dropdown_data_option" placeholder="Option"/>
                <i class="fa fa-plus-circle"></i>
            </div>
        </div>
    </div>
    <?php
  }
  $placholder_fields = [
    "text_form_field", "textarea_form_field", "date_form_field"
  ];
  if( in_array($id,$placholder_fields) ){
    ?>
    <div class="skfb__field-box __2">
        <label for="msfb-placeholder-field">Placeholder</label>
        <input type="text" value="" class="msfb-placeholder-field" placeholder="Placeholder" />
    </div>
    <?php
  }
  if( $id == "slider_form_field" ){
    ?>
    <div class="skfb__field-box __2">
        <label for="msfb-slider-default-value">Default value</label>
        <input type="number" value="" placeholder="Default value" id="msfb-slider-default-value" />
    </div>
    <div class="skfb__field-box __2">
        <label for="msfb-slider-max-value">Maximum value</label>
        <input type="number" value="" placeholder="Maximum value" id="msfb-slider-max-value" />
    </div>
    <div class="skfb__field-box __2">
        <label for="msfb-slider-min-value">Minimum value</label>
        <input type="number" value="" placeholder="Minimum value" id="msfb-slider-min-value" />
    </div>
    <div class="skfb__field-box __2">
        <label for="msfb-slider-step">Step</label>
        <input type="number" value="" placeholder="Step" step="0.01" id="msfb-slider-step" />
    </div>
    <?php
  }
}
?>
<!-- multiselect form -->
<div class="skfb-right-options" style="display:none;" data-drawer-type="multiselect_form_field">
  <div class="sk-text-right">
    <button class="skfb-right-sidebar-close">
      <i class="fa fa-times"></i>
    </button>
  </div>
  <h5 class="sk-head __2 sk-text-white">Multiselect Options</h5>
  <div class="skfb__field-opt__boxes skfb__overflow_scroll">
    <?php msfb_form_field_options("multiselect_form_field"); ?>
  </div> 
</div>
<!-- select form -->
<div class="skfb-right-options" style="display:none;" data-drawer-type="select_form_field">
  <div class="sk-text-right">
    <button class="skfb-right-sidebar-close">
      <i class="fa fa-times"></i>
    </button>
  </div>
  <h5 class="sk-head __2 sk-text-white">Single select options</h5>
  <div class="skfb__field-opt__boxes skfb__overflow_scroll">
    <?php msfb_form_field_options("select_form_field"); ?>
  </div> 
</div>
<!-- dropdown form -->
<div class="skfb-right-options" style="display:none;" data-drawer-type="dropdown_form_field">
  <div class="sk-text-right">
    <button class="skfb-right-sidebar-close">
      <i class="fa fa-times"></i>
    </button>
  </div>
  <h5 class="sk-head __2 sk-text-white">Dropdown options</h5>
  <div class="skfb__field-opt__boxes skfb__overflow_scroll">
    <?php msfb_form_field_options("dropdown_form_field"); ?>
  </div> 
</div>
<!-- text form -->
<div class="skfb-right-options" style="display:none;" data-drawer-type="text_form_field">
  <div class="sk-text-right">
    <button class="skfb-right-sidebar-close">
      <i class="fa fa-times"></i>
    </button>
  </div>
  <h5 class="sk-head __2 sk-text-white">Text field options</h5>
  <div class="skfb__field-opt__boxes skfb__overflow_scroll">
    <?php msfb_form_field_options("text_form_field"); ?>
  </div> 
</div>
<!-- upload form field-->
<div class="skfb-right-options" style="display:none;" data-drawer-type="upload_form_field">
  <div class="sk-text-right">
    <button class="skfb-right-sidebar-close">
      <i class="fa fa-times"></i>
    </button>
  </div>
  <h5 class="sk-head __2 sk-text-white">Upload field options</h5>
  <div class="skfb__field-opt__boxes skfb__overflow_scroll">
    <?php msfb_form_field_options("upload_form_field"); ?>
  </div> 
</div>
<!-- textarea form -->
<div class="skfb-right-options" style="display:none;" data-drawer-type="textarea_form_field">
  <div class="sk-text-right">
    <button class="skfb-right-sidebar-close">
      <i class="fa fa-times"></i>
    </button>
  </div>
  <h5 class="sk-head __2 sk-text-white">Textarea options</h5>
  <div class="skfb__field-opt__boxes skfb__overflow_scroll">
    <?php msfb_form_field_options("textarea_form_field"); ?>
  </div> 
</div>
<!-- textarea form -->
<div class="skfb-right-options" style="display:none;" data-drawer-type="date_form_field">
  <div class="sk-text-right">
    <button class="skfb-right-sidebar-close">
      <i class="fa fa-times"></i>
    </button>
  </div>
  <h5 class="sk-head __2 sk-text-white">Date field options</h5>
  <div class="skfb__field-opt__boxes skfb__overflow_scroll">
    <?php msfb_form_field_options("date_form_field"); ?>
  </div> 
</div>
<!-- slider form -->
<div class="skfb-right-options" style="display:none;" data-drawer-type="slider_form_field">
  <div class="sk-text-right">
    <button class="skfb-right-sidebar-close">
      <i class="fa fa-times"></i>
    </button>
  </div>
  <h5 class="sk-head __2 sk-text-white">Slider Options</h5>
  <div class="skfb__field-opt__boxes skfb__overflow_scroll">
    <?php msfb_form_field_options("slider_form_field"); ?>
  </div> 
</div>