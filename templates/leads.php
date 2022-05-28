<?php
$leads_list = new MSFB_List_Table('leads');
?>
  <div class="app">
    <?php $leads_list->get_header(); ?>
    <div class="skfb-content">
      <div class="skfb-datatable">
        <div class="sk-container">
          <div class="sk-row skfb--gY-20 sk-align-items-center">
            <div class="sk-col-md-8">
              <div class="sk-d-flex sk-align-items-center sk-flex-wrap sk-column-gap">
                <?php $leads_list->get_actions(); ?>
              </div>
            </div>
            <div class="sk-col-md-4">
              <div class="skfb-search-box">
                <form action="">
                  <?php if($leads_list->has_search){ ?>
                    <input type="search" id="msfb-search-name" class="sk-form-control" placeholder="<?php echo $leads_list->search_placeholder; ?>">
                  <?php } ?>
                  <button class="skfb-search-btn"><i class="fas fa-search"></i></button>
                </form>
              </div>
            </div>
          </div>
          <div class="skfb-table-wrap">
            <?php $leads_list->get_table(); ?>
          </div>
          <?php $leads_list->get_pagination(); ?>
        </div>
      </div>

    </div>
  </div>