@extends('layouts.dashboard')

@section('content')

    @if (Auth::user() && Auth::user()->is_admin)
        <div class="row custom-row">
            <div class="col-12">
                <h1 class="h2 display-5 mb-3 d-inline-block">
                    Top 5 Media Items
                </h1>
            </div>
            <div class="col-6">

                <label>
                    <h2 class="h5 mb-5">
                        Enter up to five media items that you are currently looking for. For example,
                        this may include audio files of speeches or pictures of early 1900s Columbus.
                    </h2>
                </label>

                <form action="{{route('add-top-five')}}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="photo_priority_one">Item One</label>
                        <input class="form-control" type="text" name="photo_priority_one" value="{{ old('photo_priority_one', $wantedPhoto->photo_priority_one) }}">
                    </div>
                    <div class="form-group">
                        <label for="photo_priority_two">Item Two</label>
                        <input class="form-control" type="text" name="photo_priority_two" value="{{ old('photo_priority_two', $wantedPhoto->photo_priority_two) }}">
                    </div>
                    <div class="form-group">
                        <label for="photo_priority_three">Item Three</label>
                        <input class="form-control" type="text" name="photo_priority_three" value="{{ old('photo_priority_three', $wantedPhoto->photo_priority_three) }}">
                    </div>
                    <div class="form-group">
                        <label for="photo_priority_four">Item Four</label>
                        <input class="form-control" type="text" name="photo_priority_four" value="{{ old('photo_priority_four', $wantedPhoto->photo_priority_four) }}">
                    </div>
                    <div class="form-group">
                        <label for="photo_priority_five">Item Five</label>
                        <input class="form-control" type="text" name="photo_priority_five" value="{{ old('photo_priority_five', $wantedPhoto->photo_priority_five) }}">
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    @endif

@endsection