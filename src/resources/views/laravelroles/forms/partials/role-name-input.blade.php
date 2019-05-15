<div class="form-group has-feedback row {{ $errors->has('name') ? ' has-error ' : '' }}">
    <label for="name" class="col-12 control-label">
        {{ trans("laravelroles::laravelroles.forms.roles-form.role-name.label") }}
    </label>
    <div class="col-12">
        <input type="text" id="name" name="name" class="form-control" value="{{ $name }}" placeholder="{{ trans('laravelroles::laravelroles.forms.roles-form.role-name.placeholder') }}">
    </div>
    @if ($errors->has('name'))
        <div class="col-12">
            <span class="help-block">
                <strong>{{ $errors->first('name') }}</strong>
            </span>
        </div>
    @endif
</div>
