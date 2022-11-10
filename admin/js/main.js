(function ($) {
    $(document).ready(function () {
        // drawer scrollbar
        $( window ).resize(() => {
            $('.skfb__field-opt__boxes').height(window.innerHeight - 200)
        })
        $('.skfb__field-opt__boxes').height(window.innerHeight - 200)
        // hide all drawers
        let rightDrawer = $('.skfb-right-options');
        let drawerWidth = rightDrawer.width();
        let setRight = drawerWidth + 22;
        rightDrawer.css({ "right": "-" + setRight + "px" });
        // set the date picker format
        $('[data-id="datepicker"]').datepicker({
            dateFormat: 'yy-mm-dd',
            showAnim: 'slideDown',
        });
        // enable the select2 for dropdowns
        // $('.skfb__custom-select').select2();
        
        // $(document).on('click', '.skfb-form-builder-drawer', function () {
        //     let rightDrawer = $('.skfb-right-options');
        //     let drawerWidth = rightDrawer.width();
        //     let setRight = drawerWidth + 20;
        //     rightDrawer.css({ "right": 0 });
        // });
        $(document).on('click', '.skfb-right-sidebar-close', function () {
            let rightDrawer = $('.skfb-right-options');
            let drawerWidth = rightDrawer.width();
            let setRight = drawerWidth + 22;
            rightDrawer.css({ "right": "-" + setRight + "px" });
        });
    });
    $('#msfb-color-scheme').on('input',function(){
        $('label[for="msfb-color-scheme"] code').html($(this).val())
        $('label[for="msfb-color-scheme"] div').css({background: $(this).val()})
    })
    // get this value function
    const this__ = el => $(el.currentTarget)
    // filter by category
    if ( $('#msfb-filter-by-cat').length > 0 ) {
        $('#msfb-filter-by-cat').on('change',e => {
            let this_el = this__(e)
            let this_val = this_el.val()
            $('#msfb-table-item-holder tr').show()
            if( this_el.closest('.app').attr('data-lead-table') && this_el.closest('.app').attr('data-lead-table') == "true" ) {
                let url = this_el.closest('.app').attr('data-lead-table-url') + '&formulation_id=' + this_val
                window.location.href = url
            } else {
                let i = 0;
                $.each( $('#msfb-table-item-holder tr'), (k,v) => {
                    let item_cats = $(v).find('select[data-msfb-cat-id]');
                    if( item_cats.attr('data-msfb-cat-id') != this_val ){
                        item_cats.closest('tr').hide()
                    } else {
                        i++
                    }
                })
                msfb_upate_pagination(this_val,i)
            }
        })
    }
    const msfb_upate_pagination = (this_val, i) => {
        if( i == 0 ) {
            if( this_val != "" ){
                $('#msfb-row-not-found').show()
            }  else {
                $('#msfb-row-not-found').hide()
            }
        } else {
            $('#msfb-row-not-found').hide()
        }
        if ( this_val == "" ) {
            $(`#msfb-table-item-holder tr`).hide()
            if($(`#msfb-table-item-holder tr[data-msfb-pagination]`).length > 0 ){
                $(`#msfb-table-item-holder tr[data-msfb-pagination="1"]`).show()
            } else {
                $(`#msfb-table-item-holder tr`).show()
            }
            $('.skfb-table-pagination-wrap ul li').attr('class','')
            $('.skfb-table-pagination-wrap ul li[data-msfb-pag-no="1"]').attr('class','active')
            // $('#msfb-row-not-found').hide()
        }
    }
    // allow the pagination
    const msfb_apply_pagination = ( active = 1 ) => {
        let total_rows = $('#msfb-table-item-holder tr')
        if( total_rows.length >= msfb.max_rows ){
            let pagination = 1
            let i = 1
            let pages = []
            pages.push(pagination)
            $.each($('#msfb-table-item-holder tr'),(k,v) => {
                $(v).attr('data-msfb-pagination',pagination)
                if ( i % msfb.max_rows == 0 && total_rows.length > i ) {
                    pagination++
                    pages.push(pagination)
                }
                i++
            })
            // console.log(pages);
            if( pages.length > 1 ) {
                $('.skfb-table-pagination-wrap').show()
                    for (let p_i = 0; p_i < pages.length; p_i++) {
                    const p_no = pages[p_i];
                    let is_active = active == p_no ? "class='active'" : ""
                    let page_html = `<li ${is_active} data-msfb-pag-no='${p_no}'>
                                        <p class="skfb-table-pagination-indecator"></p>
                                        <p class="skfb-table-pagination-number">${p_no}</p>
                                    </li>`
                    $('.skfb-table-pagination-wrap ul').append(page_html)
                }
                $(`#msfb-table-item-holder tr`).hide()
                $(`#msfb-table-item-holder tr[data-msfb-pagination="${active}"]`).show()
            }
        }
    }
    msfb_apply_pagination()
    // change pagination
    $(document).on('click','.skfb-table-pagination li', e => {
        let this_el = this__(e)
        let page_no = this_el.attr("data-msfb-pag-no")
        $.each($('.skfb-table-pagination li'),(k,v) => {
            $(v).attr('class','')
        })
        this_el.attr('class','active')
        $(`#msfb-table-item-holder tr`).hide()
        $(`#msfb-table-item-holder tr[data-msfb-pagination="${page_no}"]`).show()
        $('#msfb-row-not-found').hide()
        $('#msfb-sel-all').prop('checked',false)
        $(`#msfb-table-item-holder tr[data-msfb-pagination] td input.msfb-sel-field`).prop('checked',false)
    })
    // select all items
    $('#msfb-sel-all').on('click', e => {
        let this_el = this__(e)
        let act_no = $('.skfb-table-pagination li.active').attr('data-msfb-pag-no')
        act_no = act_no !=  undefined ? act_no : 1
        let is_checked = this_el.prop('checked')
        if( $(`#msfb-table-item-holder tr[data-msfb-pagination]`).length > 0 ) {
            $(`#msfb-table-item-holder tr[data-msfb-pagination="${act_no}"] td input.msfb-sel-field`).prop('checked',is_checked)
        } else {
            $(`#msfb-table-item-holder tr td input.msfb-sel-field`).prop('checked',is_checked)
        }
    })
    // search by name
    if( $("#msfb-search-name").length > 0 ) {
        $("#msfb-search-name").on('keyup', e => {
            let this_el = this__(e)
            let this_val = this_el.val().toLowerCase()
            $('#msfb-table-item-holder tr').show()
            let i = 0;
            $.each( $('#msfb-table-item-holder tr'), (k,v) => {
                // let item_cats = $(v).find('td[data-msfb-row-name]');
                // if( item_cats.length > 0 ){
                //     if( item_cats.attr('data-msfb-row-name').indexOf(this_val) == -1 ){
                //         item_cats.closest('tr').hide()
                //     } else {
                //         i++
                //     }
                // }
                if( $(v).html().toLowerCase().indexOf(this_val) == -1 ){
                    $(v).hide()
                } else {
                    i++
                }
            })
            msfb_upate_pagination(this_val,i)
        })
    }
    // change the questions by tool
    $('div[data-question-type]').on('click',e => {
        let field_types = [
            'msfb-multiselect',
            'msfb-date-field',
            'msfb-map-field',
            'msfb-dropdown-field',
            'msfb-single-select-field',
            'msfb-slider-field',
            'msfb-text-field',
            'msfb-textarea-field',
            'msfb-upload-field'
        ]
        let this_field = $(e.currentTarget)
        clicked_field = this_field.data('question-type');
        for (let i = 0; i < field_types.length; i++) {
            const element = field_types[i];
            if( element == clicked_field ){
                $('.' + element).attr('data-msfb-active',1)
                $('.' + element).show();
                // msfb_show_drawer(element)
            }else{
                $('.' + element).hide();
                $('.' + element).attr('data-msfb-active',0);
                msfb_hide_drawer(element)
            }
        }
        if( clicked_field == "msfb-slider-field" ) {
            $('label[for="msfb-price"]').html("Price value per Unit")
        } else {
            $('label[for="msfb-price"]').html("Price")
        }
    }) 
    const msfb_active_question = () => {
        let act_el = $('div[data-msfb-active="1"]')
        if( act_el.length > 0 ){
            return act_el.data('body-type')
        } else {
            return false
        }
    }
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
        $.each($('.skfb__form-title, .skfb__form-desc'),(k,v) => {
            if($(v).hasClass('skfb_question_seleted')){
                $(v).removeClass('skfb_question_seleted')
            }
            $(e.currentTarget).addClass('skfb_question_seleted');
            let el_type = $(e.currentTarget).closest('div[data-body-type]').data('body-type')
            msfb_show_drawer(el_type)
        })
    })
    // show drawers once click on fields
    $('.skfb__field-box').on('click',e => {
        let this_el = this__(e)
        let el = this_el.closest('div[data-body-type]').data('body-type')
        msfb_show_drawer(el)
    })
    
    // add multiselect option
    $('.msfb-multiselect-add').on('click', e => {
        // let this_el = this__(e)
        let act_qtn = msfb_active_question()
        console.log(act_qtn)
        let ans_no = $('.' + act_qtn + ' div[data-multiselect-no]').length
        ans_no++
        let new_answer = `
            <div class="sk-col-lg-6 sk-col-xl-3" data-multiselect-no="${ans_no}">
            <div class="skfb__builder-box skfb-form-builder-drawer" style="position:relative;">
                <i class="fa fa-times msfb-remove-option" style="position:absolute;top:8px;left:8px;z-index:999;color:gray;font-size:18px;cursor:pointer;"></i>
                    <div class="skfb__builder-top">
                        <div class="icon">
                            <i class="${msfb_icons[ans_no]}"></i>
                        </div>
                    </div>
                    <div class="skfb__builder-bottom">
                        <p class="skfb__answer">Answer</p>
                    </div>
                </div>
            </div>
        `
        $('.' + act_qtn + ' .msfb-multiselect-holder').append(new_answer)
    })
    $(document).on('click','.msfb-remove-option',function(e){
        e.stopPropagation()
        let rightDrawer = $('.skfb-right-options');
        let drawerWidth = rightDrawer.width();
        let setRight = drawerWidth + 22;
        rightDrawer.css({ "right": "-" + setRight + "px" });
        $(this).closest('div[data-multiselect-no]').remove()
    })
    // multiselect selected an answer
    $(document).on('click','div[data-multiselect-no]', e => {
        let this_el = this__(e)
        console.log(this_el.data('multiselect-no'))
        $.each($('div[data-multiselect-no]'),(k,v) => {
            if($(v).find('div').hasClass('active')){
                $(v).find('div').removeClass('active')
            }
        })
        this_el.find('div').addClass('active')
        this_el.closest('div[data-body-type]').attr('data-selected-ans',this_el.data('multiselect-no'))
        // $('#msfb-multiselect-holder').attr('data-selected-ans',this_el.data('multiselect-no'))
        msfb_hide_all_drawer()
        msfb_show_drawer('msfb-multiselect-ans')
        let act_el = msfb_active_question()
        let sel_ans = $('.' + act_el ).attr('data-selected-ans')
        let this_ans_el = $(`.${act_el} div[data-multiselect-no="${sel_ans}"] .skfb__answer`)
        let this_ans = $(`.${act_el} div[data-multiselect-no="${sel_ans}"] .skfb__answer`).html()
        if( this_ans == "Answer" ){
            $('.msfb_answer').val(null)
        } else {
            $('.msfb_answer').val(this_ans)
        }
        if( this_ans_el.attr('data-price') ) {
            $('.msfb_answer_price').val(this_ans_el.attr('data-price'))
        } else {
            $('.msfb_answer_price').val('')
        }
    })
    // multiselect/ single select answer update
    $('.msfb_answer').on('keyup',e => {
        let this_el = this__(e)
        let act_qtn = msfb_active_question()
        let sel_ans = $('.' + act_qtn).attr('data-selected-ans')
        $(`div[data-multiselect-no="${sel_ans}"] .skfb__answer`).html(this_el.val())
    })
    // multiselect/ single select answer update
    $('.msfb_answer_price').on('keyup',e => {
        let this_el = this__(e)
        let act_qtn = msfb_active_question()
        let sel_ans = $('.' + act_qtn).attr('data-selected-ans')
        $(`div[data-multiselect-no="${sel_ans}"] .skfb__answer`).attr('data-price',this_el.val())
    })
    // multiselect/ single select icon update
    $('.skfb__icon_select_field i').on('click',e => {
        let this_el = this__(e)
        let icon_classes = this_el.attr('class')
        let act_qtn = msfb_active_question()
        let sel_ans = $('.' + act_qtn).attr('data-selected-ans')
        $(`div[data-multiselect-no="${sel_ans}"] .icon i`).attr('class',icon_classes)
        icon_holder = $(`div[data-multiselect-no="${sel_ans}"] .icon`)
        if( icon_holder.find('i').length > 0 ) {
            icon_holder.find('i').show()
        } else {
            icon_holder.append('<i class="' + icon_classes + '"></i>')
        }
        if( icon_holder.find('img').length > 0 ){
            icon_holder.find('img').hide()
        }
    })
    // multiselect/ single select image update
    $('.msfb_custom_icon_image').on('click',e => {
        let this_el = this__(e)
        let url = this_el.attr('src')
        // let icon_classes = this_el.attr('class')
        let act_qtn = msfb_active_question()
        let sel_ans = $('.' + act_qtn).attr('data-selected-ans')
        let img_html = '<img style="height:64px;" src="' + url + '"/>'
        let icon_holder = $(`div[data-multiselect-no="${sel_ans}"] .icon`)
        icon_holder.find('i').hide()
        if( icon_holder.find('img').length > 0 ) {
            icon_holder.find('img').show()
            icon_holder.find('img').attr('src',url)
        } else {
            $(`div[data-multiselect-no="${sel_ans}"] .icon`).append(img_html)
        }
    })
    // question name update
    $('.msfb-qtn-name').on('keyup',e => {
        let this_el = this__(e)
        let act_qtn = msfb_active_question()
        $('.' + act_qtn).attr('data-qtn-name',this_el.val())
    })
    // title update
    $('.msfb-title').on('keyup',e => {
        let this_el = this__(e)
        let act_qtn = msfb_active_question()
        $('.' + act_qtn + ' .skfb__form-title').html(this_el.val())
    })
    // description update
    $('.msfb-desc').on('keyup',e => {
        let this_el = this__(e)
        let act_qtn = msfb_active_question()
        $('.' + act_qtn + ' .skfb__form-desc').html(this_el.val())
    })
    // price update
    $('.msfb-price').on('keyup',e => {
        let this_el = this__(e)
        let act_qtn = msfb_active_question()
        $('.' + act_qtn).attr('data-msfb-price',this_el.val())
    })
    // update placeholder field
    $('.msfb-placeholder').on('keyup',e => {
        let act_qtn = msfb_active_question()
        let this_el = this__(e)
        $(`div[data-body-type="${act_qtn}"] [placeholder]`).attr('placeholder',this_el.val())
    })
    // set required field
    $('.msfb-required').on('click',e => {
        let act_qtn = msfb_active_question()
        let is_checked = $(`div[data-drawer-type="${act_qtn}"] .msfb-required:checked`).val()
        if( is_checked != undefined ) {
            $('.' + act_qtn).attr('data-msfb-required',1)
        } else {
            $('.' + act_qtn).attr('data-msfb-required',0)
        }
    })
    // date format field on change
    $('.skfb__date_format').on('change', e => {
        let this_el = this__(e)
        let act_qtn = msfb_active_question()
        let date_format = this_el.val()
        $('.' + act_qtn).attr('data-msfb-date-format',date_format)
    })
    // add dropdown options row
    $(document).on('click','.msfb-dropdown-value-field i.fa-plus-circle', e => {
        let this_el = this__(e)
        let row_no = this_el.closest('.msfb-dropdown-value-fields').attr('data-dropdown-row-no')
        row_no++
        let row_html = `
            <div class="msfb-dropdown-value-field" data-dropdown-row-no="${row_no}">
                <input type="text" data-msfb-field-type="value" data-dropdown-row-no="${row_no}" class="msfb_dropdown_data_value" placeholder="Value"/>
                <input type="text" data-msfb-field-type="option" data-dropdown-row-no="${row_no}" class="msfb_dropdown_data_option" placeholder="Option"/>
                <input type="text" data-msfb-field-type="price" data-dropdown-row-no="${row_no}" class="msfb_dropdown_data_price" placeholder="Price"/>
                <i class="fa fa-plus-circle"></i>
            </div>
        `
        $('.msfb-dropdown-value-fields').append(row_html)
        $('.msfb-dropdown-value-fields').attr('data-dropdown-row-no',row_no)
        let act_qtn = msfb_active_question()
        let icon_prefix = ".msfb-dropdown-value-field"
        if( $('.' + act_qtn + ' select').length > 0 ) {
            $('.' + act_qtn + ' select').append(`<option value="">${row_no}</option>`)
        } else if ( $('.msfb-form-builder .msfb-form-field-selected').length > 0 ){
            let field_type = $('.msfb-form-field-selected').attr('data-field-type')
            let a_multiselect_opt = `
                <li>
                    <input type="checkbox" disabled="true" class="sk-custom-checkbox md" id="optC${row_no}">
                    <label for="optC${row_no}" class="skfb__opt-name">Option ${row_no}</label>
                </li>
            `
            let a_select_opt = `
                <li>
                    <input type="radio" disabled="true" class="sk-custom-checkbox md" id="opt${row_no}">
                    <label for="opt${row_no}" class="skfb__opt-name">Option ${row_no}</label>
                </li>
            `
            let a_dropdown_opt = `<option value="${row_no}">${row_no}</option>`
            if( field_type == "multiselect_form_field" ) {
                // div[data-field-type="${field_type}"]
                icon_prefix = `.msfb-form-builder .msfb-form-field-selected ul.skfb__input-option__lists li`
                $('.msfb-form-field-selected ul.skfb__input-option__lists').append(a_multiselect_opt)
            } else if ( field_type == "select_form_field" ) {
                icon_prefix = `.msfb-form-builder .msfb-form-field-selected ul.skfb__input-option__lists li`
                $('.msfb-form-field-selected ul.skfb__input-option__lists').append(a_select_opt)
            } else if ( field_type == "dropdown_form_field" ) {
                icon_prefix = `.msfb-form-builder .msfb-form-field-selected select`
                $('.msfb-form-field-selected select').append(a_dropdown_opt)
            }
        }
        let all_rows = this_el.closest('.msfb-dropdown-value-fields').find('.msfb-dropdown-value-field')
        let total_rows = all_rows.length
        console.log(total_rows)
        for( let i = 0; i < total_rows; i++ ) {
            if( i == total_rows - 1 ){
                $(all_rows[i]).find('i').attr('class','fa fa-plus-circle')
            } else {
                $(all_rows[i]).find('i').attr('class','fa fa-times-circle')
            }
        }
    })
    // remove dropdown options
    $(document).on('click','.msfb-dropdown-value-field i.fa-times-circle', e => {
        let act_el = msfb_active_question()
        let this_el = this__(e)
        let row_no = this_el.closest('.msfb-dropdown-value-field').attr('data-dropdown-row-no')
        row_no--
        let options = $(`.${act_el} select option`)
        if ( options.length > 0 ){
            $(options[row_no]).remove()
            this_el.closest('.msfb-dropdown-value-field').remove()
        } else if ( $('.msfb-form-builder .msfb-form-field-selected').length > 0 ) {
            console.log('working')
            let field_type = this_el.closest('div[data-drawer-type]').attr('data-drawer-type')
            if( field_type == "multiselect_form_field" ) {
                let options = $('.msfb-form-field-selected ul.skfb__input-option__lists li')
                $(options[row_no]).remove()
            } else if ( field_type == "select_form_field" ) {
                let options = $('.msfb-form-field-selected ul.skfb__input-option__lists li')
                $(options[row_no]).remove()
            } else if ( field_type == "dropdown_form_field" ) {
                let options = $('.msfb-form-field-selected select option')
                $(options[row_no]).remove()
            }
            this_el.closest('.msfb-dropdown-value-field').remove()
        }
    })
    // update dropdown field value 
    $(document).on('keyup','.msfb-dropdown-value-field input', e => {
        let this_el = this__(e)
        let field_type = this_el.attr('data-msfb-field-type')
        let row_no = this_el.attr('data-dropdown-row-no')
        let act_qtn = msfb_active_question()
        let options = $('.' + act_qtn + ' select option')
        row_no--
        if( options.length > 0 ) {
            let option_el = $(options[row_no])
            if( field_type == "value" ){
                option_el.val(this_el.val())
            } else if( field_type == "option" ) {
                option_el.html(this_el.val())
            } else if( field_type == "price" ) {
                option_el.attr('data-price',this_el.val())
            }
        } else if ( $('.msfb-form-builder .msfb-form-field-selected').length > 0 ) {
            let form_field_type = this_el.closest('div[data-drawer-type]').attr('data-drawer-type')
            let option_el = ""
            if( form_field_type == "multiselect_form_field" ) {
                let options = $('.msfb-form-field-selected ul.skfb__input-option__lists li')
                option_el = field_type == "value" ? $(options[row_no]).find('input') : $(options[row_no]).find('label')
            } else if ( form_field_type == "select_form_field" ) {
                let options = $('.msfb-form-field-selected ul.skfb__input-option__lists li')
                option_el = field_type == "value" ? $(options[row_no]).find('input') : $(options[row_no]).find('label')
            } else if ( form_field_type == "dropdown_form_field" ) {
                let options = $('.msfb-form-field-selected select option')
                option_el = $(options[row_no])
            }
            if( field_type == "value" ){
                option_el.val(this_el.val())
            } else if( field_type == "option" ) {
                option_el.html(this_el.val())
            }
        }
    })
    // update slider fields
    $('.msfb-slider-default-value').on('keyup', e => {
        let this_el = this__(e)
        let act_el = msfb_active_question()
        $('.' + act_el + ' .skfb__value').html(`Default value: ${this_el.val()}`)
        $('.' + act_el).attr(`data-msfb-default-val`,`${this_el.val()}`)
    })
    $('.msfb-slider-max-value').on('keyup', e => {
        let this_el = this__(e)
        let act_el = msfb_active_question()
        $('.' + act_el + ' .skfb__range-max').html(`${this_el.val()}`)
    })
    $('.msfb-slider-min-value').on('keyup', e => {
        let this_el = this__(e)
        let act_el = msfb_active_question()
        $('.' + act_el + ' .skfb__range-min').html(`${this_el.val()}`)
    })
    $('.msfb-slider-step').on('keyup', e => {
        let this_el = this__(e)
        let act_el = msfb_active_question()
        $('.' + act_el).attr('data-msfb-slider-step',`${this_el.val()}`)
    })
    $('#msfb-formulation-settings').on('click', e => {
        e.preventDefault()
        msfb_show_drawer("formulation");
    })
    // $('.tw-msfb-total-price span').counterUp({
    //     delay: 10,
    //     time: 1000
    // })
    $('.tw-msfb-multiselect-qtn__item').on('click', e => {
        let this_el = this__(e)
        console.log(this_el)
    })
})(jQuery);