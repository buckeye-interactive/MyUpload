@extends('layouts.dashboard')

@section('content')

    <div class="row custom-row">

        <div class="col-12">

            <h2 class='display-5 mb-5 d-inline-block'>{{ __('Users') }}</h2>

        </div> <!-- col-12 -->

        <div class="col-12">

            <div class="card">

                <div class="card-header">Add New Admin</div>

                <form class="card-body" method="POST" action="{{ route('user.store') }}">
                    @csrf

                    <div class="form-group">

                        <input
                            id='name'
                            name="name"
                            class='form-control'
                            placeholder="Name"
                            required
                        >

                    </div> <!-- form-group -->

                    <div class="form-group">

                        <input
                            id='email'
                            type="email"
                            class='form-control'
                            name="email"
                            placeholder="Email"
                            required
                        >

                    </div> <!-- form-group -->

                    <div class="form-group">

                        <input
                            id='password'
                            type="password"
                            class='form-control'
                            name="password"
                            placeholder="Password"
                            required
                        >

                    </div> <!-- form-group -->
                
                    <button type='submit' class='btn btn-info px-3' role='button'>Add</button>

                </form> <!-- card-body -->

            </div> <!-- card -->

        </div> <!-- col-12 -->

        <div class="col-md-12 mt-5">

            <ul class="list-group">

                @foreach($users as $user)

                    <li class="list-group-item">
                        <span>{{ $user->email }}</span>

                        <form action="{{ route('user.destroy', [$user->id]) }}" method="POST" onSubmit="return confirm('Are you sure you want to delete this user\'s account?')" class="float-right">
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