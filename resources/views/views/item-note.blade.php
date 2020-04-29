@extends('layouts.main')

@section('content')
<div class="box content-container">
    <form action="{{ route('item.save') }}" method="POST">
        @csrf

        <input type="hidden" name="id" value="{{ $item->id }}" />
        <input type="hidden" name="item_type_id" value="{{ $item->item_type_id }}" />

        <div class="columns">
            <div class="column">
                <div class="field">
                    <label for="item-name" class="label">{{ __('app.Name') }}:</label>
                    <div class="control">
                        <input id="item-name"
                               type="text"
                               class="input @if(!$isEditable) is-static @endif"
                               name="name"
                               value="{{ $item->name }}" />
                    </div>
                </div>
            </div>

            <div class="column">
                <div class="field">
                    <label for="item-folder" class="label">{{ __('app.Folder') }}:</label>
                    <div class="control">
                        <input type="text"
                               id="item-folder"
                               class="input @if(!$isEditable) is-static @endif"
                               name="folder"
                               value="{{ $item->folder }}">
                    </div>
                </div>
            </div>
        </div>

        <div class="columns">
            <div class="column">
                <label for="item-comments" class="label">{{ __('app.Note') }}:</label>
                <textarea name="comments"
                          id="item-comments"
                          rows="5"
                          @if(!$isEditable) disabled @endif
                          class="textarea has-fixed-size">{{ $item->comments }}</textarea>
            </div>
        </div>

        <div class="has-text-right">
            <a href="{{ $prev_url }}" class="button is-primary">{{ __('app.Cancel') }}</a>
            @if(!$isEditable)
                <a href="{{ route('item.edit', $item->id) }}" class="button is-info">{{ __('app.Edit') }}</a>
            @else
                <button type="submit" class="button is-info">{{ __('app.Save') }}</button>
            @endif
        </div>
    </form>

</div>
@endsection
