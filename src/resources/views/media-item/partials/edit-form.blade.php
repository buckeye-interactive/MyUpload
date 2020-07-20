@include('layouts.partials.modals.info-modal')

<form class='edit-form' action="{{ $action ?? route('media-item.update', optional($mediaItem)->id) }}" method='POST'>
    @method('PUT')
    @csrf

    <div class="row">

        <div class="col-12 mb-3">

            <h2 class="h4">
                {{ $title ?? 'Tell us about your item.' }}
                @if($previousItem)
                    <a href="#" class="previous-autofill h6">(Fill from previous item)</a>
                @endif
            </h2>

        </div> <!-- col-12 mb-3 -->

    </div> <!-- row -->

    <div class="row">
        
        <div class="col">

            <div class="form-group">

                <label for='title' class=''>{{ __('Title*') }}</label>

                <input
                    required
                    type="text"
                    name="title"
                    id="tile"
                    class='form-control'
                    value="{{ old('title', optional($mediaItem)->title) }}"
                    data-previous="{{ optional($previousItem)->title }}"
                >

            </div> <!-- form-group -->

        </div> <!-- col -->

    </div> <!-- row -->

    <div class="row">
        
        <div class="col">

            <div class="form-group date">

                <label for='original_date'>{{ __('Original Date') }}</label>

                <input
                type="text"
                class="form-control custom-date"
                name='original_date'
                value="{{ old('original_date', optional($mediaItem)->original_date) }}"
                data-previous="{{ optional($previousItem)->original_date }}"
                >
                <small class='form-text text-muted'>When was the item taken or created?</small>

            </div> <!-- form-group -->

        </div> <!-- col -->

        <div class="col">

            <div class="form-group">

                <label for='original_location'>{{ __('Original Location') }}</label>

                <input
                type="text"
                name="original_location"
                id="original_location"
                class='form-control'
                value="{{ old('original_location', optional($mediaItem)->original_location) }}"
                data-previous="{{ optional($previousItem)->original_location }}"
                >
                <small class='form-text text-muted'>Address and city if possible.</small>

            </div> <!-- form-group -->

        </div> <!-- col -->

    </div> <!-- row -->

    <div class="row">

        <div class="col">

            <div class="form-group">

                <label for='original_creator'>{{ __('Author/Creator*') }}</label>

                <input
                required
                type="text"
                name="original_creator"
                id="original_creator"
                class='form-control'
                value="{{ old('original_creator', optional($mediaItem)->original_creator) }}"
                data-previous="{{ optional($previousItem)->original_creator }}"
                >
                <small class="form-text text-muted">{{ __('Who took the photo or wrote the document?') }}</small>

            </div> <!-- form-group -->

        </div> <!-- col -->

    </div> <!-- row -->

    <div class="row">

        <div class="col">

            <div class="form-group">

                <label for='description'>{{ __('Description*') }}</label>

                <textarea
                required
                name="description"
                id="description"
                class='form-control'
                data-previous="{{ optional($previousItem)->description }}"
                >{{ old('description', optional($mediaItem)->description) }}</textarea>

                <small class='form-text text-muted'>What is this item and why is it important?</small>

            </div> <!-- form-group -->

        </div> <!-- col -->

    </div> <!-- row -->

    <div class="row">

        <div class="col-12 mb-3">

            <h2 class="h4">Permissions</h2>

        </div> <!-- col-12 mb-3 -->

    </div> <!-- row -->

    <div class="row">

        <div class="col">

            <div class="form-group">

                <label for='credit'>{{ __('Credit*') }}</label>

                <textarea
                required
                name="credit"
                id="credit"
                class='form-control'
                data-previous="{{ optional($previousItem)->credit }}"
                >{{ old('credit', optional($mediaItem)->credit) }}</textarea>
                <small class='form-text text-muted'>How would you like your name to appear on My History?</small>

            </div> <!-- form-group -->

        </div> <!-- col -->

        <div class="col">

            <div class="form-group">

                <label>Copyright*</label>

                <label class="custom-checkbox">Open to everyone to use
                    <input 
                        {{ old('copyright') === 'open' ? 'checked' : '' }} 
                        <?= optional($mediaItem)->copyright === 'open' ? 'checked' : ''; ?> 
                        <?= optional($previousItem)->copyright === 'open' ? 'data-previous-checked' : ''; ?> 
                        type="radio" 
                        name="copyright" 
                        id="copyright_open" 
                        value="open"
                    >
                    <span class="radio"></span>
                </label>
                <label class="custom-checkbox">Non-commercial use only
                    <input 
                        {{ old('copyright') === 'non-commercial' ? 'checked' : '' }} 
                        <?= optional($mediaItem)->copyright === 'non-commercial' ? 'checked' : ''; ?> 
                        <?= optional($previousItem)->copyright === 'non-commercial' ? 'data-previous-checked' : ''; ?> 
                        type="radio" 
                        name="copyright" 
                        id="copyright_nc" 
                        value="non-commercial"
                    >
                    <span class="radio"></span>
                </label>
                <label class="custom-checkbox">No re-use permitted
                    <input 
                        {{ old('copyright') === 'closed' ? 'checked' : '' }} 
                        <?= optional($mediaItem)->copyright === 'closed' ? 'checked' : ''; ?>
                        <?= optional($previousItem)->copyright === 'closed' ? 'data-previous-checked' : ''; ?>
                        type="radio" 
                        name="copyright" 
                        id="copyright_closed" 
                        value="closed"
                    >
                    <span class="radio"></span>
                </label>
                <label class="custom-checkbox">I don’t own the copyright
                    <input 
                        {{ old('copyright') === 'na' ? 'checked' : '' }} 
                        <?= optional($mediaItem)->copyright === 'na' ? 'checked' : ''; ?>
                        <?= optional($previousItem)->copyright === 'na' ? 'data-previous-checked' : ''; ?>
                        type="radio" 
                        name="copyright" 
                        id="copyright_na" 
                        value="na"
                    >
                    <span class="radio"></span>
                </label>

            </div> <!-- form-group -->

        </div> <!-- col -->

    </div> <!-- row -->

    <div class="row">

        <div class="col">

            <div class="form-group">

                <label>Use*</label>

                <label class="custom-checkbox">{{ env('USAGE_VERBIAGE') }}
                    <input <?= optional($mediaItem)->authorization ? 'checked' : ''; ?> type="checkbox" name="authorization" id="authorization" value="true">
                    <span class="checkmark"></span>
                </label>

            </div> <!-- form-group -->

        </div> <!-- col -->

    </div> <!-- row -->

    @if (!$hideButton)
        <button id='confirm-info-button' data-toggle='modal' data-target='#info-modal' class='btn btn-primary mt-2'>
            {{ __('Submit for Approval') }}
        </button>
    @else
        <input type="submit" class="btn btn-primary" value="Save Changes" />
    @endif

</form>