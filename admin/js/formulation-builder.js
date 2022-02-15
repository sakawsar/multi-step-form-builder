(function($){
    $(document).ready(e => {
        $('#msfb-search-formula-element').on('keyup', e => {
            let this_el = $(e.currentTarget)
            let this_val = this_el.val()
            let elements = $('div[data-element-name]')
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
    })
})(jQuery)