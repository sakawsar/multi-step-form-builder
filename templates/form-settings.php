<?php
global $wpdb;
$table_name = $wpdb->prefix.'msfb_forms';
$form_settings = [];
$form_data = [];
if(isset($_GET['form_id']) && sanitize_text_field( $_GET['form_id'] )){
  $form_id = sanitize_text_field( $_GET['form_id'] );
  $results = $wpdb->get_results("SELECT * FROM $table_name WHERE id='$form_id'",ARRAY_A);
  $form_data = json_decode( stripslashes( $results[0]['form_data'] ) , true );
  $form_settings = isset($form_data['settings']) ? $form_data['settings'] : [] ;
  // echo '<pre>';
  // // print_r( json_decode( stripslashes( $results[0]['form_data'] ) , true ) );
  // print_r( $form_settings );
  // echo '</pre>';
}
$field_labels = [];
$available_vars = "";
if( !empty($form_data) ) {
  foreach( $form_data['field_data'] as $a_field ) {
    $field_labels[] = '{'.$a_field['field_label'].'}';
  }
  $field_labels[] = '{totalPrice}';
  $available_vars = '<label for="senderEmail" class="skfb__with-icon"><i class="fas fa-info"></i>'.implode(', ',$field_labels).'</label>';
}
?>
<div class="app">
  <div class="skfb-container-with-sidebar skfb--no-drawer">
    <div class="skfb-header">
      <div class="sk-container">
        <div class="sk-row sk-align-items-center">
          <div class="sk-col-12">
            <div class="sk-d-flex sk-align-items-center sk-flex-wrap sk-column-gap">
              <div href="#" class="skfb-nav-logo">
                <h3>Form settings</h3>
              </div>
              <!--  -->
              <div>
                <button class="skfb-btn" id="msfb-save-form-settings" data-form-id="<?php echo $form_id; ?>"><i class="fas fa-save"></i> Save</button>
                <a href="#" class="skfb-btn"><i class="fas fa-plus"></i> Add new</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="skfb-content">
      <div class="sk-container">
        <form action="#" class="skfb__form">
          <div class="sk-row ">
            <div class="sk-col-md-6">
              <div class="skfb__field-box">
                <label for="mgs" class="skfb__with-icon" style="color:red;"><i class="fas fa-info"></i>You can place variables using the label of the form field like {Field label}. The label texts are case sensitive.</label>
                <label for="mgs" class="skfb__with-icon" style="color:red;"><i class="fas fa-info"></i>To add the total calculated price use {totalPrice} variable.</label>
                <br><label for="senderName" class="skfb__with-icon"><i class="fas fa-user"></i>Sender name - the following variables can be inserted:</label>
                <?php echo $available_vars;?>
                <input type="text" value="<?php echo isset($form_settings['sender_name']) ? $form_settings['sender_name'] : null; ?>" placeholder="Albert Einstein" id="msfb_senderName" />
              </div>
              <div class="skfb__field-box">
                <label for="senderEmail" class="skfb__with-icon"><i class="fas fa-envelope"></i>Sender email</label>
                <!-- <label for="senderEmail" class="skfb__with-icon"><i class="fas fa-envelope"></i>Sender email - the following variables can be inserted:</label> -->
                <?php //echo $available_vars;?>
                <input type="text" value="<?php echo isset($form_settings['sender_email']) ? $form_settings['sender_email'] : null; ?>" placeholder="abc@xyz.com" id="msfb_senderEmail" />
              </div>
              <div class="skfb__field-box">
                <label for="senderEmail" class="skfb__with-icon"><i class="fas fa-envelope"></i>Lead sending email</label>
                <?php //echo $available_vars;?>
                <input type="text" value="<?php echo isset($form_settings['lead_email']) ? $form_settings['lead_email'] : null; ?>" placeholder="abc@xyz.com" id="msfb_leadEmail" />
              </div>
              <div class="skfb__field-box">
                <label for="recipientEmail" class="skfb__with-icon"><i class="fas fa-envelope"></i>Recipient e-mail - the following variables can be inserted:</label>
                <?php echo $available_vars;?>
                <input type="text" value="<?php echo isset($form_settings['recipient_email']) ? $form_settings['recipient_email'] : null; ?>" placeholder="abc@xyz.com" id="msfb_recipientEmail" />
              </div>
              <div class="skfb__field-box">
                <label for="BCCRecipientEmail" class="skfb__with-icon"><i class="fas fa-envelope"></i>BCC recipient e-mail (comma separated) - the following variables can be inserted:</label>
                <?php echo $available_vars;?>
                <input type="text" value="<?php echo isset($form_settings['msfb_BCCRecipientEmail']) ? $form_settings['msfb_BCCRecipientEmail'] : null; ?>" placeholder="abc@xyz.com" id="msfb_BCCRecipientEmail" />
              </div>
              <div class="skfb__field-box">
                <label for="replyTo" class="skfb__with-icon"><i class="fas fa-envelope"></i>Reply-To (reply address) - the following variables can be inserted:</label>
                <?php echo $available_vars;?>
                <input type="text" value="<?php echo isset($form_settings['msfb_replyTo']) ? $form_settings['msfb_replyTo'] : null; ?>" placeholder="abc@xyz.com" id="msfb_replyTo" />
              </div>
              <div class="skfb__field-box">
                <label for="subject" class="skfb__with-icon"><i class="fas fa-stream"></i>Subject - the following variables can be inserted:</label>
                <?php echo $available_vars;?>
                <input type="text" value="<?php echo isset($form_settings['msfb_subject']) ? $form_settings['msfb_subject'] : null; ?>" placeholder="Placeholder subject" id="msfb_subject" />
              </div>
              <div class="skfb__field-box">
                <label for="mgs" class="skfb__with-icon"><i class="fas fa-envelope-open-text"></i>Message - the following variables can be inserted:</label>
                <?php echo $available_vars;?>
                <textarea style="height:300px;" type="text" placeholder="Messages" id="msfb_mgs"><?php echo isset($form_settings['msfb_mgs']) ? $form_settings['msfb_mgs'] : null; ?></textarea>
              </div>
              <div class="skfb__field-box">
                <label for="mgs" class="skfb__with-icon"><i class="fas fa-envelope-open-text"></i>Lead Message - the following variables can be inserted:</label>
                <?php echo $available_vars;?>
                <textarea style="height:300px;" type="text" placeholder="Messages" id="msfb_lead_mgs"><?php echo isset($form_settings['msfb_lead_mgs']) ? $form_settings['msfb_lead_mgs'] : null; ?></textarea>
              </div>
            </div> <!-- /.col- -->

            <div class="sk-col-md-6">
              <!-- <div class="sk--mb-20">
                <div class="skfb__form-title __2">Autoresponder</div>
                <div class="skfb__field-box">
                  <label for="senderName" class="skfb__with-icon"><i class="fas fa-user"></i>Sender name</label>
                  <input type="text" placeholder="Albert Einstein" id="senderName" />
                </div>
                <div class="skfb__field-box">
                  <label for="subject" class="skfb__with-icon"><i class="fas fa-stream"></i>Subject - the following variables can be inserted:</label>
                  <input type="text" placeholder="Placeholder subject" id="subject" />
                </div>
                <div class="skfb__field-box">
                  <label for="mgs" class="skfb__with-icon"><i class="fas fa-envelope-open-text"></i>Message - the following variables can be inserted:</label>
                  <input type="text" placeholder="Messages" id="mgs" />
                </div>
              </div> -->

              <!-- <div>
                <div class="skfb__form-title __2">SMTP server</div>
                <div class="skfb__field-box">
                  <label for="smtpServer" class="skfb__with-icon"><i class="fas fa-server"></i>SMTP server</label>
                  <input type="text" value="<?php echo isset($form_settings['smtp_server']) ? $form_settings['smtp_server'] : null; ?>" placeholder="123.123.123.123" id="msfb_smtpServer" />
                </div>
                <div class="skfb__field-box">
                  <label for="smtpUsername" class="skfb__with-icon"><i class="fas fa-stream"></i>SMTP username</label>
                  <input type="text" value="<?php echo isset($form_settings['smtp_username']) ? $form_settings['smtp_username'] : null; ?>" placeholder="abc@xyz.com" id="msfb_smtpUsername" />
                </div>
                <div class="sk-row">
                  <div class="sk-col-md-6">
                    <div class="skfb__field-box">
                      <label for="smtpPass" class="skfb__with-icon"><i class="fas fa-key"></i>SMTP password</label>
                      <input type="text" value="<?php echo isset($form_settings['msfb_smtpPass']) ? $form_settings['msfb_smtpPass'] : null; ?>" placeholder="########" id="msfb_smtpPass" />
                    </div>
                  </div>
                  <div class="sk-col-md-6">
                    <div class="skfb__field-box">
                      <label for="smtpPort" class="skfb__with-icon"><i class="fas fa-passport"></i>SMTP Port</label>
                      <input type="text" value="<?php echo isset($form_settings['msfb_smtpPort']) ? $form_settings['msfb_smtpPort'] : null; ?>" placeholder="467" id="msfb_smtpPort" />
                    </div>
                  </div>
                </div>
              </div> -->
            </div>
          </div> <!-- /.row -->

          <!-- <div class="skfb__submit-btn__wrapper __2">
            <button type="submit" class="skfb-btn"><i class="fas fa-save"></i>Save</button>
            <button type="submit" class="skfb-btn"><i class="fas fa-envelope"></i>Send Test Mail</button>
          </div> -->
        </form>
      </div>
    </div>
  </div>
</div>