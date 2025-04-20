@if(isset($comments) && count($comments) >0)
  @foreach($comments as $ck=>$cv)
    <table class="singleCommentTable">
      <tr>
        <td rowspan="2" valign="top" class="listIcon"><i class="fa fa-user user-icon"></i></td>
        <td align="left"><strong>{{$cv['previewSender'] or ''}}</strong></td>
        <td align="right">{{$cv['created_format'] or ''}}</td>
      </tr>
       <tr>
        <td colspan="2">{{$cv['comment'] or ''}}</td>
      </tr>
    </table>
  @endforeach
@endif