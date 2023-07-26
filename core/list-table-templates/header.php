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
                        <a href="#" class="skfb-btn" data-msfb-export-type="<?php echo $this->list_type; ?>" data-msfb-cat-type="<?php echo $this->cat_type; ?>" id="msfb-export-data"><i class="fas fa-download"></i><span> Export <?php echo $this->label; ?></span></a>
                        <?php if( $this->cat_type != "lead" ){ ?>
                            <input type="file" name="" data-msfb-import-type="<?php echo $this->list_type; ?>" data-msfb-cat-type="<?php echo $this->cat_type; ?>" id="msfb-import-data" style="display:none;">
                            <label class="skfb-btn" for="msfb-import-data"><i class="fas fa-upload"></i><span> Import <?php echo $this->label; ?></span></label>
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