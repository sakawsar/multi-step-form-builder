<div class="skfb-right-options" data-drawer-type="formulation" style="display:none;">
    <div class="sk-text-right">
      <button class="skfb-right-sidebar-close">
        <i class="fa fa-times"></i>
      </button>
    </div>
    <h5 class="sk-head __2 sk-text-white"><?php _e('Options','msfb'); ?></h5>
    <div class="skfb__field-opt__boxes">
      <div class="skfb__field-box __2">
        <label for="msfb-show-price"><?php _e('Show price','msfb'); ?></label>
        <?php
        $checked = "";
        if( isset($this_formula_data['formulation_data']['show_price']) ){
          $checked = "checked";
        }
        ?>
        <input <?php echo $checked; ?> style="width:auto;" type="checkbox" id="msfb-show-price" />
      </div>
      <div class="skfb__field-box __2">
        <?php
          $url = home_url( '/' );
          if( isset($this_formula_data['formulation_data']['redirect']) ){
            $url = $this_formula_data['formulation_data']['redirect'];
          }
        ?>
        <label for="formName"><?php _e('Thank you page URL','msfb'); ?></label>
        <input value="<?php echo $url; ?>" type="text" placeholder="Thank you page URL" id="msfb-redirect-url"/>
      </div>
      <div class="skfb__field-box __2">
        <?php
          $current_position = "top";
          if( isset($this_formula_data['formulation_data']['msfb_nav_menu_position']) ){
            $current_position = $this_formula_data['formulation_data']['msfb_nav_menu_position'];
          }
        ?>
        <label for="formName"><?php _e('Position of the menu','msfb').' '.$current_position; ?></label>
        <label for="msfb_nav_menu_top_position">
          <input type="radio" <?php checked('top', $current_position, true); ?> class="sk-custom-checkbox msfb_nav_menu_position" name="msfb_nav_menu_position" value="top" id="msfb_nav_menu_top_position">
          <?php _e('Top','msfb'); ?>
        </label>
        <label for="msfb_nav_menu_bottom_position">
          <input type="radio" <?php checked('bottom', $current_position, true); ?> class="sk-custom-checkbox msfb_nav_menu_position" name="msfb_nav_menu_position" value="buttom" id="msfb_nav_menu_bottom_position">
          <?php _e('Bottom','msfb'); ?>
        </label>
      </div>
      <div class="skfb__field-box __2">
        <?php
          $color_scheme = "#0693e3";
          if( isset($this_formula_data['formulation_data']['color_scheme']) ){
            $color_scheme = $this_formula_data['formulation_data']['color_scheme'];
          }
        ?>
        <label for="formName"><?php _e('Color scheme','msfb'); ?></label>
        <div>
          <label for="msfb-color-scheme" style="
                padding: 8px;
                background: white;
                display: flex;
            "><code style="
                width: calc( 100% - 50px );
                color:gray;
            "><?php echo $color_scheme; ?></code><div style="
                height: 30px;
                width: 50px;
                background: <?php echo $color_scheme; ?>;
            "></div>
          </label>
          <style>
            .colorpick-eyedropper-input-trigger{
              display:none!important;
            }
          </style>
          <input style="width: 0;
                        padding: 0;
                        margin: 0;
                        height: 0;
                        visibility: hidden;" value="<?php echo $color_scheme; ?>" type="color" id="msfb-color-scheme"/>
        </div>
      </div>
    </div> <!-- /.skfb__field-opt__boxes -->
  </div>
</div>