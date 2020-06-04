<div class="media-group col-12">

    <div class="d-flex align-items-start">
        <h2 class="flex-grow-1 display-5 mb-5 d-inline-block">{{ __($title) }} {{ __('Media') }}</h2>
        <div id="reportrange" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
            <i class="fa fa-calendar"></i>&nbsp;
            <span></span> <i class="fa fa-caret-down"></i>
        </div>
    </div>

    @if ($mediaItems->count() > 0)

        <div class='row custom-row image-grid'>

            @foreach ($mediaItems as $item)

                @php
                    $media = $item->getMedia('media')->first();
                    $type = File::extension($media->file_name);
                @endphp
        
                <div class="image-block col-md-3">
        
                    <div class="image">
        
                        <span
                        class="background-image {{ $type === 'mp3' ? 'mp3' : '' }}"
                        role='img'
                        aria-label='{{ !empty($item->description) ? $item->description : $media->name }}'
                        @if ($type !== 'mp3')
        
                            style='background-image: url({{ $media->getFullUrl('grid') }});'
        
                        @endif
                        ></span>
        
                        @if ($type === 'mp3')
        
                            <h3 class="type">{{ __('Audio File') }}</h3>
        
                        @endif
        
                        <div class="inner">

                            @if ($item->status === null || $item->status === \App\MediaItem::READY || $item->status === \App\MediaItem::REJECTED)

                                <div class="button-container">
        
                                    <a
                                    href="{{ route('media-item.show', $item->id) }}"
                                    class="btn btn-info"
                                    role='button'
                                    
                                    >
                                        {{__('Download') }} <i class="fas fa-file-download"></i>
                                    </a>
                
                                
                                    <a
                                    href="{{ route('media-item.edit', $item->id) }}"
                                    class="btn btn-success"
                                    role='link'>
                                        {{ __('Edit') }} <i class="fas fa-edit"></i>
                                    </a>
                
                                    <button class="btn btn-danger item-delete" data-toggle='modal' data-target='#rejection-modal-{{ $item->id }}'>
                                        {{ __('Delete') }} <i class="fas fa-trash-alt"></i>
                                    </button>
                                
                                </div> <!-- button-container -->

                            @else

                                <div class="button-container single-container">
        
                                    <a
                                    href="{{ route('media-item.show', $item->id) }}"
                                    class="btn btn-info"
                                    role='button'
                                    
                                    >
                                        {{__('Download') }} <i class="fas fa-file-download"></i>
                                    </a>                       
    
                                </div> <!-- button-container single-container -->

                            @endif
        
                        </div> <!-- inner -->
        
                    </div> <!-- image -->
        
                </div> <!-- image-block col-md-3 -->

                @if ($item->status !== \App\MediaItem::READY || $item->status === \App\MediaItem::APPROVED)
                    @include('layouts.partials.modals.rejection-modal', [
                        'id' => $item->id,
                        'modalTitle' => 'Confirm Item Deletion',
                        'addComment' => false,
                        'modalContent' => 'Are you sure you want to delete this item?',
                        'confirmRoute' => route('media-item.destroy', $item->id),
                        'confirmText' => 'Delete',
                        'cancelText' => 'Cancel',
                        'method' => 'DELETE'
                    ])
                @endif
        
            @endforeach
    
            @if ($mediaItems->count() > 0) 
                
                <div class="button-container col-12">

                    @if ($title == 'Approved')

                        <a href="{{ route('admin-export', ['start' => request()->start, 'end' => request()->end]) }}" class="btn btn-secondary mr-4" role='button'>{{ __('Export Approved Data') }}</a>

                        <a
                        href="{{ route('download-approved', ['start' => request()->start, 'end' => request()->end]) }}"
                        class="btn btn-success"
                        role='button'
                        >
                            {{__('Download Approved Media') }} <i class="fas fa-file-download"></i>
                        </a>

                    @endif

                </div> <!-- button-container col-12 -->

            @endif

        </div> <!-- row custom-row image-grid -->
    
    @else
        
        <div class="container dashboard-container">

            <div class="row custom-row">

                <div class="col-12">

                    <h5 class="w-100">{{ __('No media found.') }}</h5>

                </div> <!-- col-12 -->

            </div> <!-- row custom-row -->

        </div> <!-- container dashboard-container -->
    
    @endif

</div> <!-- media-group col-12 -->
