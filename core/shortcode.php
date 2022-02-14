<?php
add_shortcode('msfb_ui','msfb_ui_callback');
function msfb_ui_callback(){
	ob_start();
	?>
	<div id="cy"></div>
	<?php
	return ob_get_clean();
}