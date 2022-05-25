<?php
$leads_list = new MSFB_List_Table('leads');
?>
<div class="app" data-lead-table="true">
  <?php $leads_list->get_header(); ?>
  <!-- <div class="skfb-header">
    <div class="sk-container">
      <div class="sk-row sk-align-items-center">
        <div class="sk-col-sm-6">
          <div class="skfb-nav-logo">
            <h3>Leads</h3>
          </div>
        </div>
        <div class="sk-col-sm-6">
          <div class="sk-row">
            <div class="sk-col-md-3 sk-col-lg-6"></div>
            <div class="sk-col-md-9 sk-col-lg-6">
              <div class="skfb-header-nav-filters">
                <form action="">
                  <select name="" id="" class="sk-form-control sk-custom-select">
                    <option value="">Lead 1</option>
                    <option value="">Lead 2</option>
                    <option value="">Lead 3</option>
                  </select>
                </form>
              </div>
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
                <button class="skfb-btn"><i class="fas fa-file-export"></i> <span>Export</span></button>
              </div>
            </div>
          </div>
          <div class="sk-col-md-4">
            <div class="skfb-search-box">
              <form action="">
                <input type="search" class="sk-form-control" placeholder="Search leads">
                <button class="skfb-search-btn"><i class="fas fa-search"></i></button>
              </form>
            </div>
          </div>
        </div>
        <div class="skfb-table-wrap">
          <table class="sk-table">
            <thead>
              <tr>
                <th><input type="checkbox" class="sk-custom-checkbox"></th>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Message</th>
                <th>Phone number</th>
                <th>IP</th>
                <th>Details</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td><input type="checkbox" class="sk-custom-checkbox"></td>
                <td>1</td>
                <td>Tamim</td>
                <td>contact@tmaimikbal.com</td>
                <td>This is test message</td>
                <td>01817271727</td>
                <td>127.00.20.22</td>
                <td>
                  <a href="leads-details.html" class="skfb-btn">
                    <i class="fas fa-list-ul"></i>
                    <span>Details</span>
                  </a>
                </td>
              </tr>
              <tr>
                <td><input type="checkbox" class="sk-custom-checkbox"></td>
                <td>1</td>
                <td>Tamim</td>
                <td>contact@tmaimikbal.com</td>
                <td>This is test message</td>
                <td>01817271727</td>
                <td>127.00.20.22</td>
                <td>
                  <a href="leads-details.html" class="skfb-btn">
                    <i class="fas fa-list-ul"></i>
                    <span>Details</span>
                  </a>
                </td>
              </tr>
              <tr>
                <td><input type="checkbox" class="sk-custom-checkbox"></td>
                <td>1</td>
                <td>Tamim</td>
                <td>contact@tmaimikbal.com</td>
                <td>This is test message</td>
                <td>01817271727</td>
                <td>127.00.20.22</td>
                <td>
                  <a href="leads-details.html" class="skfb-btn">
                    <i class="fas fa-list-ul"></i>
                    <span>Details</span>
                  </a>
                </td>
              </tr>
              <tr>
                <td><input type="checkbox" class="sk-custom-checkbox"></td>
                <td>1</td>
                <td>Tamim</td>
                <td>contact@tmaimikbal.com</td>
                <td>This is test message</td>
                <td>01817271727</td>
                <td>127.00.20.22</td>
                <td>
                  <a href="leads-details.html" class="skfb-btn">
                    <i class="fas fa-list-ul"></i>
                    <span>Details</span>
                  </a>
                </td>
              </tr>
              <tr>
                <td><input type="checkbox" class="sk-custom-checkbox"></td>
                <td>1</td>
                <td>Tamim</td>
                <td>contact@tmaimikbal.com</td>
                <td>This is test message</td>
                <td>01817271727</td>
                <td>127.00.20.22</td>
                <td>
                  <a href="leads-details.html" class="skfb-btn">
                    <i class="fas fa-list-ul"></i>
                    <span>Details</span>
                  </a>
                </td>
              </tr>
              <tr>
                <td><input type="checkbox" class="sk-custom-checkbox"></td>
                <td>1</td>
                <td>Tamim</td>
                <td>contact@tmaimikbal.com</td>
                <td>This is test message</td>
                <td>01817271727</td>
                <td>127.00.20.22</td>
                <td>
                  <a href="leads-details.html" class="skfb-btn">
                    <i class="fas fa-list-ul"></i>
                    <span>Details</span>
                  </a>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <?php $leads_list->get_pagination(); ?>
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