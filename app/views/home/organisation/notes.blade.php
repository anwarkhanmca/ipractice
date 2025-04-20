
 <script src="{{ URL :: asset('tinymce/tinymce.min.js') }}"></script>

<script type="text/javascript">

tinymce.init({

    selector: "textarea",

    plugins: [

        "advlist autolink lists link image charmap print preview anchor",

        "searchreplace visualblocks code fullscreen",

        "insertdatetime media table contextmenu paste"

    ],

    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",

    plugins: ["wordcount", "table", "charmap", "anchor", "insertdatetime", "link", "image", "media", "visualblocks", "preview", "fullscreen", "print", "code" ]

});

</script>
 <input name="orgnotes_id" id="editorgnotes_id" type="hidden" value="{{ $orgdtails_notes['orgnotes_id'] or "" }}">
<input name="client_id" id="editclient_id" type="hidden" value="{{ $orgdtails_notes['client_id'] or "" }}">
                         <img src="/img/icon_1.png" class="heading_icon">
                  
                    <div id="demo" >
                    <p id="notes_error1"></p>
                    <div class="form-group">
                <label for="exampleInputPassword1">Title</label>
                 
                   <input type="text" name="notestitle" id="editnotestitle" class="form-control" value="{{ $orgdtails_notes['title'] or "" }}" />
                
              
              </div>
                    
                    <div class="form-group">
                <label for="exampleInputPassword1">Message</label>
                <textarea name="notesmsg" rows="15" cols="20" id="editnotesmsg" class="form-control">{{ $orgdtails_notes['textmessage'] or "" }}</textarea>
                </div>
                
                <div class="add_client_btn">
                    
                    
                    
                      <button type="button" id="editsave_notes" class="btn btn-success"> Save</button>
                       
                       
                       
                       <!-- <button class="btn btn-success" id="editsave_notes" >Save</button> -->
                     <!--   <button class="btn btn-info"  type="button">Edit</button> -->
                        <button type="button" id="delete_notes" class="btn btn-danger"> Delete</button>
                      <!--  <button class="btn btn-danger"  type="submit">Delete</button> -->
                        <a href="/organisation-clients" class="btn btn-primary">Cancel</a>
                           
                          </div>
                
                   
                    <div class="clearfix"></div>
                    </div>
                     
                    

