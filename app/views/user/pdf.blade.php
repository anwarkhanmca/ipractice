<div class="col-4">
        <h1 style="color:blue">{{ $title or "" }}</h1>
    </div>

<table border="1" style="width: 100%;margin-bottom: 20px; border-collapse: collapse;">
    <thead>
        <tr role="row">
            <th width="3%"></th>
            <th>Name</th>
            <th width="35%">Permissions</th>
            <th>Status</th>
            <th>Last Login</th>
            <th>Login this week </th></tr>
    </thead>

    <tbody role="alert" aria-live="polite" aria-relevant="all">
    @if(!empty($user_lists) && count($user_lists) > 0)
        @foreach($user_lists as $user_row)
            <tr class="odd">
                <td><input type="checkbox" value="{{$user_row->user_id}}" name="user_delete_id[]" id="user_delete_id"></td>
                <td class="sorting_1"><a href="/edit-user/{{$user_row->user_id}}">{{ $user_row->fname or ""}} {{ $user_row->lname or "" }}</a></td>


                <td class=" ">{{ $user_row->permission or "" }}</td>
                <td class=" ">
                    @if($user_row->status == 'I')
                        <a href="#" class="active_t">Inactive</a>
                    @else
                        <a href="#" class="active_t">Active</a>
                    @endif
                </td>
                <td class=" ">{{ $user_row->last_login or '' }}<!-- 1 May 2013 9:13 p.m. --></td>
                <td class=" ">{{ $user_row->login_count or '0' }}</td>
            </tr>
        @endforeach
    @endif

    </tbody>
</table>

