<!-- <div style="width: 100%;">
  <div style="width: 100%;font-size: 20px; margin-bottom: 10px;">checklist</div>
  <div style="width: 100%; font-size: 22px; color: gray;border-bottom: 1px solid #ccc; padding-bottom: 20px;">Today at 20:13</div>

  <h1>Hello, </h1>
  <p><strong>Message</strong></p>
  <p>tdtdtdt tdtdtdt tdt dt</p>
  <br> 
  <div style="width: 100%;font-size: 25px; margin-bottom: 10px;">Please click on the link below to update the task status</div>
  <div><a href="" target="_blank" style="font-size: 20px;color: #00acd6">Please click here</a></div>

  <br /><br />
  <div style="width: 100%;font-size: 25px; margin-bottom: 10px;">Regards,</di>

  <div style="width: 100%;font-size: 25px; margin-bottom: 10px;">i-Practice Team</div>
</div> -->



<!-- <form method="post" action="/checklist/update-status">
<table width="50%" style="margin-top: 50px; margin-left: 200px;">
  <tr>
    <td width="20%">
      <input type="hidden" name="onboard_check_id" value="{{ $onboarding_checklist_id or '' }}">
      <select class="form-control newdropdown" name="status" id="statusdrop">
          <option value="N" {{ (isset($status) && $status == 'N')?'selected':'' }}>Not Started</option>
          <option value="D" {{ (isset($status) && $status == 'D')?'selected':'' }}>Done</option>
          <option value="W" {{ (isset($status) && $status == 'W')?'selected':'' }}>WIP</option>
      </select>
    </td>
    <td><input type="submit" name="change" value="Update"></td>
  </tr>
</table>
</form> -->

<?php //die;?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head id="Head1">
<title>i-Practice | Custom tasks</title>
<meta http-equiv="X-UA-Compatible" content="chrome=1" /><meta name="viewport" content="width=512px, user-scalable=no" />
  <script type="text/javascript" src="https://2.cloud.invoice.2go.com/scripts/jquery-1.7.2.min.js"> </script>
  <link rel="stylesheet" type="text/css" href="https://2.cloud.invoice.2go.com/Services/webfonts.css" />
  <link rel="icon" type="image/png" href="/img/favicon.ico" />
  <style type="text/css">
    
    
    body {background:black url(../../images/payment_notifier_background_tiles.jpg) center;}


    #container, #innerContainer, #envelopeContainer, #letterContainer, #envelopeFlap, #envelopeFlapShadow, #envelopeFlapReverse, #envelopeMiddle, #envelopeText, #tryBox, .confirmBox, .confirmBox div, .remainingBox, .commentBox textarea {-moz-box-sizing:border-box; box-sizing:border-box;}

    #envelopeContainer {-moz-transition:top 1s; -webkit-transition:top 1s; -o-transition:top 1s; -ms-transition:top 1s; transition:top 1s;}


    #letterContainer {-moz-transition: height 0.5s 0s, top 0.5s 0s; -webkit-transition: height 0.5s 0s, top 0.5s 0s; -o-transition: height 0.5s 0s, top 0.5s 0s; -ms-transition: height 0.5s 0s, top 0.5s 0s; transition: height 0.5s 0s, top 0.5s 0s;}
    .open #letterContainer {-moz-transition-delay: 0.75s; -webkit-transition-delay: 0.75s; -o-transition-delay: 0.75s; -ms-transition-delay: 0.75s; transition-delay: 0.75s;}

    #envelopeFlapShadow {-moz-transition: height 0.5s 0.70s, opacity 0.5s 0.70s; -webkit-transition: height 0.5s 0.70s, opacity 0.5s 0.70s; -o-transition: height 0.5s 0.70s, opacity 0.5s 0.70s; -ms-transition: height 0.5s 0.70s, opacity 0.5s 0.70s; transition: height 0.5s 0.70s, opacity 0.5s 0.70s;}
    .open #envelopeFlapShadow {-moz-transition-delay: 0s; -webkit-transition-delay: 0s; -o-transition-delay: 0s; -ms-transition-delay: 0s; transition-delay: 0s;}

    #envelopeFlap {-moz-transition: height 0.5s 0.70s; -webkit-transition: height 0.5s 0.70s; -o-transition: height 0.5s 0.70s; -ms-transition: height 0.5s 0.70s; transition: height 0.5s 0.70s;}
    .open #envelopeFlap {-moz-transition-delay: 0s; -webkit-transition-delay: 0s; -o-transition-delay: 0s; -ms-transition-delay: 0s; transition-delay: 0s;}

    #envelopeFlapReverse {-moz-transition: height 0.5s 0.20s; -webkit-transition: height 0.5s 0.20s; -o-transition: height 0.5s 0.20s; -ms-transition: height 0.5s 0.20s; transition: height 0.5s 0.20s;}
    .open #envelopeFlapReverse {-moz-transition-delay: 0.5s; -webkit-transition-delay: 0.5s; -o-transition-delay: 0.5s; -ms-transition-delay: 0.5s; transition-delay: 0.5s;}

    #envelopeText {-moz-transition: opacity 0.2s; -webkit-transition: opacity 0.2s; -o-transition: opacity 0.2s; -ms-transition: opacity 0.2s; transition: opacity 0.2s;}

    #loglow, #logo-colour {-moz-transition:opacity 0.5s; -webkit-transition:opacity 0.5s; -o-transition:opacity 0.5s; -ms-transition:opacity 0.5s; transition:opacity 0.5s;}
    .glowoff #loglow {-moz-transition-duration: 1.5s; -webkit-transition-duration: 1.5s; -o-transition-duration: 1.5s; -ms-transition-duration: 1.5s; transition-duration: 1.5s;}



    #container {background:url(../../images/payment_notifier_background.jpg); width:512px; height:768px; position:absolute; top:50%; left:50%; margin-top:-384px; margin-left:-256px;}

    #innerContainer {height:100%; margin:0px auto; width:342px; position:relative;}

    #envelopeContainer { position:absolute;}
    #letterContainer {height:161px; top:16px; width:380px; left:7px; position:absolute; box-shadow:1px 1px 3px rgba(0,0,0,0.5); background:url(../../images/paper_texture.png); z-index:3; overflow:hidden; padding:6px; font-family:"helvetica neue", helvetica, sans-serif; color:#575757;}


    #envelopeMiddle {z-index:4; position:absolute; width:100%; background:url(../../images/envelope_body.png); height:200px;}
    #envelopeFlapShadow {z-index:5; position:absolute; width:100%; height:195px; opacity:1;}
    #envelopeFlap {z-index:6; position:absolute; width:100%; height:195px; top:5px;}
    #envelopeFlapReverse {z-index:2; position:absolute; width:100%; height:0px; bottom:195px;}
    #envelopeText {z-index:7; position:absolute; width:100%; height:100px; opacity:0; top:24px;}


    .open #envelopeContainer {top:436px;}
    .open #letterContainer {top:-260px; height:200px;}

    .open #envelopeFlapShadow {height:120px; opacity:0;}
    .open #envelopeFlap {height:0px;}
    .open #envelopeFlapReverse {height:195px;}
    
    .success #envelopeText, .error #envelopeText {opacity:1;}


    #tryBox {height:63px; font-family:"helvetica neue", helvetica, sans-serif; font-size:12px; line-height:17px; text-align:center; width:100%; position:absolute; bottom:44px;}
    #tryBox span {display:block; color:white;}
    #tryBox a {color:#47A3D6 !important; font-weight:bold; text-decoration:none !important;}
    #tryBox a:hover {text-decoration:underline !important;}

    #tryLink {position:absolute; display:block; top:570px; text-decoration:none !important; left:80px; width:180px; height:60px; z-index:3;}

    #loglow {position:absolute; bottom:95px; left:37px; display:block; opacity:0; z-index:2;}
    .glowon #loglow {opacity:1;}
    .glowoff #loglow {opacity:0;}

    #logo-colour {height:0px; display:block; z-index:1; position:absolute; bottom:131px; left:90px; opacity:0;}
    .glowoff #logo-colour {height:auto; opacity:1;}
    

    #letterContainer h3 {font-size:20px; color:#47A3D6; font-family:"museoslab-500", helvetica, sans-serif; text-align: center; margin-bottom: 10px}
    #letterContainer .numberBox {border:1px dashed #999898; border-width:1px 0; padding:6px 0; margin:10px 0; font-weight:normal; font-size:13.42px; overflow:hidden;}
    #letterContainer .numberBox .label {float:left; width:55px;}
    #letterContainer .numberBox .property {float:left; font-weight:bold; width:241px;}
    #letterContainer .numberBox .label div, #letterContainer .numberBox .property div {height:17px; overflow:hidden; display:block; white-space:nowrap;}
    



    #letterContainer .commentBox {}
    #letterContainer textarea {width:100%; resize:none; height:82px;}


    #letterContainer .confirmBox {overflow:hidden; margin-top:8px;}
    #letterContainer .confirmBox div {cursor:pointer; width:204px; height:41px; line-height:34px; display:block; font-size:14.82px; text-align:center; background:url(../../images/confirm_button.png) left; color:white; font-weight:bold; margin:0px auto;}
    #letterContainer .confirmBox div:hover {background-position:right;}

    #letterContainer .remainingBox {font-size:12.39px; text-align:center; margin-top:8px; color:red;}
    #letterContainer .remainingBox.hidden {display:none;}


    .success #envelopeText {background:url(../../images/payment_notifier_greentick.png) no-repeat center 60px;}
    #envelopeText h3 {font-family:"museoslab-500", helvetica, sans-serif; margin:0px; padding:0px; font-weight:normal; color:#47A3D6; text-align:center; font-size:22px;}
    #envelopeText .text {font-family:"helvetica neue", helvetica, sans-serif; color:#929292; font-size:12.1px; line-height:12px; text-align:center; width:128px; margin:0px auto; margin-top:4px;}
    .error #envelopeText h3 {color:#FFA347;}


  </style>
</head>
<body>
    <div id="container">
  
      <div id="innerContainer">
        <div id="envelopeContainer">
          
          
          <div id="letterContainer">
            <div style="border: 1px solid #00acd6; padding: 5px;">
              <h3>Update Task Status</h3>

              
              @if(Session::has('message'))
                  <div style="font-size: 15px; color: green; float: left; margin-left: 60px;">
                      {{ Session::get('message') }}
                  </div>
              @endif
              
              <form method="post" action="/checklist/update-status">
              <table width="50%" style="margin-top: 28px; margin-left: 57px; margin-bottom: 73px;">
                <tr>
                  <td width="20%">
                    <input type="hidden" name="onboard_check_id" value="{{ $onboarding_checklist_id or '' }}">
                    <select style="width: 170px; height: 28px;border-radius: 4px;" name="status" id="statusdrop">
                        <option value="N" {{ (isset($status) && $status == 'N')?'selected':'' }}>Not Started</option>
                        <option value="D" {{ (isset($status) && $status == 'D')?'selected':'' }}>Done</option>
                        <option value="W" {{ (isset($status) && $status == 'W')?'selected':'' }}>WIP</option>
                    </select>
                  </td>
                  <td><input type="submit" name="change" value="Update" style="height: 28px; margin-left: 10px;cursor: pointer;"></td>
                </tr>
              </table>
              </form>

            </div>
          </div>
        </div>
        
        
      </div>
    
</div>


  <script type="text/javascript">

      // Pageload
      $(document).ready(function () {

          // Initial state
          $("#envelopeText").attr("style", "visibility:hidden;");
          $("#loglow").attr("style", "visibility:hidden;");

      

        // Open envelope
        if (!(($("#container").hasClass("success")) || ($("#container").hasClass("error")))) {
            window.setTimeout(openEnvelope, 500);
        }


        // iOS hide address bar
        setTimeout(function () {
            window.scrollTo(0, 1);
        }, 0);


        // Character limit
        // Modified version of original from http://www.webdeveloperjuice.com/2011/05/20/quick-jquery-limit-input-box-characters-to-defined-count/
        hardLimit = 140;
        softLimit = 20;
        $(".remainingBox .num").text(hardLimit);
        $(".commentBox textarea").keyup(function () {
            var $this = $(this);
            $(".remainingBox .num").attr("style", "");
            if ($this.val().length > hardLimit - softLimit) {
                $(".remainingBox").removeClass("hidden");
            } else {
                $(".remainingBox").addClass("hidden");
            }
            if ($this.val().length > hardLimit) {
                $this.val($this.val().substr(0, hardLimit));
            }
            $(".remainingBox .num").text(hardLimit - $this.val().length);

        });


    });



    // Open Envelope
    function openEnvelope() {
        $("#container").addClass("open");
        $("#letterContainer").attr("style", "visibility:visible;");
        window.setTimeout(hideElements, 500);
        function hideElements() {
            $("#envelopeFlapShadow").attr("style", "visibility:hidden;");
        }
    }



    // Send comment (close envelope, submit)
    $(".confirmBox .submit").click(sendComment);
    function sendComment() {

        $.ajax("notifycall.aspx?uniqueID=" + encodeURIComponent("m4Yv39DvdxCt0eCPV4jlNPoSlgiIXrdPkv58b7M6gaAr8++/Pt0Sytz2gaRTSjRhB567dxqypTE=") + "&comment=" + encodeURIComponent($(".commentBox textarea").attr("value")));

        $("#container").removeClass("open");
        $("#container").addClass("send");

        $("#envelopeFlapShadow").attr("style", "visibility:visible;");
        window.setTimeout(hideElements, 900);
        function hideElements() {
            $("#letterContainer").remove();
        }
        $("#loglow").attr("style", "visibility:visible;");
        window.setTimeout(glowOn, 500);
        window.setTimeout(glowOff, 1000);
        window.setTimeout(glowDestroy, 3000);
        function glowOn() {
            $("#container").addClass("glowon");
        }
        function glowOff() {
            $("#container").removeClass("glowon");
            $("#container").addClass("glowoff");
        }
        function glowDestroy() {
            $("#loglow").attr("style", "visibility:hidden;");
        }
    }

    // Ajax response
    $(document).ajaxSuccess(function (e, xhr, settings) {
        if (xhr.responseText == "OK") { // Ajax success
            $("#container").addClass("success");
            $("#envelopeText").attr("style", "visibility:visible;");
        } else { // Ajax error
            ajaxError();
        }
    });

    // Ajax error
    $(document).ajaxError(function (e, jqxhr, settings, exception) {
        ajaxError();
    });
    function ajaxError() {
        $("#container").addClass("error");
        $("#envelopeText").attr("style", "visibility:visible;");
        $("#envelopeText h1").text("Error - Sorry!");
      $("#envelopeText .text").text("Message could not be sent. Please email the vendor to confirm payment.");
    }

    function alreadyConfirmed() {
        $("#container").addClass("success");
        $("#envelopeText").attr("style", "visibility:visible;");
    }


  </script>
</body>
</html>
