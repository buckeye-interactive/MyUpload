@extends('layouts.common')

@section('header')

    @include('layouts.partials.header')

@endsection

@section('layout-content')
    <main role="main">
        @yield('content')
    </main>
@endsection
