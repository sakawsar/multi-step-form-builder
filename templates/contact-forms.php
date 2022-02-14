
<?php
$form_list = new MSFB_List_Table('forms');
?>
<div class="app">
  <?php $form_list->get_header(); ?>
  <div class="skfb-content">
    <div class="skfb-datatable">
      <div class="sk-container">
        <div class="sk-row skfb--gY-20 sk-align-items-center">
          <div class="sk-col-md-8">
            <div class="sk-d-flex sk-align-items-center sk-flex-wrap sk-column-gap">
              <?php $form_list->get_actions(); ?>
            </div>
          </div>
          <div class="sk-col-md-4">
            <div class="skfb-search-box">
              <form action="">
                <input type="search" id="msfb-search-name" class="sk-form-control" placeholder="<?php echo $form_list->search_placeholder; ?>">
                <button class="skfb-search-btn"><i class="fas fa-search"></i></button>
              </form>
            </div>
          </div>
        </div>
        <div class="skfb-table-wrap">
          <?php $form_list->get_table(); ?>
          <!-- <table class="sk-table skfb-table-question">
            <thead>
              <tr>
                <th><input type="checkbox" class="sk-custom-checkbox" /></th>
                <th>Contact form name</th>
                <th>Frontend Title</th>
                <th>Author</th>
                <th>Last modified</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td><input type="checkbox" class="sk-custom-checkbox" /></td>
                <td>Contact from</td>
                <td>Test Form</td>
                <td>author</td>
                <td>2021-05-01 2:55 PM</td>
              </tr>
              <tr>
                <td><input type="checkbox" class="sk-custom-checkbox" /></td>
                <td>Contact from</td>
                <td>Test Form</td>
                <td>author</td>
                <td>2021-05-01 2:55 PM</td>
              </tr>
              <tr>
                <td><input type="checkbox" class="sk-custom-checkbox" /></td>
                <td>Contact from</td>
                <td>Test Form</td>
                <td>author</td>
                <td>2021-05-01 2:55 PM</td>
              </tr>
              <tr>
                <td><input type="checkbox" class="sk-custom-checkbox" /></td>
                <td>Contact from</td>
                <td>Test Form</td>
                <td>author</td>
                <td>2021-05-01 2:55 PM</td>
              </tr>
              <tr>
                <td><input type="checkbox" class="sk-custom-checkbox" /></td>
                <td>Contact from</td>
                <td>Test Form</td>
                <td>author</td>
                <td>2021-05-01 2:55 PM</td>
              </tr>
            </tbody>
          </table> -->
        </div>
        <?php $form_list->get_pagination(); ?>
      </div>
    </div>

  </div>
</div>