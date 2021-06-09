@extends('layouts.app')
@section('content')
@push('styles')
    <link href="{{ asset('css/form_login_register.css') }}" type="text/css" rel="stylesheet">
@endpush
    <main class="form-signin">
        <form action="#" name="login-form" id="login-form" method="post">
            <h1 class="h3 mb-3 fw-normal text-center">Please sign in</h1>
            
            <div class="mb-3">
                <input type="text" class="form-control" id="username" name="username" placeholder="Your user name"> 
            </div>

            <div class="mb-3">
                <input type="password" class="form-control" id="password" name="password" placeholder="Password">
            </div>

            <div class="d-grid gap-2">
                <button class="w-100 btn btn-lg btn-primary" type="button">Sign in</button>
                <span>Don't have an account? <a href="{{ route('register')}}" class="text-center">Sign up</a></span>
            </div>
            <p class="mt-5 mb-3 text-muted">&copy; 2017–2021</p>
        </form>
    </main>
@endsection