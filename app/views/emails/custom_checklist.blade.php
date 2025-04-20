<div style="width: 100%;">
  <div style="width: 100%;font-size: 20px; margin-bottom: 10px;">{{ $check_name }}</div>
  <div style="width: 100%; font-size: 22px; color: gray;border-bottom: 1px solid #ccc; padding-bottom: 20px;">Today at {{ date('H:i') }}</div>

  <h1>Hello, </h1>
  <p>{{ $notes or '' }}</p>
  <br> 
  <div><a href="{{ $attachment }}" target="_blank" style="font-size: 18px;color: #00acd6" download>Download Attachment</a></div>
  <br>
  <div style="width: 100%;font-size: 20px; margin-bottom: 10px;">Please click on the link below to update the task status</div>
  <div><a href="{{ $link }}" target="_blank" style="font-size: 20px;color: #00acd6; margin-bottom: 10px;">Please click here</a></div>

  <br /><br />
  <div style="width: 100%;font-size: 25px;">Regards,</di>
<br />
  <div style="width: 100%;font-size: 25px; margin-bottom: 10px;">{{ $practice_name or '' }}</div>
</div>
