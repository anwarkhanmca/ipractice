<!DOCTYPE html>
<html class="bg-black">
    <head>
        <meta charset="UTF-8">
       <title>{{ $title }}</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- bootstrap 3.0.2 -->
        <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- font Awesome -->
        <link href="css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="css/AdminLTE.css" rel="stylesheet" type="text/css" />
        <link rel="icon" type="image/png" href="/img/favicon.ico" />
    </head>
    <body class="bg-black">

        <div class="form-box" id="login-box">

        
            <!-- <div class="header">ForgotPassword</div> -->

           <!-- <div class="header">ForgotPassword</div> -->
             <div class="header"><a href="/"> <img src="/img/logo_outer.png" /></a></div>

            {{ Form::open(array('url' => '/password-send', 'files' => true)) }}
            
            
            <!-- <form action="" method="post"> -->
                <div class="body bg-gray">
                
                <!-- @if ( $errors->count() > 0 )
        
                    <ul>
                        @foreach( $errors->all() as $message )
                          <li>{{ $message }}</li>
                        @endforeach
                    </ul>
                @endif -->
                <div id="message" style="color: green;font-size: 15px;">{{ Session::get('message') }}</div> 
                <div id="message" style="color: red;font-size: 15px;">{{ Session::get('message_error') }}</div> 
                    <div class="form-group">
                        <input type="text" name="userid" id="userid" class="form-control" placeholder="Email Address"/>
                    </div>
                            
                   
                </div>
                <div class="footer">                                                               
                   <button type="submit" class="btn bg-olive btn-block">Send</button>  
                    
                   
                    
                    <a style="display:none" href='/login' class="text-center">Click Here To LOGIN !!</a>
                    
                    @if(Session::get('message'))
                             <a href='/login' class="text-center">Click Here To LOGIN !!</a>
                             @endif
                    
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