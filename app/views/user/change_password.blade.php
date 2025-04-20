<!DOCTYPE html>
<html class="bg-black">
    <head>
        <meta charset="UTF-8">
        <title>{{ $title }}</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- bootstrap 3.0.2 -->
        <link href="{{ URL :: asset('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- font Awesome -->
        <link href="{{ URL :: asset('css/font-awesome.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="{{ URL :: asset('css/AdminLTE.css') }}" rel="stylesheet" type="text/css" />

    </head>
    <body class="bg-black">
    
        <div class="form-box" id="login-box">
            <!-- <div class="header">{{ $title }}</div> -->
            <div class="header"><a href="/"> <img src="/img/logo_outer.png" /></a></div>
            {{ Form::open(array('url' => '/create-password-process', 'files' => true)) }}
            <input type="hidden" name="user_id" value="{{ $user_id }}">
            
            <!-- <form action="" method="post"> -->
                <div class="body bg-gray">
                    <div style="color: red;font-size: 15px;">
                    @if ( $errors->count() > 0 )
                        <ul>
                            @foreach( $errors->all() as $message )
                              <li>{{ $message }}</li>
                            @endforeach
                        </ul>
                    @endif
                </div>

                <div style="color: green;font-size: 15px;">{{ Session::get('message') }}</div> 
                
                    <div class="form-group">
                        <input type="password" name="password" id="password" class="form-control" placeholder="Password"/>
                    </div>
                    <div class="form-group">
                        <input type="password" name="con_pass" id="con_pass" class="form-control" placeholder="Confirm Password"/>
                    </div>           
                    
                </div>
                <div class="footer">                                                               
                    <button type="submit" class="btn bg-olive btn-block">Save</button>
                </div>
            {{ Form::close() }}

           
        </div>

    </body>
</html>