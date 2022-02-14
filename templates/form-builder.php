<div class="app">
  <div class="skfb-container-with-sidebar">
    <div class="skfb-header">
      <div class="sk-container">
        <div class="sk-row sk-align-items-center">
          <div class="sk-col-12">
            <div class="sk-d-flex sk-align-items-center sk-flex-wrap sk-column-gap">
                <div class="skfb-nav-logo">
                  <h3>Form Builder</h3>
                </div>
                <!-- Button -->
                <div>
                  <button class="skfb-btn" id="msfb-save-form"><i class="fas fa-save"></i> Save</button>
                  <a href="#" class="skfb-btn"><i class="fas fa-plus"></i> Add new</a>
                  <a href="#" class="skfb-btn"><i class="fas fa-cog"></i> Settings</a>
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="skfb-content">
      <div class="sk-container">
        <div class="sk-row">
          <?php include(MSFB_PATH.'templates/form-builder-parts/form-tools.php'); ?>
          <!-- /.col- -->
          <div class="sk-col-md-9 sk-col-lg-10 msfb-form-builder">
            <div class="skfb__form-wrapper">
              <header class="skfb__form-header">
                <h2 class="skfb__form-title">Form title</h2>
                <p class="skfb__form-desc">Form description</p>
              </header>
              <form action="#" class="skfb__form">
                <div class="skfb__sortable-data" id="msfb-form-field-holder"></div>
                <div class="skfb__submit-btn__wrapper">
                  <button type="submit" class="skfb-btn"><i class="fas fa-envelope"></i> Send</button>
                </div>
              </form>
            </div> <!-- /.sk__form-wrapper -->
          </div> <!-- /.col- -->
        </div> <!-- /.row -->
      </div>
    </div>
  </div>
  <?php include(MSFB_PATH.'templates/form-builder-parts/form-drawer.php'); ?>
</div>