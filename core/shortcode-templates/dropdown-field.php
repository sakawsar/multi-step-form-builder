<?php
function msfb_dropdown_step( $data ){ 
    $step_data = $data['step_data'];
    $question_data = json_decode( stripslashes( $data['question_data'] ), true);
    // echo '<pre>';
    // print_r($data);
    // echo '</pre>';
?>
<div class="msfb-dropdown w-4/5 m-auto flex flex-col mt-4 gap-4 <?php echo $data['step'] != 1 ? 'hidden':''; ?>" data-question-type="<?php echo $data['question_type']; ?>" data-msfb-node="<?php echo $data['id']; ?>">
    <?php if($data['question_title']){ ?>
        <h1 class="text-center text-4xl"><?php echo $data['question_title']; ?></h1>
    <?php } ?>
    <?php if($data['question_desc']){ ?>
        <p class="text-center text-xl"><?php echo $data['question_desc']; ?></p>
    <?php } ?>
    <?php isset($data['nav_position']) && $data['nav_position'] == 'top' ? msfb_step_navigation( $data ) : false; ?>
    <!-- dropdown -->
    <div class="msfb-multiselect-qtn tw-msfb-qtn-field tw-msfb-dropdown-qtn relative">
        <div class="tw-msfb-dropdown-field">
            <p><?php echo get_option('msfb_select_from_dropdown','Select from dropdown'); ?></p>
            <i class="fa fa-angle-down"></i>
            <div class="item-holder">
                <?php 
                $i = 1;
                foreach( $question_data['option_data'] as $a_qtn_data) {
                    $node = "";
                    if( !empty($step_data['outputs']['output_'.$i]['connections']) ) {
                        $node = $step_data['outputs']['output_'.$i]['connections'][0]['node'];
                    }
                ?>
                <div class="tw-msfb-dropdown-qtn__item" data-price="<?php echo isset($a_qtn_data['price']) ? $a_qtn_data['price'] : ""; ?>" data-next-node="<?php echo $node; ?>" data-dropdown-value="<?php echo $a_qtn_data['value']; ?>"><?php echo $a_qtn_data['option']; ?></div>
                <?php $i++; } ?>
            </div>
        </div>
    </div>
    <!-- dropdown end -->
<?php
}