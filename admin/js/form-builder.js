(function ($) {
    $(document).ready(() => {
        // this element
        const this__ = el => $(el.currentTarget)
        // sort contact form fields
        $('.skfb__sortable-data').sortable({
            cursor: 'move',
            placeholder: 'ui-state-highlight',
        });
        $(document).on('click','.skfb__field-box i.fa-times-circle', e => {
            let this_el = this__(e)
            this_el.closest('.skfb__field-box').remove()
            msfb_hide_all_drawer()
        })
        let text_field = `
            <div class="skfb__field-box skfb-form-builder-drawer" data-field-type="text_form_field">
                <label for="textField"><i class="fa fa-times-circle"></i> Text field title</label>
                <input type="text" placeholder="Placeholder" id="textField" />
            </div>
        `
        let select_field = `
            <div class="skfb__field-box skfb-form-builder-drawer" data-field-type="select_form_field">
                <label><i class="fa fa-times-circle"></i> Select field</label>
                <ul class="skfb__input-option__lists">
                    <li>
                        <input type="radio" name="singleSelField" class="sk-custom-checkbox md" id="opt1" />
                        <label for="opt1" class="skfb__opt-name">Option 1</label>
                    </li>
                    <li>
                        <input type="radio" name="singleSelField" class="sk-custom-checkbox md" id="opt2" />
                        <label for="opt2" class="skfb__opt-name">Option 2</label>
                    </li>
                </ul>
            </div>
        `
        let multiselect_field = `
            <div class="skfb__field-box skfb-form-builder-drawer" data-field-type="multiselect_form_field">
                <label><i class="fa fa-times-circle"></i> MultiSelect field</label>
                <ul class="skfb__input-option__lists">
                    <li>
                        <input type="checkbox" class="sk-custom-checkbox md" id="optC1" />
                        <label for="optC1" class="skfb__opt-name">Option 1</label>
                    </li>
                    <li>
                        <input type="checkbox" class="sk-custom-checkbox md" id="optC2" />
                        <label for="optC2" class="skfb__opt-name">Option 2</label>
                    </li>
                    <li>
                        <input type="checkbox" class="sk-custom-checkbox md" id="optC3" />
                        <label for="optC3" class="skfb__opt-name">Option 3</label>
                    </li>
                    <li>
                        <input type="checkbox" class="sk-custom-checkbox md" id="optC4" />
                        <label for="optC4" class="skfb__opt-name">Option 4</label>
                    </li>
                </ul>
            </div>
        `
        let date_field = `
            <div class="skfb__field-box skfb-form-builder-drawer" data-field-type="date_form_field">
                <label for="date"><i class="fa fa-times-circle"></i> Date</label>
                <input type="text" placeholder="YYYY-MM-DD" id="date" data-id="datepicker" />
            </div>
        `
        let dropdown_field = `
            <div class="skfb__field-box skfb-form-builder-drawer" data-field-type="dropdown_form_field">
                <label for="date"><i class="fa fa-times-circle"></i> Dropdown</label>
                <select>
                    <option value="">Select a value</option>
                    <option value="1">1</option>
                </select>
            </div>
        `
        let slider_field = `
            <div class="skfb__field-box skfb-form-builder-drawer" data-field-type="slider_form_field">
                <label><i class="fa fa-times-circle"></i> Slider</label>
                <div class="skfb-prev-input __2">
                    <div class="skfb-prev-slider">
                        <span></span>
                    </div>
                </div>
            </div>
        `
        let textarea_field = `
            <div class="skfb__field-box skfb-form-builder-drawer" data-field-type="textarea_form_field">
                <label for="textArea"><i class="fa fa-times-circle"></i> Text area</label>
                <textarea name="textArea" cols="30" rows="4" placeholder="Placeholder" id="textArea"></textarea>
            </div>
        `
        let form_field_holder = $('#msfb-form-field-holder')
        // add new fields
        $('#msfb-multiselect-form-field').on('click', e => {
            form_field_holder.append(multiselect_field)
        })
        $('#msfb-select-form-field').on('click', e => {
            form_field_holder.append(select_field)
        })
        $('#msfb-text-form-field').on('click', e => {
            form_field_holder.append(text_field)
        })
        $('#msfb-textarea-form-field').on('click', e => {
            form_field_holder.append(textarea_field)
        })
        $('#msfb-date-form-field').on('click', e => {
            form_field_holder.append(date_field)
        })
        $('#msfb-slider-form-field').on('click', e => {
            form_field_holder.append(slider_field)
        })
        $('#msfb-dropdown-form-field').on('click', e => {
            form_field_holder.append(dropdown_field)
        })
        // show specific drawer
        const msfb_show_drawer = element => {
            $('div[data-drawer-type="' + element + '"]').show();
            let rightDrawer = $('div[data-drawer-type="' + element + '"]');
            let drawerWidth = rightDrawer.width();
            let setRight = drawerWidth + 20;
            rightDrawer.css({ "right": 0 });
        }
        const msfb_hide_all_drawer = () => {
            $('div[data-drawer-type]').hide()
        }
        const msfb_hide_drawer = element => {
            $('div[data-drawer-type="' + element + '"]').hide();
            let rightDrawer = $('div[data-drawer-type="' + element + '"]');
            let drawerWidth = rightDrawer.width();
            let setRight = drawerWidth + 22;
            rightDrawer.css({ "right": "-" + setRight + "px" });
        }
        // question or des selected
        $('.skfb__form-title, .skfb__form-desc').on('click',e => {
            msfb_hide_all_drawer()
            msfb_show_drawer("default_options")
        })
        $(document).on('click','div[data-field-type]',e => {
            let this_el = this__(e)
            if( e.target.localName != "i" ){
                let field_type = this_el.attr('data-field-type')
                if( field_type ) {
                    this_el.addClass('msfb-form-field-selected')
                    msfb_hide_all_drawer()
                    msfb_show_drawer(field_type)
                }
            }
        })
        // update form title
        $('#msfb-form-name').on('keyup', e => {
            let this_el = this__(e)
            let this_val = this_el.val()
            $('.msfb-form-builder .skfb__form-title').html(this_val)
        })
        // update form description
        $('#msfb-form-desc').on('keyup', e => {
            let this_el = this__(e)
            let this_val = this_el.val()
            $('.msfb-form-builder .skfb__form-desc').html(this_val)
        })
        // update field label
        $('.msfb-form-field-label').on('keyup', e => {
            let this_el = this__(e)
            let this_val = this_el.val()
            $('.msfb-form-field-selected label').html(`<i class="fa fa-times-circle"></i> ${this_val}`)
        })
        // update placeholder
        $('.msfb-placeholder-field').on('keyup', e => {
            let this_el = this__(e)
            let this_val = this_el.val()
            $('.msfb-form-field-selected input, .msfb-form-field-selected textarea').attr(`placeholder`,this_val)
        })
        // update required field
        $('.msfb-form-field-required').on('click', e => {
            let this_el = this__(e)
            let this_val = this_el.val()
            console.log(`this val`,e)
            let field_type = $('.msfb-form-field-selected div[data-field-type]').attr('data-field-type')
            let is_checked = $(`.msfb-form-field-selected data[data-drawer-type="${field_type}"] .msfb-form-field-required:checked`).val()
            console.log(is_checked)
            // $('.msfb-form-field-selected').attr(`msfb-field-required`,true)
        })
        // update required field
        $('.msfb-lead-column-field').on('keyup', e => {
            let this_el = this__(e)
            let this_val = this_el.val()
            let field_type = this_el.attr('data-field-type')
            let this_status = $(`div[data-drawer-type="${field_type}" .msfb-lead-column-field:checked]`).val()
            console.log(this_status)
            // $('.msfb-form-field-selected input, .msfb-form-field-selected textarea').attr(`placeholder`,this_val)
        })
        
    })
})(jQuery)