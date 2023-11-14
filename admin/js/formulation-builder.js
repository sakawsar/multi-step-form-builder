(function($){
    $(document).ready(e => {
        let elements = $('div[data-element-name]')
        $('#msfb-search-formula-element').on('keyup', e => {
            let this_el = $(e.currentTarget)
            let this_val = this_el.val().toLowerCase()
            let cat_val = ""
            if( elements.length > 0 ){
                let sel_el_type = $('.msfb-filter-tab div.msfb-tab-selected').attr('data-type')
                sel_el_type = sel_el_type == "qtn" ? "question" : "form"
                cat_val = sel_el_type == "question" ? $('#msfb_list_questions_by_category').val() : $('#msfb_list_questions_by_category2').val()
                $.each(elements, (k,el) => {
                    if( this_val != "" ){
                        $(el).hide()
                    }
                    let el_name = $(el).attr('data-element-name').toLowerCase()
                    if( el_name.indexOf(this_val) > -1 ){
                        if( $(el).attr('data-element-type') == sel_el_type ) {
                            console.log(cat_val)
                            if( $(el).attr('data-element-cat-id') == cat_val || cat_val == "" ) {
                                $(el).show()
                            }
                        }
                    }
                })
            }
        })
        $('#msfb_list_questions_by_category, #msfb_list_questions_by_category2').on('change',function(e){
            let cat_id = $(this).val()
            let el_type = $(this).attr('data-cat-type')
            $.each(elements,function(k,el){
                if( $(el).attr('data-element-type') == el_type ) {
                    $(el).show()
                }
                if( cat_id ) {
                    if( $(el).attr('data-element-cat-id') != cat_id ) {
                        $(el).hide()
                    }
                }
            })
        })
        $('.msfb-filter-tab div').on('click',function(){
            let elements = $('div[data-element-name]')
            $.each(elements,function(k,v){
                $(v).show()
            })
            $('#msfb_list_questions_by_category, #msfb_list_questions_by_category2').prop('selectedIndex',0)
            let type=$(this).attr('data-type')
            if( type == "qtn" ) {
                $('.msfb-qtn-tab').addClass('msfb-tab-selected')
                $('.msfb-form-tab').removeClass('msfb-tab-selected')
                $('.msfb-form-els-holder').fadeOut(function(){
                    $('.msfb-qtn-els-holder').show()
                })
                
                $.each(elements, (k,el) => {
                    if( $(el).attr('data-element-type') == 'question' ) {
                        $(el).show()
                    } else {
                        $(el).hide()
                    }
                })
            } else if ( type == "form" ) {
                $('.msfb-form-tab').addClass('msfb-tab-selected')
                $('.msfb-qtn-tab').removeClass('msfb-tab-selected')
                $('.msfb-qtn-els-holder').fadeOut(function(){
                    $('.msfb-form-els-holder').show()
                })
                $.each(elements, (k,el) => {
                    if( $(el).attr('data-element-type') == 'form' ) {
                        $(el).show()
                    } else {
                        $(el).hide()
                    }
                })
            }
        })
    })
})(jQuery)