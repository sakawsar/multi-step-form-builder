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
                anchor.setAttribute("download", "scene.json")
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
})