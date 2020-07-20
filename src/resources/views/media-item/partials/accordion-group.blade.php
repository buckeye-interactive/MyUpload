<div class="accordion-group-container col-12">

    <div class="row custom-row justify-content-center align-content-start accordion-group">

        <div class="col-md-8 mb-3">

            <a href="#" class="accordion-select-all">Select all</a> / <a href="#" class="accordion-deselect-all">Deselect all</a>

            <button class="btn btn-danger float-right accordion-reject ml-2">Bulk Reject</button>
            <button class="btn btn-success float-right accordion-approve">Bulk Approve</button>

        </div> <!-- col-12 -->

        @foreach ($mediaItems as $mediaItem)

            @php
                $previousItem = null;
                $media = $mediaItem->getMedia('media')->first();
                $type = File::extension($media->file_name);
            @endphp
            
            <div class="col-md-8 mb-3 accordion-column">

                <div class="accordion" id='accordion'>

                    <div class="accordion-block">

                        <div
                        class="accordion-header bg-light align-items-center p-3"
                        id="accordion-header-{{ $mediaItem->id }}"
                        data-toggle="collapse"
                        data-target="#accordion-body-{{ $mediaItem->id }}"
                        aria-controls="accordion-body-{{ $mediaItem->id }}"
                        aria-expanded="false"
                        >

                            <input class='bulk-select' type='checkbox' value="{{ $mediaItem->id }}">

                            <h3 class='pl-3 mb-0 align-self-start'>
                                {{ $media->file_name }}
                            </h3>
                            
                            <p class='mb-0 align-self-end text-right'><i class="fas fa-chevron-down"></i></p>
        
                        </div> <!-- accordion-header bg-light p-3 -->

                        <div id="accordion-body-{{ $mediaItem->id }}" class="bg-light collapse accordion-body" aria-labelledby="accordion-header-{{ $mediaItem->id }}" data-parent="#accordion">

                            <div class="accordion-content p-3 pt-5 border-top">

                                <div class="submitter-info mb-3">
                                    <p>Submitted by: {{ $mediaItem->submitted_users_name }}</p>
                                    <p>Phone Number: {{ $mediaItem->phone_number }}</p>
                                    <p>Email: {{ $mediaItem->user_email }}</p>
                                </div>

                                @if ($includePreviewModal)

                                    <div class="button-container mb-5">

                                        @if (in_array($type, ['jpg','jpeg','png','gif','bmp','ico','mp4','mp3']))
                                            <button
                                            class="btn btn-info"
                                            data-toggle='modal'
                                            data-target='#view-modal-{{ $mediaItem->id }}'
                                            >
                                                {{ __('Preview Media') }} <i class="fas fa-eye"></i>
                                            </button>

                                        @else
                                            <a
                                            href="{{ $media->getFullUrl() }}"
                                            target="_blank"
                                            class="btn btn-info"
                                            >
                                                {{ __('Download Media') }} <i class="fas fa-download"></i>
                                            </a>
                                        @endif

                                    </div> <!-- button-container mb-5 -->

                                @endif

                                @include('media-item.partials.edit-form', [
                                    'hideButton' => true
                                ])

                                @if ($admin)
                                        
                                    <div class="button-container mt-5">

                                        <button
                                        class="btn btn-success"
                                        data-toggle='modal'
                                        data-target='#rejection-modal-{{ $mediaItem->id }}'
                                        >
                                            {{ __('Approve') }} <i class="fas fa-thumbs-up"></i>
                                        </button>

                                        <button
                                        class="btn btn-danger ml-2"
                                        data-toggle='modal'
                                        data-target='#rejection-modal-{{ $mediaItem->id . "r" }}'
                                        >
                                            {{ __('Reject') }} <i class="fas fa-thumbs-down"></i>
                                        </button>

                                    </div> <!-- button-container mt-5 -->

                                    @include('layouts.partials.modals.rejection-modal', [
                                        'id' => $mediaItem->id,
                                        'modalTitle' => 'Confirm Approval',
                                        'modalContent' => 'Are you sure you want to approve this item?',
                                        'addComment' => false,
                                        'confirmRoute' => route('admin-approve', $mediaItem->id),
                                        'confirmText' => 'Approve',
                                        'cancelText' => 'Cancel',
                                        'method' => 'PUT'
                                    ])

                                    @include('layouts.partials.modals.rejection-modal', [
                                        'id' => $mediaItem->id . "r",
                                        'modalTitle' => 'Confirm Rejection',
                                        'modalContent' => 'Are you sure you want to reject this item?',
                                        'addComment' => true,
                                        'confirmRoute' => route('admin-reject', $mediaItem->id),
                                        'confirmText' => 'Reject',
                                        'cancelText' => 'Cancel',
                                        'method' => 'PUT'
                                    ])

                                @endif

                            </div> <!-- accordion-content -->

                        </div> <!-- bg-light accordion-body -->

                    </div> <!-- accordion-block -->

                </div> <!-- accordion -->

            </div> <!-- col-md-8 mb-3 accordion-column -->
            
            @if ($includePreviewModal)
                
                @include('layouts.partials.modals.view-modal', [
                    'id' => $mediaItem->id,
                    'modalTitle' => $mediaItem->title,
                    'type' => $type,
                    'modalContent' => $media->getFullUrl(),
                    'cancelText' => 'Close'
                ])

            @endif

        @endforeach

    </div> <!-- row custom-row justify-content-center accordion-group -->

</div> <!-- accordion-group col-12 -->