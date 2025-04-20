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
        <p>Please enter the passcode</p> 
        <form method="post" action="{{ url('passcode') }}/{{$key}}">
            <div class="form-group">
                <label class="sr-only" for="inputPasscode">Passcode</label>
                <input type="text" class="form-control" id="inputPasscode" name="passcode"
                placeholder="Passcode">
            </div>
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <button type="submit" class="btn btn-primary btn-block">Submit</button>
        </form>
        <footer class="page-copyright">
            <p>© <?= date('Y'); ?>. All RIGHT RESERVED.</p>
        </footer>
    </div>
</div>
<!-- End Page -->

@endsection
