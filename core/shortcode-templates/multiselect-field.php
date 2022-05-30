<?php
function msfb_multiselect_step( $data ){
    $step_data = $data['step_data'];
    $question_data = json_decode( stripcslashes( $data['question_data'] ), true);
?>
<div class="msfb-multiselect w-4/5 m-auto flex flex-col mt-4 gap-4 <?php echo $data['step'] != 1 ? 'hidden':''; ?>" data-question-type="<?php echo $data['question_type']; ?>" data-msfb-node="<?php echo $data['id']; ?>">
    <?php if($data['question_title']){ ?>
        <h1 class="text-center text-4xl"><?php echo $data['question_title']; ?></h1>
    <?php } ?>
    <?php if($data['question_desc']){ ?>
        <p class="text-center text-xl"><?php echo $data['question_desc']; ?></p>
    <?php } ?>
    <!-- select -->
    <div class="msfb-multiselect-qtn tw-msfb-qtn-field tw-msfb-multiselect-qtn">
        <?php 
        $i = 1;
        foreach($question_data as $option){
            $node = "";
            if( !empty($step_data['outputs']['output_1']['connections']) ) {
                $node = $step_data['outputs']['output_1']['connections'][0]['node'];
            }
        ?>
        <div class="tw-msfb-multiselect-qtn__item" data-price="<?php echo isset($option['price']) ? $option['price'] : ""; ?>" data-next-node="<?php echo $node; ?>">
            <i class="<?php echo $option['icon_class']; ?>"></i>
            <p><?php echo $option['answer']; ?></p>
        </div>
        <?php $i++; } ?>
    </div>
<?php } ?>