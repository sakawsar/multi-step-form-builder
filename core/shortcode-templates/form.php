<?php
function msfb_form_step( $data ){
    $form_data = json_decode( stripcslashes( $data['form_data'] ), true );
?>
<div class="msfb-form w-4/5 m-auto flex flex-col mt-4 gap-4 <?php echo $data['step'] != 1 ? 'hidden':''; ?>" data-msfb-node="<?php echo $data['id']; ?>">
    <?php if($form_data['form_title']){ ?>
        <h1 class="text-center text-4xl"><?php echo $form_data['form_title']; ?></h1>
    <?php } ?>
    <?php if($form_data['form_desc']){ ?>
        <p class="text-center text-xl"><?php echo $form_data['form_desc']; ?></p>
    <?php } ?>
    <!-- form step -->
    <div class="msfb-form-qtn tw-msfb-qtn-field tw-msfb-form-qtn relative items-center text-xl">
        <?php if(!empty($form_data['field_data'])){
            foreach($form_data['field_data'] as $field){
        ?>

            <!-- multiselect field -->
            <?php if($field['field_type'] == "multiselect_form_field"){ ?>
            <div class="msfb-form-field msfb-form-checkbox" data-field-label="<?php echo trim(strip_tags( $field['field_label'] )); ?>">
                <label class="w-full text-lg mb-2 text-blue-400"><?php echo trim(strip_tags( $field['field_label'] )); ?></label>
                <?php foreach($field['field_data'] as $field_option){ ?>
                <label class="mr-8">
                    <input type="checkbox" value="<?php echo $field_option['value']; ?>" name="<?php echo trim(strip_tags( $field['field_label'] )); ?>"/> <?php echo $field_option['label']; ?>
                </label>
                <?php } ?>
            </div>


            <!-- select field -->
            <?php } elseif($field['field_type'] == "select_form_field"){ ?>
            <div class="msfb-form-field msfb-form-radio" data-field-label="<?php echo trim(strip_tags( $field['field_label'] )); ?>">
                <label class="w-full text-lg mb-2 text-blue-400"><?php echo trim(strip_tags( $field['field_label'] )); ?></label>
                <?php foreach($field['field_data'] as $field_option){ ?>
                <label class="mr-8">
                    <input type="radio" value="<?php echo $field_option['value']; ?>" name="<?php echo trim(strip_tags( $field['field_label'] )); ?>"/> <?php echo $field_option['label']; ?>
                </label>
                <?php } ?>
            </div>


            <!-- dropdown field -->
            <?php } elseif($field['field_type'] == "dropdown_form_field"){ ?>
            <div class="msfb-form-field msfb-form-field msfb-form-text" data-field-label="<?php echo trim(strip_tags( $field['field_label'] )); ?>">
                <label class="w-full text-lg mb-2 text-blue-400"><?php echo trim(strip_tags( $field['field_label'] )); ?></label>
                <label class="w-full shadow-md tw-msfb-dropdown-field">
                    <p>Select from dropdown</p>
                    <div class="item-holder bg-white z-50">
                        <?php 
                        $i = 1;
                        foreach( $field['field_data'] as $option) {
                        ?>
                        <div class="tw-msfb-dropdown-qtn__item tw-form-dropdown" data-dropdown-value="<?php echo $option['value']; ?>"><?php echo $option['label']; ?></div>
                        <?php $i++; } ?>
                    </div>
                </label>
            </div>


            <!-- text field -->
            <?php } elseif($field['field_type'] == "text_form_field"){ ?>
            <?php
            // echo '<pre>';
            // print_r($field);
            // echo '</pre>';
            ?>
            <div class="msfb-form-field msfb-form-field msfb-form-text" data-field-label="<?php echo trim(strip_tags( $field['field_label'] )); ?>">
                <label class="w-full text-lg mb-2 text-blue-400"><?php echo trim(strip_tags( $field['field_label'] )); ?></label>
                <label class="w-full">
                    <input type="text" placeholder="<?php echo $field['field_data']['placeholder']; ?>" class="tw-msfb-text-field w-full" value="test" name="test"/>
                </label>
            </div>


            <!-- textarea field -->
            <?php } elseif($field['field_type'] == "textarea_form_field"){ ?>
            <div class="msfb-form-field msfb-form-textarea" data-field-label="<?php echo trim(strip_tags( $field['field_label'] )); ?>">
                <label class="w-full text-lg mb-2 text-blue-400"><?php echo trim(strip_tags( $field['field_label'] )); ?></label>
                <textarea class="tw-msfb-textarea-field msfb-form-textarea w-full" placeholder="Test textarea"></textarea>
            </div>


            <!-- date field -->
            <?php } elseif($field['field_type'] == "date_form_field"){ ?>
            <div class="msfb-form-field msfb-form-date" data-field-label="<?php echo trim(strip_tags( $field['field_label'] )); ?>">
                <label class="w-full text-lg mb-2 text-blue-400"><?php echo trim(strip_tags( $field['field_label'] )); ?></label>
                <label class="w-full">
                    <input type="date" class="tw-msfb-text-field w-full" value="test" name="test"/>
                </label>
            </div>


            <!-- slider field -->
            <?php } elseif($field['field_type'] == "slider_form_field"){ ?>
            <div class="msfb-form-field msfb-form-date" data-field-label="<?php echo trim(strip_tags( $field['field_label'] )); ?>">
                <label class="w-full text-lg mb-2 text-blue-400"><?php echo trim(strip_tags( $field['field_label'] )); ?></label>
                <input type="range" class="tw-msfb-slider-field"/>
            </div>
            <?php } ?>


        <?php } } ?>
    </div>
    <!-- form step end -->
<?php 
// echo '<pre>';
// print_r($form_data);
// echo '</pre>';
}