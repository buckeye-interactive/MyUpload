@extends('layouts.app')

@section('content')

    <section class='full'>

        <div class="container text-center">

 
            <h1 class='text-primary display-4 mb-2'>Welcome to My History Upload!</h1>
            <h2 class='text-primary h4 mb-5'>Help us document and preserve central Ohio’s history.</h2>

            <div class="row position-relative instruction-container text-left">
                <span class="background-image d-none d-md-block" style="background-image: url({{ asset('images/instructional-background.png') }});"></span>

                <div class="col-md-4">
                    <div class="position-relative">
                        <img class="instruction-step mb-3 mb-md-5" src="{{ asset('images/instructional-screen-1.png') }}" alt="Upload items">
                        <img class="instruction-arrow d-none d-md-inline" src="{{ asset('images/instructional-arrow.png') }}" alt="Arrow">
                        <img class="instruction-human first d-none d-md-block" src="{{ asset('images/instructional-human.png') }}" alt="Person">
                    </div>
                    <h3 class='text-primary'>Step 1:</h3>
                    <p class="mb-5"><strong>Upload your items in the box above.</strong> Upload as many images/videos/audio files as you'd like. Accepted file formats are: {{ env('UPLOAD_FILE_TYPES') }}</p>
                </div>
                <div class="col-md-4">
                    <div class="position-relative">
                        <img class="instruction-step mb-3 mb-md-5" src="{{ asset('images/instructional-screen-2.png') }}" alt="Insert metadata">
                        <img class="instruction-arrow d-none d-md-inline" src="{{ asset('images/instructional-arrow.png') }}" alt="Arrow">
                    </div>
                    <h3 class='text-primary'>Step 2:</h3>
                    <p class="mb-5"><strong>Describe your items.</strong> Remember to hit submit after you upload your items in the box. The description screen will appear for each item.</p>
                </div>
                <div class="col-md-4">
                    <div class="position-relative">
                        <img class="instruction-step mb-3 mb-md-5" src="{{ asset('images/instructional-screen-3.png') }}" alt="Submit for approval">
                        <img class="instruction-human last d-none d-md-block" src="{{ asset('images/instructional-human-2.png') }}" alt="Person">
                    </div>
                    <h3 class='text-primary'>Step 3:</h3>
                    <p class="mb-5"><strong>Submit.</strong> A librarian will review your submission and let you know when it is approved.</p>
                </div>
            </div>

            <a class="btn btn-primary btn-large px-5" href="{{ route('media-item.create') }}">Get Started</a>

        </div> <!-- container -->

    </section> <!-- full -->

@endsection
