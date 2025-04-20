@if(!empty($inserted_id))
 {{$inserted_id or ""}}|||
 @endif

                        <div class="notes_inner_top">
                        <img src="/img/icon_1.png" class="heading_icon">
                         <div class="add_client_btn">
                        
                        
                    
                    
                    
                   <!--   <button type="button" id="editsave_notes" class="btn btn-success "> Save</button> -->
                       
                       
                       
                       <!-- <button class="btn btn-success" id="editsave_notes" >Save</button> -->
                        <button class="btn btn-info" id="editnotes"  type="button">Edit</button>
                        
                        
                        <button type="button" id="delete_notes" class="btn btn-danger "> Delete</button>
                      <!--  <button class="btn btn-danger"  type="submit">Delete</button> -->
                        <a href="/knowledgebase" class="btn btn-primary">Cancel</a>
                           
                          
                             <!--<button class="btn btn-danger back" type="button">Delete</button>
                            <button class="btn btn-info"  type="submit">Save</button>
                            <button class="btn btn-info open" data-id="7" type="button">Next</button> -->
                          </div>
                        <div class="n_top_left">
                        <span class="n_heading">{{ $knowledge_notes['title'] or "" }}</span>
                       <input type="hidden" name="msgid" id="msgid" value=" {{ $knowledge_notes['knowledgebase_id'] or "" }}"/>
                      
                         <p><span class="n_heading_name">By {{$user['fname']}} {{$user['lname']}}</span> <span class="n_date">On: {{ $knowledge_notes['created'] or "" }}</span></p>
                        </div>
                        <div class="print">
                       <!-- <a href="#"><img src="/img/print.png"></a> -->
                       
                       
                        </div>
                        <div class="clearfix"></div>
                        </div>
                        <p class="n_text">{{ $knowledge_notes['textmessage'] or "" }} </p>
                        
                        
                           <!--
                            <div class="add_client_btn">
                    
                        <button class="btn btn-info" id="editnotes"  type="button">Edit</button>
                        <button type="button" id="delete_notes" class="btn btn-danger "> Delete</button>
                     
                        <a href="/knowledgebase" class="btn btn-primary">Cancel</a>
                           
                          </div> -->
                          <div class="clearfix"></div>