@extends('layouts.app')
@section('content')
@push('styles')
    <link href="{{ asset('css/home.css') }}" type="text/css" rel="stylesheet">
@endpush
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js" integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous"></script>
    <script src="{{ asset('js/home/home.js') }}" type="text/javascript"></script>
@endpush
@include('layouts.general')
            
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Albuns list</h1>
                </div>
                <div class="col-md-12">
                    <a href="{{route('album.new').'?token='.JWTAuth::getToken()}}" class="btn btn-primary">New Album</a>
                </div>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Album name</th>
                            <th scope="col">Artist name</th>
                            <th scope="col">Year</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($albums as $album)
                        <tr>
                            <td>{{ $album->id }}</td>
                            <td><a href="{{ route('album.edit',['id' => $album->id, 'token' => JWTAuth::getToken()])}}">{{ $album->album_name }}</a></td>
                            <td>{{ $album->artist_name }}</td>
                            <td>{{ $album->year }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                   
                </table>

            </main>
        </div>
    </div>
@endsection