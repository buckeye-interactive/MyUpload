@extends('layouts.dashboard')

@section('content')

    @if (Auth::user() && Auth::user()->is_admin)
        <a class="btn btn-info mb-4" href="{{route('top-five')}}" role="button">Edit Top 5 Media Items</a>
    @endif

    @if($wantedPhotos)
        <div class="row">
            <div class="top-five w-45 my-3">
                <div class="title mx-4">
                    <h1 class="h3">{{ config('myupload.wanted_items_text') }}</h1>
                </div>
                <ul>
                    @foreach ($wantedPhotos as $item)
                        
                        @if ($item)
                            
                            <li>{{ $item }}</li>

                        @endif

                    @endforeach
                </ul>
            </div> <!-- top-five -->
        </div> <!-- row -->
    @endif

    <form action="{{ route('api.media-item.store') }}" id='upload' method='POST' enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-6">
                <div class="dz-input"></div>
            </div>
            <div class="col-md-6">
                <div class="accordion" id="upload-accordion">
                    <div class="card">
                        <div class="card-header"><h5>Your Information</h5></div>
                        <div id="info-collapse" class="collapse show" aria-labelledby="info" data-parent="#upload-accordion">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for='submitted_users_name'>{{ __('Your Name*') }}</label>
                                            <input
                                                required
                                                type="text"
                                                name="submitted_users_name"
                                                id="submitted_users_name"
                                                class='form-control'
                                                value="{{ old('submitted_users_name') }}"
                                            >
                                        </div> <!-- form-group -->
                                    </div> <!-- col -->

                                    <div class="col">
                                        <div class="form-group">
                                            <label for='phone_number'>{{ __('Your Phone Number*') }}</label>
                                            <input
                                                required
                                                type="tel"
                                                name="phone_number"
                                                id="phone_number"
                                                class='form-control'
                                                value="{{ old('phone_number') }}"
                                            >
                                        </div> <!-- form-group -->
                                    </div> <!-- col -->

                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="email">Your Email Address*</label>
                                            <input type="email" name='email' class="form-control" placeholder='Email Address' required>
                                        </div> <!-- form-group -->
                                    </div> <!-- col-12 -->

                                    <div class="col-12">
                                        <small class="form-text text-muted text-center mb-3">{{ __('Note: Contact information is for staff use only.') }}</small> 
                                    </div> <!-- col -->
                                    
                                    @if(env('RECAPTCHA_SITE'))
                                        <div class="col-md-12 mb-3 text-center">
                                            <div class="g-recaptcha" data-sitekey="{{ env('RECAPTCHA_SITE') }}" data-callback="recaptcha_callback"></div>
                                        </div>
                                    @endif

                                    <button type="button" class='btn btn-primary btn-block info-submit' role='button'>Next</button>
                                </div> <!-- row -->
                            </div> <!-- card-body -->
                        </div> <!-- info-collapse -->
                    </div> <!-- card -->

                    <div class="card">
                        <div class="card-header"><h5>Upload Media</h5></div>
                        <div id="media-collapse" class="collapse" aria-labelledby="upload" data-parent="#upload-accordion">
                            <div class="card-body">
                                <div class="row">                                
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>Metadata (author, description, etc.)*</label>
                                            <label class="custom-checkbox">Submit metadata for each item individually
                                                <input 
                                                    checked
                                                    type="radio" 
                                                    name="metadata" 
                                                    id="metadata_single" 
                                                    value="single"
                                                >
                                                <span class="radio"></span>
                                            </label>
                                            <label class="custom-checkbox">Submit metadata that will be used for all items
                                                <input 
                                                    type="radio" 
                                                    name="metadata" 
                                                    id="metadata_bulk" 
                                                    value="bulk"
                                                >
                                                <span class="radio"></span>
                                            </label>
                                        </div>
                                    </div> <!-- col-12 -->

                                    <button type="button" class='btn btn-primary btn-block upload-submit' role='button'>Upload Media</button>
                                </div> <!-- row -->
                            </div> <!-- card-body -->
                        </div> <!-- info-collapse -->
                    </div> <!-- card -->
                </div> <!-- accordion -->

                <div class="title mt-3">
                    <h2 class="h3">{{ __("Instructions:") }}</h2>
                </div>
                <ol>
                    <li>Upload your items in the box on the left. Upload as many images/videos/audio files as you'd like. Accepted file formats are: <strong>{{ env('UPLOAD_FILE_TYPES') }}</strong></li>
                    <li>Describe your items. Remember to hit submit after you upload your items in the box. The description screen will appear for each item.</li>
                    <li class="mb-3">Submit. {{ config('myupload.submit_step_text') }}</li>
                    <strong>**Note: JavaScript must be enabled for this form to work.</strong>
                </ol>
            </div>
        </div>
    </form>


@endsection