@extends('layouts.app')
@section('content')
@push('styles')
    <link href="{{ asset('css/home.css') }}" type="text/css" rel="stylesheet">
@endpush
@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.maskedinput/1.4.1/jquery.maskedinput.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js" integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous"></script>
    <script src="{{ asset('js/album/album.js') }}" type="text/javascript"></script>
@endpush
<header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
    <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="https://www.moat.ai/">Moat.ai</a>
    <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <input class="form-control form-control-dark w-100" type="text" placeholder="Search" aria-label="Search">
    <ul class="navbar-nav px-3">
        <li class="nav-item text-nowrap">
        <a class="nav-link" href="{{route('logout').'?token='.JWTAuth::getToken()}}">Sign out</a>
        </li>
    </ul>
    </header>

    <div class="container-fluid">
        <div class="row">
            <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
                <div class="position-sticky pt-3">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="{{route('home').'?token='.JWTAuth::getToken()}}">
                            <span data-feather="home"></span>
                            Artist list
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="{{route('album').'?token='.JWTAuth::getToken()}}">
                            <span data-feather="file"></span>
                            Albuns
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
            
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Album</h1>
                </div>
                <div class="col-sm-4 col-md-6 col-lg-12">
                    <input type="hidden" name="token" id="token" value="{{JWTAuth::getToken()}}" />
                    <form action="{{ route('album.create')}}" name="album_form" id="album_form" method="post">
                        @csrf
                        <input type="hidden" name="album" id="album" value="{{isset($album) ? $album->id : ''}}" />
                        <div class="mb-3">
                            <label for="artist" class="form-label">Artist</label>
                            <select class="form-select" name="artist" id="artist">
                                @foreach ($artists as $artist)
                                    <option value="{{$artist['id']}}" 
                                    @if(isset($album) && ($album->artist_id == $artist['id']))  selected='selected' @endif>{{$artist['name']}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="album_name" class="form-label">Album name</label>
                            <input type="text" class="form-control" name="album_name" id="album_name" value="{{isset($album) ? $album->album_name : ''}}">
                        </div>
                        <div class="mb-3">
                            <label for="year" class="form-label">Album Year</label>
                            <input type="text" class="form-control" name="year" id="year" value="{{isset($album) ? $album->year : ''}}">
                        </div>
                        <button type="submit" class="btn btn-primary">Save album</button>
                        <button type="button" @if(!isset($album)) disabled="disabled" @endif class="btn btn-danger" id="delete_album">Delete album</button>
                    </form>
                </div>
            </main>
        </div>
    </div>
@endsection