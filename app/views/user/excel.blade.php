<table border="1" style="width: 100%;margin-bottom: 20px; border-collapse: collapse;">

<tr>

                <td><h5>Date:{{$cdate or ""}}</h5></td>
                <td>&nbsp;</td>
                <td colspan="2" height="30px" align="center"><p style="font-size: 18; text-decoration:underline; font-weight:bold;">{{strtoupper($title) }} </p></td>
                
                <td>&nbsp;</td>
</tr>

<tr>

                <td><h5>Time:		{{$ctime or ""}}</h5></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
</tr>
<tr>

                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
</tr>
<thead>
            <tr role="row">
             
                <td align="center" width="20%"><strong>Name</strong></td>
                <td align="center" width="20%" ><strong>Permissions</strong></td>
                <td align="center" width="20%"><strong>Status</strong></td>
                <td align="center" width="20%"><strong>Last Login</strong></td>
                <td align="center" width="20%"><strong>Login this week</strong></td>
               
                
            </tr>
            
            
        </thead>
    
   
    <tbody role="alert" aria-live="polite" aria-relevant="all">
    @if(!empty($user_lists) && count($user_lists) > 0)
        @foreach($user_lists as $user_row)
            <tr class="odd">
                <td align="center" width="20%" class="sorting_1">{{ $user_row->fname or ""}} {{ $user_row->lname or "" }}</td>
                <td align="center" width="20%" class=" ">{{ $user_row->permission or "" }}</td>
                <td align="center" width="20%" class=" ">
                    @if($user_row->status == 'I')
                        Inative
                    @else
                        Active
                    @endif
                </td>
                <td align="center" width="20%"  class=" ">{{ $user_row->last_login or '' }}<!-- 1 May 2013 9:13 p.m. --></td>
                <td align="center" width="20%" class=" ">{{ $user_row->login_count or '0' }}</td>
            </tr>
        @endforeach
    @endif
           
    </tbody>
</table>
