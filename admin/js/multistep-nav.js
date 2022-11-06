(function ($) {
    $(document).ready(() => {
        $('.tw-msfb-total-price span').counterUp();
        const msfb_visited_path = () => {
            let nodes = [$('.tw-msfb-btn-container[data-msfb-root]').attr('data-msfb-root')]
            let visited_nodes = []
            $.each($('button[data-msfb-prev]'),(k,v) => {
                let has_node = $(v).attr('data-msfb-prev')
                if( has_node ) {
                    let node_id = $(v).closest('div[data-msfb-node]').attr('data-msfb-node')
                    if( $(v).closest('div[data-msfb-node]').attr('data-msfb-skipped') != "true" ){
                        if( $(v).closest('div[data-msfb-node]').find('button[data-msfb-redirect]').length == 0 ){
                        // if( !$(v).closest('div[data-msfb-node').hasClass('msfb-form') ){
                            nodes.push(node_id)
                            //console.log(node_id)
                        }
                    }
                    visited_nodes.push(node_id)
                }
            })
            nodes.push($('button[data-msfb-redirect]').closest('div[data-msfb-node].msfb-form').attr('data-msfb-node'))
            visited_nodes.push($('button[data-msfb-redirect]').closest('div[data-msfb-node].msfb-form').attr('data-msfb-node'))
            let lead_data = msfb_get_formulation_data(nodes)
            // let redirect_url = 
            //console.log(lead_data)
            $.ajax({
                url: msfb.ajax_url,
                type: "POST",
                dataType: "json",
                data: {
                    action: "msfb_add_leads",
                    dataset: {
                        "formulation_id": $('.tw-msfb-container').attr('data-formulation-id'),
                        "lead_data": JSON.stringify(lead_data)
                    }
                },
                success: resp => {
                    console.log(resp)
                    if( resp.formulation_id ) {
                        Swal.fire({
                            icon: "success",
                            text: msfb.translate.form_data_successfully_submitted
                        }).then( data => {
                            // window.location.href = $('button[data-msfb-redirect]').attr('data-msfb-redirect')
                        })
                    }
                },
                error: err => console.log(err)
            })
            //console.log(nodes)
            //console.log('visited nodes',visited_nodes)
        }
        $('.msfb-select .tw-msfb-qtn-field div').on('click', e => {
            let this_el = $(e.currentTarget)
            let this_node = this_el.closest('div[data-msfb-node]').attr('data-msfb-node')
            let total
            if( $('.tw-msfb-total-price span').length > 0 ) {
                total = parseFloat( $('.tw-msfb-total-price span').html() )
            }
            $.each($(`div[data-msfb-node=${this_node}] .tw-msfb-qtn-field div`),(k,v) => {
                if( $(v).hasClass('selected') ) {
                    if ( this_el.attr('data-price') && total != null ) {
                        total -= parseFloat($(v).attr('data-price'))
                        $('.tw-msfb-total-price span').html(total)
                    }
                }
                $(v).removeClass('selected')
            })
            this_el.addClass('selected');
            this_el.closest('div[data-msfb-node]').find('button[data-msfb-next]').attr('data-msfb-next',this_el.attr('data-next-node'))
            if ( this_el.attr('data-price') && total != null ) {
                total += parseFloat(this_el.attr('data-price'))
                //console.log(this_el.attr('data-price'))
                $('.tw-msfb-total-price span').html(total)
                $('.tw-msfb-total-price span').counterUp();
            }
        })
        $('.tw-msfb-slider-field').on('change',function(e){
            let price_holder =  $(this).closest('div[data-price]')
            let base_price = parseFloat( price_holder.attr('data-base-price') )
            let new_price = parseFloat($(this).val()) * base_price
            price_holder.attr('data-price',new_price)
        })
        $('.msfb-multiselect .tw-msfb-qtn-field div').on('click', e => {
            // //console.log(e)
            let this_el = $(e.currentTarget)
            let total
            if( $('.tw-msfb-total-price span').length > 0 ) {
                total = parseFloat( $('.tw-msfb-total-price span').html() )
            }
            if( this_el.hasClass('selected') ) {
                this_el.removeClass('selected');
                if ( this_el.attr('data-price') && total != null ) {
                    total -= parseFloat(this_el.attr('data-price'))
                    $('.tw-msfb-total-price span').html(total)
                    $('.tw-msfb-total-price span').counterUp();
                }
            } else {
                this_el.addClass('selected');
                if ( this_el.attr('data-price') && total != null ) {
                    total += parseFloat(this_el.attr('data-price'))
                    $('.tw-msfb-total-price span').html(total)
                    $('.tw-msfb-total-price span').counterUp();
                }
            }
        })
        $('button[data-msfb-next], button[data-msfb-prev]').on('click', e => {
            $('html, body').animate({
                scrollTop: $(".tw-msfb-container").offset().top
            }, 500)
            let this_el = $(e.currentTarget)
            let this_el_node = this_el.closest('div[data-msfb-node]').attr('data-msfb-node')
            let node_id
            let is_prev
            let is_skipped
            let step_holder = $('#msfb-progressbar-step')
            let step_unit_val = parseFloat($('#msfb-progressbar-step').attr('data-step'))
            let step_val = parseFloat($('#msfb-progressbar-step').attr('data-current-step'))
            if( this_el.attr('data-msfb-next') ) {
                node_id = this_el.attr('data-msfb-next')
                if( this_el.closest('div').attr('data-msfb-required') == "true" || this_el.closest('div[data-msfb-node]').hasClass('msfb-form') ) {
                    let msfb_validation = msfb_required_validator(this_el_node)
                    if( msfb_validation == false ) {
                        msfb_swal2_warning(msfb.translate.this_step_is_required)
                        return false
                    } else if ( msfb_validation !== true && msfb_validation !== false && typeof(msfb_validation) == "string" ) {
                        msfb_swal2_warning(msfb_validation)
                        return false
                    }
                }
                if( this_el.hasClass('msfb-skip-step') ) {
                    this_el.closest('div[data-msfb-node]').attr('data-msfb-skipped',true)
                    is_skipped = true
                } else {
                    this_el.closest('div[data-msfb-node]').attr('data-msfb-skipped',false)
                    is_skipped = false
                }
            } else if ( this_el.attr('data-msfb-prev') ) {
                node_id = this_el.attr('data-msfb-prev')
                is_prev = true
            }
            // //console.log(node_id)
            if ( node_id || is_prev || is_skipped ) {
                this_el.closest('div[data-msfb-node]').fadeOut('fast',() => {
                    this_el.closest('div[data-msfb-node]').addClass('hidden')
                    $(`div[data-msfb-node="${node_id}"]`).removeClass('hidden')
                    $(`div[data-msfb-node="${node_id}"]`).fadeIn('medium')
                    let this_node = this_el.closest('div[data-msfb-node]')
                    let this_node_price = parseFloat(this_node.attr('data-price'))
                    let total
                    if( $('.tw-msfb-total-price span').length > 0 ) {
                        total = parseFloat( $('.tw-msfb-total-price span').html() )
                    }
                    if( !is_prev ) {
                        $(`div[data-msfb-node="${node_id}"]`).find('button[data-msfb-prev]').attr('data-msfb-prev',this_el_node)
                        if( $('.tw-msfb-total-price span').length > 0 ) {
                            total = parseFloat( $('.tw-msfb-total-price span').html() )
                        }
                        if( this_node_price && total != null && is_skipped == false ) {
                            if ( this_node_price && total != null && !this_node.hasClass('msfb_node_price_added') ) {
                                // if (this_node.attr('data-question-type') == "msfb-slider-field" && this_node.attr('data-slider-prev-price') ) {
                                //     let prev_price = parseFloat(this_node.attr('data-slider-prev-price'))
                                //     if( this_node_price != prev_price ) {
                                //         total += this_node_price - prev_price
                                //     }
                                // } else {
                                // }
                                total += parseFloat(this_node_price)
                                $('.tw-msfb-total-price span').html(total)
                                this_node.addClass('msfb_node_price_added')
                                $('.tw-msfb-total-price span').counterUp();
                            }
                        } else if ( is_skipped == true ) {
                            if ( this_node_price && total != null && this_node.hasClass('msfb_node_price_added') ) {
                                total -= parseFloat(this_node_price)
                                $('.tw-msfb-total-price span').html(total)
                                this_node.removeClass('msfb_node_price_added')
                                $('.tw-msfb-total-price span').counterUp();
                            }
                        }
                        step_val += step_unit_val
                    } else {
                        step_val -= step_unit_val
                        // check if the node is previous question is slider
                        let prev_node_id = this_node.find('button[data-msfb-prev]').attr('data-msfb-prev')
                        let prev_node = $(`div[data-msfb-node="${prev_node_id}"]`)
                        let prev_qtn_type = prev_node.attr('data-question-type')
                        if( prev_qtn_type == "msfb-slider-field" ) {
                            prev_node.attr('data-slider-prev-price',prev_node.attr('data-price'))
                        }
                        let option_fields = ['msfb-single-select-field','msfb-multiselect','msfb-dropdown-field']
                        let this_qtn_type = this_node.attr('data-question-type')
                        if ( this_node_price && total != null && this_node.hasClass('msfb_node_price_added') && option_fields.indexOf(this_qtn_type) == -1 ) {
                            if (this_qtn_type == "msfb-slider-field" && this_node.attr('data-slider-prev-price') ) {
                                this_node_price = parseFloat(this_node.attr('data-slider-prev-price'))
                            }
                            total -= parseFloat(this_node_price)
                            $('.tw-msfb-total-price span').html(total)
                            this_node.removeClass('msfb_node_price_added')
                            $('.tw-msfb-total-price span').counterUp();
                        } 
                        else if ( option_fields.indexOf(this_qtn_type) > -1 ) {
                            let price = 0
                            switch (this_qtn_type) {
                                case 'msfb-multiselect':
                                    let selected_ans = this_node.find('.tw-msfb-qtn-field div.selected')
                                    if( this_node.find('.tw-msfb-qtn-field div.selected').length > 0 ) {
                                        $.each(selected_ans,function(k,v){
                                            price += parseFloat($(v).attr('data-price'))
                                            $(v).removeClass('selected')
                                        })
                                    }
                                    // price = this_node.find('.tw-msfb-qtn-field div.selected').length > 0 ? this_node.find('.tw-msfb-qtn-field div.selected').attr('data-price') : 0
                                    // this_node.find('.tw-msfb-qtn-field div').removeClass('selected')
                                    break;
                                case 'msfb-single-select-field':
                                    price = this_node.find('.tw-msfb-qtn-field div.selected').length > 0 ? this_node.find('.tw-msfb-qtn-field div.selected').attr('data-price') : 0
                                    this_node.find('.tw-msfb-qtn-field div').removeClass('selected')
                                    this_node.find('button[data-msfb-next]').attr('data-msfb-next','')
                                    break;
                                case 'msfb-dropdown-field':
                                    price = this_node.attr('data-added-price') ? this_node.attr('data-added-price') : 0
                                    this_node.attr('data-added-price','')
                                    this_node.find('.tw-msfb-dropdown-field p').html(msfb.translate.msfb_select_from_dropdown)
                                    this_node.find('button[data-msfb-next]').attr('data-msfb-next','')
                                    break;
                            }
                            total -= parseFloat(price)
                            $('.tw-msfb-total-price span').html(total)
                            $('.tw-msfb-total-price span').counterUp();
                        }
                        this_el.closest('div[data-msfb-node]').find('button[data-msfb-prev]').attr('data-msfb-prev','')
                    }
                    $('.tw-msfb-progress-bar__status').animate({"width":`${step_val}%`})
                    step_holder.attr('data-current-step',step_val)
                })
            } else if ( node_id == null ) {
                Swal.fire({
                    icon: 'warning',
                    text: msfb.translate.this_option_did_not_point_to_any_other_question
                })
            } else {
                Swal.fire({
                    icon: 'warning',
                    text: msfb.translate.select_an_option_first
                })
            }
        })
        $('.tw-msfb-dropdown-field').on('click', e => {
            let this_el = $(e.currentTarget)
            this_el.find('.item-holder').toggle('fast')
        })
        $('div.tw-msfb-dropdown-qtn__item').on('click', e => {
            let this_el = $(e.currentTarget)
            let next_node = this_el.attr('data-next-node')
            let is_form_field = this_el.hasClass('tw-form-dropdown')
            let total
            if( $('.tw-msfb-total-price span').length > 0 ) {
                total = parseFloat( $('.tw-msfb-total-price span').html() )
            }
            if( next_node ) {
                this_el.closest('div[data-msfb-node]').find('button[data-msfb-next]').attr('data-msfb-next',next_node)
                if ( total != null && this_el.attr('data-price') ) {
                    if( this_el.closest('div[data-msfb-node]').attr('data-added-price') ) {
                        total -= parseFloat(this_el.closest('div[data-msfb-node]').attr('data-added-price'))
                    }
                    total += parseFloat(this_el.attr('data-price'))
                    this_el.closest('div[data-msfb-node]').attr('data-added-price',this_el.attr('data-price'))
                    $('.tw-msfb-total-price span').html(total)
                    $('.tw-msfb-total-price span').counterUp();
                }
            } else {
                if( !is_form_field ) {
                    Swal.fire({
                        icon: 'warning',
                        text: msfb.translate.this_option_did_not_point_to_any_other_question
                    })
                    return false
                }
            }
            let option_label = this_el.html()
            let option_value = this_el.attr('data-dropdown-value')
            this_el.closest('.tw-msfb-dropdown-field').find('p').html(option_label)
            if( is_form_field ) {
                this_el.closest('.msfb-form-dropdown').attr('data-dropdown-value',this_el.attr('data-dropdown-value'))
            } else {
                this_el.closest('.msfb-dropdown').attr('data-dropdown-value',this_el.attr('data-dropdown-value'))
            }
        })
        $('button[data-msfb-redirect]').on('click', e => {
            let this_el = $(e.currentTarget)
            let node_id = this_el.closest('div[data-msfb-node]').attr('data-msfb-node')
            let msfb_validation = msfb_required_validator(node_id)
            if( msfb_validation == false ) {
                msfb_swal2_warning(msfb.translate.this_step_is_required)
                return false
            } else if ( msfb_validation !== true && msfb_validation !== false && typeof(msfb_validation) == "string" ) {
                msfb_swal2_warning(msfb_validation)
                return false
            }
            msfb_visited_path()
            $('.tw-msfb-progress-bar__status').animate({"width":`100%`})
        })
        // slider change
        $('.tw-msfb-slider-field').on('change', e => {
            let this_el = $(e.currentTarget)
            $('.msfb-slider-field-value strong').html(this_el.val())
        })
        // upload
        $('.tw-msfb-upload-field input').on('change', e => {
            let this_el = $(e.currentTarget)
            // //console.log(this_el)
            let files = this_el[0].files
            if( files.length > 0 ) {
                this_el.closest('.tw-msfb-upload-field')
                    .addClass('selected')
                    .find('p').html(`${files.length} file selected.`)
                this_el.closest('.tw-msfb-upload-field').find('i').removeClass('fa-upload')
                this_el.closest('.tw-msfb-upload-field').find('i').addClass('fa-file')
            }
            // //console.log(this_el[0].files[0])
        })
        // $('button[data-msfb-next]').on('click', e => {
        //     let this_el = $(e.currentTarget)
        //     let btn_holder = this_el.closest('div')
        //     if( btn_holder.attr('data-msfb-required') ) {
        //         Swal.fire({
        //             icon: "warning",
        //             text: msfb.translate.this_step_is_required
        //         })
        //     }
        // })
        const msfb_swal2_warning = msg => {
            Swal.fire({
                icon: "warning",
                text: msg
            })
        }
        const msfb_required_validator = node_id => {
            let validator = true
            let this_el = $(`div[data-msfb-node="${node_id}"]`)
            if( this_el.attr('data-question-type') ) {
                let field_type = this_el.attr('data-question-type')
                if( field_type == "msfb-date-field" || field_type == "msfb-text-field") {
                    if( !this_el.find('input').val() ) {
                        validator = false
                    }
                } else if ( field_type == "msfb-textarea-field") {
                    if( !this_el.find('textarea').val() ) {
                        validator = false
                    }
                } else if ( field_type == "msfb-multiselect") {
                    let selected = []
                    $.each($(`div[data-msfb-node="${node_id}"] .tw-msfb-multiselect-qtn__item`),(k,v) => {
                        if( $(v).hasClass('selected')) {
                            selected.push('selected')
                        }
                    })
                    if( selected.length == 0 ) {
                        validator = false
                    }
                } else if ( field_type == "msfb-upload-field") {
                    if( !this_el.find('input').val() ) {
                        validator = false
                    }
                }
            } else {
                let field_is_required_msg = msfb.translate.field_is_required
                $.each($(`div[data-msfb-node="${node_id}"] .msfb-form-field`),(k,v) => {
                    if( $(v).attr('data-msfb-required') == "1" ) {
                        if( $(v).hasClass('msfb-form-checkbox') ) {
                            if( $(v).find(`input:checked`).length === 0 ) {
                                validator = `${$(v).find('label.text-lg').html()} ${field_is_required_msg}`
                                return false
                            }
                        } else if ( ( $(v).hasClass('msfb-form-text') && !$(v).hasClass('msfb-form-dropdown')) || $(v).hasClass('msfb-form-date') ) {
                            if( $(v).find('input').val() == "" ) {
                                validator = `${$(v).find('label.text-lg').html()} ${field_is_required_msg}`
                                return false
                            }
                        } else if ( $(v).hasClass('msfb-form-textarea') ) {
                            if( $(v).find('textarea').val() == "" ) {
                                validator = `${$(v).find('label.text-lg').html()} ${field_is_required_msg}`
                                return false
                            }
                        } else if ( $(v).hasClass('msfb-form-dropdown') ) {
                            if( $(v).attr('data-dropdown-value') == undefined || $(v).attr('data-dropdown-value') == null ) {
                                validator = `${$(v).find('label.text-lg').html()} ${field_is_required_msg}`
                                return false
                            }
                        }
                    }
                })
                // //console.log('This is form step')
            }
            return validator
        }
        // get the formulation data
        const msfb_get_formulation_data = node_ids => {
            let data = []
            // //console.log(node_ids)
            for (let i = 0; i < node_ids.length; i++) {
                let dataset
                let title
                let value
                let node_id = node_ids[i]
                let this_el = $(`div[data-msfb-node="${node_id}"]`)
                if( this_el.attr('data-question-type') ) {
                    let field_type = this_el.attr('data-question-type')
                    if( field_type == "msfb-date-field" || field_type == "msfb-text-field" || field_type == "msfb-slider-field") {
                        if( this_el.find('input').val() ) {
                            title = this_el.find('h1.text-4xl').html()
                            value = this_el.find('input').val()
                        }
                    } else if ( field_type == "msfb-textarea-field") {
                        if( this_el.find('textarea').val() ) {
                            title = this_el.find('h1.text-4xl').html()
                            value = this_el.find('textarea').val()
                        }
                    } else if ( field_type == "msfb-multiselect" || field_type == "msfb-single-select-field") {
                        let selected = []
                        $.each($(`div[data-msfb-node="${node_id}"] .tw-msfb-multiselect-qtn__item`),(k,v) => {
                            if( $(v).hasClass('selected')) {
                                selected.push($(v).find('p').html())
                            }
                        })
                        title = this_el.find('h1.text-4xl').html()
                        value = selected
                    } else if ( field_type == "msfb-dropdown-field") {
                        if( this_el.attr('data-dropdown-value') ) {
                            title = this_el.find('h1.text-4xl').html()
                            value = this_el.attr('data-dropdown-value')
                        }
                    } else if ( field_type == "msfb-upload-field") {
                        if( this_el.find('input').val() ) {
                            title = this_el.find('h1.text-4xl').html()
                            value = this_el.attr('data-dropdown-value')
                        }
                    }
                    dataset = { title, value}
                } else {
                    let field_is_required_msg = msfb.translate.field_is_required
                    let form_fiels = this_el.find('.msfb-form-field')
                    // //console.log(form_fiels)
                    // $.each(form_fiels,(k,v) => {
                    // for( j = 0; j < form_fiels.length; j++ ){
                    let form_data = []
                    let lead_map = []
                    $.each(form_fiels,(k,v) => {
                        // v = form_fiels[j]
                        // //console.log(v)
                        let is_required = $(v).attr('data-msfb-required')
                        let is_lead_col = $(v).attr('data-msfb-is-lead-col')
                        if( is_lead_col ) {
                            lead_map[k] = $(v).find('label.text-lg').html()
                        }
                        title = $(v).attr('data-field-label')
                        if( $(v).hasClass('msfb-form-checkbox') ) {
                            let value = []
                            $.each( $(v).find('input:checked'), (kke,vva) => {
                                value.push($(vva).val())
                            })
                            if( value.length == 0 && is_required) {
                                validator = `${$(v).find('label.text-lg').html()} ${field_is_required_msg}`
                                Swal.fire({
                                    icon: "warning",
                                    text: validator
                                })
                                return false
                            }
                            if( value.length ) {
                                if( is_lead_col ) {
                                    form_data[k] = { title, value, "lead_col": k}
                                } else {
                                    form_data[k] = { title, value}
                                }
                            }
                        } 
                        if( $(v).hasClass('msfb-form-radio') ) {
                            // //console.log($(v))
                            let value = []
                            $.each( $(v).find('input:checked'), (kke,vva) => {
                                value.push($(vva).val())
                            })
                            // if( $(v).find(`input:checked`).length > 0 ) {
                            // //console.log(value)
                            if( value.length == 0 && is_required) {
                                validator = `${$(v).find('label.text-lg').html()} ${field_is_required_msg}`
                                Swal.fire({
                                    icon: "warning",
                                    text: validator
                                })
                                return false
                            }
                            if( value.length ) {
                                if( is_lead_col ) {
                                    form_data[k] = { title, value, "lead_col": k}
                                } else {
                                    form_data[k] = { title, value}
                                }
                            }
                        }
                        if ( ( $(v).hasClass('msfb-form-text') && !$(v).hasClass('msfb-form-dropdown')) || $(v).hasClass('msfb-form-date') ) {
                            let value = []
                            if( $(v).find('input').val() == "" && is_required) {
                                validator = `${$(v).find('label.text-lg').html()} ${field_is_required_msg}`
                                Swal.fire({
                                    icon: "warning",
                                    text: validator
                                })
                                return false
                            }
                            if( $(v).find('input').val() ) {
                                value.push($(v).find('input').val())
                                if( is_lead_col ) {
                                    form_data[k] = { title, value, "lead_col": k}
                                } else {
                                    form_data[k] = { title, value}
                                }
                            }
                        }
                        if ( $(v).hasClass('msfb-form-textarea') ) {
                            let value = []
                            if( $(v).find('textarea').val() == "" && is_required) {
                                validator = `${$(v).find('label.text-lg').html()} ${field_is_required_msg}`
                                Swal.fire({
                                    icon: "warning",
                                    text: validator
                                })
                                return false
                            }
                            if( $(v).find('textarea').val() ) {
                                value.push($(v).find('textarea').val())
                                if( is_lead_col ) {
                                    form_data[k] = { title, value, "lead_col": k}
                                } else {
                                    form_data[k] = { title, value}
                                }
                            }
                        }
                        if ( $(v).hasClass('msfb-form-dropdown') ) {
                            let value = []
                            if( ($(v).attr('data-dropdown-value') == undefined || $(v).attr('data-dropdown-value') == null) && is_required ) {
                                validator = `${$(v).find('label.text-lg').html()} ${field_is_required_msg}`
                                Swal.fire({
                                    icon: "warning",
                                    text: validator
                                })
                                return false
                            }
                            if( $(v).attr('data-dropdown-value') ) {
                                value.push($(v).attr('data-dropdown-value'))
                                if( is_lead_col ) {
                                    form_data[k] = { title, value, "lead_col": k}
                                } else {
                                    form_data[k] = { title, value}
                                }
                            }
                        }
                        if ( $(v).hasClass('msfb-form-slider') ) {
                            let value = []
                            if( $(v).find('input').val() ) {
                                value.push($(v).find('input').val())
                                if( is_lead_col ) {
                                    form_data[k] = { title, value, "lead_col": k}
                                } else {
                                    form_data[k] = { title, value}
                                }
                            }
                        }
                    })
                    let form_id = $('button[data-msfb-redirect]').closest('div[data-msfb-node].msfb-form').attr('data-form-id')
                    dataset = { form_id, "form_data": {...form_data}, "lead_map": {...lead_map}, "total_price": $('.tw-msfb-total-price span').html() }
                    // if( $('.tw-msfb-total-price span').length > 0 ) {
                    // } else {
                    //     dataset = { form_id, "form_data": {...form_data}, "lead_map": {...lead_map} }
                    // }
                }
                data.push(dataset)
            }
            //console.log(data)
            return data
        }
    })
})(jQuery);