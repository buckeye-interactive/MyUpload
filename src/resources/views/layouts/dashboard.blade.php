@extends('layouts.common')

@if (Auth::user() && Auth::user()->is_admin)
    
    @section('header')
        
        @include('layouts.partials.interior-header')

    @endsection

@else

    @section('header')
        
        @include('layouts.partials.header')

    @endsection
    
@endif

@section('layout-content')
    <main role="main" class='interior-main'>
        <section class='dashboard-section'>
            <div class="container dashboard-container">
                @yield('content')
            </div>
        </section>
    </main>
@endsection
