<div class="skfb-header">
    <div class="sk-container">
        <div class="sk-row sk-align-items-center">
            <div class="sk-col-sm-8">
                <div class="sk-d-flex sk-align-items-center sk-flex-wrap sk-column-gap">
                    <div class="skfb-nav-logo">
                        <h3><?php echo $this->title; ?></h3>
                    </div>
                    <?php if($this->add_new_url && $this->cat_type != "lead"){ ?>
                    <div>
                        <a href="<?php echo $this->add_new_url; ?>" class="skfb-btn"><i class="fas fa-plus"></i><span><?php echo $this->add_button; ?></span></a>
                    </div>
                        <?php if($this->has_category){ ?>
                            <div>
                                <a href="#" class="skfb-btn" data-msfb-cat-type="<?php echo $this->cat_type; ?>" id="msfb-add-category"><i class="fas fa-plus"></i><span>Add category</span></a>
                            </div>
                        <?php } ?>
                    <?php } ?>
                    <div>
                        <?php if( $this->cat_type != "lead" ){ ?>
                            <a href="#" class="skfb-btn" data-msfb-export-type="<?php echo $this->list_type; ?>" data-msfb-cat-type="<?php echo $this->cat_type; ?>" id="msfb-export-data"><i class="fas fa-download"></i><span> Export <?php echo $this->label; ?></span></a>
                            <input type="file" name="" data-msfb-import-type="<?php echo $this->list_type; ?>" data-msfb-cat-type="<?php echo $this->cat_type; ?>" id="msfb-import-data" style="display:none;">
                            <label class="skfb-btn" for="msfb-import-data"><i class="fas fa-upload"></i><span> Import <?php echo $this->label; ?></span></label>
                        <?php } else { ?>
                            <button class="skfb-btn" id="msfb-export-leads"><i class="fas fa-download"></i> <?php _e('Export leads of current Q-Flow','msfb'); ?></button>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div class="sk-col-sm-4 sk-col-lg-2 sk-col-xl-2 sk-align-right">
                <?php if($this->has_category && $this->get_cates()){ ?>
                <div class="skfb-header-nav-filters">
                    <form action="">
                        <select name="" id="msfb-filter-by-cat" class="sk-form-control sk-custom-select">
                            <?php echo $this->get_cates(); ?>
                            <!-- <option value="">Category 1</option>
                            <option value="">Category 2</option>
                            <option value="">Category 3</option> -->
                        </select>
                        <!-- <i class="fa fa-plus-circle"></i> -->
                    </form>
                </div>
                <!-- <div class="skfb-btn">Add category</div> -->
                <?php } ?>
            </div>
        </div>
    </div>
</div>
<?php if( $this->list_type == "leads" ) { ?>
    <div style="padding:8px 16px;display:flex; flex-direction:row; gap:16px;align-items:center;">
        <label for="msfb_update_chart">
            <select name="" id="msfb_update_chart">
                <option value="7">Last 7 days</option>
                <option value="7">Yesterday</option>
            </select>
        </label>
        <label for="msfb_update_chart_by_date_range">
            <p>From: <input type="date" name="" id=""> To: <input type="date" name="" id=""></p>
        </label>
    </div>
    <canvas id="msfb-leads-states" style="padding:8px 16px;width:100%;height:360px;"></canvas>
<?php } ?>