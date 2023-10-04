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
    // load preview
    $('#msfb-preview-formula-btn').on('click',e => {
        // this_el
        let this_el = this__(e)
        let qflow_id = this_el.attr('data-qflow-id')
        // $.ajax({
        //     url: msfb.ajax_url,
        //     type: "POST",
        //     dataType: "html",
        //     data: {
        //         action: "msfb_preview_formula",
        //         dataset: qflow_id
        //     },
        //     success: function(resp){
        //         $('#msfb-preview-formula').html(resp)
        //     },
        //     error:function(err){
        //         Swal.fire({
        //             icon: "error",
        //             text: "Something went wrong."
        //         })
        //         console.log(err)
        //     }
        // })
    })
    // duplicate item
    $('.msfb-duplicate-item').on('click',e => {
        e.preventDefault()
        let this_el = this__(e)
        let item_id = this_el.attr('data-el-id')
        let item_type = this_el.attr('data-el-type')
        let icon = this_el.find('i')
        icon.attr('class','fa fa-spinner fa-spin')
        $.ajax({
            url: msfb.ajax_url,
            type: "POST",
            dataType: "json",
            data: {
                action: "msfb_duplicate_item",
                dataset: {
                    item_id, item_type
                }
            },
            success: resp => {
                console.log(resp)
                icon.attr('class','fa fa-clone')
                if( resp.status ) {
                    window.location.reload()
                }
            },
            error: err => {
                console.log(err)
                icon.attr('class','fa fa-clone')
            }
        })
    })
    // leads date range filter by ajax
    $('#msfb_filter_lead_by_date_range').on('click',e => {
        e.preventDefault()
        if( !$('#msfb_chart_date_start').val() || !$('#msfb_chart_date_end').val()) {
            Swal.fire({
                icon: "warning",
                text: "Please select start and end date"
            })
            return false
        }
        let start_date = $('#msfb_chart_date_start').val()
        let end_date = $('#msfb_chart_date_end').val()
        let data = {
            action: 'msfb_leads_date_range',
            dataset: [start_date,end_date, window.msfb_all_data]
        }
        $.ajax({
            url: msfb.ajax_url,
            type: "POST",
            dataType: "json",
            data,
            success: res => {
                // console.log(res)
                window.msfb_chart.data.labels = res.data.labels
                window.msfb_chart.data.datasets[0].data = res.data.data
                window.msfb_chart.update()
            },
            error: err => {
                console.log(err)
            }
        })
    })
    // update chartjs
    $('#msfb_update_chart').on('change', e => {
        let set_type = $(e.currentTarget).val()
        console.log(set_type)
        let this_data = {
            labels: [],
            data: []
        }
        switch(set_type) {
            case "last_7_days":
                this_data = JSON.parse(window.msfb_last_7_days)
                break
            case "yesterday":
                console.log(window.msfb_yesterday_data)
                this_data = JSON.parse(window.msfb_yesterday_data)
                break
            case "last_month":
                console.log(window.msfb_last_month_data)
                this_data = JSON.parse(window.msfb_last_month_data)
                break
            case "all":
                console.log(window.msfb_all_data)
                this_data = JSON.parse(window.msfb_all_data)
                break
        }
        window.msfb_chart.data.labels = this_data.labels
        window.msfb_chart.data.datasets[0].data = this_data.data
        window.msfb_chart.update()
    })
    // get this value function
    const this__ = el => $(el.currentTarget)
    // save question
    $('#msfb_save_question').on('click',e => {
        let this_el = this__(e)
        let act_el = msfb_active_question()
        let qtn_name = $(`.${act_el}`).attr('data-qtn-name')
        let qtn_title = $(`.${act_el} .skfb__form-title`).html()
        let qtn_desc = $(`.${act_el} .skfb__form-desc`).val()
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
        // if( qtn_desc == undefined || qtn_desc == "" || qtn_desc == "Description" ){
        //     msfb_error_message("Question description field is reqeuired.")
        //     return false;
        // }
        // if( qtn_desc == undefined || qtn_desc == "" || qtn_desc == "Description" ){
        //     msfb_error_message("Question description field is reqeuired.")
        //     return false;
        // }
        if( act_el == "msfb-multiselect" ) {
            let select_opts = $(`.${act_el} div[data-multiselect-no]`)
            if( select_opts.length == 0 ) {
                msfb_error_message("There should be at least one option")
                return false
            }
            let multiselect_opts = []
            $.each(select_opts,(k,v) => {
                let opt_data = {
                    // "icon_class": $(v).find('.icon i').attr('class'),
                    "answer": $(v).find('.skfb__answer').html(),
                    "price": $(v).find('.skfb__answer').attr('data-price')
                }
                let icon = $(v).find('.icon i')
                let img = $(v).find('.icon img')
                if( icon.length > 0 && icon.css('display') != 'none' ) {
                    opt_data.icon_class = icon.attr('class')
                }
                if( img.length > 0 && img.css('display') != 'none' ) {
                    opt_data.img_url = img.attr('src')
                }
                multiselect_opts.push(opt_data)
            })
            fields_data.question_type = "msfb-multiselect"
            // let field_data_for_multiselect = {
            //     "option_data": multiselect_opts
            // }
            // if( $('.msfb-create-route-set').attr('preserved-data') ) {
            //     field_data_for_multiselect.route_data = $('.msfb-create-route-set').attr('preserved-data')
            // }
            fields_data.question_data = JSON.stringify( multiselect_opts  )
            // $.each($('.msfb-a-route-set-holder'),function(k,the_row){
            //     $(the_row).find('.msfb-a-route-set').each(function(kk,the_route){
            //         let route_data = {
            //             "route_type": $(the_route).attr('data-msfb-route-type'),
            //             "route_value": $(the_route).attr('data-msfb-route-value'),
            //             "route_action": $(the_route).attr('data-msfb-route-action'),
            //             "route_action_value": $(the_route).attr('data-msfb-route-action-value')
            //         }
            //         fields_data[`route_${k}_${kk}`] = JSON.stringify(route_data)
            //     })
            // }) 
            // console.log('route data', fields_data)
        } else if ( act_el == "msfb-single-select-field" ) {
            let select_opts = $(`.${act_el} div[data-multiselect-no]`)
            if( select_opts.length == 0 ) {
                msfb_error_message("There should be at least one option")
                return false
            }
            let single_select_opts = []
            $.each(select_opts,(k,v) => {
                let opt_data = {
                    // "icon_class": $(v).find('.icon i').attr('class'),
                    "answer": $(v).find('.skfb__answer').html(),
                    "price": $(v).find('.skfb__answer').attr('data-price')
                }
                let icon = $(v).find('.icon i')
                let img = $(v).find('.icon img')
                if( icon.length > 0 && icon.css('display') != 'none' ) {
                    opt_data.icon_class = icon.attr('class')
                }
                if( img.length > 0 && img.css('display') != 'none' ) {
                    opt_data.img_url = img.attr('src')
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
                "placeholder": $(`.${act_el} #textArea`).attr('placeholder')
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
                    "option": $(v).html(),
                    "price": $(v).attr('data-price')
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
        this_el.html(`<i class="fa fa-spinner fa-spin"></i> Save`)
        let qtn_id = this_el.attr('data-qtn-id')
        if( qtn_id != undefined && qtn_id != "" ) {
            fields_data.question_id = qtn_id
        }
        let qtn_cat_field = $('#msfb-qtn-category-' + fields_data.question_type)
        if( qtn_cat_field.length > 0 ) {
            fields_data.cat_id = qtn_cat_field.val()
        }
        // console.log('fields data',fields_data)
        $.ajax({
            url: msfb.ajax_url,
            type: "POST",
            dataType: "json",
            data: {
                action: "msfb_save_questions",
                dataset: fields_data
            },
            success:resp => {
                //console.log(resp)
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
                //console.log(err)
                this_el.html(`<i class="fas fa-save"></i> Save`)
            }
        })
    })
    // drag and drop upload
    
    $('#msfb-drop-the-file').on('drop',function(e){
        e.preventDefault()
        e.stopPropagation()
        // console.log('dropped',e)
        let formData = new FormData()
        var files = e.originalEvent.dataTransfer.files;
	    if ( files.length > 0 ) {
	    	formData.append('main_image', files[0]);
	    	formData.append('action', 'msfb_custom_icon_upload');
	    } else {
            Swal.fire({
                icon: "warning",
                text: "No file choosen to be uploaded."
            })
            return false
        }
        $('label[for="msfb-custom-icon"]').find('div i').attr('class','fa fa-spinner fa-spin')
        $.ajax({
	        url: msfb.ajax_url,
	        type: "POST",
	        dataType: "json",
	        data: formData,
	        contentType: false,
	        processData: false,
	        success: function (resp) {
                //console.log(resp)
                $('label[for="msfb-custom-icon"]').find('div i').attr('class','fa fa-upload')
                $('#msfb-custom-icon').val('')
                // this_el.html('Upload')
                $('.skfb__custom_icon_select_field').prepend('<img class="msfb_custom_icon_image" style="height:50px;width:auto;margin:16px 16px 0px 0px;" src="' + resp.url + '"/>')
	        },
	        error:function(err){
	            //console.log(err);
                $('label[for="msfb-custom-icon"]').find('div i').attr('class','fa fa-upload')
	        }
	    });
    })
    // upload custom icon
    $('#msfb-custom-icon').on('change',function(){
        // console.log('changed')
        let this_el = $(this)
        let formData = new FormData()
        var files = $('#msfb-custom-icon')[0].files;
	    if ( files.length > 0 ) {
	    	formData.append('main_image', files[0]);
	    	formData.append('action', 'msfb_custom_icon_upload');
	    } else {
            Swal.fire({
                icon: "warning",
                text: "No file choosen to be uploaded."
            })
            return false
        }
        $('label[for="msfb-custom-icon"]').find('div i').attr('class','fa fa-spinner fa-spin')
        $.ajax({
	        url: msfb.ajax_url,
	        type: "POST",
	        dataType: "json",
	        data: formData,
	        contentType: false,
	        processData: false,
	        success: function (resp) {
                //console.log(resp)
                $('#msfb-custom-icon').val('')
                $('label[for="msfb-custom-icon"]').find('div i').attr('class','fa fa-upload')
                $('.skfb__custom_icon_select_field').prepend('<img class="msfb_custom_icon_image" style="height:50px;width:auto;margin:16px 16px 0px 0px;" src="' + resp.url + '"/>')
	        },
	        error:function(err){
	            //console.log(err);
                $('label[for="msfb-custom-icon"]').find('div i').attr('class','fa fa-upload')
	        }
	    });
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
                        //console.log(resp)
                        if( resp.status ) {
                            window.location.reload()
                        }
                    },
                    error: err => {
                        //console.log(err)
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
                //console.log(resp)
                if( resp.status ) {
                    window.location.reload()
                }
            },
            error: err => {
                //console.log(err)
            }
        })
    })
    // show add category popup
    $('#msfb-add-category').on('click', async (e) => {
        e.preventDefault()
        let this_el = this__(e)
        let cat_type = this_el.attr('data-msfb-cat-type')
        //console.log('working')
        const { value: cat_name } = await Swal.fire({
            title: 'Add a category',
            text: "Category name",
            input: 'text',
            inputLabel: 'Category name',
            inputPlaceholder: 'Category name'
        })
        if (cat_name) {
            //console.log(cat_name)
            this_el.find('i').attr('class','fa fa-spinner fa-spin')
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
                    //console.log(err)
                    this_el.find('i').attr('class','fa fa-plus')
                }
            })
        }
    })
    // apply bulk action
    $('#msfb-apply-bulk-action').on('click', e => {
        let this_el = this__(e)
        let el_type = this_el.attr('data-el-type')
        let checked_items = $(`#msfb-table-item-holder tr td input.msfb-sel-field:checked`)
        // let checked_items = $(`#msfb-table-item-holder tr[data-msfb-pagination] td input.msfb-sel-field:checked`)
        let checked_item_ids = []
        $.each(checked_items,(k,v) => {
            checked_item_ids.push($(v).attr('data-msfb-item-id'))
        })
        if( checked_item_ids.length > 0 && $('#msfb-bulk-action').val() != "" ) {
            //console.log(checked_item_ids)
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
                    //console.log(resp)
                    this_el.find('i').attr('class','fas fa-check')
                    if( resp.status ){
                        window.location.reload()
                    }
                },
                error: err => {
                    //console.log(err)
                    this_el.find('i').attr('class','fas fa-check')
                }
            })
        }
    })
    // let field label
    const msfb_field_label = raw_label => raw_label.replace('<i class="fa fa-times-circle"></i> ','')
    $('#msfb-save-form-settings').on('click', e => {
        let this_el = this__(e)
        let request_data = {}
        let form_id = this_el.attr('data-form-id')
        request_data = { form_id }
        let sender_name = $('#msfb_senderName').val()
        if( !sender_name ) {
            msfb_error_message("Sender name is required.")
            return false
        }
        request_data = { sender_name, ...request_data}
        let sender_email = $('#msfb_senderEmail').val()
        if( !sender_email ) {
            msfb_error_message("Sender email is required.")
            return false
        }
        request_data = { sender_email, ...request_data}
        let lead_email = $('#msfb_leadEmail').val()
        if( !lead_email ) {
            msfb_error_message("Lead email is required.")
            return false
        }
        request_data = { lead_email, ...request_data}
        let recipient_email = $('#msfb_recipientEmail').val()
        if( !recipient_email ) {
            msfb_error_message("Recipient email is required.")
            return false
        }
        request_data = { recipient_email, ...request_data}
        let msfb_BCCRecipientEmail = $('#msfb_BCCRecipientEmail').val()
        if( msfb_BCCRecipientEmail ) {
            request_data = { msfb_BCCRecipientEmail, ...request_data}
        }
        let msfb_replyTo = $('#msfb_replyTo').val()
        if( msfb_replyTo ) {
            request_data = { msfb_replyTo, ...request_data}
        }
        let msfb_subject = $('#msfb_subject').val()
        if( !msfb_subject ) {
            msfb_error_message("Subject is required.")
            return false
        }
        request_data = { msfb_subject, ...request_data}
        let msfb_lead_subject = $('#msfb_lead_subject').val()
        if( !msfb_lead_subject ) {
            msfb_error_message("Lead email subject is required.")
            return false
        }
        request_data = { msfb_lead_subject, ...request_data}
        let msfb_mgs = $('#msfb_mgs').val()
        if( !msfb_mgs ) {
            msfb_error_message("Message body is required.")
            return false
        }
        request_data = { msfb_mgs, ...request_data}
        let msfb_lead_mgs = $('#msfb_lead_mgs').val()
        if( !msfb_lead_mgs ) {
            msfb_error_message("Lead message body is required.")
            return false
        }
        request_data = { msfb_lead_mgs, ...request_data}
        /** smtp data */
        // let smtp_server = $('#msfb_smtpServer').val()
        // if( !smtp_server ) {
        //     msfb_error_message("SMTP server is required.")
        //     return false
        // }
        // request_data = { smtp_server, ...request_data}
        // let smtp_username = $('#msfb_smtpUsername').val()
        // if( !smtp_username ) {
        //     msfb_error_message("SMTP username is required.")
        //     return false
        // }
        // request_data = { smtp_username, ...request_data}
        // let msfb_smtpPass = $('#msfb_smtpPass').val()
        // if( !msfb_smtpPass ) {
        //     msfb_error_message("SMTP password is required.")
        //     return false
        // }
        // request_data = { msfb_smtpPass, ...request_data}
        // let msfb_smtpPort = $('#msfb_smtpPort').val()
        // if( !msfb_smtpPort ) {
        //     msfb_error_message("SMTP port is required.")
        //     return false
        // }
        // request_data = { msfb_smtpPort, ...request_data}
        this_el.html(`<i class="fa fa-spinner fa-spin"></i> Save`)
        //console.log(request_data)
        // return false
        $.ajax({
            url: msfb.ajax_url,
            type: "POST",
            dataType: "json",
            data: {
                action: "msfb_save_forms_settings",
                dataset: request_data
            },
            success: resp => {
                //console.log(resp)
                this_el.html(`<i class="fas fa-save"></i> Save`)
                if( resp.status != undefined && resp.status == "success" ) {
                    Swal.fire({
                        icon: "success",
                        text: "The form settings has been updated."
                    })
                } else if(resp.status != undefined && resp.status == "error" ){
                    Swal.fire({
                        icon: "error",
                        text: resp.message
                    })
                }
            },
            error: err => {
                this_el.html(`<i class="fas fa-save"></i> Save`)
                //console.log(err)
            }
        })
    })
    $('#msfb-save-form').on('click', e => {
        let this_el = this__(e)
        let form_name = $('.msfb-form-builder').attr('data-form-name')
        if( !form_name ) {
            msfb_error_message("Form name is required.")
            return false
        }
        let form_title = $('#msfb-form-title').val()
        if( !form_title ) {
            msfb_error_message("Form title is required.")
        }
        let form_desc = $('#msfb-form-desc').val()
        // if( !form_desc ) {
        //     msfb_error_message("Form description is required.")
        //     return false
        // }
        let form_fields = $('.msfb-form-builder div[data-field-type].skfb__field-box')
        if( form_fields.length == 0 ) {
            msfb_error_message("Add at least one field.")
            return false
        }
        // //console.log(form_fields.map())
        let form_data = []
        let field_data = []
        form_data['form_name'] = form_name
        $.each(form_fields, (k,field) => {
            let a_field_data = []
            let field_type = $(field).attr('data-field-type')
            if( field_type == "slider_form_field" ) {
                a_field_data['field_data'] = {
                    "default_val": $(field).attr('msfb-slider-default-val'),
                    "max_val": $(field).attr('msfb-slider-max-val'),
                    "min_val": $(field).attr('msfb-slider-min-val'),
                    "step_val": $(field).attr('msfb-slider-step-val')
                }
            } else if ( field_type == "multiselect_form_field" || field_type == "select_form_field" ) {
                let multisel_field_data = $(field).find('ul li')
                let field_data = []
                $.each(multisel_field_data,(k,a_opt) => {
                    field_data[k] = {
                        "label": $(a_opt).find('label').html(),
                        "value": $(a_opt).find('input').val(),
                    }
                })
                a_field_data['field_data'] = field_data
            } else if ( field_type == "dropdown_form_field" ) {
                let dropdown_field_data = $(field).find('select option')
                let field_data = []
                $.each(dropdown_field_data,(k,a_opt) => {
                    field_data[k] = {
                        "label": $(a_opt).html(),
                        "value": $(a_opt).val()
                    }
                })
                a_field_data['field_data'] = field_data
            } else if ( field_type == "upload_form_field" || field_type == "text_form_field" || field_type == "date_form_field" || field_type == "textarea_form_field" ) {
                a_field_data['field_data'] = {
                    "placeholder": field_type == "textarea_form_field" ? $(field).find('#textArea').attr('placeholder') : $(field).find('input').attr('placeholder')
                }
            }
            // is required
            a_field_data['is_required'] = $(field).attr('msfb-field-required') == "true" ? true : false
            // is lead column
            a_field_data['is_lead_column'] = $(field).attr('msfb-field-is-lead-column') == "true" ? true : false
            // assign field label
            a_field_data['field_label'] = msfb_field_label($(field).find('label').html())
            // assign field type
            a_field_data['field_type'] = field_type
            a_field_data = { ...a_field_data }
            field_data[k] = a_field_data
        })
        //console.log(field_data)
        form_data['form_data'] = JSON.stringify({ 
            'form_title': form_title,
            'form_desc': form_desc,
            'field_data': field_data
        })
        if( this_el.attr('data-form-id') ) {
            form_data['form_id'] = this_el.attr('data-form-id')
        }
        if( $('#msfb-form-category').length > 0 ) {
            let msfb_form_cat = $('#msfb-form-category').val()
            form_data.cat_id = msfb_form_cat
        }
        //console.log(form_data)
        this_el.html(`<i class="fa fa-spinner fa-spin"></i> Save`)
        $.ajax({
            url: msfb.ajax_url,
            type: "POST",
            dataType: "json",
            data: {
                action: "msfb_save_forms",
                dataset: { ...form_data }
            },
            success: resp => {
                //console.log(resp)
                this_el.html(`<i class="fas fa-save"></i> Save`)
                this_el.attr('data-form-id',resp.form_id)
                if( resp.status != undefined && resp.status == "created" ) {
                    Swal.fire({
                        icon: "success",
                        text: "Form has been added."
                    })
                    window.location.href = resp.redirect
                } else if(resp.status != undefined && resp.status == "updated" ){
                    Swal.fire({
                        icon: "success",
                        text: "Form has been updated."
                    })
                }
            },
            error: err => {
                this_el.html(`<i class="fas fa-save"></i> Save`)
                //console.log(err)
            }
        })
    })
})