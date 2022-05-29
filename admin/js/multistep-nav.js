(function ($) {
    $(document).ready(() => {
        const msfb_visited_path = () => {
            let nodes = [$('.tw-msfb-btn-container[data-msfb-root]').attr('data-msfb-root')]
            $.each($('button[data-msfb-prev]'),(k,v) => {
                let has_node = $(v).attr('data-msfb-prev')
                if( has_node ) {
                    if( $(v).closest('div[data-msfb-node]').attr('data-msfb-skipped') != "true" ){
                        let node_id = $(v).closest('div[data-msfb-node]').attr('data-msfb-node')
                        nodes.push(node_id)
                    }
                }
            })
            let lead_data = msfb_get_formulation_data(nodes)
            // let redirect_url = 
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
                },
                error: err => console.log(err)
            })
            // console.log(nodes)
        }
        $('.msfb-select .tw-msfb-qtn-field div').on('click', e => {
            // console.log(e)
            let this_el = $(e.currentTarget)
            $.each($('.msfb-select .tw-msfb-qtn-field div'),(k,v) => {
                $(v).removeClass('selected')
            })
            if( this_el.hasClass('selected') ) {
                this_el.removeClass('selected');
            } else {
                this_el.addClass('selected');
                this_el.closest('div[data-msfb-node]').find('button[data-msfb-next]').attr('data-msfb-next',this_el.attr('data-next-node'))
            }
        })
        $('.msfb-multiselect .tw-msfb-qtn-field div').on('click', e => {
            // console.log(e)
            let this_el = $(e.currentTarget)
            if( this_el.hasClass('selected') ) {
                this_el.removeClass('selected');
            } else {
                this_el.addClass('selected');
            }
        })
        $('button[data-msfb-next], button[data-msfb-prev]').on('click', e => {
            let this_el = $(e.currentTarget)
            let this_el_node = this_el.closest('div[data-msfb-node]').attr('data-msfb-node')
            let node_id
            let is_prev
            let is_skipped
            if( this_el.attr('data-msfb-next') ) {
                node_id = this_el.attr('data-msfb-next')
                if( this_el.closest('div').attr('data-msfb-required') == "true" || this_el.closest('div[data-msfb-node]').hasClass('msfb-form') ) {
                    let msfb_validation = msfb_required_validator(this_el_node)
                    if( msfb_validation == false ) {
                        msfb_swal2_warning("This step is required")
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
            // console.log(node_id)
            if ( node_id || is_prev || is_skipped ) {
                this_el.closest('div[data-msfb-node]').fadeOut('fast',() => {
                    this_el.closest('div[data-msfb-node]').addClass('hidden')
                    $(`div[data-msfb-node="${node_id}"]`).removeClass('hidden')
                    $(`div[data-msfb-node="${node_id}"]`).fadeIn('medium')
                    if( !is_prev ) {
                        $(`div[data-msfb-node="${node_id}"]`).find('button[data-msfb-prev]').attr('data-msfb-prev',this_el_node)
                    } else {
                        this_el.closest('div[data-msfb-node]').find('button[data-msfb-prev]').attr('data-msfb-prev','')
                    }
                })
            } else {
                Swal.fire({
                    icon: 'warning',
                    text: 'Selct an option first'
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
            if( next_node ) {
                this_el.closest('div[data-msfb-node]').find('button[data-msfb-next]').attr('data-msfb-next',next_node)
            } else {
                if( !is_form_field ) {
                    Swal.fire({
                        icon: 'warning',
                        text: 'This option did not point to any other field'
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
                msfb_swal2_warning("This step is required")
                return false
            } else if ( msfb_validation !== true && msfb_validation !== false && typeof(msfb_validation) == "string" ) {
                msfb_swal2_warning(msfb_validation)
                return false
            }
            msfb_visited_path()
        })
        // slider change
        $('.tw-msfb-slider-field').on('change', e => {
            let this_el = $(e.currentTarget)
            $('.msfb-slider-field-value strong').html(this_el.val())
        })
        // upload
        $('.tw-msfb-upload-field input').on('change', e => {
            let this_el = $(e.currentTarget)
            // console.log(this_el)
            let files = this_el[0].files
            if( files.length > 0 ) {
                this_el.closest('.tw-msfb-upload-field')
                    .addClass('selected')
                    .find('p').html(`${files.length} file selected.`)
                this_el.closest('.tw-msfb-upload-field').find('i').removeClass('fa-upload')
                this_el.closest('.tw-msfb-upload-field').find('i').addClass('fa-file')
            }
            // console.log(this_el[0].files[0])
        })
        // $('button[data-msfb-next]').on('click', e => {
        //     let this_el = $(e.currentTarget)
        //     let btn_holder = this_el.closest('div')
        //     if( btn_holder.attr('data-msfb-required') ) {
        //         Swal.fire({
        //             icon: "warning",
        //             text: "This step is required"
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
                $.each($(`div[data-msfb-node="${node_id}"] .msfb-form-field`),(k,v) => {
                    if( $(v).attr('data-msfb-required') == "1" ) {
                        if( $(v).hasClass('msfb-form-checkbox') ) {
                            if( $(v).find(`input:checked`).length === 0 ) {
                                validator = `${$(v).find('label.text-lg').html()} is required.`
                                return false
                            }
                        } else if ( ( $(v).hasClass('msfb-form-text') && !$(v).hasClass('msfb-form-dropdown')) || $(v).hasClass('msfb-form-date') ) {
                            if( $(v).find('input').val() == "" ) {
                                validator = `${$(v).find('label.text-lg').html()} is required.`
                                return false
                            }
                        } else if ( $(v).hasClass('msfb-form-textarea') ) {
                            if( $(v).find('textarea').val() == "" ) {
                                validator = `${$(v).find('label.text-lg').html()} is required.`
                                return false
                            }
                        } else if ( $(v).hasClass('msfb-form-dropdown') ) {
                            if( $(v).attr('data-dropdown-value') == undefined || $(v).attr('data-dropdown-value') == null ) {
                                validator = `${$(v).find('label.text-lg').html()} is required.`
                                return false
                            }
                        }
                    }
                })
                // console.log('This is form step')
            }
            return validator
        }
        // get the formulation data
        const msfb_get_formulation_data = node_ids => {
            let data = []
            // console.log(node_ids)
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
                    let form_fiels = this_el.find('.msfb-form-field')
                    // console.log(form_fiels)
                    // $.each(form_fiels,(k,v) => {
                    // for( j = 0; j < form_fiels.length; j++ ){
                    let form_data = []
                    let lead_map = []
                    $.each(form_fiels,(k,v) => {
                        // v = form_fiels[j]
                        // console.log(v)
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
                                validator = `${$(v).find('label.text-lg').html()} is required.`
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
                            // console.log($(v))
                            let value = []
                            $.each( $(v).find('input:checked'), (kke,vva) => {
                                value.push($(vva).val())
                            })
                            // if( $(v).find(`input:checked`).length > 0 ) {
                            // console.log(value)
                            if( value.length == 0 && is_required) {
                                validator = `${$(v).find('label.text-lg').html()} is required.`
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
                                validator = `${$(v).find('label.text-lg').html()} is required.`
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
                                validator = `${$(v).find('label.text-lg').html()} is required.`
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
                                validator = `${$(v).find('label.text-lg').html()} is required.`
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
                    dataset = { "form_data": {...form_data}, "lead_map": {...lead_map} }
                }
                data.push(dataset)
            }
            console.log(data)
            return data
        }
    })
})(jQuery);