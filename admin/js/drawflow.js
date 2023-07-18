var id = document.getElementById("msfb_drawflow");
if(id != null){
    const editor = new Drawflow(id);
    window.msfb_eidtor = editor
    editor.reroute = true;
    const dataToImport = {"drawflow":{"Home":{"data":{"1":{"id":1,"name":"welcome","data":{},"class":"welcome","html":"\n    <div>\n      <div class=\"title-box\">👏 Welcome!!</div>\n      <div class=\"box\">\n        <p>Simple flow library <b>demo</b>\n        <a href=\"https://github.com/jerosoler/Drawflow\" target=\"_blank\">Drawflow</a> by <b>Jero Soler</b></p><br>\n\n        <p>Multiple input / outputs<br>\n           Data sync nodes<br>\n           Import / export<br>\n           Modules support<br>\n           Simple use<br>\n           Type: Fixed or Edit<br>\n           Events: view console<br>\n           Pure Javascript<br>\n        </p>\n        <br>\n        <p><b><u>Shortkeys:</u></b></p>\n        <p>🎹 <b>Delete</b> for remove selected<br>\n        💠 Mouse Left Click == Move<br>\n        ❌ Mouse Right == Delete Option<br>\n        🔍 Ctrl + Wheel == Zoom<br>\n        📱 Mobile support<br>\n        ...</p>\n      </div>\n    </div>\n    ","typenode": false, "inputs":{},"outputs":{},"pos_x":50,"pos_y":50},"2":{"id":2,"name":"slack","data":{},"class":"slack","html":"\n          <div>\n            <div class=\"title-box\"><i class=\"fab fa-slack\"></i> Slack chat message</div>\n          </div>\n          ","typenode": false, "inputs":{"input_1":{"connections":[{"node":"7","input":"output_1"}]}},"outputs":{},"pos_x":1028,"pos_y":87},"3":{"id":3,"name":"telegram","data":{"channel":"channel_2"},"class":"telegram","html":"\n          <div>\n            <div class=\"title-box\"><i class=\"fab fa-telegram-plane\"></i> Telegram bot</div>\n            <div class=\"box\">\n              <p>Send to telegram</p>\n              <p>select channel</p>\n              <select df-channel>\n                <option value=\"channel_1\">Channel 1</option>\n                <option value=\"channel_2\">Channel 2</option>\n                <option value=\"channel_3\">Channel 3</option>\n                <option value=\"channel_4\">Channel 4</option>\n              </select>\n            </div>\n          </div>\n          ","typenode": false, "inputs":{"input_1":{"connections":[{"node":"7","input":"output_1"}]}},"outputs":{},"pos_x":1032,"pos_y":184},"4":{"id":4,"name":"email","data":{},"class":"email","html":"\n            <div>\n              <div class=\"title-box\"><i class=\"fas fa-at\"></i> Send Email </div>\n            </div>\n            ","typenode": false, "inputs":{"input_1":{"connections":[{"node":"5","input":"output_1"}]}},"outputs":{},"pos_x":1033,"pos_y":439},"5":{"id":5,"name":"template","data":{"template":"Write your template"},"class":"template","html":"\n            <div>\n              <div class=\"title-box\"><i class=\"fas fa-code\"></i> Template</div>\n              <div class=\"box\">\n                Ger Vars\n                <textarea df-template></textarea>\n                Output template with vars\n              </div>\n            </div>\n            ","typenode": false, "inputs":{"input_1":{"connections":[{"node":"6","input":"output_1"}]}},"outputs":{"output_1":{"connections":[{"node":"4","output":"input_1"},{"node":"11","output":"input_1"}]}},"pos_x":607,"pos_y":304},"6":{"id":6,"name":"github","data":{"name":"https://github.com/jerosoler/Drawflow"},"class":"github","html":"\n          <div>\n            <div class=\"title-box\"><i class=\"fab fa-github \"></i> Github Stars</div>\n            <div class=\"box\">\n              <p>Enter repository url</p>\n            <input type=\"text\" df-name>\n            </div>\n          </div>\n          ","typenode": false, "inputs":{},"outputs":{"output_1":{"connections":[{"node":"5","output":"input_1"}]}},"pos_x":341,"pos_y":191},"7":{"id":7,"name":"facebook","data":{},"class":"facebook","html":"\n        <div>\n          <div class=\"title-box\"><i class=\"fab fa-facebook\"></i> Facebook Message</div>\n        </div>\n        ","typenode": false, "inputs":{},"outputs":{"output_1":{"connections":[{"node":"2","output":"input_1"},{"node":"3","output":"input_1"},{"node":"11","output":"input_1"}]}},"pos_x":347,"pos_y":87},"11":{"id":11,"name":"log","data":{},"class":"log","html":"\n            <div>\n              <div class=\"title-box\"><i class=\"fas fa-file-signature\"></i> Save log file </div>\n            </div>\n            ","typenode": false, "inputs":{"input_1":{"connections":[{"node":"5","input":"output_1"},{"node":"7","input":"output_1"}]}},"outputs":{},"pos_x":1031,"pos_y":363}}},"Other":{"data":{"8":{"id":8,"name":"personalized","data":{},"class":"personalized","html":"\n            <div>\n              Personalized\n            </div>\n            ","typenode": false, "inputs":{"input_1":{"connections":[{"node":"12","input":"output_1"},{"node":"12","input":"output_2"},{"node":"12","input":"output_3"},{"node":"12","input":"output_4"}]}},"outputs":{"output_1":{"connections":[{"node":"9","output":"input_1"}]}},"pos_x":764,"pos_y":227},"9":{"id":9,"name":"dbclick","data":{"name":"Hello World!!"},"class":"dbclick","html":"\n            <div>\n            <div class=\"title-box\"><i class=\"fas fa-mouse\"></i> Db Click</div>\n              <div class=\"box dbclickbox\" ondblclick=\"showpopup(event)\">\n                Db Click here\n                <div class=\"modal\" style=\"display:none\">\n                  <div class=\"modal-content\">\n                    <span class=\"close\" onclick=\"closemodal(event)\">&times;</span>\n                    Change your variable {name} !\n                    <input type=\"text\" df-name>\n                  </div>\n\n                </div>\n              </div>\n            </div>\n            ","typenode": false, "inputs":{"input_1":{"connections":[{"node":"8","input":"output_1"}]}},"outputs":{"output_1":{"connections":[{"node":"12","output":"input_2"}]}},"pos_x":209,"pos_y":38},"12":{"id":12,"name":"multiple","data":{},"class":"multiple","html":"\n            <div>\n              <div class=\"box\">\n                Multiple!\n              </div>\n            </div>\n            ","typenode": false, "inputs":{"input_1":{"connections":[]},"input_2":{"connections":[{"node":"9","input":"output_1"}]},"input_3":{"connections":[]}},"outputs":{"output_1":{"connections":[{"node":"8","output":"input_1"}]},"output_2":{"connections":[{"node":"8","output":"input_1"}]},"output_3":{"connections":[{"node":"8","output":"input_1"}]},"output_4":{"connections":[{"node":"8","output":"input_1"}]}},"pos_x":179,"pos_y":272}}}}}
    editor.start();
    if( msfb.raw_data ) {
      // update the html DOM
      for( the_node_key in msfb.raw_data.drawflow.Home.data ) {
        // node to be updated
        let the_node = msfb.raw_data.drawflow.Home.data[the_node_key]
        // node name
        let node_name = the_node.name
        // the updated html for the node
        let updated_html = update_the_nodes_with_raw_data(node_name)
        // previous html of the node
        let prev_html = msfb.raw_data.drawflow.Home.data[the_node_key].html
        // previous options of the node
        let prev_options = jQuery(prev_html).find('ul li').length
        // current options of the node
        let current_options = jQuery(updated_html).find('ul li').length
        console.log('current options',current_options, prev_options)
        // update the html 
        msfb.raw_data.drawflow.Home.data[the_node_key].html = updated_html
        // update the outputs
        let qtn_type = jQuery('div[data-node="'+node_name+'"]').attr('data-question-type')
        if ( qtn_type == "msfb-single-select-field" || qtn_type == "msfb-dropdown-field" ) {
          let new_options = []
          let new_input_options = []
          if( prev_options !== current_options ) {
            let inputs = msfb.raw_data.drawflow.Home.data[the_node_key].outputs
            let outputs = msfb.raw_data.drawflow.Home.data[the_node_key].outputs
            for( let i = 1; i <= current_options; i++ ) {
              let this_opt_key = `output_${i}`
              let this_int_key = `input_${i}`
              new_options[this_opt_key] = outputs[this_opt_key] ? outputs[this_opt_key] : {connections:[]}
              new_input_options[this_opt_key] = inputs[this_int_key] ? inputs[this_int_key] : {connections:[]}
            }
            // Object.assign(outputs, 'output_' + this_opt_key, {connections:[]})
            console.log({...new_options})
            msfb.raw_data.drawflow.Home.data[the_node_key].outputs = {...new_options}
            msfb.raw_data.drawflow.Home.data[the_node_key].inputs = {...new_input_options}
          }
        }
      }
      console.log('the raw data',msfb.raw_data.drawflow)
      editor.import(msfb.raw_data);
    }
    editor.zoom_max = 1.5
    editor.zoom_min = 0.5
    // zoom in
    document.getElementById('msfb_drawflow_zoom_in').addEventListener('click',function(){
      editor.zoom_in()
    })
    // zoom out
    document.getElementById('msfb_drawflow_zoom_out').addEventListener('click',function(){
      editor.zoom_out()
    })
    // zoom reset
    document.getElementById('msfb_drawflow_zoom_reset').addEventListener('click',function(){
      editor.zoom_reset()
    })
    // Events!
    editor.on('nodeCreated', function(id) {
      // console.log("Node created " + id);
    })

    editor.on('nodeRemoved', function(id) {
      // console.log("Node removed " + id);
    })

    editor.on('nodeSelected', function(id) {
      console.log("Node selected " + id);
    })

    editor.on('moduleCreated', function(name) {
      // console.log("Module Created " + name);
    })

    editor.on('moduleChanged', function(name) {
      // console.log("Module Changed " + name);
    })

    editor.on('connectionCreated', function(connection) {
      // console.log('Connection created');
      // console.log(connection);
    })

    editor.on('connectionRemoved', function(connection) {
      // console.log('Connection removed');
      // console.log(connection);
    })

    // editor.on('mouseMove', function(position) {
    //   console.log('Position mouse x:' + position.x + ' y:'+ position.y);
    // })

    editor.on('nodeMoved', function(id) {
      // console.log("Node moved " + id);
    })

    editor.on('zoom', function(zoom) {
      // console.log('Zoom level ' + zoom);
    })

    editor.on('translate', function(position) {
      // console.log('Translate x:' + position.x + ' y:'+ position.y);
    })

    editor.on('addReroute', function(id) {
      console.log("Reroute added " + id);
    })

    editor.on('removeReroute', function(id) {
      // console.log("Reroute removed " + id);
    })

    /* DRAG EVENT */

    /* Mouse and Touch Actions */

    var elements = document.getElementsByClassName('drag-drawflow');
    for (var i = 0; i < elements.length; i++) {
      elements[i].addEventListener('touchend', drop, false);
      elements[i].addEventListener('touchmove', positionMobile, false);
      elements[i].addEventListener('touchstart', drag, false );
    }

    var mobile_item_selec = '';
    var mobile_last_move = null;
   function positionMobile(ev) {
     mobile_last_move = ev;
   }

   function allowDrop(ev) {
      ev.preventDefault();
    }

    function drag(ev) {
      if (ev.type === "touchstart") {
        mobile_item_selec = ev.target.closest(".drag-drawflow").getAttribute('data-node');
      } else {
      ev.dataTransfer.setData("node", ev.target.getAttribute('data-node'));
      }
    }

    function drop(ev) {
      if (ev.type === "touchend") {
        var parentdrawflow = document.elementFromPoint( mobile_last_move.touches[0].clientX, mobile_last_move.touches[0].clientY).closest("#drawflow");
        if(parentdrawflow != null) {
          addNodeToDrawFlow(mobile_item_selec, mobile_last_move.touches[0].clientX, mobile_last_move.touches[0].clientY);
        }
        mobile_item_selec = '';
      } else {
        ev.preventDefault();
        var data = ev.dataTransfer.getData("node");
        addNodeToDrawFlow(data, ev.clientX, ev.clientY);
      }

    }
    function update_the_nodes_with_raw_data( name, pos_x = 0, pos_y = 0, type = 'update') {
      if( name.indexOf('form') > -1 ) {
        let form_data = name.split('-')
        let form_id = form_data[1]
        let form_found = msfb.all_forms.filter( a_form => {
          return a_form.id == form_id
        })
        if( form_found.length > 0 ){
          let form_name = form_found[0].form_name
          var form_html = `
            <div>
              <div class="box">
                  <ul>
                    <li>${form_name}</li>
                  </ul>
              </div>
            </div>
          `
        }
        if( type != 'update' ) {
          editor.addNode(name, 1, 1, pos_x, pos_y, name, {"channel":"","channel2":""}, form_html );
        } else {
          return form_html
        }
      } else {
        let qtn_data = name.split('-')
        let qtn_id = qtn_data[1]
        let qtn_found = msfb.all_questions.filter( a_qtn => {
          return a_qtn.id == qtn_id
        })
        if( qtn_found.length > 0 ) {
          let qtn_type = qtn_found[0].question_type
          let qtn_name = qtn_found[0].question_name
          if( qtn_type == "msfb-multiselect" || qtn_type == "msfb-text-field" || qtn_type == "msfb-textarea-field" || qtn_type == "msfb-date-field" || qtn_type == "msfb-map-field" || qtn_type == "msfb-upload-field" || qtn_type == "msfb-slider-field" ) {
            let qtn_html = `
              <div>
                <div class="box">
                    <ul>
                      <li>${qtn_name}</li>
                    </ul>
                </div>
              </div>
            `
            if( type != 'update' ) {
              editor.addNode(name, 1, 1, pos_x, pos_y, name, {"channel":"","channel2":""}, qtn_html );
            } else {
              return qtn_html
            }
          } else if ( qtn_type == "msfb-single-select-field" || qtn_type == "msfb-dropdown-field" ) {
            let qtn_options = ``
            let qtn_data = qtn_found[0].question_data
            let input_count = 0
            if( qtn_type == "msfb-single-select-field" ) {
              for (let i = 0; i < qtn_data.length; i++) {
                qtn_options += `<li><i class="${qtn_data[i].icon_class}"></i> ${qtn_data[i].answer}</li>` 
                input_count++
              }
            } else {
              for (let i = 0; i < qtn_data.option_data.length; i++) {
                qtn_options += `<li>${qtn_data.option_data[i].option}</li>` 
                input_count++
              }
            }
            let qtn_html = `
              <div>
                <div class="box">
                    <p>${qtn_name}</p>
                    <ul>
                      ${qtn_options}
                    </ul>
                </div>
              </div>
            `
            if( type != 'update' ) {
              editor.addNode(name, input_count, input_count, pos_x, pos_y, name, {"channel":"","channel2":""}, qtn_html );
            } else {
              return qtn_html
            }
          }
        }
      }
    }
    function addNodeToDrawFlow(name, pos_x, pos_y) {
      if(editor.editor_mode === 'fixed') {
        return false;
      }
      pos_x = pos_x * ( editor.precanvas.clientWidth / (editor.precanvas.clientWidth * editor.zoom)) - (editor.precanvas.getBoundingClientRect().x * ( editor.precanvas.clientWidth / (editor.precanvas.clientWidth * editor.zoom)));
      pos_y = pos_y * ( editor.precanvas.clientHeight / (editor.precanvas.clientHeight * editor.zoom)) - (editor.precanvas.getBoundingClientRect().y * ( editor.precanvas.clientHeight / (editor.precanvas.clientHeight * editor.zoom)));
      update_the_nodes_with_raw_data( name, pos_x, pos_y, 'add')
    }

  var transform = '';
  function showpopup(e) {
    e.target.closest(".drawflow-node").style.zIndex = "9999";
    e.target.children[0].style.display = "block";
    //document.getElementById("modalfix").style.display = "block";

    //e.target.children[0].style.transform = 'translate('+translate.x+'px, '+translate.y+'px)';
    transform = editor.precanvas.style.transform;
    editor.precanvas.style.transform = '';
    editor.precanvas.style.left = editor.canvas_x +'px';
    editor.precanvas.style.top = editor.canvas_y +'px';
    console.log(transform);

    //e.target.children[0].style.top  =  -editor.canvas_y - editor.container.offsetTop +'px';
    //e.target.children[0].style.left  =  -editor.canvas_x  - editor.container.offsetLeft +'px';
    editor.editor_mode = "fixed";

  }

   function closemodal(e) {
     e.target.closest(".drawflow-node").style.zIndex = "2";
     e.target.parentElement.parentElement.style.display  ="none";
     //document.getElementById("modalfix").style.display = "none";
     editor.precanvas.style.transform = transform;
       editor.precanvas.style.left = '0px';
       editor.precanvas.style.top = '0px';
      editor.editor_mode = "edit";
   }

    function changeModule(event) {
      var all = document.querySelectorAll(".menu ul li");
        for (var i = 0; i < all.length; i++) {
          all[i].classList.remove('selected');
        }
      event.target.classList.add('selected');
    }

    function changeMode(option) {

    //console.log(lock.id);
      if(option == 'lock') {
        lock.style.display = 'none';
        unlock.style.display = 'block';
      } else {
        lock.style.display = 'block';
        unlock.style.display = 'none';
      }

    }
    const msfb_get_the_id = label => {
      let label_data = label.split('-')
      return label_data[1]
    }
    jQuery('#msfb-preview-formula-btn').on('click',function(){
      let this_el = jQuery(this)
      let prev_html = this_el.html()
      if( !this_el.attr('data-previewing') ) {
        this_el.html('<i class="fa fa-times"></i> Close preview')
        this_el.attr('data-previewing',true)
        jQuery('#msfb_drawflow').hide(function(){
          jQuery('#msfb-preview-formula').fadeIn()
        })
      } else {
        this_el.removeAttr('data-previewing')
        this_el.html('<i class="fa fa-eye"></i> Preview')
        jQuery('#msfb-preview-formula').hide(function(){
          jQuery('#msfb_drawflow').fadeIn()
        })
      }
    })
    jQuery('#msfb-formulation-builder').on('click',async (e) => {

        let this_el = jQuery(e.currentTarget)
        console.log(editor.export());
        let data = editor.export()
        let node_data = data.drawflow.Home.data
        if( Object.keys(node_data).length == 0 ) {
          Swal.fire({
            icon: "warning",
            text: "No Formula found."
          })
          return false
        }
        let formulation_data = []
        // console.log(node_data)
        // return false
        let is_valid = false
        jQuery.each(node_data,(k,v) => {
          let has_connection = false
          let node_name = v.name
          let node_item_id = msfb_get_the_id(node_name)
          let inputs = v.inputs
          let is_root = true
          jQuery.each(inputs, (in_k,in_v) => {
            if ( in_v.connections.length > 0 ) {
              has_connection = true
              is_root = false
            }
          })
          console.log(has_connection)
          let outputs = v.outputs
          // console.log(outputs)
          let output_data = []
          jQuery.each(outputs, (out_k,out_v) => {
            if ( out_v.connections.length > 0 ) {
              has_connection = true
              output_data[out_k] = out_v.connections.map( a_con => {
                return node_data[a_con.node].name
              })
            }
          })
          if( has_connection == false ) {
            Swal.fire({
              icon: "warning",
              text: "Each node should have at least one connection"
            })
            is_valid = false
            return false
          } else {
            is_valid = true
          }
          if(!is_root){
            formulation_data[node_data[k].name] = output_data
          } else {
            formulation_data['root'] = output_data
          }
        })
        if( is_valid == false ) {
          return false
        }
        let formulation_name
        if ( !this_el.attr('data-formula-id') ) {
          const { value: formula_name } = await Swal.fire({
            title: 'Formulation name',
            text: "Enter this formulation name",
            input: 'text',
            inputLabel: 'Formulation name',
            inputPlaceholder: 'Formulation name'
          })
          formulation_name = formula_name
        } else {
          formulation_name = this_el.attr('data-formula-name')
        }
        let show_price = jQuery('#msfb-show-price:checked').val()
        let redirect = jQuery('#msfb-redirect-url').val()
        let color_scheme = jQuery('#msfb-color-scheme').val()
        if( show_price ) {
          formulation_data.show_price = show_price
        }
        if( redirect ){
          formulation_data.redirect = redirect
        }
        if( color_scheme ){
          formulation_data.color_scheme = color_scheme
        }
        if ( formulation_name ) {
          this_el.find('i').attr('class','fa fa-spinner fa-spin')
          let request_data = {
            "formulation_name": formulation_name,
            "formulation_data": JSON.stringify( { ...formulation_data }),
            "raw_data": JSON.stringify( data )
          }
          if ( this_el.attr('data-formula-id' ) ) {
            request_data.formula_id = this_el.attr('data-formula-id' )
          }
          jQuery.ajax({
            url: msfb.ajax_url,
            type: "POST",
            dataType: "json",
            data: {
              action: "msfb_add_formulation",
              dataset: request_data
              // dataset: {
              //   "formulation_name": formulation_name,
              //   "formulation_data": JSON.stringify( { ...formulation_data }),
              //   "raw_data": JSON.stringify( data )
              // }
            },
            success: resp => {
              this_el.find('i').attr('class','fas fa-save')
              // console.log(resp)
              this_el.attr('data-formula-id',resp.formula_id)
                if( resp.status != undefined && resp.status == "created" ) {
                    Swal.fire({
                        icon: "success",
                        text: "Formula has been added."
                    })
                    window.location.href = resp.redirect
                } else if(resp.status != undefined && resp.status == "updated" ){
                    Swal.fire({
                        icon: "success",
                        text: "Formula has been updated."
                    }).then( ok => {
                      window.location.reload()
                    })
                }
            },
            error: err => {
              this_el.find('i').attr('class','fas fa-save')
              console.log(err)
            }
          })
        } else {
          Swal.fire({
            icon: "warning",
            text: "Formulation name is required to save it."
          })
          return false
        }
    })
}