@extends('layouts.dashboard')

@section('content')

    <div class="row custom-row">

        <div class="col-12">

            <h2 class='display-5 mb-5 d-inline-block'>{{ __('Ban Email Addresses') }}</h2>

        </div> <!-- col-12 -->

        <div class="col-12">

            <form method="POST" action="{{ route('ban.store') }}">
                @csrf

                <div class="input-group">

                    <input
                      id='email'
                      type="email"
                      class='form-control'
                      name="email"
                      placeholder="Ban new email"
                      required
                    >

                    <div class="input-group-append">
                      <button type='submit' class='btn btn-info px-3' role='button'>Ban</button>
                    </div> <!-- input-group-append -->

                </div> <!-- input-group -->
            
            </form>

        </div> <!-- col-12 -->

        <div class="col-md-12 mt-5">

        <ul class="list-group">

          @foreach($bans as $ban)

            <li class="list-group-item">
              <span>{{ $ban->email }}</span>

              <form action="{{ route('ban.destroy', [$ban->id]) }}" method="POST" class="float-right">
                @csrf
                @method('DELETE')

                <button type=submit class="btn btn-danger btn-sm">
                    <i class="fas fa-times"></i>
                </button>
              </form>
            </li>

          @endforeach
            
        </ul>

        </div> <!-- col-md-12 -->

    </div> <!-- row custom-row -->

@endsection