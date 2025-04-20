<!DOCTYPE html>
<html class="no-js before-run" lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="bootstrap admin template">
    <meta name="author" content="">
    <meta name="csrf-token" content="<?php echo csrf_token() ?>"/>
    <title>Upload document for signature</title>

    <link rel="apple-touch-icon" href="./assets/images/apple-touch-icon.png">
    <link rel="shortcut icon" href="./assets/images/favicon.ico">

    <!-- Stylesheets -->
    <link rel="stylesheet" href="./assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="./assets/css/bootstrap-extend.min.css">
    <link rel="stylesheet" href="./assets/css/site.min.css">

    <link rel="stylesheet" href="./assets/vendor/animsition/animsition.css">
    <link rel="stylesheet" href="./assets/vendor/asscrollable/asScrollable.css">
    <link rel="stylesheet" href="./assets/vendor/switchery/switchery.css">
    <link rel="stylesheet" href="./assets/vendor/intro-js/introjs.css">
    <link rel="stylesheet" href="./assets/vendor/slidepanel/slidePanel.css">
    <link rel="stylesheet" href="./assets/vendor/flag-icon-css/flag-icon.css">

    <!-- Plugin -->
    <link rel="stylesheet" href="./assets/vendor/jquery-wizard/jquery-wizard.css">
    <link rel="stylesheet" href="./assets/vendor/formvalidation/formValidation.css">
    <link rel="stylesheet" href="{{ asset('assets/vendor/blueimp-file-upload/jquery.fileupload.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/imgareaselect-default.css') }}">
    
    <!-- drop zone -->
    <link rel="stylesheet" href="./assets/css/dropzone.css">

    <link rel="stylesheet" type="text/css" href="./assets/css/sweetalert.css">

    <!-- Fonts -->
    <link rel="stylesheet" href="./assets/fonts/web-icons/web-icons.min.css">
    <link rel="stylesheet" href="./assets/fonts/brand-icons/brand-icons.min.css">
    <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Roboto:300,400,500,300italic'>


<!--[if lt IE 9]>
<script src="./assets/vendor/html5shiv/html5shiv.min.js"></script>
<![endif]-->

<!--[if lt IE 10]>
<script src="./assets/vendor/media-match/media.match.min.js"></script>
<script src="./assets/vendor/respond/respond.min.js"></script>
<![endif]-->

<!-- Scripts -->
<script src="./assets/vendor/modernizr/modernizr.js"></script>
<script src="./assets/vendor/breakpoints/breakpoints.js"></script>
<script>
    Breakpoints();
</script>

<style type="text/css">
    .canvas-container {
        margin: auto;
    }
</style>
</head>
<body class="layout-full">
<!--[if lt IE 8]>
<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
<![endif]-->

@include('layouts.nav')


<!-- Page -->
<div class="page animsition">

    <div class="page-content container-fluid" style="margin-top: 60px ">
        <div class="row">

            <div class="col-lg-9 col-md-12 col-xs-12" style="margin: 0 auto; float: none;">
                <!-- Panel Wizard Form Container -->
                <div class="panel" id="docUploadFormContainer">
                    <div class="panel-heading">
                        <h3 class="panel-title">Add a new document to start a sign request</h3>
                    </div>
                    <div class="panel-body">

                        <!-- Steps -->
                        <div class="pearls row">
                            <div class="pearl current col-xs-4">
                                <div class="pearl-icon"><i class="icon wb-upload" aria-hidden="true"></i></div>
                                <span class="pearl-title">Upload the document(pdf)</span>
                            </div>
                            <div class="pearl col-xs-4">
                                <div class="pearl-icon"><i class="icon wb-list" aria-hidden="true"></i></div>
                                <span class="pearl-title">Enter the recipients</span>
                            </div>
                            <div class="pearl col-xs-4">
                                <div class="pearl-icon"><i class="icon wb-check" aria-hidden="true"></i></div>
                                <span class="pearl-title">Done!</span>
                            </div>
                        </div>
                        <!-- End Steps -->

                        <!-- Wizard Content -->
                        <form class="wizard-content" id="docUploadForm" action="{{ url('/createSignDoc') }}" method="post">


                            <div class="wizard-pane active" id="docInfo" role="tabpanel">
                                <div class="form-group"> 
                                    <label class="control-label" for="dropdiv">Please add your documents (upto 5 documents)</label>
                                    <div> <span style="position:absolute; padding: 0 21px; border: 1px dashed; font-size: 41px;">+</span>
                                        <div class="dropzone" id="dropdiv" style="
                                        border: 2px dashed #0087F7;
                                        border-radius: 5px;
                                        min-height: 200px;
                                        padding: 50px;
                                        text-align: center;
                                        font-weight: 400;
                                        font-size: 20px;
                                        display: block;
                                        position:relative;
                                        background: transparent">
                                        </div>
                                    </div>
                                    
                                </div>
                                <div class="form-group">     
                                    <label class="control-label" for="docTitle">Title</label>
                                    <input type="text" class="form-control" id="docTitle" name="docTitle" required>                                    
                                </div>
                                <div class="form-group">     
                                    <label class="control-label" for="docDesc">Description message</label>
                                    <textarea type="text" class="form-control" id="docDesc" name="docDesc" style="resize:none" required></textarea>
                                </div>
                                <div class="form-group" id="numberRecip" style="display: block">
                                    <label class="control-label" for="recipSelect">Select the number of recipients</label>
                                    <select name="recipType" class="form-control" id="recipSelect">
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                        <option value="9">9</option>
                                        <option value="10">10</option>
                                    </select>
                                </div>
                                <div class="form-group" id="priority">
                                    <label class="control-label" for="reqMethod">Select the method for requests</label>
                                    <select name="reqMethod" class="form-control" id="reqMethod">
                                        <option value="0">Parallel requests</option>
                                        <option value="1">Queued requests</option>
                                    </select>
                                </div>
                                
                            </div>
                            <div class="wizard-pane" id="recipientsInfo" role="tabpanel">
                                <!--inputs for users-->
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <label>Enter recipient info</label>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="control-label" for="recipName">Name</label>
                                        <input type="text" class="form-control" id="recipName" name="recipName[]" value="" placeholder="Recipient name" required >
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="control-label" for="recipEmail">Email</label>
                                        <input type="email" class="form-control" id="recipEmail" name="recipEmail[]" value="" placeholder="Recipient email" required >
                                    </div>
                                </div>
                            </div>
                            <div class="wizard-pane" id="doneInfo" role="tabpanel">
                                <center>
                                    <h3>Congratulations. Press finish to send the requests.</h3>
                                </center>
                            </div>
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        </form>

                        <!-- Wizard Content -->
                    </div>
                </div>

                
                <!-- End Panel Wizard Form Container -->
            </div>
        </div>

    </div>
</div>
<!-- End Page -->


<!-- Core  -->
<script src="./assets/vendor/jquery/jquery.js"></script>
<script src="./assets/vendor/bootstrap/bootstrap.js"></script>
<script src="./assets/vendor/animsition/jquery.animsition.js"></script>
<script src="./assets/vendor/asscroll/jquery-asScroll.js"></script>
<script src="./assets/vendor/mousewheel/jquery.mousewheel.js"></script>
<script src="./assets/vendor/asscrollable/jquery.asScrollable.all.js"></script>
<script src="./assets/vendor/ashoverscroll/jquery-asHoverScroll.js"></script>

<!-- Plugins -->
<script src="./assets/vendor/switchery/switchery.min.js"></script>
<script src="./assets/vendor/intro-js/intro.js"></script>
<script src="./assets/vendor/screenfull/screenfull.js"></script>
<script src="./assets/vendor/slidepanel/jquery-slidePanel.js"></script>
<script src="{{ asset('assets/vendor/jquery-placeholder/jquery.placeholder.js') }}"></script>

<script src="./assets/vendor/formvalidation/formValidation.js"></script>
<script src="./assets/vendor/formvalidation/framework/bootstrap.js"></script>
<script src="./assets/vendor/matchheight/jquery.matchHeight-min.js"></script>
<script src="./assets/vendor/jquery-wizard/jquery-wizard.js"></script>

<script src="{{ asset('assets/vendor/jquery-ui/jquery-ui.js') }}"></script>
<script src="{{ asset('assets/vendor/blueimp-tmpl/tmpl.js') }}"></script>
<script src="{{ asset('assets/vendor/blueimp-canvas-to-blob/canvas-to-blob.js') }}"></script>
<script src="{{ asset('assets/vendor/blueimp-load-image/load-image.all.min.js') }}"></script>
<script src="{{ asset('assets/vendor/blueimp-file-upload/jquery.fileupload.js') }}"></script>
<script src="{{ asset('assets/vendor/blueimp-file-upload/jquery.fileupload-process.js') }}"></script>
<script src="{{ asset('assets/vendor/blueimp-file-upload/jquery.fileupload-image.js') }}"></script>
<script src="{{ asset('assets/vendor/blueimp-file-upload/jquery.fileupload-audio.js') }}"></script>
<script src="{{ asset('assets/vendor/blueimp-file-upload/jquery.fileupload-video.js') }}"></script>
<script src="{{ asset('assets/vendor/blueimp-file-upload/jquery.fileupload-validate.js') }}"></script>
<script src="{{ asset('assets/vendor/blueimp-file-upload/jquery.fileupload-ui.js') }}"></script>

<!-- Scripts -->
<script src="./assets/js/core.js"></script>
<script src="./assets/js/site.js"></script>

<script src="./assets/js/sections/menu.js"></script>
<script src="./assets/js/sections/menubar.js"></script>
<script src="./assets/js/sections/sidebar.js"></script>

<script src="./assets/js/configs/config-colors.js"></script>
<script src="./assets/js/configs/config-tour.js"></script>

<script src="./assets/js/components/asscrollable.js"></script>
<script src="./assets/js/components/animsition.js"></script>
<script src="./assets/js/components/slidepanel.js"></script>
<script src="./assets/js/components/switchery.js"></script>
<script src="./assets/js/components/jquery-wizard.js"></script>
<script src="./assets/js/components/matchheight.js"></script>

<script src="./assets/js/dropzone.js"></script>
<script src="./assets/js/sweetalert.min.js"></script>
<script src="{{ asset('assets/js/fabric.min.js') }}"></script>

<script>
 
    (function(document, window, $) {
        'use strict';

        var Site = window.Site;

        $(document).ready(function($) {
            Site.run();
        });

(function() {

    var defaults = $.components.getDefaults("wizard");
    var options = $.extend(true, {}, defaults, {
        // onInit: function() {
        //     $('#docUploadForm').formValidation({
        //         framework: 'bootstrap',
        //         fields: {
        //             docTitle: {
        //               validators: {
        //                 notEmpty: {
        //                   message: 'The document title is required'
        //                 }
        //               }
        //             },
        //             'recipName[]': {
        //               validators: {
        //                 notEmpty: {
        //                   message: 'The recipient name is required'
        //                 }
        //               }
        //             },
        //             'recipEmail[]': {
        //               validators: {
        //                 notEmpty: {
        //                   message: 'The recipient e-mail is required'
        //                 }
        //               }
        //             },
        //         }
        //     });
        // },
        // validator: function() {
        //     var fv = $('#docUploadForm').data(
        //         'formValidation');

        //     var $this = $(this);

        //     // Validate the container
        //     fv.validateContainer($this);

        //     var isValidStep = fv.isValidContainer($this);
        //     if (isValidStep === false || isValidStep === null) {
        //         return false;
        //     }

        //     return true;
        // },
        onFinish: function() {
            //do what you want before submit form
            $('form#docUploadForm').submit();
            $("a[data-wizard='finish']").attr('disabled','disabled');
            swal({title:"Thank you!", text:"Sending requests to your recipients...", imageUrl: "", showConfirmButton:false,      allowOutsideClick:false});
        },
    buttonsAppendTo: '.panel-body'
    });

    $("#docUploadFormContainer").wizard(options);
})();

Dropzone.autoDiscover = false;
var mediaDropzone = new Dropzone(".dropzone", 
    { url: "{{ url('/uploadFile') }}",
    acceptedFiles:'application/pdf',
    maxFiles: 10,
    headers: {
        'X-CSRF-Token': '{{ csrf_token() }}'
    },
    init: function() {
            this.on("sending", function(file, xhr, formData){
                //formData.append("recip_type", $('#recipSelect').val())
            });
        }
});
var ind = 0;
mediaDropzone.on("complete", function(file) {

   if(mediaDropzone.getAcceptedFiles().length > 0) {
        
        // swal(
        //     {
        //         title: "Success!!",   
        //         text: "You have successfuly uploaded a document",   
        //         type: "success",   
        //         showCancelButton: true,   
        //         confirmButtonColor: "#DD6B55",   
        //         confirmButtonText: "Yes, continue with it!", 
        //         cancelButtonText:"No, upload new!",  
        //         closeOnConfirm: true 
        //     },
        //     function(isConfirm){
        //         if (isConfirm) {

                    $('<input>').attr({
                        type: 'hidden',
                        id: 'docName',
                        name: 'docName[]',
                        value: JSON.parse(mediaDropzone.getAcceptedFiles()[ind++]['xhr']['response'])['filename']
                    }).appendTo('#docUploadForm');

                    if ($('#docTitle').val() == '') {
                        $('#docTitle').val(JSON.parse(mediaDropzone.getAcceptedFiles()[0]['xhr']['response'])['title']);
                    }
                    // to enable next button
                    $("a[data-wizard='next']").removeAttr('disabled');
                    
        //         } else {    
        //             mediaDropzone.removeAllFiles();
        //         }
        //     }
        // );
        } 
 });

// prevent form submission on enter click
$('#docUploadForm').bind('keypress keydown keyup', function(e){
   if(e.keyCode == 13) { e.preventDefault(); }
});

})(document, window, jQuery);

$(document).ready(function(){
    $("a[data-wizard='next']").attr('disabled','disabled');

    $('#recipSelect').change(function (e) {
        var recipCount = $(e.target).val();
        $('#recipientsInfo').html('');
        for (var i = 1; i <= recipCount; i++) {
             $('#recipientsInfo').append('<div class="form-group row"><div class="col-sm-12"><label>Enter info recipient '+i+'</label></div><div class="col-sm-6"><label class="control-label" for="recipName">Name<\/label><input type="text" class="form-control" id="recipName" name="recipName[]" value="" placeholder="Recipient name" required ><\/div><div class="col-sm-6"><label class="control-label" for="recipEmail">Email<\/label><input type="email" class="form-control" id="recipEmail" name="recipEmail[]" value="" placeholder="Recipient email" required ><\/div><\/div>');
        }
    });

    $('#docDesc').keydown(function(event) {
       if (event.keyCode == 13) {
          event.preventDefault();
          var s = $(this).val();
          $(this).val(s+"\n");
       }
    });
});

</script>

</body>

</html>