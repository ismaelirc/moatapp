@extends('layouts.app')
@section('content')
@push('styles')
    <link href="{{ asset('css/login.css') }}" type="text/css" rel="stylesheet">
@endpush
@push('scripts')
    <script src="{{ asset('js/login/login.js') }}" type="text/javascript"></script>
@endpush
    <main class="form-signin">
        <form action="{{ route('login')}}" name="login_form" id="login_form" method="post">
            @csrf
            <h1 class="h3 mb-3 fw-normal text-center">Please sign in</h1>
            
            <div class="mb-3">
                <input type="text" class="form-control" id="username" name="username" placeholder="Your username"> 
            </div>

            <div class="mb-3">
                <input type="password" class="form-control" id="password" name="password" placeholder="Password">
            </div>

            <div class="d-grid gap-2">
                <button class="w-100 btn btn-lg btn-primary" type="submit">Sign in</button>
                <span>Don't have an account? <a href="{{ route('register')}}" class="text-center">Sign up</a></span>
            </div>
            <p class="mt-5 mb-3 text-muted">&copy; 2017–2021</p>
        </form>
    </main>
@endsection