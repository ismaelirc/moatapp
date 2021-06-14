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
                    <h1 class="h2">Artists list</h1>
                </div>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Artist</th>
                            <th scope="col">Twitter</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($artists as $artist)
                        <tr>
                            <td>{{ $artist['id'] }}</td>
                            <td><a href="{{route('album').'/'.JWTAuth::getToken().'/'.$artist['id']}}">{{ $artist['name'] }}</a></td>
                            <td><a href="https://twitter.com/{{ $artist['twitter'] }}">{{ $artist['twitter'] }}</a></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

            </main>
        </div>
    </div>
@endsection