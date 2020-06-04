<div class="modal fade view-modal" id="view-modal-{{ $id }}" tabindex="-1" role="dialog" aria-labelledby="viewModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __($modalTitle) }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('Close') }}">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
            
                @if ($type === 'mp3')

                    <audio controls>
                        <source src="{{ __($modalContent) }}" type="audio/ogg">
                        <source src="{{ __($modalContent) }}" type="audio/mpeg">
                        {{ __('Your browser does not support the audio element.') }}
                    </audio>
                
                @elseif ($type === 'mp4')
    
                    <video controls>
                        <source src="{{ __($modalContent) }}" type="video/mp4">
                        <source src="{{ __($modalContent) }}" type="video/ogg">
                        {{ __('Your browser does not support the video tag.') }}
                    </video>
    
                @else
    
                    <img
                    class='img-fluid'
                    src="{{ __($modalContent) }}"
                    >
    
                @endif

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-info" data-dismiss="modal">{{ __($cancelText) }}</button>
            </div>
        </div> <!-- modal-content -->
    </div> <!-- modal-dialog -->
</div> <!-- modal fade -->