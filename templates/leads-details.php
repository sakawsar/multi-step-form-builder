<?php
global $wpdb;
$table_name = $wpdb->prefix.'msfb_leads';
$invalid = false;
$lead_time = null;
if( isset( $_GET['lead_id'] ) && sanitize_text_field( $_GET['lead_id'] )){
  $lead_id = sanitize_text_field( $_GET['lead_id'] );
  $results = $wpdb->get_results("SELECT * FROM $table_name WHERE id='$lead_id'",ARRAY_A);
  if( $wpdb->num_rows > 0 ) {
    $lead_data = $results[0];
    $lead_time = $lead_data['lead_time'];
    $lead_raw_data = json_decode( stripslashes( $lead_data['lead_data'] ), true );
  } else {
    // echo "Not a valid lead";
    $invalid = true;
  }
} else {
  // echo "Not a valid lead";
  $invalid = true;
}
?>
<div class="app">
  <div class="skfb-header">
    <div class="sk-container">
      <div class="sk-row sk-align-items-center">
        <div class="sk-col-12">
          <h3 class="skfb-header-title"><?php echo !$invalid ? "Lead Details - ".date('d M, Y',$lead_time).' at '.date('h:i:s A',$lead_time) : "Not a valid lead"; ?></h3>
        </div>
      </div>
      <?php if( $invalid ) return; ?>
    </div>
  </div>
  <div class="skfb-content">
    <div class="skfb-datatable">
      <div class="sk-container">

        <div class="skfb-table-wrap">
          <?php
          // echo '<pre>';
          // print_r($lead_raw_data);
          // echo '</pre>';
          ?>
          <table class="sk-table skfb-leads-details-table">
            <tbody>
              <?php $total_price = 0; foreach($lead_raw_data as $a_row){ if( !isset($a_row['form_data']) ) { ?>
              <tr>
                <?php if(!isset($a_row['title'])) continue; ?>
                <th><?php echo $a_row['title']; ?></th>
                <td>
                  <?php 
                  if( is_array($a_row['value'])) {
                    echo implode(', ',$a_row['value']); 
                  } else {
                    echo $a_row['value']; 
                  }
                  ?>
                </td>
              </tr>
              <?php } else { 
                $total_price = $a_row['total_price'];
              ?>
                <tr>
                    <td><h2>Form data</h2></td>
                    <td></td>
                </tr>
                <?php foreach($a_row['form_data'] as $a_field) { ?>
                  <tr>
                    <th><?php echo $a_field['title']; ?></th>
                    <td>
                      <?php 
                      if( is_array($a_field['value'])) {
                        echo implode(', ',$a_field['value']); 
                      } else {
                        echo $a_field['value']; 
                      }
                      ?>
                    </td>
                  </tr>
                <?php } ?>
              <?php
              }} ?>
                <tr>
                    <td><h2 style="margin:0px;">Total price</h2></td>
                    <td><?php echo $total_price; ?></td>
                </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

  </div>
</div>