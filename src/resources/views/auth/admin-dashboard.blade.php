@extends('layouts.dashboard')

@section('content')

    <div class="row custom-row">

        <div class="col-12">

            <h2 class='display-5 mb-5 d-inline-block'>{{ __('Pending Media') }}</h2>

        </div> <!-- col-12 -->

        @if (count($mediaItems) > 0)
            @include('media-item.partials.accordion-group', [
                'mediaItems' => $mediaItems,
                'includePreviewModal' => true,
                'admin' => true
            ])
        @else
        
            <div class="col-12">

                <p>{{ __('No media items pending approval at this time.') }}</p>

            </div> <!-- col-12 -->

        @endif

    </div> <!-- row custom-row -->

@endsection