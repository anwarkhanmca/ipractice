<!DOCTYPE html>
<html class="no-js before-run" lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="bootstrap admin template">
    <meta name="author" content="hcb">

    <title>{{ $title or 'E-Signature'}}</title>

    <link rel="apple-touch-icon" href="./assets/images/apple-touch-icon.png">
    <link rel="shortcut icon" href="./assets/images/favicon.ico">

    <!-- Stylesheets -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-extend.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/site.min.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/vendor/animsition/animsition.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/asscrollable/asScrollable.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/switchery/switchery.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/intro-js/introjs.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/slidepanel/slidePanel.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/flag-icon-css/flag-icon.css') }}">
    <link rel="stylesheet" type="text/css" href="./assets/css/sweetalert.css">


    <!-- Page -->
    <link rel="stylesheet" href="{{ asset('assets/css/pages/login.css') }}">

    <!-- Plugins -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/blueimp-file-upload/jquery.fileupload.css') }}">

    <!-- Fonts -->
    <link rel="stylesheet" href="{{ asset('assets/fonts/web-icons/web-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/brand-icons/brand-icons.min.css') }}">
    <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Roboto:300,400,500,300italic'>
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Tangerine" />


<!--[if lt IE 9]>
<script src="./assets/vendor/html5shiv/html5shiv.min.js"></script>
<![endif]-->

<!--[if lt IE 10]>
<script src="./assets/vendor/media-match/media.match.min.js"></script>
<script src="./assets/vendor/respond/respond.min.js"></script>
<![endif]-->

<!-- Scripts -->
    <script src="{{ asset('assets/vendor/modernizr/modernizr.js') }}"></script>
    <script src="{{ asset('assets/vendor/breakpoints/breakpoints.js') }}"></script>
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

@include('layouts.nav')
@yield('content')

<!-- Core  -->
<script src="{{ asset('assets/vendor/jquery/jquery.js') }}"></script>
<script src="{{ asset('assets/vendor/bootstrap/bootstrap.js') }}"></script>
<script src="{{ asset('assets/vendor/animsition/jquery.animsition.js') }}"></script>
<script src="{{ asset('assets/vendor/asscroll/jquery-asScroll.js') }}"></script>
<script src="{{ asset('assets/vendor/mousewheel/jquery.mousewheel.js') }}"></script>
<script src="{{ asset('assets/vendor/asscrollable/jquery.asScrollable.all.js') }}"></script>
<script src="{{ asset('assets/vendor/ashoverscroll/jquery-asHoverScroll.js') }}"></script>

<!-- Plugins -->
<script src="{{ asset('assets/vendor/switchery/switchery.min.js') }}"></script>
<script src="{{ asset('assets/vendor/intro-js/intro.js') }}"></script>
<script src="{{ asset('assets/vendor/screenfull/screenfull.js') }}"></script>
<script src="{{ asset('assets/vendor/slidepanel/jquery-slidePanel.js') }}"></script>
<script src="{{ asset('assets/vendor/jquery-placeholder/jquery.placeholder.js') }}"></script>

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
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/site.js') }}"></script>

<script src="{{ asset('assets/js/sections/menu.js') }}"></script>
<script src="{{ asset('assets/js/sections/menubar.js') }}"></script>
<script src="{{ asset('assets/js/sections/sidebar.js') }}"></script>

<script src="{{ asset('assets/js/configs/config-colors.js') }}"></script>
<script src="{{ asset('assets/js/configs/config-tour.js') }}"></script>

<script src="{{ asset('assets/js/components/asscrollable.js') }}"></script>
<script src="{{ asset('assets/js/components/animsition.js') }}"></script>
<script src="{{ asset('assets/js/components/slidepanel.js') }}"></script>
<script src="{{ asset('assets/js/components/switchery.js') }}"></script>
<script src="{{ asset('assets/js/components/jquery-placeholder.js') }}"></script>

<script>
    (function(document, window, $) {
        'use strict';

        var Site = window.Site;
        $(document).ready(function() {
            Site.run();
        });
    })(document, window, jQuery);
</script>


<script>
    (function(document, window, $) {
      $(document).ready(function($) {
        Site.run();
      });

      // Example File Upload
      // -------------------
   
        
      $('#exampleUploadForm').fileupload({
        url: '../../server/fileupload/',
        dropzone: $('#exampleUploadForm'),
        filesContainer: $('.file-list'),
        uploadTemplateId: false,
        downloadTemplateId: false,
        uploadTemplate: tmpl(
          '{% for (var i=0, file; file=o.files[i]; i++) { %}' +
          '<div class="file template-upload fade col-lg-12 col-md-12 col-sm-12 {%=file.type.search("pdf") !== -1? "pdf" : "other-file"%}">' +
          '<div class="file-item">' +
          '<div class="preview vertical-align">' +
          '<div class="file-action-wrap">' +
          '<div class="file-action">' +
          '{% if (!i && !o.options.autoUpload) { %}' +
          '<i class="icon wb-upload start" data-toggle="tooltip" data-original-title="Upload file" aria-hidden="true"></i>' +
          '{% } %}' +
          '{% if (!i) { %}' +
          '<i class="icon wb-close cancel" data-toggle="tooltip" data-original-title="Stop upload file" aria-hidden="true"></i>' +
          '{% } %}' +
          '</div>' +
          '</div>' +
          '</div>' +
          '<div class="info-wrap">' +
          '<div class="title">{%=file.name%}</div>' +
          '</div>' +
          '<div class="progress progress-striped active" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0" role="progressbar">' +
          '<div class="progress-bar progress-bar-success" style="width:0%;"></div>' +
          '</div>' +
          '</div>' +
          '</div>' +
          '{% } %}'
        ),
        downloadTemplate: tmpl(
          '{% for (var i=0, file; file=o.files[i]; i++) { %}' +
          '<div class="file template-download fade col-lg-2 col-md-4 col-sm-6 {%=file.type.search("image") !== -1? "image" : "other-file"%}">' +
          '<div class="file-item">' +
          '<div class="preview vertical-align">' +
          '<div class="file-action-wrap">' +
          '<div class="file-action">' +
          '<i class="icon wb-trash delete" data-toggle="tooltip" data-original-title="Delete files" aria-hidden="true"></i>' +
          '</div>' +
          '</div>' +
          '<img src="{%=file.url%}"/>' +
          '</div>' +
          '<div class="info-wrap">' +
          '<div class="title">{%=file.name%}</div>' +
          '</div>' +
          '</div>' +
          '</div>' +
          '{% } %}'
        ),
        forceResize: true,
        previewCanvas: false,
        previewMaxWidth: false,
        previewMaxHeight: false,
        previewThumbnail: false
      }).on('fileuploadprocessalways', function(e, data) {
        var length = data.files.length;

        for (var i = 0; i < length; i++) {
          if (!data.files[i].type.match(
              /^application\/(pdf)$/)) {
            data.files[i].filetype = 'other-file';
          } else {
            data.files[i].filetype = 'pdf';
          }
        }
      }).on('fileuploadadded', function(e) {
        var $this = $(e.target);

        if ($this.find('.file').length > 0) {
          $this.addClass('has-file');
        } else {
          $this.removeClass('has-file');
        }
      }).on('fileuploadfinished', function(e) {
        var $this = $(e.target);

        if ($this.find('.file').length > 0) {
          $this.addClass('has-file');
        } else {
          $this.removeClass('has-file');
        }
      }).on('fileuploaddestroyed', function(e) {
        var $this = $(e.target);

        if ($this.find('.file').length > 0) {
          $this.addClass('has-file');
        } else {
          $this.removeClass('has-file');
        }
      }).on('click', function(e) {
        if ($(e.target).parents('.file').length === 0) $('#inputUpload')
          .trigger('click');
      });

      $(document).bind('dragover', function(e) {
        var dropZone = $('#exampleUploadForm'),
          timeout = window.dropZoneTimeout;
        if (!timeout) {
          dropZone.addClass('in');
        } else {
          clearTimeout(timeout);
        }
        var found = false,
          node = e.target;
        do {
          if (node === dropZone[0]) {
            found = true;
            break;
          }
          node = node.parentNode;
        } while (node !== null);
        if (found) {
          dropZone.addClass('hover');
        } else {
          dropZone.removeClass('hover');
        }
        window.dropZoneTimeout = setTimeout(function() {
          window.dropZoneTimeout = null;
          dropZone.removeClass('in hover');
        }, 100);
      });

      $('#inputUpload').on('click', function(e) {
        e.stopPropagation();
      });

      $('#uploadlink').on('click', function(e) {
        e.stopPropagation();
      });

    })(document, window, jQuery);

  </script>


</body>

</html>