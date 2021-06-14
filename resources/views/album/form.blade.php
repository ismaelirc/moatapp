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

@include('layouts.general')
            
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