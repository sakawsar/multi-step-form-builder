(function ($) {
    $(document).ready(() => {
        // this element
        const this__ = el => $(el.currentTarget)
        // sort contact form fields
        $('.skfb__sortable-data').sortable({
            cursor: 'move',
            placeholder: 'ui-state-highlight',
        });
        $(document).on('click','.msfb-form-builder .skfb__field-box i.fa-times-circle', e => {
            let this_el = this__(e)
            this_el.closest('.skfb__field-box').remove()
            msfb_hide_all_drawer()
        })
        let text_field = `
            <div class="skfb__field-box skfb-form-builder-drawer" data-field-type="text_form_field">
                <label class="msfb-field-label" for="textField"><i class="fa fa-times-circle"></i> Text field title</label>
                <input disabled="true" type="text" placeholder="Placeholder" id="textField" />
            </div>
        `
        let select_field = `
            <div class="skfb__field-box skfb-form-builder-drawer" data-field-type="select_form_field">
                <label class="msfb-field-label"><i class="fa fa-times-circle"></i> Select field</label>
                <ul class="skfb__input-option__lists">
                    <li>
                        <input disabled="true" type="radio" name="singleSelField" class="sk-custom-checkbox md" id="opt1" />
                        <label for="opt1" class="skfb__opt-name">Option 1</label>
                    </li>
                    <li>
                        <input disabled="true" type="radio" name="singleSelField" class="sk-custom-checkbox md" id="opt2" />
                        <label for="opt2" class="skfb__opt-name">Option 2</label>
                    </li>
                </ul>
            </div>
        `
        let multiselect_field = `
            <div class="skfb__field-box skfb-form-builder-drawer" data-field-type="multiselect_form_field">
                <label class="msfb-field-label"><i class="fa fa-times-circle"></i> MultiSelect field</label>
                <ul class="skfb__input-option__lists">
                    <li>
                        <input disabled="true" type="checkbox" class="sk-custom-checkbox md" id="optC1" />
                        <label for="optC1" class="skfb__opt-name">Option 1</label>
                    </li>
                    <li>
                        <input disabled="true" type="checkbox" class="sk-custom-checkbox md" id="optC2" />
                        <label for="optC2" class="skfb__opt-name">Option 2</label>
                    </li>
                    <li>
                        <input disabled="true" type="checkbox" class="sk-custom-checkbox md" id="optC3" />
                        <label for="optC3" class="skfb__opt-name">Option 3</label>
                    </li>
                    <li>
                        <input disabled="true" type="checkbox" class="sk-custom-checkbox md" id="optC4" />
                        <label for="optC4" class="skfb__opt-name">Option 4</label>
                    </li>
                </ul>
            </div>
        `
        let date_field = `
            <div class="skfb__field-box skfb-form-builder-drawer" data-field-type="date_form_field">
                <label class="msfb-field-label" for="date"><i class="fa fa-times-circle"></i> Date</label>
                <input disabled="true" type="text" placeholder="YYYY-MM-DD" id="date" data-id="datepicker" />
            </div>
        `
        let file_upload_field = `
            <div class="skfb__field-box skfb-form-builder-drawer" data-field-type="upload_form_field">
                <label class="msfb-field-label" for="upload"><i class="fa fa-times-circle"></i> Upload file</label>
                <input disabled="true" type="file" id="upload"/>
            </div>
        `
        let dropdown_field = `
            <div class="skfb__field-box skfb-form-builder-drawer" data-field-type="dropdown_form_field">
                <label class="msfb-field-label" for="date"><i class="fa fa-times-circle"></i> Dropdown</label>
                <select>
                    <option value="">1</option>
                    <option value="2">2</option>
                </select>
            </div>
        `
        let slider_field = `
            <div class="skfb__field-box skfb-form-builder-drawer" data-field-type="slider_form_field" msfb-slider-default-val="5" msfb-slider-max-val="10" msfb-slider-min-val="0" msfb-slider-step-val="1">
                <label class="msfb-field-label"><i class="fa fa-times-circle"></i> Slider</label>
                <div class="skfb-prev-input __2">
                    <div class="skfb-prev-slider">
                        <span></span>
                    </div>
                </div>
            </div>
        `
        let textarea_field = `
            <div class="skfb__field-box skfb-form-builder-drawer" data-field-type="textarea_form_field">
                <label class="msfb-field-label" for="textArea"><i class="fa fa-times-circle"></i> Text area</label>
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
        $('#msfb-upload-form-field').on('click', e => {
            form_field_holder.append(file_upload_field)
        })
        $('#msfb-slider-form-field').on('click', e => {
            form_field_holder.append(slider_field)
        })
        $('#msfb-dropdown-form-field').on('click', e => {
            form_field_holder.append(dropdown_field)
        })
        // show specific drawer
        const msfb_show_drawer = element => {
            $('.msfb-question-type-holders').fadeOut(function(){
                let rightDrawer = $('div[data-drawer-type="' + element + '"]');
                rightDrawer.show();
                let drawerWidth = rightDrawer.width();
                let setRight = drawerWidth + 20;
                rightDrawer.css({ "right": 0 });
            })
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
        $('.msfb-form-builder .skfb__form-title,.msfb-form-builder .skfb__form-desc').on('click',e => {
            msfb_hide_all_drawer()
            msfb_show_drawer("default_options")
            $('#msfb-form-name').val($('.msfb-form-builder').attr('data-form-name'))
            $('#msfb-form-title').val($('.skfb__form-title').html())
            $('#msfb-form-desc').val($('.skfb__form-desc').html())
        })
        window.msfb_show_drawer = function( field_type ){
            msfb_show_drawer( field_type )
        }
        $(document).on('click','div[data-field-type]',e => {
            console.log(e.target.localName)
            let this_el = this__(e)
            if( e.target.localName != "i" ){
                let field_type = this_el.attr('data-field-type')
                $('div[data-field-type]').removeClass('msfb-form-field-selected')
                if( field_type ) {
                    this_el.addClass('msfb-form-field-selected')
                    msfb_hide_all_drawer()
                    msfb_show_drawer(field_type)
                    // update drawer values
                    let drawer_holder = $(`div[data-drawer-type="${field_type}"]`)
                    // update field label
                    let field_title_label = this_el.find('.msfb-field-label').html()
                    field_title_label = field_title_label.replace('<i class="fa fa-times-circle"></i> ','')
                    drawer_holder.find('.msfb-form-field-label').val(field_title_label)
                    // update required fields
                    let is_required = this_el.attr('msfb-field-required')
                    if( is_required == "true" ) {
                        drawer_holder.find('.msfb-form-field-required').prop('checked',true)
                    } else {
                        drawer_holder.find('.msfb-form-field-required').prop('checked',false)
                    }
                    // update is lead field
                    let is_lead_column = this_el.attr('msfb-field-is-lead-column')
                    if( is_lead_column == "true" ) {
                        drawer_holder.find('.msfb-lead-column-field').prop('checked',true)
                    } else {
                        drawer_holder.find('.msfb-lead-column-field').prop('checked',false)
                    }
                    // update placeholder
                    let placeholder_field = drawer_holder.find('.msfb-placeholder-field')
                    if ( placeholder_field.length > 0 ) {
                        let placeholder_val = this_el.find('input').attr('placeholder') ? this_el.find('textarea').attr('placeholder') : 'placeholder'
                        placeholder_field.attr('placeholder',placeholder_val)
                    }
                    // slider fields update
                    if ( field_type == "slider_form_field" ) {
                        let default_val = this_el.attr('msfb-slider-default-val')
                        let max_val = this_el.attr('msfb-slider-max-val')
                        let min_val = this_el.attr('msfb-slider-min-val')
                        let step_val = this_el.attr('msfb-slider-step-val')
                        drawer_holder.find('#msfb-slider-default-value').val(default_val)
                        drawer_holder.find('#msfb-slider-max-value').val(max_val)
                        drawer_holder.find('#msfb-slider-min-value').val(min_val)
                        drawer_holder.find('#msfb-slider-step').val(step_val)
                    }
                    // update other fields
                    let field_option_data = []
                    let has_option = false
                    if( field_type == "multiselect_form_field" || field_type == "select_form_field" ) {
                        has_option = true
                        let field_options = this_el.find(`ul li`)
                        $.each(field_options,(k,v) => {
                            let a_option = []
                            a_option['label'] = $(v).find('label').html()
                            a_option['value'] = $(v).find('input').val()
                            field_option_data.push(a_option)
                        })
                    } else if ( field_type == "dropdown_form_field" ) {
                        has_option = true
                        let field_options = this_el.find(`select option`)
                        $.each(field_options,(k,v) => {
                            let a_option = []
                            a_option['label'] = $(v).html()
                            a_option['value'] = $(v).val()
                            field_option_data.push(a_option)
                        })
                    } else if ( field_type == "slider_form_field" ) {
                        
                    }
                    if( has_option == true ) {
                        // console.log(field_option_data)
                        let drawer_option_holder = $(`div[data-drawer-type="${field_type}"] .msfb-dropdown-value-fields`)
                        drawer_option_holder.html('')
                        let total_rows = field_option_data.length
                        $.each(field_option_data,(k,v) => {
                            k++
                            let icon_suffix = k == total_rows ? "plus" : "times"
                            let a_field_option = `
                                <div class="msfb-dropdown-value-field" data-dropdown-row-no="${k}">
                                    <input type="text" data-msfb-field-type="value" data-dropdown-row-no="${k}" class="msfb_dropdown_data_value" value="${v.value}" placeholder="Value"/>
                                    <input type="text" data-msfb-field-type="option" data-dropdown-row-no="${k}" class="msfb_dropdown_data_option" value="${v.label}" placeholder="Option"/>
                                    <i class="fa fa-${icon_suffix}-circle"></i>
                                </div>
                            `
                            drawer_option_holder.append(a_field_option)
                            drawer_option_holder.attr('data-dropdown-row-no',k)
                        })
                    }
                }
            }
        })
        // update form title
        $('#msfb-form-title').on('keyup', e => {
            let this_el = this__(e)
            let this_val = this_el.val()
            $('.msfb-form-builder .skfb__form-title').html(this_val)
        })
        // update form name
        $('#msfb-form-name').on('keyup', e => {
            let this_el = this__(e)
            let this_val = this_el.val()
            $('.msfb-form-builder').attr('data-form-name',this_val)
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
            $('.msfb-form-field-selected label.msfb-field-label').html(`<i class="fa fa-times-circle"></i> ${this_val}`)
        })
        // update placeholder
        $('.msfb-placeholder-field').on('keyup', e => {
            let this_el = this__(e)
            let this_val = this_el.val()
            $('.msfb-form-field-selected input, .msfb-form-field-selected textarea').attr(`placeholder`,this_val)
        })
        // update required field
        $('.msfb-form-field-required').on('click', e => {
            let is_checked = e.target.checked
            $('.msfb-form-field-selected').attr(`msfb-field-required`,is_checked)
        })
        // update is lead field
        $('.msfb-lead-column-field').on('click', e => {
            let is_checked = e.target.checked
            $('.msfb-form-field-selected').attr(`msfb-field-is-lead-column`,is_checked)
        })
        // update slider default value
        $('#msfb-slider-default-value').on('keyup', e => {
            let this_el = this__(e)
            let default_val = $('#msfb-slider-default-value').val()
            $('.msfb-form-field-selected').attr('msfb-slider-default-val',default_val)
        })
         // update slider maximum value
        $('#msfb-slider-max-value').on('keyup', e => {
            let this_el = this__(e)
            let max_val = $('#msfb-slider-max-value').val()
            $('.msfb-form-field-selected').attr('msfb-slider-max-val',max_val)
        })
        // update slider min value
        $('#msfb-slider-min-value').on('keyup', e => {
            let this_el = this__(e)
            let max_val = $('#msfb-slider-min-value').val()
            $('.msfb-form-field-selected').attr('msfb-slider-min-val',max_val)
        })
        // update slider min value
        $('#msfb-slider-step').on('keyup', e => {
            let this_el = this__(e)
            let step_val = $('#msfb-slider-step').val()
            $('.msfb-form-field-selected').attr('msfb-slider-step-val',step_val)
        })
    })
})(jQuery)