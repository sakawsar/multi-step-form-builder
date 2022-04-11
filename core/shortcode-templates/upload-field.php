<?php
function msfb_upload_step( $data ){
    $step_data = $data['step_data'];
    $question_data = json_decode( stripslashes( $data['question_data'] ), true);
    // echo '<pre>';
    // print_r($question_data);
    // echo '</pre>';
?>
    <div class="msfb-upload w-4/5 m-auto flex flex-col mt-4 gap-4 <?php echo $data['step'] != 1 ? 'hidden':''; ?>" data-question-type="<?php echo $data['question_type']; ?>" data-msfb-node="<?php echo $data['id']; ?>">
        <?php if($data['question_title']){ ?>
            <h1 class="text-center text-4xl"><?php echo $data['question_title']; ?></h1>
        <?php } ?>
        <?php if($data['question_desc']){ ?>
            <p class="text-center text-xl"><?php echo $data['question_desc']; ?></p>
        <?php } ?>
        <!-- upload field -->
        <div class="msfb-upload-qtn tw-msfb-qtn-field tw-msfb-upload-qtn relative">
            <label class="tw-msfb-upload-field flex flex-col items-center justify-center gap-4">
                <input type="file" class="hidden"/>
                <i class="fa fa-upload text-8xl text-gray-400"></i>
                <p class="text-gray-400">Drag & Drop</p>
            </label>
        </div>
        <!-- upload field end -->
<?php }