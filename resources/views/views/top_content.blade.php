@auth()
<form action="{{ route('board.index') }}">
    <div class="columns">
        <div class="column is-8">
            <div class="field is-fullwidth">
                <div class="control has-icons-left">
                    <input type="text" class="input" name="search" />
                    <span class="icon is-small is-left">
                        <i class="fas fa-search"></i>
                    </span>
                </div>
            </div>
        </div>

        <div class="column is-2">
            <div class="field">
                <button type="submit" class="button is-primary is-fullwidth">{{ __('app.Search') }}</button>
            </div>
        </div>

        <div class="column is-2">
            <select-new-item></select-new-item>
        </div>
    </div>
</form>
@endauth
