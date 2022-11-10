<div class="app">
  <div class="skfb-container-with-sidebar">
    <div class="skfb-header">
      <div class="sk-container">
        <?php
         $has_data = false;
         $this_formula_data = false;
         $formula_id = false;
         $formula_name = false;
         if( isset($_GET['formulation_id']) ) {
           global $wpdb;
           $table_name = $wpdb->prefix.'msfb_formulations';
           $formula_id = sanitize_text_field( $_GET['formulation_id'] );
           $this_formula_data = $wpdb->get_results("SELECT * FROM $table_name WHERE id='$formula_id'",ARRAY_A);
           if( $wpdb->num_rows > 0){
             $has_data = true;
             $this_formula_data = $this_formula_data[0];
             $this_formula_data['formulation_data'] = json_decode( stripslashes( $this_formula_data['formulation_data'] ),true);
             $formula_name =  $this_formula_data['formulation_name'];
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
                <h3>Formula builder</h3>
              </div>
              <div>
                <button class="skfb-btn" <?php echo $has_data ? "data-formula-id='{$formula_id}'" : ""; ?> <?php echo $has_data ? "data-formula-name='{$formula_name}'" : ""; ?> id="msfb-formulation-builder"><i class="fas fa-save"></i> Save</button>
                <a href="<?php echo admin_url( 'admin.php?page=formula_builder&formulation_id' ); ?>" class="skfb-btn"><i class="fas fa-plus"></i> Add new</a>
                <?php if(isset($_GET['formulation_id']) && sanitize_text_field( $_GET['formulation_id'] ) != "" ) { ?>
                  <a id="msfb-formulation-settings" href="<?php echo admin_url( 'admin.php?page=formula_builder&formulation_id='.sanitize_text_field( $_GET['formulation_id'] ).'&settings' ); ?>" class="skfb-btn"><i class="fas fa-cog"></i> Settings</a>
                  <button class="skfb-btn" id="msfb-preview-formula-btn" type="button"><i class="fa fa-eye"></i> Preview</button>
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
          <div class="sk-col-md-3 sk-col-lg-2 skfb__overflow_scroll">
            <div class="skfb-feilds-panel">
              <h6 class="sk-head skfb-bb-primary sk-text-primary">Search questions</h6>
              <!-- <div class="skfb__field-box __3">
                <select class="sk-form-control sk-custom-select skfb__custom-select">
                  <option value="">Element type</option>
                  <option value="question">Question</option>
                  <option value="form">Forms</option>
                </select>
              </div>
              <div class="skfb__field-box __3">
                <select class="sk-form-control sk-custom-select skfb__custom-select">
                  <option value="">All field type questions</option>
                  <option value="msfb-multiselect">Multiselect</option>
                  <option value="msfb-single-select-field">Single select</option>
                  <option value="msfb-text-field">Text</option>
                  <option value="msfb-textarea-field">Textarea</option>
                  <option value="msfb-date-field">Date</option>
                  <option value="msfb-slider-field">Slider</option>
                  <option value="msfb-map-field">Map</option>
                  <option value="msfb-dropdown-field">Dropdown</option>
                  <option value="msfb-upload-field">File upload</option>
                </select>
              </div> -->
              <div class="skfb-search-box __2">
                <form action="#">
                  <input type="search" class="sk-form-control" id="msfb-search-formula-element" placeholder="Search Elements by Name">
                  <button class="skfb-search-btn"><i class="fas fa-search"></i></button>
                </form>
              </div>
              <?php
              global $wpdb;
              $cat_table = $wpdb->prefix.'msfb_category';
              $qt_cats = $wpdb->get_results("SELECT * FROM  $cat_table WHERE cat_type in ('question','from')");
              ?>
              <h6 class="sk-head skfb-bb-primary sk-text-primary">Filter questions</h6>
              <!-- <h6 class="sk-head skfb-bb-primary sk-text-primary">Filter <span style="padding:2px 4px;background:#4992ff;color:white;">questions</span>/<span style="padding:2px 4px;background:yellow;color:black;">forms</span></h6> -->
              <div style="margin-top:8px;" class="skfb-search-box __2">
                    <style>
                      /* #msfb_list_questions_by_category option[data-type="question"]{
                        border-top:4px solid white;
                        background:#4992ff;
                      }
                      #msfb_list_questions_by_category option[data-type="from"]{
                        border-top:4px solid white;
                        background:yellow;
                        color:black;
                      }
                      #msfb_list_questions_by_category option:hover{
                        background:gray!important;
                      } */
                      .msfb-filter-tab{
                        display:flex;
                        flex-direction:row;
                        gap: 4px;
                        justify-content: center;
                        margin-bottom:16px;
                        border-bottom:1px solid #4992ff;
                      }
                      .msfb-filter-tab div{
                        border: 1px solid #4992ff;
                        border-bottom:1px solid white;
                        padding:8px 16px;
                        border-radius: 8px 8px 0px 0px;
                        z-index:999;
                        color:#4992ff;
                      }
                      .msfb-filter-tab div:hover{
                        /* position:absolute; */
                        border: 1px solid ##4992ff;
                        border-bottom:1px solid #4992ff;
                        padding:8px 16px;
                        border-radius: 8px 8px 0px 0px;
                        z-index:999;
                        color:white;
                        background: #4992ff;
                      }
                      .msfb-tab-selected{
                        margin-bottom:-1px;
                      }
                    </style>
                  <div class="msfb-filter-tab">
                    <div class="msfb-qtn-tab msfb-tab-selected">
                      <p>Question</p>
                    </div>
                    <div class="msfb-form-tab">
                      <p>Form</p>
                    </div>
                  </div>
                  <select class="sk-form-control" id="msfb_list_questions_by_category">
                    <option value="">Filter questions by category</option>
                    <?php foreach($qt_cats as $a_cat){ if( $a_cat->cat_type != "question") continue; ?>
                      <option data-type="<?php echo $a_cat->cat_type; ?>" value="<?php echo $a_cat->id; ?>"><?php echo $a_cat->cat_name; ?></option>
                    <?php } ?>
                  </select>
                  <h6 class="sk-head skfb-bb-primary sk-text-primary">Filter forms</h6>
                  <!-- <h6 class="sk-head skfb-bb-primary sk-text-primary">Filter <span style="padding:2px 4px;background:#4992ff;color:white;">questions</span>/<span style="padding:2px 4px;background:yellow;color:black;">forms</span></h6> -->
                  <select class="sk-form-control" id="msfb_list_questions_by_category2">
                    <option value="">Filter forms by category</option>
                    <?php foreach($qt_cats as $a_cat){ if( $a_cat->cat_type != "from") continue; ?>
                      <option data-type="<?php echo $a_cat->cat_type; ?>" value="<?php echo $a_cat->id; ?>"><?php echo $a_cat->cat_name; ?></option>
                    <?php } ?>
                  </select>
                <!-- <form action="#">
                  <input type="search" class="sk-form-control" id="msfb-search-formula-element" placeholder="Search Elements by Name">
                  <button class="skfb-search-btn"><i class="fas fa-search"></i></button>
                </form> -->
              </div>
              <?php
              $form_table = $wpdb->prefix.'msfb_forms';
              $question_table = $wpdb->prefix.'msfb_questions';
              $all_questions = $wpdb->get_results("SELECT * FROM $question_table",ARRAY_A);
              $all_questions = array_map(function($a_qtn){
                $a_qtn['question_data'] = json_decode( stripcslashes($a_qtn['question_data']), true );
                return $a_qtn;
              }, $all_questions);
              $all_forms = $wpdb->get_results("SELECT * FROM $form_table",ARRAY_A);
              $all_forms = array_map(function($a_frm){
                $a_frm['form_data'] = json_decode( stripcslashes($a_frm['form_data']), true );
                return $a_frm;
              }, $all_forms);
              ?>
              <?php foreach($all_questions as $a_question) { ?>
              <div data-element-type="question" data-element-cat-id="<?php echo $a_question['cat_id']; ?>" data-question-type="<?php echo $a_question['question_type']; ?>" data-element-name="<?php echo $a_question['question_name']; ?>" class="skfb-card skfb-feild-draggable" draggable="true" ondragstart="<?php echo 'drag'; ?>(event)" data-node="question-<?php echo $a_question['id']; ?>">
                <div class="sk-row sk-align-items-center">
                  <div class="sk-col-12">
                    <div class="skfb-prev-input">
                      <?php if($a_question['question_type'] == "msfb-slider-field") { ?>
                        <div class="skfb-prev-slider">
                          <span></span>
                        </div>
                      <?php } elseif( $a_question['question_type'] == "msfb-date-field" ){ ?>
                        <div class="skfb-prev-text">
                          <span>Date: YYYY-MM-DD</span>
                          <i class="fas fa-calendar-alt"></i>
                        </div>
                      <?php } elseif( $a_question['question_type'] == "msfb-multiselect" ){ ?>
                        <ul class="skfb-prev-checkbox">
                          <li><span></span></li>
                          <li class="active"><span></span></li>
                          <li><span></span></li>
                          <li class="active"><span></span></li>
                          <li><span></span></li>
                        </ul>
                      <?php } elseif( $a_question['question_type'] == "msfb-dropdown-field" ){ ?>
                        <div class="skfb-prev-text">
                          <span>Select option</span>
                          <i class="fas fa-chevron-down"></i>
                        </div>
                      <?php } elseif( $a_question['question_type'] == "msfb-upload-field" ){ ?>
                        <div class="skfb-prev-text">
                          <span>Upload file</span>
                          <i class="fas fa-cloud-upload"></i>
                        </div>
                      <?php } elseif( $a_question['question_type'] == "msfb-map-field" ){ ?>
                        <div class="skfb-prev-text">
                          <span>Write an address..</span>
                          <i class="fas fa-map-location"></i>
                        </div>
                      <?php } elseif( $a_question['question_type'] == "msfb-single-select-field" ){ ?>
                        <ul class="skfb-prev-checkbox">
                          <li><span></span></li>
                          <li class="active"><span></span></li>
                          <li><span></span></li>
                          <li><span></span></li>
                          <li><span></span></li>
                        </ul>
                      <?php } elseif( $a_question['question_type'] == "msfb-text-field" ){ ?>
                        <div class="skfb-prev-text">
                          <span>Write something..</span>
                        </div>
                      <?php } elseif( $a_question['question_type'] == "msfb-textarea-field" ){ ?>
                        <div class="skfb-prev-text">
                          <span>Write Message..</span>
                        </div>
                      <?php } ?>
                    </div>
                    <p><?php echo $a_question['question_name']; ?></p>
                  </div>
                </div>
              </div>
              <?php } ?>
              <?php foreach($all_forms as $a_form) { ?>
                <div data-element-type="form" data-element-cat-id="<?php echo $a_form['cat_id']; ?>" data-element-name="<?php echo $a_form['form_name']; ?>" class="skfb-card skfb-feild-draggable" draggable="true" ondragstart="<?php echo 'drag'; ?>(event)" data-node="form-<?php echo $a_form['id']; ?>">
                  <div class="sk-row sk-align-items-center">
                    <div class="sk-col-12">
                      <div class="skfb-prev-input" style="color:gray;text-align:center;">
                        <i class="fa fa-list"></i>
                      </div>
                      <p><?php echo $a_form['form_name']; ?></p>
                    </div>
                  </div>
                </div>
              <?php } ?>
            </div>
          </div> <!-- /.col- -->
          <div class="sk-col-md-9 sk-col-lg-10" id="msfb_drawflow" ondrop="drop(event)" ondragover="allowDrop(event)">
            <!-- <div class="btn-lock">
              <i id="lock" class="fas fa-lock" onclick="editor.editor_mode='fixed'; changeMode('lock');"></i>
              <i id="unlock" class="fas fa-lock-open" onclick="editor.editor_mode='edit'; changeMode('unlock');" style="display:none;"></i>
            </div> -->
            <div class="bar-zoom">
              <i class="fas fa-search-minus" title="Zoom Out" id="msfb_drawflow_zoom_out"></i>
              <i class="fas fa-search" title="Zoom Reset" id="msfb_drawflow_zoom_reset"></i>
              <i class="fas fa-search-plus" title="Zoom In" id="msfb_drawflow_zoom_in"></i>
            </div>
          </div> <!-- /.col- -->
          <?php if( $formula_id ) { ?>
          <div class="sk-col-md-9 sk-col-lg-9" id="msfb-preview-formula" style="display:none;">
            <?php echo do_shortcode("[msfb_multistep_form disabled='yes' id='".$formula_id."']"); ?>
          </div>
          <?php } ?>
        </div> <!-- /.row -->
        <!-- <div class="sk-row">
          <div class="sk-col-md-3 sk-col-lg-3"></div>
          
        </div> -->
      </div>
    </div>
  </div>
<?php include(MSFB_PATH.'templates/formulation-builder-parts/formulation-drawer.php'); ?>