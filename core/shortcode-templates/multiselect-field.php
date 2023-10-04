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
        <p style="white-space: pre-wrap;" class="text-center text-xl"><?php echo $data['question_desc']; ?></p>
    <?php } ?>
    <?php isset($data['nav_position']) && $data['nav_position'] == 'top' ? msfb_step_navigation( $data ) : false; ?>
    <?php
    $question_id = $data['item_id'];
    $routes = get_option('msfb_multistep_routes') ?: [];
    // var_dump($data);
    $route_data = isset($routes[$question_id]) ? $routes[$question_id] : false;
    // $get_question = msfb_get_question($question_id);
    ?>
    <!-- select -->
    <div class="msfb-multiselect-qtn tw-msfb-qtn-field tw-msfb-multiselect-qtn" data-node-route='<?php echo json_encode($step_data['outputs']); ?>' data-route-data='<?php echo json_encode($route_data); ?>'>
        <?php 
        $i = 1;
        foreach($question_data as $option){
            $node = "";
            if( !empty($step_data['outputs']['output_'.$i]['connections']) ) {
                $node = $step_data['outputs']['output_'.$i]['connections'][0]['node'];
            }
        ?>
        <div class="tw-msfb-multiselect-qtn__item" data-price="<?php echo isset($option['price']) ? $option['price'] : ""; ?>" data-next-node="<?php echo $node; ?>">
            <?php if ( isset($option['icon_class']) ) { ?>
                <i class="<?php echo $option['icon_class']; ?>"></i>
            <?php } elseif( isset($option['img_url']) ) { ?>
                <img style="height:6rem;" src="<?php echo $option['img_url']; ?>"/>
            <?php } ?>
            <p><?php echo $option['answer']; ?></p>
        </div>
        <?php $i++; } ?>
    </div>
<?php } ?>