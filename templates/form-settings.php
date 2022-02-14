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
                <button class="skfb-btn"><i class="fas fa-save"></i> Save</button>
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
                <label for="senderName" class="skfb__with-icon"><i class="fas fa-user"></i>Sender name</label>
                <input type="text" placeholder="Albert Einstein" id="senderName" />
              </div>
              <div class="skfb__field-box">
                <label for="senderEmail" class="skfb__with-icon"><i class="fas fa-envelope"></i>Sender email</label>
                <input type="text" placeholder="abc@xyz.com" id="senderEmail" />
              </div>
              <div class="skfb__field-box">
                <label for="recipientEmail" class="skfb__with-icon"><i class="fas fa-envelope"></i>Recipient e-mail</label>
                <input type="text" placeholder="abc@xyz.com" id="recipientEmail" />
              </div>
              <div class="skfb__field-box">
                <label for="BCCRecipientEmail" class="skfb__with-icon"><i class="fas fa-envelope"></i>BCC recipient e-mail (comma separated)</label>
                <input type="text" placeholder="abc@xyz.com" id="BCCRecipientEmail" />
              </div>
              <div class="skfb__field-box">
                <label for="replyTo" class="skfb__with-icon"><i class="fas fa-envelope"></i>Reply-To (reply address) - the following placeholders can be inserted:</label>
                <input type="text" placeholder="abc@xyz.com" id="replyTo" />
              </div>
              <div class="skfb__field-box">
                <label for="subject" class="skfb__with-icon"><i class="fas fa-stream"></i>Subject - the following placeholders can be inserted:</label>
                <input type="text" placeholder="Placeholder subject" id="subject" />
              </div>
              <div class="skfb__field-box">
                <label for="mgs" class="skfb__with-icon"><i class="fas fa-envelope-open-text"></i>Message - the following placeholders can be inserted:</label>
                <input type="text" placeholder="Messages" id="mgs" />
              </div>
            </div> <!-- /.col- -->

            <div class="sk-col-md-6">
              <div class="sk--mb-20">
                <div class="skfb__form-title __2">Autoresponder</div>
                <div class="skfb__field-box">
                  <label for="senderName" class="skfb__with-icon"><i class="fas fa-user"></i>Sender name</label>
                  <input type="text" placeholder="Albert Einstein" id="senderName" />
                </div>
                <div class="skfb__field-box">
                  <label for="subject" class="skfb__with-icon"><i class="fas fa-stream"></i>Subject - the following placeholders can be inserted:</label>
                  <input type="text" placeholder="Placeholder subject" id="subject" />
                </div>
                <div class="skfb__field-box">
                  <label for="mgs" class="skfb__with-icon"><i class="fas fa-envelope-open-text"></i>Message - the following placeholders can be inserted:</label>
                  <input type="text" placeholder="Messages" id="mgs" />
                </div>
              </div>

              <div>
                <div class="skfb__form-title __2">SMTP server</div>
                <div class="skfb__field-box">
                  <label for="smtpServer" class="skfb__with-icon"><i class="fas fa-server"></i>SMTP server</label>
                  <input type="text" placeholder="123.123.123.123" id="smtpServer" />
                </div>
                <div class="skfb__field-box">
                  <label for="smtpUsername" class="skfb__with-icon"><i class="fas fa-stream"></i>SMTP username</label>
                  <input type="text" placeholder="abc@xyz.com" id="smtpUsername" />
                </div>
                <div class="sk-row">
                  <div class="sk-col-md-6">
                    <div class="skfb__field-box">
                      <label for="smtpPass" class="skfb__with-icon"><i class="fas fa-key"></i>SMTP password</label>
                      <input type="text" placeholder="########" id="smtpPass" />
                    </div>
                  </div>
                  <div class="sk-col-md-6">
                    <div class="skfb__field-box">
                      <label for="smtpPort" class="skfb__with-icon"><i class="fas fa-passport"></i>SMTP Port</label>
                      <input type="text" placeholder="467" id="smtpPort" />
                    </div>
                  </div>
                </div>
              </div>
            </div> <!-- /.col- -->
          </div> <!-- /.row -->

          <div class="skfb__submit-btn__wrapper __2">
            <button type="submit" class="skfb-btn"><i class="fas fa-save"></i>Save</button>
            <button type="submit" class="skfb-btn"><i class="fas fa-envelope"></i>Send Test Mail</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>