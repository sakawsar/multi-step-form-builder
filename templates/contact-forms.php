
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
              <div>
                <select name="" id="" class="sk-form-control sk-custom-select">
                  <option value="">Bulk Action</option>
                  <option value="">1</option>
                  <option value="">2</option>
                </select>
              </div>
              <div>
                <button class="skfb-btn"><i class="fas fa-check"></i> <span>Apply</span></button>
              </div>
            </div>
          </div>
          <div class="sk-col-md-4">
            <div class="skfb-search-box">
              <form action="">
                <input type="search" class="sk-form-control" placeholder="Search Form">
                <button class="skfb-search-btn"><i class="fas fa-search"></i></button>
              </form>
            </div>
          </div>
        </div>
        <div class="skfb-table-wrap">
          <table class="sk-table skfb-table-question">
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
          </table>
        </div>
        <?php $form_list->get_pagination(); ?>
      </div>
    </div>

  </div>
</div>