<?php
function msfb_date_step( $data ){
    $step_data = $data['step_data'];
    $question_data = json_decode( stripslashes( $data['question_data'] ), true);
    // echo '<pre>';
    // print_r($data);
    // echo '</pre>';
?>
<div class="msfb-date w-4/5 m-auto flex flex-col mt-4 gap-4 <?php echo $data['step'] != 1 ? 'hidden':''; ?>" data-question-type="<?php echo $data['question_type']; ?>" data-msfb-node="<?php echo $data['id']; ?>">
    <?php if($data['question_title']){ ?>
        <h1 class="text-center text-4xl"><?php echo $data['question_title']; ?></h1>
    <?php } ?>
    <?php if($data['question_desc']){ ?>
        <p class="text-center text-xl"><?php echo $data['question_desc']; ?></p>
    <?php } ?>
     <!-- date field -->
    <div class="msfb-date-qtn tw-msfb-qtn-field tw-msfb-date-qtn relative">
        <input type="date" placeholder="<?php echo $question_data['placeholder']; ?>" class="tw-msfb-date-field w-full"/>
    </div>
    <!-- date field -->
<?php }