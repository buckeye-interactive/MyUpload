@if (session()->has('success'))

    <div role="alert" aria-live="assertive" aria-atomic="true" class="toast auto-toast" data-autohide="true" data-delay='3000'>

        <div class="toast-header bg-success">

            <strong class="mr-auto text-white">{{ __('Success!') }}</strong>
            <button type="button" class="ml-2 mb-1 close text-white" data-dismiss="toast" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>

        </div> <!-- toast-header bg-success -->

        <div class="toast-body">
            {{ __(session()->get('success')) }}
        </div> <!-- toast-body -->

    </div> <!-- toast -->

@endif

@if (session()->has('error'))

    <div role="alert" aria-live="assertive" aria-atomic="true" class="toast auto-toast" data-autohide="true" data-delay='3000'>

        <div class="toast-header bg-danger">

            <strong class="mr-auto text-white">{{ __('Error') }}</strong>
            <button type="button" class="ml-2 mb-1 close text-white" data-dismiss="toast" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>

        </div> <!-- toast-header bg-danger -->

        <div class="toast-body">
            {{ __(session()->get('error')) }}
        </div> <!-- toast-body -->

    </div> <!-- toast -->

@endif

@if ($errors->any())

    <div role="alert" aria-live="assertive" aria-atomic="true" class="toast auto-toast" data-autohide="true" data-delay='3000'>

        <div class="toast-header bg-danger">

            <strong class="mr-auto text-white">{{ __('Error') }}</strong>
            <button type="button" class="ml-2 mb-1 close text-white" data-dismiss="toast" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>

        </div> <!-- toast-header bg-danger -->

        <div class="toast-body">
            
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ __($error) }}</li>
                @endforeach
            </ul>

        </div> <!-- toast-body -->

    </div> <!-- toast -->

@endif

<div role="alert" aria-live="assertive" aria-atomic="true" class="toast error-toast" data-autohide="true" data-delay='3000'>

    <div class="toast-header bg-danger">

        <strong class="mr-auto text-white">{{ __('Error') }}</strong>
        <button type="button" class="ml-2 mb-1 close text-white" data-dismiss="toast" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>

    </div> <!-- toast-header bg-danger -->

    <div class="toast-body">
    </div> <!-- toast-body -->

</div> <!-- toast -->