<div class="app">
  <div class="skfb-container-with-sidebar">
    <div class="skfb-header">
      <div class="sk-container">
        <?php
          $has_data = false;
          $this_form_data = false;
          $form_id = false;
          if( isset($_GET['form_id']) ) {
            global $wpdb;
            $table_name = $wpdb->prefix.'msfb_forms';
            $form_id = sanitize_text_field( $_GET['form_id'] );
            $this_form_data = $wpdb->get_results("SELECT * FROM $table_name WHERE id='$form_id'",ARRAY_A);
            if( $wpdb->num_rows > 0){
              $has_data = true;
              $this_form_data = $this_form_data[0];
              $this_form_data['form_data'] = json_decode( stripslashes( $this_form_data['form_data'] ),true);
              // echo '<pre>';
              // print_r($this_form_data);
              // echo '</pre>';
            }
          }
        ?>
        <div class="sk-row sk-align-items-center">
          <div class="sk-col-12">
            <div class="sk-d-flex sk-align-items-center sk-flex-wrap sk-column-gap">
                <div class="skfb-nav-logo">
                  <h3>Form Builder</h3>
                </div>
                <!-- Button -->
                <div>
                  <button class="skfb-btn" id="msfb-save-form" <?php echo $has_data ? "data-form-id='{$form_id}'" : ""; ?>><i class="fas fa-save"></i> Save</button>
                  <a href="<?php echo admin_url( 'admin.php?page=contact_form_builder&form_id' ); ?>" class="skfb-btn"><i class="fas fa-plus"></i> Add new</a>
                  <?php if(isset($_GET['form_id']) && sanitize_text_field( $_GET['form_id'] ) != "" ) { ?>
                    <a href="<?php echo admin_url( 'admin.php?page=contact_form_builder&form_id='.sanitize_text_field( $_GET['form_id'] ).'&settings' ); ?>" class="skfb-btn"><i class="fas fa-cog"></i> Settings</a>
                  <?php } ?>
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="skfb-content">
      <div class="sk-container">
        <div class="sk-row">
          <?php include(MSFB_PATH.'templates/form-builder-parts/form-tools.php'); ?>
          <!-- /.col- -->
          <div class="sk-col-md-9 sk-col-lg-10 msfb-form-builder" <?php echo $has_data ? "data-form-name='".$this_form_data['form_name']."'" : ""; ?>>
            <div class="skfb__form-wrapper">
              <header class="skfb__form-header">
                <h2 contenteditable="true" class="skfb__form-title"><?php echo $has_data ? $this_form_data['form_data']['form_title'] : "Form title"; ?></h2>
                <textarea style="width:100%;" contenteditable="true" class="skfb__form-desc"><?php echo $has_data ? $this_form_data['form_data']['form_desc'] : "Form description"; ?></textarea>
              </header>
              <form action="#" class="skfb__form">
                <div class="skfb__sortable-data" id="msfb-form-field-holder">
                  <?php if($has_data) { ?>
                    <?php
                    foreach($this_form_data['form_data']['field_data'] as $a_field){
                      $is_required = $a_field['is_required'] == "true" ? "msfb-field-required='true'" : "";
                      $is_lead_column = $a_field['is_lead_column'] == "true" ? "msfb-field-is-lead-column='true'" : "";
                    ?>
                    <?php if( $a_field['field_type'] == "multiselect_form_field" || $a_field['field_type'] == "select_form_field" ){ ?>
                    <div <?php echo $is_required." ".$is_lead_column; ?> class="skfb__field-box skfb-form-builder-drawer" data-field-type="<?php echo $a_field['field_type']; ?>">
                      <label contenteditable="true" contenteditable="true" class="msfb-field-label"><i class="fa fa-times-circle"></i> <?php echo $a_field['field_label']; ?></label>
                      <ul class="skfb__input-option__lists">
                          <?php foreach($a_field['field_data'] as $a_option){ ?>
                          <li>
                              <input disabled="true" type="checkbox" class="sk-custom-checkbox md" id="optC1">
                              <label for="optC1" class="skfb__opt-name"><?php echo $a_option['label']; ?></label>
                          </li>
                          <?php } ?>
                      </ul>
                    </div>
                    <?php } elseif( in_array($a_field['field_type'],["text_form_field","date_form_field"]) ) { ?>
                      <div <?php echo $is_required." ".$is_lead_column; ?> class="skfb__field-box skfb-form-builder-drawer" data-field-type="<?php echo $a_field['field_type']; ?>">
                          <label contenteditable="true" class="msfb-field-label" for="textField"><i class="fa fa-times-circle"></i> <?php echo $a_field['field_label']; ?></label>
                          <input disabled="true" type="text" placeholder="<?php echo $a_field['field_data']['placeholder']; ?>" id="textField">
                      </div>
                    <?php } elseif( $a_field['field_type'] == "textarea_form_field" ) { ?>
                      <div <?php echo $is_required." ".$is_lead_column; ?> class="skfb__field-box skfb-form-builder-drawer" data-field-type="textarea_form_field">
                        <label contenteditable="true" class="msfb-field-label" for="textArea"><i class="fa fa-times-circle"></i> <?php echo $a_field['field_label']; ?></label>
                        <textarea name="textArea" cols="30" rows="4" placeholder="<?php echo $a_field['field_data']['placeholder']; ?>" id="textArea"></textarea>
                      </div>
                    <?php } elseif( $a_field['field_type'] == "slider_form_field" ) { ?>
                      <div <?php echo $is_required." ".$is_lead_column; ?> class="skfb__field-box skfb-form-builder-drawer msfb-form-field-selected" data-field-type="slider_form_field" msfb-slider-default-val="<?php echo $a_field['field_data']['default_val']; ?>" msfb-slider-max-val="<?php echo $a_field['field_data']['max_val']; ?>" msfb-slider-min-val="<?php echo $a_field['field_data']['min_val']; ?>" msfb-slider-step-val="<?php echo $a_field['field_data']['step_val']; ?>">
                        <label contenteditable="true" class="msfb-field-label"><i class="fa fa-times-circle"></i> <?php echo $a_field['field_label']; ?></label>
                          <div class="skfb-prev-input __2">
                              <div class="skfb-prev-slider">
                                  <span></span>
                              </div>
                          </div>
                      </div>
                      <?php } elseif( $a_field['field_type'] == "upload_form_field" ) { ?>
                      <div <?php echo $is_required." ".$is_lead_column; ?> class="skfb__field-box skfb-form-builder-drawer" data-field-type="upload_form_field">
                          <label class="msfb-field-label" for="upload"><i class="fa fa-times-circle"></i> <?php echo $a_field['field_label']; ?></label>
                          <input disabled="true" type="file" id="upload"/>
                      </div>
                    <?php } elseif( $a_field['field_type'] == "dropdown_form_field" ) { ?>
                      <div <?php echo $is_required." ".$is_lead_column; ?> class="skfb__field-box skfb-form-builder-drawer" data-field-type="dropdown_form_field">
                          <label contenteditable="true" class="msfb-field-label" for="date"><i class="fa fa-times-circle"></i> Dropdown</label>
                          <select>
                            <?php foreach( $a_field['field_data'] as $a_opt) { ?>
                              <option value="<?php echo $a_opt['value']; ?>"><?php echo $a_opt['label']; ?></option>
                            <?php } ?>
                          </select>
                      </div>
                    <?php } ?>
                    <?php
                    }
                    ?>
                  <?php } ?>
                </div>
                <div class="skfb__submit-btn__wrapper">
                  <button type="submit" class="skfb-btn"><i class="fas fa-envelope"></i> <?php echo get_option('msfb_form_builder_send_text') ?: "Send"; ?></button>
                </div>
              </form>
            </div> <!-- /.sk__form-wrapper -->
          </div> <!-- /.col- -->
        </div> <!-- /.row -->
      </div>
    </div>
  </div>
  <?php include(MSFB_PATH.'templates/form-builder-parts/form-drawer.php'); ?>
</div>