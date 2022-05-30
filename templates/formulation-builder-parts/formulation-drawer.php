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
        <label for="formName"><?php _e('Redirect URL','msfb'); ?></label>
        <input value="<?php echo $url; ?>" type="text" placeholder="Redirect URL" id="msfb-redirect-url"/>
      </div>
      <div class="skfb__field-box __2">
        <?php
          $color_scheme = "#0693e3";
          if( isset($this_formula_data['formulation_data']['color_scheme']) ){
            $color_scheme = $this_formula_data['formulation_data']['color_scheme'];
          }
        ?>
        <label for="formName"><?php _e('Color scheme','msfb'); ?></label>
        <input style="width:50%;padding:0px;" value="<?php echo $color_scheme; ?>" type="color" id="msfb-color-scheme"/>
      </div>
    </div> <!-- /.skfb__field-opt__boxes -->
  </div>
</div>