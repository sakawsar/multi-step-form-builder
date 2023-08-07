jQuery(document).ready(function($){
    $('#msfb-export-data').on('click',function(e){
        e.preventDefault()
        let data_type = $(this).attr('data-msfb-export-type')
        console.log(data_type)
        $.ajax({
            url: msfb.ajax_url,
            type: "POST",
            dataType: "json",
            data: {
                action: 'msfb_export_data',
                dataset: data_type
            },
            success:function(resp){
                console.log(resp)
                let dataStr = "data:text/json;charset=utf-8," + encodeURIComponent(JSON.stringify(resp));
                let anchor = document.createElement('a')
                anchor.setAttribute("href",dataStr)
                let file_name = data_type + '-' + new Date().getTime() + '.json'
                anchor.setAttribute("download", file_name)
                anchor.click()
            },
            error:function(err){
                console.log(err)
            }
        })
    })
    $('#msfb-import-data').on('change',function(e){
        e.preventDefault()
        let data_type = $(this).attr('data-msfb-import-type')
        let file = $(this).prop('files')[0]
        console.log(file)
        let reader = new FileReader()
        reader.onload = function(e){
            let data = JSON.parse(e.target.result)
            console.log(data)
            $.ajax({
                url: msfb.ajax_url,
                type: "POST",
                dataType: "json",
                data: {
                    action: 'msfb_import_data',
                    dataset: JSON.stringify({ data, data_type })
                },
                success:function(resp){
                    console.log(resp)
                    if( resp.status && resp.message ) {
                        Swal.fire({
                            icon: resp.status,
                            text: resp.message,
                        }).then( ok => {
                            window.location.reload()
                        })
                    }
                },
                error:function(err){
                    console.log(err)
                }
            })
        }
        reader.readAsText(file)
    })
    $('#msfb-export-leads').on('click',function(){
        let q_flow_id = $('#msfb-filter-by-cat').val()
        if( !q_flow_id ) {
            $.each($('#msfb-filter-by-cat option'),function(i,v){
                if( i == 1 ) {
                    q_flow_id = $(this).val()
                }
            })
        }
        if( q_flow_id ) {
            console.log(q_flow_id)
            Swal.fire({
                title: 'Export Leads',
                text: 'Are you sure to export all leads of this flow?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, export it!',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: msfb.ajax_url,
                        type: "POST",
                        dataType: "json",
                        data: {
                            action: 'msfb_export_leads',
                            dataset: q_flow_id
                        },
                        success:function(resp){
                            console.log(resp)
                            if( resp.status && resp.message ) {
                                var $a = $("<a>");
                                $a.attr("href",resp.file);
                                $("body").append($a);
                                let date = new Date().toISOString()
                                let file_name = 'leads-' + date + '.csv'
                                $a.attr("download",file_name);
                                $a[0].click();
                                $a.remove();
                                Swal.fire({
                                    icon: resp.status,
                                    text: resp.message,
                                }).then( ok => {
                                    window.location.reload()
                                })
                            }
                        },
                        error:function(err){
                            console.log(err)
                        }
                    })
                }
            })
        } else {
            Swal.fire({
                icon: 'error',
                text: 'No flow found to export leads!',
            })
            return false
        }
    })
})