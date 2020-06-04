@extends('layouts.dashboard')

@section('content')

    <div class='row custom-row'>
            
        @include('media-item.partials.media-group', [
            'mediaItems' => $mediaItems,
            'title' => $title,
            'route' => null
        ])

    </div> <!-- row custom-row -->

@endsection
