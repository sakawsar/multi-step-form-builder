(function($){
    $(document).ready(e => {
        let elements = $('div[data-element-name]')
        $('#msfb-search-formula-element').on('keyup', e => {
            let this_el = $(e.currentTarget)
            let this_val = this_el.val()
            if( elements.length > 0 ){
                $.each(elements, (k,el) => {
                    if( this_val != "" ){
                        $(el).hide()
                    }
                    if( $(el).attr('data-element-name').indexOf(this_val) > -1 ){
                        $(el).show()
                    }
                })
            }
        })
        $('#msfb_list_questions_by_category').on('change',function(){
            let cat_id = $(this).val()
            $.each(elements,function(k,el){
                $(el).show()
                if( cat_id ) {
                    if( $(el).attr('data-element-cat-id') != cat_id ) {
                        $(el).hide()
                    }
                }
            })
        })
    })
})(jQuery)