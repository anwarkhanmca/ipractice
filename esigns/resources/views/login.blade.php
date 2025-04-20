@extends('layouts.master')

@section('content')

<!-- Page -->
<div class="page animsition vertical-align text-center" data-animsition-in="fade-in"
data-animsition-out="fade-out">
    <div class="page-content vertical-align-middle">
        <div class="brand">
            <!--<img class="brand-img" src="./assets/images/logo.png" alt="...">-->
            <a href="{{ asset('/') }}"><img class="brand-img" src="{{ asset('assets/images/logo.png') }}" alt="I Practice !"></a> 
        </div>
        <p>Sign into your account</p>
                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <strong>Whoops!</strong> There were some problems with your input.<br><br>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ url('/auth/login') }}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-group">
                            <label class="sr-only" for="inputEmail">Email</label>
                            <input type="email" class="form-control" id="inputEmail" name="email" placeholder="Email"  value="{{ old('email') }}">
                        </div>
                        <div class="form-group">
                            <label class="sr-only" for="inputPassword">Password</label>
                            <input type="password" class="form-control" id="inputPassword" name="password"
                            placeholder="Password">
                        </div>

                        <div class="form-group clearfix">
                            <div class="checkbox-custom checkbox-inline pull-left">
                                <input type="checkbox" id="inputCheckbox" name="remember">
                                <label for="inputCheckbox">Remember me</label>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Sign in</button>
                    </form>
                <footer class="page-copyright">
                    <p>© <?= date('Y'); ?>. All RIGHT RESERVED.</p>
                </footer>
            </div>
        </div>
<!-- End Page -->

@endsection
