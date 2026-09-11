<div class="mb-3 has-feedback row {{ $errors->has('slug') ? ' has-error ' : '' }}">
    <label for="slug" class="col-12 form-label">
        {{ trans("laravelroles::laravelroles.forms.roles-form.role-slug.label") }}
    </label>
    <div class="col-12">
        <input type="text" id="slug" name="slug" class="form-control" value="{{ $slug }}" onkeypress="return numbersAndLettersOnly()" placeholder="{{ trans('laravelroles::laravelroles.forms.roles-form.role-slug.placeholder') }}">
    </div>
    @if ($errors->has('slug'))
        <div class="col-12">
            <span class="form-text">
                <strong>{{ $errors->first('slug') }}</strong>
            </span>
        </div>
    @endif
</div>
