
@if(!empty($inserted_id))
 {{$inserted_id or ""}}|||
 @endif

                        <div class="notes_inner_top">
                        <img src="/img/icon_1.png" class="heading_icon">
                        <div class="n_top_left">
                        <span class="n_heading">{{ $orgdtails_notes['title'] or "" }}</span>
                       <input type="hidden" name="msgid" id="msgid" value=" {{ $orgdtails_notes['orgnotes_id'] or "" }}"/>
                       <input name="editclient_id" id="editclient_id" type="hidden" value="{{ $orgdtails_notes['client_id'] or "" }}">
                         <p><span class="n_heading_name">By {{$user['fname']}} {{$user['lname']}}</span> <span class="n_date">On: {{ $orgdtails_notes['created'] or "" }}</span></p>
                        </div>
                        <div class="print">
                       <!-- <a href="#"><img src="/img/print.png"></a> -->
                        <a onclick="window.print();" href="#"><img src="/img/print.png" /></a>
                       
                        </div>
                        <div class="clearfix"></div>
                        </div>
                        <p class="n_text">{{ $orgdtails_notes['textmessage'] or "" }} </p>
                        
                        
                           
                            <div class="add_client_btn">
                    
                    
                    
                  <!--    <button type="button" id="1editsave_notes" class="btn btn-success "> Save</button> -->
                       
                       
                       
                       <!-- <button class="btn btn-success" id="editsave_notes" >Save</button> -->
                        <button class="btn btn-info" id="editnotes"  type="button">Edit</button>
                        <button type="button" id="delete_notes" class="btn btn-danger "> Delete</button>
                      <!--  <button class="btn btn-danger"  type="submit">Delete</button> -->
                        <a href="/organisation-clients" class="btn btn-primary">Cancel</a>
                           
                          </div>
                          <div class="clearfix"></div>