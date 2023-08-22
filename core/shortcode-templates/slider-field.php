<?php
function msfb_slider_step( $data ){
    $step_data = $data['step_data'];
    $question_data = json_decode( stripslashes( $data['question_data'] ), true);
    $min_val = isset($question_data['min_val']) ? $question_data['min_val'] : 0;
    $max_val = isset($question_data['max_val']) ? $question_data['max_val'] : 10;
    $step = isset($question_data['step']) ? $question_data['step'] : 1;
    $default_val = isset($question_data['default_val']) ? $question_data['default_val'] : 5;
    // echo '<pre>';
    // print_r($question_data);
    // echo '</pre>';
?>
<div data-base-price="<?php echo isset($data['question_price']) && $data['question_price'] != "" ? $data['question_price'] : ""; ?>"  data-price="<?php echo isset($data['question_price']) && $data['question_price'] != "" ? floatval($data['question_price']) * floatval($default_val) : ""; ?>" class="msfb-slider w-4/5 m-auto flex flex-col mt-4 gap-4 <?php echo $data['step'] != 1 ? 'hidden':''; ?>" data-question-type="<?php echo $data['question_type']; ?>" data-msfb-node="<?php echo $data['id']; ?>">
    <?php if($data['question_title']){ ?>
        <h1 class="text-center text-4xl"><?php echo $data['question_title']; ?></h1>
    <?php } ?>
    <?php if($data['question_desc']){ ?>
        <p style="white-space: pre-wrap;" class="text-center text-xl"><?php echo $data['question_desc']; ?></p>
    <?php } ?>
    <?php isset($data['nav_position']) && $data['nav_position'] == 'top' ? msfb_step_navigation( $data ) : false; ?>
    <!-- slider -->
    <div class="msfb-slider-qtn tw-msfb-qtn-field tw-msfb-slider-qtn relative items-center text-xl">
        <p class="mb-8 msfb-slider-field-value">Value: <strong><?php echo $default_val; ?></strong></p>
        <input type="range" step="<?php echo $step; ?>" class="tw-msfb-slider-field" min="<?php echo $min_val; ?>" max="<?php echo $max_val; ?>"  value="<?php echo $default_val; ?>"/>
        <div class="flex flex-row justify-between w-full mt-4">
            <p class="msfb-min-val"><strong><?php echo $min_val; ?></strong></p>
            <p class="msfb-max-val"><strong><?php echo $max_val; ?></strong></p>
        </div>
    </div>
    <!-- slider end -->
<?php }