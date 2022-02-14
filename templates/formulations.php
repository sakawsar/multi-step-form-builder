<?php
$formula_list = new MSFB_List_Table('formulations');
?>
<div class="app">
  <?php $formula_list->get_header(); ?>
  <!-- <div class="skfb-header">
    <div class="sk-container">
      <div class="sk-row sk-align-items-center">
        <div class="sk-col-12">
          <div class="sk-d-flex sk-align-items-center sk-flex-wrap sk-column-gap">
            <div class="skfb-nav-logo">
              <h3>Formulations</h3>
            </div>
            <div>
              <a href="<?php echo admin_url( 'admin.php?page=formula_builder&formulation_id' ); ?>" class="skfb-btn"><i class="fas fa-plus"></i><span>Add Formulation</span></a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div> -->

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
                <input type="search" class="sk-form-control" placeholder="Search formulations">
                <button class="skfb-search-btn"><i class="fas fa-search"></i></button>
              </form>
            </div>
          </div>
        </div>
        <div class="skfb-table-wrap">
          <table class="sk-table skfb-table-question">
            <thead>
              <tr>
                <th><input type="checkbox" class="sk-custom-checkbox"></th>
                <th>Formula Title</th>
                <th>Shortcode</th>
                <th>Leads</th>
                <th>Last modified</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td><input type="checkbox" class="sk-custom-checkbox"></td>
                <td>Formula</td>
                <td>[form_shortcode id="1"]</td>
                <td>author</td>
                <td>2021-05-01 2:55 PM</td>
              </tr>
              <tr>
                <td><input type="checkbox" class="sk-custom-checkbox"></td>
                <td>Formula</td>
                <td>[form_shortcode id="1"]</td>
                <td>author</td>
                <td>2021-05-01 2:55 PM</td>
              </tr>
              <tr>
                <td><input type="checkbox" class="sk-custom-checkbox"></td>
                <td>Formula</td>
                <td>[form_shortcode id="1"]</td>
                <td>author</td>
                <td>2021-05-01 2:55 PM</td>
              </tr>
              <tr>
                <td><input type="checkbox" class="sk-custom-checkbox"></td>
                <td>Formula</td>
                <td>[form_shortcode id="1"]</td>
                <td>author</td>
                <td>2021-05-01 2:55 PM</td>
              </tr>
              <tr>
                <td><input type="checkbox" class="sk-custom-checkbox"></td>
                <td>Formula</td>
                <td>[form_shortcode id="1"]</td>
                <td>author</td>
                <td>2021-05-01 2:55 PM</td>
              </tr>
              <tr>
                <td><input type="checkbox" class="sk-custom-checkbox"></td>
                <td>Formula</td>
                <td>[form_shortcode id="1"]</td>
                <td>author</td>
                <td>2021-05-01 2:55 PM</td>
              </tr>
              <tr>
                <td><input type="checkbox" class="sk-custom-checkbox"></td>
                <td>Formula</td>
                <td>[form_shortcode id="1"]</td>
                <td>author</td>
                <td>2021-05-01 2:55 PM</td>
              </tr>
            </tbody>
          </table>
        </div>
        <?php $formula_list->get_pagination(); ?>
        <!-- <div class="skfb-table-pagination-wrap">
          <ul class="skfb-table-pagination">
            <li class="skfb-paginate-arrow"><a href="#" class="skfb-next"><i class="fas fa-long-arrow-alt-left"></i></a></li>
            <li><a href="#">
                <p class="skfb-table-pagination-indecator"></p>
                <p class="skfb-table-pagination-number">1</p>
              </a></li>
            <li class="active"><a href="#">
                <p class="skfb-table-pagination-indecator"></p>
                <p class="skfb-table-pagination-number">2</p>
              </a></li>
            <li><a href="#">
                <p class="skfb-table-pagination-indecator"></p>
                <p class="skfb-table-pagination-number">...</p>
              </a></li>
            <li><a href="#">
                <p class="skfb-table-pagination-indecator"></p>
                <p class="skfb-table-pagination-number">12</p>
              </a></li>
            <li class="skfb-paginate-arrow"><a href="#" class="skfb-next"><i class="fas fa-long-arrow-alt-right"></i></a></li>
          </ul>
        </div> -->
      </div>
    </div>

  </div>
</div>