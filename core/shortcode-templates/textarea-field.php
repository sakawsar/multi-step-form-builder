<?php
function msfb_textarea_step( $data ){ 
    $step_data = $data['step_data'];
    $question_data = json_decode( stripslashes( $data['question_data'] ), true);
    // echo '<pre>';
    // print_r($question_data);
    // echo '</pre>';
?>
<div data-price="<?php echo isset($data['question_price']) && $data['question_price'] != "" ? $data['question_price'] : ""; ?>" class="msfb-textarea w-4/5 m-auto flex flex-col mt-4 gap-4 <?php echo $data['step'] != 1 ? 'hidden':''; ?>" data-question-type="<?php echo $data['question_type']; ?>" data-msfb-node="<?php echo $data['id']; ?>">
    <?php if($data['question_title']){ ?>
        <h1 class="text-center text-4xl"><?php echo $data['question_title']; ?></h1>
    <?php } ?>
    <?php if($data['question_desc']){ ?>
        <p class="text-center text-xl"><?php echo $data['question_desc']; ?></p>
    <?php } ?>
    <?php isset($data['nav_position']) && $data['nav_position'] == 'top' ? msfb_step_navigation( $data ) : false; ?>
    <!-- textarea field -->
    <div class="msfb-textarea-qtn tw-msfb-qtn-field tw-msfb-textarea-qtn relative">
        <textarea placeholder="<?php echo $question_data['placeholder']; ?>" class="tw-msfb-textarea-field"></textarea>
    </div>
    <!-- textarea field -->
<?php }