<div class="container">
    <div class="col-md-8 col-md-offset-2">
        <div class="row" style="margin-top: 10px;">
            <div class="panel panel-primary" style="border-color: #0866C6">
            	  <div class="panel-heading" style="color: #fff; background-color: #0866C6; border-color: #0866C6;">
            			<h3 class="panel-title">{{ $page_title }} - Additional Note</h3>
            	  </div>
            	  <div class="panel-body">
                  {{ Form::open(array('url' => '/crm/saveAdditionalNote', 'class'=>'form-horizontal')) }}
                        <div class="row">
                            <div class="form-group col-md-12">
                                <div class="col-md-3">
                                    <label class="proposal-label">Additional Note</label>
                                </div>
                                <div class="col-md-8">
                                    <textarea class="form-control summernote" name="note" placeholder="Additional Note" style="height:150px;">
                                        @if(($page_title == 'Edit Proposal' || $page_title == 'Copy Proposal') && ($note))
                                            {{ $note->note }}
                                        @endif
                                    </textarea>
                                    @if (Session::has('add_note_error')) <span style="color: red">{{ Session::get('add_note_error') }}</span> @endif
                                </div>
                            </div>
<!--                            form-group col-md-12-->
                        </div>
                            <div class="row col-md-12">
                            @if(isset($copy_proposal_id))
                                <input name="copy_proposal_id" type="hidden" value="{{ $copy_proposal_id }}"/>
                            @endif

                                <input name="proposal_id" type="hidden" value="{{ $proposal_id }}"/>
                                <input type="hidden" name="page_title" value="{{ $page_title }}"/>

                                <button type="submit" class="btn bnt-sm btn-primary proposal-button" style="background-color: #0866C6">Next</button>
                                <a href="{{ url('crm/'.(($page_title == 'Edit Proposal') ? 'editSelectTemplate' : 'selectTemplate') . '/'.$proposal_id) }}" class="btn bnt-sm btn-primary proposal-button" style="background-color: #0866C6">Skip</a>
                            </div>
                    {{ Form::close() }}
            	  </div>
            </div>
            
            </div>
<!--        .row-->
        </div>
<!--    col-md-6 col-md-offset-3-->
    </div>