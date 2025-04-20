<!DOCTYPE html>
<html class="bg-black">
    <head>
        <meta charset="UTF-8">
        <title>{{ $title }}</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- bootstrap 3.0.2 -->
        <link href="/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- font Awesome -->
        <link href="/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="/css/AdminLTE.css" rel="stylesheet" type="text/css" />
        <link rel="icon" type="image/png" href="/img/favicon.ico" />
    </head>
    <body class="bg-black">
        <div class="form-box" id="login-box">
            <div class="header"><div style="color: black">{{ $display_name or "" }}</div>
                @if(isset($practice_logo) && $practice_logo != "")
                    <a href="/"> {{ $practice_logo }}</a>
                @else
                    <a href="/"> <img src="/img/logo_outer.png" /></a>
                @endif
            </div>
            {{ Form::open(array('url' => '/login-process', 'files' => true)) }}
            
           
                <div class="body bg-gray">
                
                @if ( $errors->count() > 0 )
        
                    <ul>
                        @foreach( $errors->all() as $message )
                          <li>{{ $message }}</li>
                        @endforeach
                    </ul>
                @endif
                <div id="message" style="color: red;font-size: 15px;">{{ Session::get('message') }}</div> 
                <div id="message" style="color: green;font-size: 15px;">{{ Session::get('success') }}</div>
                    <div class="form-group">
                        <input type="text" name="userid" id="userid" class="form-control" placeholder="Email Address"/>
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" id="password" class="form-control" placeholder="Password"/>
                    </div>          
                    <!-- <div class="form-group">
                        <input type="checkbox" name="remember_me"/> Remember me
                    </div> -->
                </div>
                <div class="footer">                                                               
                    <button type="submit" class="btn bg-olive btn-block">Sign in</button>  
                    
                    <p><a href='/forgot-password'>I forgot my password</a></p>
                    
                    <a href='/admin-signup' class="text-center">Sign up for a free trial</a>
                </div>
            </form>

            <!-- <div class="margin text-center">
                <span>Sign in using social networks</span>
                <br/>
                <button class="btn bg-light-blue btn-circle"><i class="fa fa-facebook"></i></button>
                <button class="btn bg-aqua btn-circle"><i class="fa fa-twitter"></i></button>
                <button class="btn bg-red btn-circle"><i class="fa fa-google-plus"></i></button>
            
            </div> -->
        </div>

    </body>
</html>