<div class="modal fade rejection-modal" id="rejection-modal-{{ $id }}" tabindex="-1" role="dialog" aria-labelledby="confirmModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">{{ __($modalTitle) }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{ __($modalContent) }}
            </div>

            <div class="modal-footer">
                
                <form method="POST" action='{{ $confirmRoute }}' class='w-100'>
                    @method($method)
                    @csrf

                    @if ($addComment)
                        
                        <div class="form-group">

                            <textarea
                            name="comment"
                            id="comment"
                            class='form-control'
                            placeholder="{{ __('Reason for rejection (optional)') }}"></textarea>

                        </div> <!-- form-group -->

                    @endif

                    <div class="text-right">

                        <button
                        class="btn btn-success"
                        type='submit'
                        >
                            {{ __($confirmText) }}
                        </button>
    
                        <button
                        type="button"
                        class="btn btn-info ml-2"
                        data-dismiss="modal"
                        >
                            {{ __($cancelText) }}
                        </button>

                    </div> <!-- d-flex -->

                </form>
            </div>
        </div> <!-- modal-content -->
    </div> <!-- modal-dialog -->
</div> <!-- modal fade -->