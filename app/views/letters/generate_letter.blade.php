@extends('layouts.layout')

@section('mycssfile')
<link href="{{ URL :: asset('css/datatables/dataTables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
<style type="text/css">
  .bottom_space{ height: 50px;}
</style>
@stop

@section('myjsfile')
<script src="{{ URL :: asset('ckeditor457std/ckeditor.js') }}"></script>
<script type="text/javascript" src="{{ URL :: asset('tinymce/tinymce.min.js') }}"></script>
<script src="{{ URL :: asset('js/letter_email.js') }}" type="text/javascript"></script>
<script src="{{ URL :: asset('js/generate_letter.js') }}" type="text/javascript"></script>
<script src="{{ URL :: asset('js/contact_email_templates.js') }}" type="text/javascript"></script>

<!-- DATA TABES SCRIPT -->
<script src="{{ URL :: asset('js/plugins/datatables/jquery.dataTables.js') }}" type="text/javascript"></script>
<script src="{{ URL :: asset('js/plugins/datatables/dataTables.bootstrap.js') }}" type="text/javascript"></script>

<!-- page script -->
<script type="text/javascript">
var table;
$(document).ready(function(){
  /*table = $('#tab1').dataTable({
    "bPaginate": true,
    "bLengthChange": true,
    "bFilter": true,
    "bSort": true,
    "bInfo": true,
    "bAutoWidth": false,
    "aLengthMenu": [[10, 25, 50, 100], [10, 25, 50, 100]],
    "iDisplayLength": 25,

    "aoColumns":[
        {"bSortable": false},
        {"bSortable": true},
        {"bSortable": false}
    ],
    "aaSorting": [[1, 'asc']]

  });*/


});
</script>

<script type="text/javascript">
  $(document).ready(function() {
    CKEDITOR.replace( 'template_message_body' );
    CKEDITOR.config.height="500px";
    //CKEDITOR.config.font_names = 'Arial;Times New Roman;Verdana;DejaVu Sans Light;Bitstream Charter;Abyssinica SIL;DejaVu Sans;Droid Arabic Naskh;Abyssinica SIL;Bitstream Charter;Century Schoolbook L;';
    CKEDITOR.config.font_names = 'Agency FB;Agency FB Bold;Algerian;Arial Narrow;Arial Narrow Bold;Arial Narrow Bold Italic;Arial Narrow Italic;Arial Rounded MT Bold;Arial Unicode MS;Baskerville Old Face;Bauhaus 93;Bell MT;Bell MT Bold;Bell MT Italic;Berlin Sans FB;Berlin Sans FB Bold;Berlin Sans FB Demi Bold;Bernard MT Condensed;Blackadder ITC;Bodoni MT;Bodoni MT Black;Bodoni MT Black Italic;Bodoni MT Bold;Bodoni MT Bold Italic;Bodoni MT Condensed;Bodoni MT Condensed Bold;Bodoni MT Condensed Bold Italic;Bodoni MT Condensed Italic;Bodoni MT Italic;Bodoni MT Poster Compressed;Book Antiqua;Book Antiqua Bold;Book Antiqua Bold Italic;Book Antiqua Italic;Bookman Old Style;Bookman Old Style Bold;Bookman Old Style Bold Italic;Bookman Old Style Italic;Bookshelf Symbol 7;Bradley Hand ITC;Britannic Bold;Broadway;Brush Script MT Italic;Calibri;Calibri Bold;Calibri Bold Italic;Calibri Italic;Californian FB;Californian FB Bold;Californian FB Italic;Calisto MT;Calisto MT Bold;Calisto MT Bold Italic;Calisto MT Italic;Cambria Bold;Cambria Bold Italic;Cambria Italic;Candara;Candara Bold;Candara Bold Italic;Candara Italic;Castellar;Centaur;Century;Century Gothic;Century Gothic Bold;Century Gothic Bold Italic;Century Gothic Italic;Century Schoolbook;Century Schoolbook Bold;Century Schoolbook Bold Italic;Century Schoolbook Italic;Chiller;Colonna MT;Consolas;Consolas Bold;Consolas Bold Italic;Consolas Italic;Constantia;Constantia Bold;Constantia Bold Italic;Constantia Italic;Cooper Black;Copperplate Gothic Bold;Copperplate Gothic Light;Corbel;Corbel Bold;Corbel Bold Italic;Corbel Italic;Curlz MT;Edwardian Script ITC;Elephant;Elephant Italic;Engravers MT;Eras Bold ITC;Eras Demi ITC;Eras Light ITC;Eras Medium ITC;Felix Titling;Footlight MT Light;Forte;Franklin Gothic Book;Franklin Gothic Book Italic;Franklin Gothic Demi;Franklin Gothic Demi Cond;Franklin Gothic Demi Italic;Franklin Gothic Heavy;Franklin Gothic Heavy Italic;Franklin Gothic Medium Cond;Freestyle Script;French Script MT;Garamond;Garamond Bold;Garamond Italic;Gigi;Gill Sans MT;Gill Sans MT Bold;Gill Sans MT Bold Italic;Gill Sans MT Condensed;Gill Sans MT Ext Condensed Bold;Gill Sans MT Italic;Gill Sans Ultra Bold;Gill Sans Ultra Bold Condensed;Gloucester MT Extra Condensed;Goudy Old Style;Goudy Old Style Bold;Goudy Old Style Italic;Goudy Stout;Haettenschweiler;Harlow Solid Italic;Harrington;High Tower Text;High Tower Text Italic;Imprint MT Shadow;Informal Roman;Jokerman;Juice ITC;Kristen ITC;Kunstler Script;Lucida Bright;Lucida Bright Demibold;Lucida Bright Demibold Italic;Lucida Bright Italic;Lucida Calligraphy Italic;Lucida Fax Demibold;Lucida Fax Demibold Italic;Lucida Fax Italic;Lucida Fax Regular;Lucida Handwriting Italic;Lucida Sans Demibold Italic;Lucida Sans Demibold Roman;Lucida Sans Italic;Lucida Sans Regular;Lucida Sans Typewriter Bold;Lucida Sans Typewriter Bold Oblique;Lucida Sans Typewriter Oblique;Lucida Sans Typewriter Regular;Magneto Bold;Maiandra GD;Matura MT Script Capitals;Mistral;Modern No. 20;Monotype Corsiva;MS Mincho;MS Outlook;MS Reference Sans Serif;MS Reference Specialty;Niagara Engraved;Niagara Solid;OCR A Extended;Old English Text MT;Onyx;Palace Script MT;Papyrus;Parchment;Perpetua;Perpetua Bold;Perpetua Bold Italic;Perpetua Italic;Perpetua Titling MT Bold;Perpetua Titling MT Light;Playbill;Poor Richard;Pristina;Rage Italic;Ravie;Rockwell;Rockwell Bold;Rockwell Bold Italic;Rockwell Condensed;Rockwell Condensed Bold;Rockwell Extra Bold;Rockwell Italic;Script MT Bold;Segoe Chess;Segoe UI;Segoe UI Bold;Segoe UI Bold Italic;Segoe UI Italic;Showcard Gothic;Snap ITC;Stencil;Tempus Sans ITC;Tw Cen MT;Tw Cen MT Bold;Tw Cen MT Bold Italic;Tw Cen MT Condensed;Tw Cen MT Condensed Bold;Tw Cen MT Condensed Extra Bold;Tw Cen MT Italic;Viner Hand ITC;Vivaldi Italic;Vladimir Script;Wide Latin;Wingdings 2;Wingdings 3';






    tinymce.init({
      selector: "#editor3",
      plugins: [
          "advlist autolink lists link image charmap print preview anchor",
          "searchreplace visualblocks code fullscreen",
          "insertdatetime media table contextmenu paste"
      ],
      toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
      plugins: ["wordcount", "table", "charmap", "anchor", "insertdatetime", "link", "image", "media", "visualblocks", "preview", "fullscreen", "print", "code" ]
    });


  });
</script>

@stop

@section('content')
<div class="wrapper row-offcanvas row-offcanvas-left">
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="left-side sidebar-offcanvas {{ $left_class }}">
      <!-- sidebar: style can be found in sidebar.less -->
      <section class="sidebar">
          <!-- Sidebar user panel -->
          
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu">
              @include('layouts.outer_leftside')
          </ul>
      </section>
      <!-- /.sidebar -->
  </aside>

  <!-- Right side column. Contains the navbar and content of the page -->
  <aside class="right-side  {{ $right_class }}">
    @include('layouts.below_header')
      <input type="hidden" id="page_open" value="{{ $page_open }}">
      <input type="hidden" id="isCopyId" value="{{ $isCopyId }}">
      <input type="hidden" id="type" value="{{ $type }}">
      <input type="hidden" id="recipient_id" value="{{ $recipient_id or '0' }}">

    <section class="content">
        <div class="row tab3_view" style="margin-bottom: 10px;" >
          <div class="col-md-4 col-md-offset-8">
            <div class="col-md-3">Letter head:</div>
            <div class="col-md-8">
              <select name="lheads" class="form-control newdropdown">
                <option value="">Select letter head</option>
                @if(isset($letterheads) && count($letterheads) >0)
                  @foreach($letterheads as $lhead)
                    <option value="{{ $lhead['id'] }}" @if($lhead['isdefaullt'] == 1) selected="selected" @endif>{{ $lhead['name'] or '' }}</option>
                  @endforeach
                @endif
              </select>
            </div>
          </div>
        </div>

    <div class="clearfix"></div>
      <div class="practice_mid">
      {{ Form::open(array('url'=>'/letters/generate-letter-action', 'id'=>'TemplateTextForm')) }}
        <input type="hidden" name="action" value="saveTemplate">
        <input type="hidden" name="template_id" id="template_id" value="{{ $template_id }}">
        <div class="tabarea">
          <div class="show_loader"></div>
          <div class="tab_topcon">
              <div class="top_bts" style="float:left;">
                <ul style="padding:0;">
                  
                      <li class="tab1_view">
                        <a href="javascript:void(0)" class="btn btn-danger" id="deleteItems">Delete</a>
                      </li>
                      <li style="margin-left: 300px;" class="tab1_view">Select Recepients</li>
                      <li class="tab1_view">
                        <select class="form-control newdropdown selectContactType">
                          <option value="">-- Select Contact Type --</option>
                          <option value="org">Organisation contacts</option>
                          <option value="ind">Individual contacts</option>
                          <option value="staff">Staff contacts</option>
                          <option value="other">Other contacts</option>
                          <option value="group">Grouped Contacts</option>
                        </select>
                      </li>
                      <li class="tab1_view">
                      <div style="position: relative;">
                        <div class="nt_selectbox" style="margin-top: 12px;">
                          <span>Select 1 or more</span>
                          <div class="icon avoid-clicks" id="select_icon"></div>
                          <div class="clr"></div>
                          <div class="open_toggle" style="top:23px;">
                            <input type='text' class="email_top search_text" id='searchText'/>
                            <ul class="document_ul" id="custom_list"><!-- Ajax Call --></ul>
                          </div>
                        </div>
                        </div>
                        <div class="clearfix"></div>
                      </li>
                  
                      <li class="tab2_view">
                        <a href="/letters/templates" class="btn btn-info" target="_blank">View Templates</a>
                      </li>
                      <!-- <li style="margin-left: 330px;" class="tab2_view">
                        <select class="form-control newdropdown previewLetterDrop {{($template_id == 0)?'disable_click':''}}" style="width: 350px; height: 33px">
                          <option value=""> Preview Letter </option>
                          @if(isset($contacts) && count($contacts) >0)
                            @foreach($contacts as $key=>$conValue)
                              <option value="{{ $conValue['recipient_id'] }}" {{ (isset($recipient_id) && $conValue['recipient_id'] == $recipient_id)?'selected':'' }}>{{ $conValue['item_name'] or '' }}</option>
                            @endforeach
                          @endif
                        </select>
                      </li> -->
                    

                      <li class="tab3_view">
                        <a href="javascript:void(0)" class="btn btn-info" id="exportToWord">Export To Word</a>
                      </li>
                      <li style="margin-left: 200px;" class="tab3_view">
                        <select class="form-control newdropdown previewLetterDrop" id="previewLetterDrop2" style="width: 350px; height: 33px">
                          <option value=""> Preview Letter </option>
                          @if(isset($contacts) && count($contacts) >0)
                            @foreach($contacts as $key=>$conValue)
                              <option value="{{ $conValue['recipient_id'] }}" {{ (isset($recipient_id) && $conValue['recipient_id'] == $recipient_id)?'selected':'' }}>{{ $conValue['item_name'] or '' }}</option>
                            @endforeach
                          @endif
                        </select>
                      </li>
                      <!-- <li class="tab3_view"> Letter head: 
                        <select name="lheads" class="form-control newdropdown">
                          <option value="">Select letter head</option>
                          @if(isset($letterheads) && count($letterheads) >0)
                            @foreach($letterheads as $lhead)
                              <option value="{{ $lhead['id'] }}" @if($lhead['isdefaullt'] == 1) selected="selected" @endif>{{ $lhead['name'] or '' }}</option>
                            @endforeach
                          @endif
                        </select>
                      </li> -->


                  <div class="clearfix"></div>
                </ul>
              </div>
              <div class="top_search_con">
               <div class="top_bts">
                <ul style="padding:0;">
              
                  <li class="tab23_view">
                    <button class="btn btn-primary saveTemplateButton" type="button" id="saveTemplateButton1" data-save_as="D" data-status="L"><i class="fa fa-save"></i> 
                      <span>{{($template_id == 0 )?"Preview": 'Save'}}</span></button>
                  </li>
              
                  <li class="tab3_view">
                    <button class="btn btn-success saveTemplateButton" type="button" id="saveTemplateButton2" data-save_as="F" data-status="L"><i class="fa fa-save"></i> Save As Final</button>
                  </li>
              
                  <li class="tab2_view">
                    <button class="btn btn-info" type="button" id="saveAsTemplateBtn" data-save_as="F" data-status="T">Save As Template</button>
                  </li>
              
                  <li class="tab1_view"><a class="btn btn-success" href="javascript:void(0)"><i class="fa fa-download"></i> Generate PDF</a></li>
                  <li style="float:right; margin-right: 0px" class="tab1_view"><a href="javascript:void(0)" class="btn btn-info create_group">EMAIL</a></li>
              
                  <li style="margin-right: 0px;" class="tab2_view"><a class="btn btn-danger" href="javascript:void(0)" style="padding: 6px 30px" id="closeGeneratePage">Close</a></li>
              
                  <li class="tab3_view">
                    <a class="btn btn-success downloadTemplatePdf" href="javascript:void(0)" download="template.pdf"><i class="fa fa-download"></i> Generate PDF</a>
                  </li>
              

              
                  <div class="clearfix"></div>
                </ul>
              </div>
              </div>
              <div class="clearfix"></div>

            </div>


            <div class="nav-tabs-custom">
            <!-- /letters/generate-letter/1/{{$template_id}}/{{$isCopyId}}/{{$type}} -->
              <ul class="nav nav-tabs nav-tabsbg">
                <li class="{{ ($page_open == 1)?'active':'' }} TAB" id="tabli_1"><a href="javascript:void(0)" class="contactTab">CONTACTS</a></li>

                <li class="{{ ($page_open == 2)?'active':'' }} TAB" id="tabli_2"><a href="javascript:void(0)" class="writeTab" data-url="/letters/generate-letter/2/{{$template_id}}/{{$isCopyId}}/{{$type}}">WRITE</a></li>

                <li class="{{ ($page_open == 3)?'show active':'hide' }} TAB" id="tabli_3"><a href="/letters/generate-letter/3-{{$recipient_id or '0'}}/{{$template_id}}/{{$isCopyId}}/{{$type}}">PREVIEW</a></li>
              </ul>

              <div class="tab-content">

                <div id="tab_1" class="tab-pane {{ ($page_open == 1)?'active':'' }}">
                  <table class="table table-bordered table-hover dataTable" id="tab1" width="100%">
                    <thead>
                      <tr role="row">
                        <th width="5%" style="text-align: center;"><input type="checkbox" class="allCheckSelect"></th>
                        <th>Name</th>
                        <!-- <th width="10%" style="text-align: center;">Letter Preview</th> -->
                      </tr>
                    </thead>

                    <tbody>
                    @if(isset($itemDetails) && count($itemDetails) >0)
                      @foreach($itemDetails as $key=>$itemValue)
                      <tr class="del_tabletr_{{$itemValue['recipient_id']}}">
                        <td align="center"><input type="checkbox" class="checkbox ads_Checkbox" name="checkbox[]" id="cst_{{$itemValue['recipient_id']}}" value="{{$itemValue['recipient_id']}}" data-item_type="{{$itemValue['item_type']}}" /></td>
                        <!-- <td><a href="javascript:void(0)" class="openTaskPop" data-item_id="{{$itemValue['item_id']}}">{{$itemValue['item_name']}}</a></td>
                        <td align="center"><a href="/letters/generate-letter/101-{{$itemValue['recipient_id']}}" class="job_sent_btn">VIEW</a></td> -->
                      </tr>
                      @endforeach
                    @endif
                    </tbody>
                  </table>
                </div>

                <div id="tab_2" class="tab-pane {{ ($page_open == 2)?'active':'' }}">
                  <div style="float: left;width: 72%; padding-left: 20px">
                    <div class="tab_topcon">
                      <div class="top_bts" style="float:left; width: 100%">
                        <ul style="padding:0;">
                          <li style="width: 30%;">
                            <select class="form-control newdropdown templateDrop" data-type="T" style="height: 33px">
                              <option value="">Copy from Template - Settings</option>
                              @if(isset($templates) && count($templates) >0)
                                @foreach($templates as $key=>$tempValue)
                                  <option value="{{ $tempValue['id'] }}">{{ $tempValue['subject'] or '' }}</option>
                                @endforeach
                              @endif
                            </select>
                          </li>
                          <li style="width: 35%">
                            <select class="form-control newdropdown templateDrop" data-type="C" style="width:100%;height: 33px">
                              <option value="">Copy from Existing Letter</option>
                              @if(isset($recipients) && count($recipients) >0)
                                @foreach($recipients as $key=>$tempValue)
                                  <option value="{{ $tempValue['recipient_id'] }}">{{ $tempValue['template_subject'] or '' }} - {{ $tempValue['item_name'] or '' }}</option>
                                @endforeach
                              @endif
                            </select>
                          </li>
                          <li style="width: 30%">
                            <select class="form-control newdropdown templateDrop" data-type="L" style="width:100%; height: 33px">
                              <option value="">Copy from Template - Finals</option>
                              @if(isset($letters) && count($letters) >0)
                                @foreach($letters as $key=>$letValue)
                                  <option value="{{ $letValue['template_id'] }}">{{ $letValue['subject'] or '' }}</option>
                                @endforeach
                              @endif
                            </select>
                          </li>
                          
                          <div class="clearfix"></div>
                        </ul>
                      </div>
                      <div class="clearfix"></div>
                    </div>
                  
                    <table>
                      <tr>
                        <td>
                          <input type="text" placeholder="Subject Line" id="template_mail_subject" name="template_mail_subject" class="form-control" style="margin-bottom: 20px;" value="{{ $tempDetails['subject'] or '' }}">
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <textarea name="template_message_body" id="template_message_body" rows="100" class="form-control" placeholder="Message" style="height: 1000px; margin-top: 10px">{{ $content or '' }}</textarea>
                        </td>
                      </tr>
                    </table>
              
                  </div>

                  <div style="float: left;width: 28%; padding-left: 20px">
                    <div style="width: 60%; padding-bottom: 5px;">
                      <select class="form-control newdropdown" id="changePlaceHolder">
                        <option value="">Select Placeholder Type</option>
                        <option value="general">General</option>
                        <option value="org">Organisation Details</option>
                        <option value="ind">Individual Details</option>
                        <option value="staff">Staff Details</option>
                        <option value="practice">Practice Details</option>
                        <option value="address">Organisation Address Details</option>
                        <option value="other">Other Contacts</option>

                      </select>
                    </div>

                    <div style="width: 100%">
                      <ul class="placeholderList">
                        <!-- Ajax Call -->
                      </ul>
                    </div>
                  </div>
                  <div class="clearfix"></div>

                </div>

                <div id="tab_3" class="tab-pane {{ ($page_open != 1 && $page_open != 2)?'active':'' }}">
                  <div style="width: 70%; margin: 20px auto;"> 
                    <!-- <iframe width="100%" height="600" src="/uploads/emailTemplates/{{$user_id}}_template.pdf"></iframe>  -->
                    <div class="newsubject" style="text-align: center; width: 100%; font-size: 22px; margin-bottom: 10px;">{{$newsubject or ''}}</div>
                    <div class="clearfix"></div>
                    <textarea name="editor3" id="editor3" class="form-control" style="height: 550px;">{{$newcontent or ''}}</textarea>
                  </div> 
                </div>

              </div>
            </div>
          <!-- <div style="float: left;width: 25%; padding-left: 20px">
            <select class="form-control newdropdown">
              <option value="">Select Placeholder Type</option>
            </select>
          </div> -->
          <div class="clearfix"></div>

        </div>
        {{ Form::close() }}
      </div>
    </section>
  </aside>
</div>




      
<!-- Add to Group modal end -->

@stop

