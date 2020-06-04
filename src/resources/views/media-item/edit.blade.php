@extends('layouts.dashboard')
  
@section('content')

<div class="row custom-row">
    
    @if ($totalQueueSize !== 0)
    
        <div class="col-md-12 text-right mb-3">

            <span class='text-primary'>Upload {{ $completedQueueSize }}/{{ $totalQueueSize }}</span>
    
        </div> <!-- col-md-12 text-right mb-3 -->

    @endif

    <div class="col-md-6 mb-5">

        @php
            $media = $mediaItem->getMedia('media')->first();
            $type = File::extension($media->file_name);
        @endphp

        @if ($type === 'mp3')

            <audio controls>
                <source src="{{ $media->getFullUrl() }}" type="audio/ogg">
                <source src="{{ $media->getFullUrl() }}" type="audio/mpeg">
                {{ __('Your browser does not support the audio element.') }}
            </audio>
        
        @elseif ($type === 'mp4')

            <video controls>
                <source src="{{ $media->getFullUrl() }}" type="video/mp4">
                <source src="{{ $media->getFullUrl() }}" type="video/ogg">
                {{ __('Your browser does not support the video tag.') }}
            </video>

        @else

            <a href="{{ $media->getFullUrl() }}" data-toggle="lightbox">
                <img
                class='img-fluid'
                src="{{ $media->getFullUrl() }}"
                alt="{{ !empty($media->description) ? $media->description : $media->name }}">
            </a>

        @endif

    </div> <!-- col-md-6 -->

    <div class="col-md-6">

        @include('media-item.partials.edit-form', [
            'hideButton' => false
        ])

    </div> <!-- col-md-6 -->

</div> <!-- row custom-row -->

@endsection