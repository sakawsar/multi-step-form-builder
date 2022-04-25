(function ($) {
    $(document).ready(() => {
        const msfb_visited_path = () => {
            let nodes = [$('.tw-msfb-btn-container[data-msfb-root]').attr('data-msfb-root')]
            $.each($('button[data-msfb-prev]'),(k,v) => {
                let has_node = $(v).attr('data-msfb-prev')
                if( has_node ) {
                    let node_id = $(v).closest('div[data-msfb-node]').attr('data-msfb-node')
                    nodes.push(node_id)
                }
            })
            console.log(nodes)
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
                if( this_el.closest('div').attr('data-msfb-required') == "true" ) {
                    let msfb_validation = msfb_required_validator(this_el_node)
                    if( !msfb_validation ) {
                        msfb_swal2_warning("This step is required")
                        return false
                    }
                }
                if( this_el.hasClass('msfb-skip-step') ) {
                    this_el.attr('data-msfb-skipped',true)
                    is_skipped = true
                }
            } else if ( this_el.attr('data-msfb-prev') ) {
                node_id = this_el.attr('data-msfb-prev')
                is_prev = true
            }
            console.log(node_id)
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
        })
        $('button[data-msfb-redirect]').on('click', e => {
            let this_el = $(e.currentTarget)
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
            console.log(this_el)
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
                console.log('This is form step')
            }
            return validator
        }
    })
})(jQuery);