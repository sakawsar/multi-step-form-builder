<div class="app">
  <div class="skfb-container-with-sidebar">
    <div class="skfb-header">
      <div class="sk-container">
        <div class="sk-row sk-align-items-center">
          <div class="sk-col-12">
            <div class="sk-d-flex sk-align-items-center sk-flex-wrap sk-column-gap">
              <div class="skfb-nav-logo">
                <h3>Formula builder</h3>
              </div>
              <div>
                <button class="skfb-btn"><i class="fas fa-save"></i> Save</button>
                <a href="#" class="skfb-btn"><i class="fas fa-plus"></i> Add new</a>
                <a href="#" class="skfb-btn"><i class="fas fa-cog"></i> Settings</a>
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
              <h6 class="sk-head skfb-bb-primary sk-text-primary">Click to select field</h6>
              <div class="skfb__field-box __3">
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
              </div>
              <div class="skfb-search-box __2">
                <form action="#">
                  <input type="search" class="sk-form-control" placeholder="Search Elements by Name">
                  <button class="skfb-search-btn"><i class="fas fa-search"></i></button>
                </form>
              </div>
              <?php
              global $wpdb;
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
              <div data-element-type="question" data-question-type="<?php echo $a_question['question_type']; ?> data-element-name="<?php echo $a_question['question_name']; ?> class="skfb-card skfb-feild-draggable" draggable="true" ondragstart="<?php echo 'drag'; ?>(event)" data-node="question-<?php echo $a_question['id']; ?>">
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
                <div data-element-type="form" data-element-name="<?php echo $a_form['form_name']; ?>" class="skfb-card skfb-feild-draggable" draggable="true" ondragstart="<?php echo 'drag'; ?>(event)" data-node="form-<?php echo $a_form['id']; ?>">
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
          <div class="sk-col-md-9 sk-col-lg-10" id="msfb_drawflow" style="min-height:600px;" ondrop="drop(event)" ondragover="allowDrop(event)"></div> <!-- /.col- -->
        </div> <!-- /.row -->
      </div>
    </div>
  </div>
<?php include(MSFB_PATH.'templates/formulation-builder-parts/formulation-drawer.php'); ?>