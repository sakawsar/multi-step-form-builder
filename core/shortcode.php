<?php
add_shortcode('msfb_ui','msfb_ui_callback');
function msfb_ui_callback(){
	ob_start();
	?>
	<div class="tw-msfb-container">
        <div class="tw-msfb-progress-bar">
            <div class="tw-msfb-progress-bar__status"></div>
        </div>
        <div class="w-full flex flex-col mt-4 gap-4">
            <h1 class="text-center text-4xl">This is the title</h1>
            <p class="text-center text-lg">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Inventore, vel! Lorem ipsum dolor sit amet consectetur adipisicing elit. Libero, consequatur. Sed quae hic amet minus aliquid nihil quod quo recusandae sequi dolores? Voluptas explicabo ea hic quis ipsam quibusdam? Quia ea omnis fugit, quam quas tempora quisquam deserunt maxime numquam iusto expedita ex, a accusantium sit deleniti officia. Illum, consectetur!</p>
            <div class="msfb-multiselect-qtn tw-msfb-multiselect-qtn">
                <div class="tw-msfb-multiselect-qtn__item"></div>
                <div class="tw-msfb-multiselect-qtn__item"></div>
                <div class="tw-msfb-multiselect-qtn__item"></div>
                <div class="tw-msfb-multiselect-qtn__item"></div>
            </div>
        </div
    </div>
	<?php
	return ob_get_clean();
}