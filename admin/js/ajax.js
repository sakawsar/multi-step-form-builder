jQuery(document).ready($ => {
    const msfb_active_question = () => {
        let act_el = $('div[data-msfb-active="1"]')
        if( act_el.length > 0 ){
            return act_el.attr('data-body-type')
        } else {
            return false
        }
    }
    const msfb_error_message = msg => {
        Swal.fire({
            icon: "warning",
            text: msg
        })
    }
    // get this value function
    const this__ = el => $(el.currentTarget)
    // save question
    $('#msfb_save_question').on('click',e => {
        let this_el = this__(e)
        let act_el = msfb_active_question()
        let qtn_name = $(`.${act_el}`).attr('data-qtn-name')
        let qtn_title = $(`.${act_el} .skfb__form-title`).html()
        let qtn_desc = $(`.${act_el} .skfb__form-desc`).html()
        let qtn_price = $(`.${act_el}`).attr('data-msfb-price')
        let qtn_required = $(`.${act_el}`).attr('data-msfb-required')
        let fields_data = {
            "question_name": qtn_name,
            "question_title": qtn_title,
            "question_desc": qtn_desc,
            "question_price": qtn_price,
            "question_required": qtn_required
        }
        // validate the fields
        if( qtn_name == undefined || qtn_name == "" ){
            msfb_error_message("Question name field is reqeuired.")
            return false;
        }
        if( qtn_title == undefined || qtn_title == "" || qtn_title == "title" ){
            msfb_error_message("Question title field is reqeuired.")
            return false;
        }
        if( qtn_desc == undefined || qtn_desc == "" || qtn_desc == "Description" ){
            msfb_error_message("Question description field is reqeuired.")
            return false;
        }
        if( qtn_desc == undefined || qtn_desc == "" || qtn_desc == "Description" ){
            msfb_error_message("Question description field is reqeuired.")
            return false;
        }
        if( act_el == "msfb-multiselect" ) {
            let select_opts = $(`.${act_el} div[data-multiselect-no]`)
            if( select_opts.length == 0 ) {
                msfb_error_message("There should be at least one option")
                return false
            }
            let multiselect_opts = []
            $.each(select_opts,(k,v) => {
                let opt_data = {
                    "icon_class": $(v).find('.icon i').attr('class'),
                    "answer": $(v).find('.skfb__answer').html()
                }
                multiselect_opts.push(opt_data)
            })
            fields_data.question_type = "msfb-multiselect"
            fields_data.question_data = JSON.stringify( multiselect_opts )
        } else if ( act_el == "msfb-single-select-field" ) {
            let select_opts = $(`.${act_el} div[data-multiselect-no]`)
            if( select_opts.length == 0 ) {
                msfb_error_message("There should be at least one option")
                return false
            }
            let single_select_opts = []
            $.each(select_opts,(k,v) => {
                let opt_data = {
                    "icon_class": $(v).find('.icon i').attr('class'),
                    "answer": $(v).find('.skfb__answer').html()
                }
                single_select_opts.push(opt_data)
            })
            fields_data.question_type = "msfb-single-select-field"
            fields_data.question_data = JSON.stringify( single_select_opts )
        } else if ( act_el == "msfb-text-field" ) {
            let field_data = {
                "placeholder": $(`.${act_el} input`).attr('placeholder')
            }
            fields_data.question_type = "msfb-text-field"
            fields_data.question_data = JSON.stringify( field_data )
        } else if ( act_el == "msfb-textarea-field" ) {
            let field_data = {
                "placeholder": $(`.${act_el} textarea`).attr('placeholder')
            }
            fields_data.question_type = "msfb-textarea-field"
            fields_data.question_data = JSON.stringify( field_data )
        } else if ( act_el == "msfb-date-field" ) {
            let field_data = {
                "placeholder": $(`.${act_el} input`).attr('placeholder'),
                "date_format": $(`.${act_el}`).attr('data-msfb-date-format')
            }
            fields_data.question_type = "msfb-date-field"
            fields_data.question_data = JSON.stringify( field_data )
        } else if ( act_el == "msfb-upload-field" ) {
            fields_data.question_type = "msfb-upload-field"
        } else if ( act_el == "msfb-dropdown-field" ) {
            let sel_options = $(`.${act_el} select option`)
            let sel_data = []
            $.each(sel_options,(k,v) => {
                let a_opt_data = {
                    "value": $(v).val(),
                    "option": $(v).html()
                }
                sel_data.push(a_opt_data)
            }) 
            let field_data = {
                "option_data": sel_data
            }
            fields_data.question_type = "msfb-dropdown-field"
            fields_data.question_data = JSON.stringify( field_data )
        } else if ( act_el == "msfb-map-field" ) {
            fields_data.question_type = "msfb-map-field"
        } else if ( act_el == "msfb-slider-field" ) {
            let field_data = {
                "default_val": $(`.${act_el}`).attr('data-msfb-default-val'),
                "max_val": $(`.${act_el} .skfb__range-max`).html(),
                "min_val": $(`.${act_el} .skfb__range-min`).html(),
                "step": $(`.${act_el}`).attr('data-msfb-slider-step')
            }
            fields_data.question_type = "msfb-slider-field"
            fields_data.question_data = JSON.stringify( field_data )
        }
        this_el.html(`<i class="fa fa-refresh fa-spin"></i> Save`)
        let qtn_id = this_el.attr('data-qtn-id')
        if( qtn_id != undefined && qtn_id != "" ) {
            fields_data.question_id = qtn_id
        }
        $.ajax({
            url: msfb.ajax_url,
            type: "POST",
            dataType: "json",
            data: {
                action: "msfb_save_questions",
                dataset: fields_data
            },
            success:resp => {
                console.log(resp)
                this_el.html(`<i class="fas fa-save"></i> Save`)
                this_el.attr('data-qtn-id',resp.question_id)
                if( resp.status != undefined && resp.status == "created" ) {
                    Swal.fire({
                        icon: "success",
                        text: "Question has been added."
                    })
                } else if(resp.status != undefined && resp.status == "updated" ){
                    Swal.fire({
                        icon: "success",
                        text: "Question has been updated."
                    })
                }
            },
            error:err => {
                console.log(err)
                this_el.html(`<i class="fas fa-save"></i> Save`)
            }
        })
    })
    // delete an item
    $('i[data-msfb-delete-id]').on('click',e => {
        let this_el = this__(e)
        let item_type = this_el.attr('data-msfb-item-type');
        let item_id = this_el.attr('data-msfb-delete-id');
        Swal.fire({
            icon: "question",
            text: "Do you really want to delete this question?",
            showCloseButton: true,
            showCancelButton: true,
            showConfirmButton: true,
            confirmButtonText: "Yes",
            cancelButtonText: "No"
        }).then( result => {
            if(result.isConfirmed){
                $.ajax({
                    url: msfb.ajax_url,
                    type: "POST",
                    dataType: "json",
                    data: {
                        action: "msfb_delete_item",
                        dataset: [item_id, item_type]
                    },
                    success: resp => {
                        console.log(resp)
                        if( resp.status ) {
                            window.location.reload()
                        }
                    },
                    error: err => {
                        console.log(err)
                    }
                })
            }
        })
    })
    // save a category
    $('select[data-msfb-item-type]').on('change', e => {
        let this_el = this__(e)
        let cat_id = this_el.val()
        let item_id = this_el.attr('data-msfb-item-id')
        let item_type = this_el.attr('data-msfb-item-type')
        $.ajax({
            url: msfb.ajax_url,
            type: "POST",
            dataType: "json",
            data: {
                action: "msfb_save_category",
                dataset: [cat_id, item_id, item_type]
            },
            success: resp => {
                console.log(resp)
                if( resp.status ) {
                    window.location.reload()
                }
            },
            error: err => {
                console.log(err)
            }
        })
    })
    // show add category popup
    $('#msfb-add-category').on('click', async (e) => {
        e.preventDefault()
        let this_el = this__(e)
        let cat_type = this_el.attr('data-msfb-cat-type')
        console.log('working')
        const { value: cat_name } = await Swal.fire({
            title: 'Add a category',
            text: "Category name",
            input: 'text',
            inputLabel: 'Category name',
            inputPlaceholder: 'Category name'
        })
        if (cat_name) {
            console.log(cat_name)
            this_el.find('i').attr('class','fa fa-plus fa-spin')
            $.ajax({
                url: msfb.ajax_url,
                type: "POST",
                dataType: "json",
                data: {
                    action: "msfb_add_category",
                    dataset: [cat_name,cat_type]
                },
                success: resp => {
                    if( resp.status )
                    Swal.fire({
                        icon: "success",
                        text: "Category has been added"
                    })
                    this_el.find('i').attr('class','fa fa-plus')
                    window.location.reload()
                },
                error: err => {
                    console.log(err)
                    this_el.find('i').attr('class','fa fa-plus')
                }
            })
        }
    })
    // apply bulk action
    $('#msfb-apply-bulk-action').on('click', e => {
        let this_el = this__(e)
        let el_type = this_el.attr('data-el-type')
        let checked_items = $(`#msfb-table-item-holder tr[data-msfb-pagination] td input.msfb-sel-field:checked`)
        let checked_item_ids = []
        $.each(checked_items,(k,v) => {
            checked_item_ids.push($(v).attr('data-msfb-item-id'))
        })
        if( checked_item_ids.length > 0 && $('#msfb-bulk-action').val() != "" ) {
            console.log(checked_item_ids)
            this_el.find('i').attr('class','fa fa-spinner fa-spin')
            $.ajax({
                url: msfb.ajax_url,
                type: "POST",
                dataType: "json",
                data: {
                    action: "msfb_bulk_action",
                    dataset: {
                        "item_ids": checked_item_ids,
                        "action": $('#msfb-bulk-action').val(),
                        "el_type": el_type
                    }
                },
                success: resp => {
                    console.log(resp)
                    this_el.find('i').attr('class','fas fa-check')
                    if( resp.status ){
                        window.location.reload()
                    }
                },
                error: err => {
                    console.log(err)
                    this_el.find('i').attr('class','fas fa-check')
                }
            })
        }
    })
})