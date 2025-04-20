@extends('layouts.user')

@section('content')
<!-- Page -->
<div class="page animsition">
    <div class="page-content container-fluid" style="margin-top: 60px">
        <div class="row" data-plugin="masonry">
            <div class="col-lg-9 ">
                <iframe id="docframe" src={{url()}}<?="/public/web/viewer.html?file="?>{{url()}}/public/media/{{rawurlencode($filename)}} width="100%" height="600px" scrolling="yes">
                    <p>Your browser does not support iframes</p>
                </iframe>
            </div>
            <div class="col-lg-3">
                <div>
                    Hello <b>{{Session::get('recipname')}},</b>
                </div>
                <hr style=" border: 0;
                            height: 0;
                            border-top: 1px solid rgba(0, 0, 0, 0.1);
                            border-bottom: 1px solid rgba(255, 255, 255, 0.3);
                            margin-top: 0px;">
                <div>
                    Request title: <h3 style="display: inline;">{{Session::get('doctitle')}}</h3>
                </div>
                
                <h5>Sent by: <p class="pull-right text-center"><b>{{Session::get('sentby')}}</b></p></h5>
                @if(Session::get('status') == 0)
                <form action="{{url('makesign')}}" method="post" id="signform">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    <div class="form-group">
                        <input class="btn btn-primary" type="submit" name="submit" id="submit" value="Submit" onclick="javascript:confirmation();" disabled="disabled"></input>
                        <button type="button" class="btn btn-outline btn-danger pull-right" onclick="javascript:decline()">Decline</button>
                    </div>
                </form>
                
                @else
                <div class="alert alert-info">
                    <strong>Thanks! You have successfuly signed the document!<br>
                        You will receive an email with a downloadable copy of this document soon.
                    </strong>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('assets/js/fabric.min.js') }}"></script>
<script src="{{ asset('assets/js/pdf.js') }}"></script>
<script src="{{ asset('assets/js/pdf.worker.js') }}"></script>
<script src="{{ asset('assets/vendor/jquery/jquery.min.js') }}"></script>
<script src="./assets/js/sweetalert.min.js"></script>
<script>
$(document).ready(function(){

    $('#docframe').load(function(){
        var iframe = $('#docframe').contents();
        <?php echo "var status = ".Session::get('status').";";?>
        if (status == 1) {
            iframe.find('div.toolbar').hide();
        } else if (status == 0) {
            iframe.find('#mysign').show();
        }
    });

});
   
//decline process
function decline() {
    swal({   
        title: "Are you sure to decline?",   
        text: "You will not be able to view and sign this document.",   
        type: "warning",   
        showCancelButton: true,   
        confirmButtonColor: "#DD6B55",   
        confirmButtonText: "Yes, I am sure!",   
        cancelButtonText: "No, cancel plz!",   
        closeOnConfirm: false,   
        closeOnCancel: false }, 
        function(isConfirm){   
            if (isConfirm) {     
                //swal("Deleted!", "Your imaginary file has been deleted.", "success");   
                window.location = "{{url('declinetosign')}}";
            } else {     
                swal("Cancelled", "We appreciate your decision!", "error");   
            } 
    });
}

function confirmation(){

    swal({title:"Thank you!", text:"Signing the document...", imageUrl: "", showConfirmButton:false, allowOutsideClick:false});
}

function takemysign(topCoord, leftCoord, currentPage, placeid) {
    placecoords = topCoord +','+leftCoord+','+currentPage;
    
    swal({   
            title: "Signature",   
            text: 'Please draw your signs below <br><br><canvas id="mcan" width="300" height="150" style="border:1px solid gray; margin:auto"></canvas><br><a id="clearbtn">clear</a>',   
            html: true,
            showConfirmButton: true,
            animation: "slide-from-top", 
            confirmButtonColor: "#DD6B55",   
            confirmButtonText: "Sign it!", 
            closeOnConfirm: true
        },
        function(isConfirm){
            if (isConfirm) {

                canvas.deactivateAll().renderAll();
                var image = canvas.toDataURL({
                    format: 'png',
                    quality: 1
                });
                var coords = placecoords;
                var iframe = $('#docframe').contents();
                iframe.find('#'+placeid).html('<img src="'+image+'" style="height: 50px; width: 120px">').css('background','transparent');
                $('#signform').append('<input type="hidden" name="image[]" id="image" value="'+image+'"></input>');
                $('#signform').append('<input type="hidden" name="coords[]" id="coords" value="'+coords+'">');
                $('#submit').attr('disabled', false);
            }
        }
    ); 

    var canvas;

    $(function () { 
    canvas = new fabric.Canvas('mcan', {isDrawingMode: true });
    canvas.setBackgroundColor("", canvas.renderAll.bind(canvas));
    if (canvas.freeDrawingBrush) {
        //canvas.freeDrawingBrush.color = drawingColorEl.value;
        canvas.freeDrawingBrush.width = 4;
        //canvas.freeDrawingBrush.shadowBlur = 0;
    }
        $("a#clearbtn").click(function(){
            canvas.clear();
        });
    });
} 
</script>
<!-- End Page -->
@endsection
