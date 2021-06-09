@extends('layouts.app')
@section('content')
@push('styles')
    <link href="{{ asset('css/form_login_register.css') }}" type="text/css" rel="stylesheet">
@endpush
@push('scripts')
    <script src="{{ asset('js/register/register.js') }}" type="text/javascript"></script>
@endpush
    <main class="form-signin">
        <form action="{{ route('register')}}" name="account_form" id="account_form" method="post">
            @csrf
            <h1 class="h3 mb-3 fw-normal text-center">Create a new acccount</h1>
            
            <div class="mb-3">
                <input type="text" class="form-control" id="full_name" name="full_name" placeholder="Your name"> 
            </div>

            <div class="mb-3">
                <input type="text" class="form-control" id="username" name="username" placeholder="Username"> 
            </div>

            <div class="mb-3">
                <input type="password" class="form-control" id="password" name="password" placeholder="Password">
            </div>

            <div class="mb-3">
                <select class="form-select" id="role" name="role">
                    <option value="0">Select a role</option>
                    <option value="1">Normal</option>
                    <option value="2">Admin</option>
                </select>
            </div>

            <div class="d-grid gap-2">
                <button class="w-100 btn btn-lg btn-primary" type="submit">Create Account</button>
                <span>Already have an account? <a href="{{route('login')}}" class="text-center">Sign in</a></span>
            </div>
            <p class="mt-5 mb-3 text-muted">&copy; 2017–2021</p>
        </form>
    </main>
@endsection