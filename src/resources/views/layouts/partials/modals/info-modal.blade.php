<div class="modal fade info-modal" id="info-modal" tabindex="-1" role="dialog" aria-labelledby="confirmModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class='h5'>
                    Please confirm to make sure all information is correct, then click submit.
                </h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <ul>
                <li>
                    <strong>Title:</strong> <span class='input' data-name='title'></span>
                </li>
                <li>
                    <strong>{{ config('myupload.description_label') }}:</strong> <span class='input' data-name='description'></span>
                </li>
                <li>
                    <strong>{{ config('myupload.author_label') }}:</strong> <span class='input' data-name='original_creator'></span>
                </li>
                @if(!config('myupload.credit_disabled'))
                <li>
                    <strong>{{ config('myupload.credit_label') }}:</strong> <span class='input' data-name='credit'></span>
                </li>
                @endif
                <li>
                    <strong>{{ config('myupload.location_label') }}:</strong> <span class='input' data-name='original_location'></span>
                </li>
                <li>
                    <strong>{{ config('myupload.date_label') }}:</strong> <span class='input' data-name='original_date'></span>
                </li>
                @if(!config('myupload.copyright_disabled'))
                <li>
                    <strong>If you own the copyright, how would you like the image to be used by people viewing the web site?</strong> <span class='input' data-name='copyright'></span>
                </li>
                <li>
                    <strong>Use Authorization:</strong> <span class='input' data-name='authorization'></span>
                </li>
                @endif
            </ul>

            <div class="mt-3 button-container d-flex flex-wrap align-items-center justify-content-center">

                <button class="btn btn-info px-4 mr-3" role='button' data-dismiss="modal">Edit</button>

                <button id='info-modal-submit' class="btn btn-primary" role='button'>Submit</button>

            </div> <!-- button-container d-flex flex-wrap align-items-center justify-content-center -->

        </div> <!-- modal-content -->
    </div> <!-- modal-dialog -->
</div> <!-- modal fade -->