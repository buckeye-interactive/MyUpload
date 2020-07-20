@extends('layouts.app')

@section('content')

    <section class='full'>

        <div class="container text-center">

            <h1 class='text-primary display-4 mb-2'>Thank you!</h1>
            <h2 class='display-5 mb-5'>Your item has been uploaded. You will receive an email from a librarian when your item is loaded.</h2>
            
            <div class="button-container mt-2 w-50 mx-auto d-flex align-items-center justify-content-center">

                @if (Auth::user() && Auth::user()->is_admin)

                    <a
                    href='{{ route('admin') }}'
                    class='btn btn-info btn-large mr-3'
                    role='link'
                    >
                        I'm Done
                    </a>

                @else

                    <a
                        href='{{ route('cancel') }}'
                        class='btn btn-info btn-large mr-3'
                        role='link'
                    >
                        I'm Done
                    </a>
                    
                @endif

                <a
                    href='{{ route('media-item.create') }}'
                    class='btn btn-primary btn-large'
                    role='link'
                >
                    Add More Files
                </a>

            </div> <!-- button-container mt-2 w-50 mx-auto d-flex align-items-center justify-content-center -->

        </div> <!-- container -->

    </section> <!-- full -->

@endsection