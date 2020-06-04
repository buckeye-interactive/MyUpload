@extends('layouts.dashboard')
  
@section('content')

<div class="row custom-row">

    <div class="col-md-12">

        @include('media-item.partials.edit-form', [
            'action' => route('media-item.bulk.update'),
            'title' => "Tell us about your item (this will apply to all $totalQueueSize items)",
            'hideButton' => false
        ])

    </div> <!-- col-md-12 -->

</div> <!-- row custom-row -->

@endsection