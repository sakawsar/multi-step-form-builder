<!-- multiselect -->
<div class="sk-col-md-9 sk-col-lg-10 msfb-multiselect" data-msfb-active="<?php echo !empty($question_data) && $question_data['question_type'] == "msfb-multiselect" || empty($question_data) ? 1 : 0; ?>" data-body-type="msfb-multiselect" style="<?php msfb_question_body_show($question_id,'msfb-multiselect'); ?>" data-qtn-name="<?php echo !empty($question_data) ? $question_data['question_name'] : ""; ?>">
    <div class="skfb__form-wrapper">
        <header class="skfb__form-header">
        <h2 class="skfb__form-title skfb_question_seleted"><?php echo !empty($question_data) ? $question_data['question_title'] : "Title"; ?></h2>
        <p class="skfb__form-desc"><?php echo !empty($question_data) ? $question_data['question_desc'] : "Description"; ?></p>
        </header>

        <div class="skfb__question-builder">
            <div class="sk-row sk-justify-content-center sk-no-gutters msfb-multiselect-holder">
                <?php
                if(!empty($question_data) && $question_data['question_type'] == "msfb-multiselect"){
                    $i = 1;
                    foreach($question_data['question_data'] as $answer){
                        ?>
                        <div class="sk-col-lg-6 sk-col-xl-3" data-multiselect-no="<?php echo $i; ?>">
                            <div class="skfb__builder-box skfb-form-builder-drawer">
                                <div class="skfb__builder-top">
                                    <div class="icon">
                                        <i class="<?php echo $answer['icon_class']; ?>"></i>
                                    </div>
                                </div>
                                <div class="skfb__builder-bottom">
                                    <p class="skfb__answer" data-price="<?php echo isset($answer['price']) ? $answer['price'] : ""; ?>"><?php echo $answer['answer']; ?></p>
                                </div>
                            </div>
                        </div>
                        <?php
                        $i++;
                    }
                }
                ?>
            </div> <!-- /.row -->
            <div class="sk-row sk-justify-content-center" style="margin-top:8px;">
                <div class="sk-col-lg-6 sk-col-xl-2 msfb-multiselect-add">
                    <div class="skfb__builder-box skfb__builder-add">
                        <div class="icon">
                            <i class="fas fa-plus"></i>
                        </div>
                    </div> <!-- /.skfb__builder-box -->
                </div> <!-- /.col- -->
            </div>
        </div> <!-- /.skfb__question-builder -->
    </div> <!-- /.sk__form-wrapper -->
</div> <!-- /.col- -->
<!-- date time -->
<div class="sk-col-md-9 sk-col-lg-10 msfb-date-field" data-msfb-active="<?php echo !empty($question_data) && $question_data['question_type'] == "msfb-date-field" ? 1 : 0; ?>" data-msfb-date-format="Y-m-d" data-body-type="msfb-date-field" style="<?php msfb_question_body_show($question_id,'msfb-date-field'); ?>" data-qtn-name="<?php echo !empty($question_data) ? $question_data['question_name'] : ""; ?>">
    <div class="skfb__form-wrapper">
        <header class="skfb__form-header">
        <h2 class="skfb__form-title skfb_question_seleted"><?php echo !empty($question_data) ? $question_data['question_title'] : "Title"; ?></h2>
        <p class="skfb__form-desc"><?php echo !empty($question_data) ? $question_data['question_desc'] : "Description"; ?></p>
        </header>

        <form action="#" class="skfb__form">
        <div class="skfb__field-box skfb-form-builder-drawer">
            <?php $data_placeholder = !empty($question_data) && $question_data['question_type'] == "msfb-date-field" ? $question_data['question_data']['placeholder'] : false; ?>
            <input type="text" placeholder="<?php echo $data_placeholder ?: "YYYY-MM-DD"; ?>" id="date" data-id="datepicker" />
        </div>
        </form>
    </div> <!-- /.sk__form-wrapper -->
</div> <!-- /.col- -->
<!-- map field -->
<div class="sk-col-md-9 sk-col-lg-10 msfb-map-field" data-msfb-active="<?php echo !empty($question_data) && $question_data['question_type'] == "msfb-map-field" ? 1 : 0; ?>" data-body-type="msfb-map-field" style="<?php msfb_question_body_show($question_id,'msfb-map-field'); ?>" data-qtn-name="<?php echo !empty($question_data) ? $question_data['question_name'] : ""; ?>">
    <div class="skfb__form-wrapper __2">
        <header class="skfb__form-header">
        <h2 class="skfb__form-title skfb_question_seleted"><?php echo !empty($question_data) ? $question_data['question_title'] : "Title"; ?></h2>
        <p class="skfb__form-desc"><?php echo !empty($question_data) ? $question_data['question_desc'] : "Description"; ?></p>
        </header>
        <div class="sk-row">
        <div class="sk-col-md-6">
            <div class="skfb__field-box __4 skfb-form-builder-drawer">
            <label for="street">Street</label>
            <input type="text" id="street" />
            </div>

            <div class="skfb__field-box __4 skfb-form-builder-drawer">
            <label for="no">No.</label>
            <input type="text" id="no" />
            </div>

            <div class="skfb__field-box __4 skfb-form-builder-drawer">
            <label for="place">Place</label>
            <input type="text" id="place" />
            </div>

            <div class="skfb__field-box __4 skfb-form-builder-drawer">
            <label for="location ">Location </label>
            <input type="text" id="location " />
            </div>
        </div>

        <div class="sk-col-md-6">
            <iframe style="width: 100%"
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d24497.97057123768!2d-75.20193464399321!3d39.868720083668215!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c6c511062d49d5%3A0x713dec520a840a7e!2sNational%20Park%2C%20NJ%2008063%2C%20USA!5e0!3m2!1sen!2sbd!4v1642292878923!5m2!1sen!2sbd"
            width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
        </div>
        </div>
    </div> <!-- /.sk__form-wrapper -->
</div> <!-- /.col- -->
<!-- select field -->
<div class="sk-col-md-9 sk-col-lg-10 msfb-dropdown-field" data-msfb-active="<?php echo !empty($question_data) && $question_data['question_type'] == "msfb-dropdown-field" ? 1 : 0; ?>" data-body-type="msfb-dropdown-field" style="<?php msfb_question_body_show($question_id,'msfb-dropdown-field'); ?>" data-qtn-name="<?php echo !empty($question_data) ? $question_data['question_name'] : ""; ?>">
    <div class="skfb__form-wrapper">
        <header class="skfb__form-header">
        <h2 class="skfb__form-title skfb_question_seleted"><?php echo !empty($question_data) ? $question_data['question_title'] : "Title"; ?></h2>
        <p class="skfb__form-desc"><?php echo !empty($question_data) ? $question_data['question_desc'] : "Description"; ?></p>
        </header>

        <div class="sk-row sk-justify-content-center">
        <div class="sk-col-md-7">
            <div class="skfb__field-box __2">
            <select class="sk-form-control sk-custom-select skfb__custom-select">
                <?php
                if(isset($question_data['question_data']) && $question_data['question_type'] == "msfb-dropdown-field"){
                    foreach($question_data['question_data']['option_data'] as $a_opt){
                        printf('<option value="%s">%s</option>',$a_opt['value'],$a_opt['option']);
                    }
                } else {
                    echo '<option value="">1</option>';
                }
                ?>
            </select>
            </div>
        </div>
        </div>
    </div> <!-- /.sk__form-wrapper -->
</div> <!-- /.col- -->
<!-- single select -->
<div class="sk-col-md-9 sk-col-lg-10 msfb-single-select-field" data-msfb-active="<?php echo !empty($question_data) && $question_data['question_type'] == "msfb-single-select-field" ? 1 : 0; ?>" data-body-type="msfb-single-select-field" style="<?php msfb_question_body_show($question_id,'msfb-single-select-field'); ?>" data-qtn-name="<?php echo !empty($question_data) ? $question_data['question_name'] : ""; ?>">
    <div class="skfb__form-wrapper">
        <header class="skfb__form-header">
        <h2 class="skfb__form-title skfb_question_seleted"><?php echo !empty($question_data) ? $question_data['question_title'] : "Title"; ?></h2>
        <p class="skfb__form-desc"><?php echo !empty($question_data) ? $question_data['question_desc'] : "Description"; ?></p>
        </header>

        <div class="skfb__question-builder">
            <div class="sk-row sk-justify-content-center sk-no-gutters msfb-multiselect-holder">
            <?php
                if(!empty($question_data) && $question_data['question_type'] == "msfb-single-select-field"){
                    $i = 1;
                    foreach($question_data['question_data'] as $answer){
                        ?>
                        <div class="sk-col-lg-6 sk-col-xl-3" data-multiselect-no="<?php echo $i; ?>">
                            <div class="skfb__builder-box skfb-form-builder-drawer">
                                <div class="skfb__builder-top">
                                    <div class="icon">
                                        <i class="<?php echo $answer['icon_class']; ?>"></i>
                                    </div>
                                </div>
                                <div class="skfb__builder-bottom">
                                    <p class="skfb__answer" data-price="<?php echo isset($answer['price']) ? $answer['price'] : ""; ?>"><?php echo $answer['answer']; ?></p>
                                </div>
                            </div>
                        </div>
                        <?php
                         $i++;
                    }
                }
                ?>
            </div> <!-- /.row -->
            <div class="sk-row sk-justify-content-center" style="margin-top:8px;">
                <div class="sk-col-lg-6 sk-col-xl-2 msfb-multiselect-add">
                    <div class="skfb__builder-box skfb__builder-add">
                        <div class="icon">
                            <i class="fas fa-plus"></i>
                        </div>
                    </div> <!-- /.skfb__builder-box -->
                </div> <!-- /.col- -->
            </div>
        </div> <!-- /.skfb__question-builder -->
    </div> <!-- /.sk__form-wrapper -->
</div> <!-- /.col- -->
<!-- slider select -->
<?php
$slider_data = !empty($question_data) && $question_data['question_type'] == "msfb-slider-field" ? $question_data : false;
?>
<div class="sk-col-md-9 sk-col-lg-10 msfb-slider-field" data-msfb-active="<?php echo !empty($question_data) && $question_data['question_type'] == "msfb-slider-field" ? 1 : 0; ?>" data-body-type="msfb-slider-field" style="<?php msfb_question_body_show($question_id,'msfb-slider-field'); ?>" data-msfb-default-val="<?php echo $slider_data ? $slider_data['question_data']['default_val'] : "10"; ?>" data-msfb-step-value="<?php echo $slider_data && isset($slider_data['question_data']['step']) ? $slider_data['question_data']['step'] : "0.01"; ?>" data-qtn-name="<?php echo !empty($question_data) ? $question_data['question_name'] : ""; ?>">
    <div class="skfb__form-wrapper">
        <header class="skfb__form-header">
            <h2 class="skfb__form-title skfb_question_seleted"><?php echo !empty($question_data) ? $question_data['question_title'] : "Title"; ?></h2>
            <p class="skfb__form-desc"><?php echo !empty($question_data) ? $question_data['question_desc'] : "Description"; ?></p>
        </header>
        <div class="skfb__field-box skfb-form-builder-drawer">
            <div class="skfb__range-slider">
                <div class="skfb__value">Default Value: <?php echo $slider_data ? $slider_data['question_data']['default_val'] : "10"; ?></div>
                <div class="skfb-prev-input">
                    <div class="skfb-prev-slider">
                        <span></span>
                    </div>
                </div>
                <div class="skfb__range-minMax">
                    <div class="skfb__range-min"><?php echo $slider_data ? $slider_data['question_data']['min_val'] : "0"; ?></div>
                    <div class="skfb__range-max"><?php echo $slider_data ? $slider_data['question_data']['max_val'] : "50"; ?></div>
                </div>
            </div>
        </div>
    </div> <!-- /.sk__form-wrapper -->
</div> <!-- /.col- -->
<!-- text field -->
<div class="sk-col-md-9 sk-col-lg-10 msfb-text-field" data-msfb-active="<?php echo !empty($question_data) && $question_data['question_type'] == "msfb-text-field" ? 1 : 0; ?>" data-body-type="msfb-text-field"  style="<?php msfb_question_body_show($question_id,'msfb-text-field'); ?>" data-qtn-name="<?php echo !empty($question_data) ? $question_data['question_name'] : ""; ?>">
    <div class="skfb__form-wrapper">
        <header class="skfb__form-header">
            <h2 class="skfb__form-title skfb_question_seleted"><?php echo !empty($question_data) ? $question_data['question_title'] : "Title"; ?></h2>
            <p class="skfb__form-desc"><?php echo !empty($question_data) ? $question_data['question_desc'] : "Description"; ?></p>
        </header>

        <form action="#" class="skfb__form">
        <div class="skfb__field-box skfb-form-builder-drawer">
            <?php $text_placeholder = !empty($question_data) && $question_data['question_type'] == "msfb-text-field" ? $question_data['question_data']['placeholder'] : false; ?>
            <input type="text" placeholder="<?php echo $text_placeholder ?: 'Text color would be blue'; ?>" id="textField" />
        </div>
        </form>
    </div> <!-- /.sk__form-wrapper -->
</div> <!-- /.col- -->
<!-- textarea field -->
<div class="sk-col-md-9 sk-col-lg-10 msfb-textarea-field" data-msfb-active="<?php echo !empty($question_data) && $question_data['question_type'] == "msfb-textarea-field" ? 1 : 0; ?>" data-body-type="msfb-textarea-field" style="<?php msfb_question_body_show($question_id,'msfb-textarea-field'); ?>" data-qtn-name="<?php echo !empty($question_data) ? $question_data['question_name'] : ""; ?>">
    <div class="skfb__form-wrapper">
        <header class="skfb__form-header">
            <h2 class="skfb__form-title skfb_question_seleted"><?php echo !empty($question_data) ? $question_data['question_title'] : "Title"; ?></h2>
            <p class="skfb__form-desc"><?php echo !empty($question_data) ? $question_data['question_desc'] : "Description"; ?></p>
        </header>

        <form action="#" class="skfb__form">
        <div class="skfb__field-box skfb-form-builder-drawer">
            <?php $textarea_placeholder = !empty($question_data) && $question_data['question_type'] == "msfb-textarea-field" ? $question_data['question_data']['placeholder'] : false; ?>
            <textarea name="textArea" cols="30" rows="16" placeholder="<?php echo $textarea_placeholder ?: "color would be blue"; ?>" id="textArea"></textarea>
        </div>
        </form>
    </div> <!-- /.sk__form-wrapper -->
</div> <!-- /.col- -->
<!-- upload field -->
<div class="sk-col-md-9 sk-col-lg-10 msfb-upload-field" data-msfb-active="<?php echo !empty($question_data) && $question_data['question_type'] == "msfb-upload-field" ? 1 : 0; ?>" data-body-type="msfb-upload-field" style="<?php msfb_question_body_show($question_id,'msfb-upload-field'); ?>" data-qtn-name="<?php echo !empty($question_data) ? $question_data['question_name'] : ""; ?>">
    <div class="skfb__form-wrapper">
        <header class="skfb__form-header">
            <h2 class="skfb__form-title skfb_question_seleted"><?php echo !empty($question_data) ? $question_data['question_title'] : "Title"; ?></h2>
            <p class="skfb__form-desc"><?php echo !empty($question_data) ? $question_data['question_desc'] : "Description"; ?></p>
        </header>

        <div class="skfb__uploader skfb-form-builder-drawer">
        <div class="skfb__icon">
            <i class="fas fa-cloud-upload-alt"></i>
        </div>
        </div> <!-- /.skfb__uploader -->
    </div> <!-- /.sk__form-wrapper -->
</div> <!-- /.col- -->