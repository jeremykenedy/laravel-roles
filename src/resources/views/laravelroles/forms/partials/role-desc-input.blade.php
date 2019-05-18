<div class="form-group has-feedback row {{ $errors->has('description') ? ' has-error ' : '' }}">
    <label for="description" class="col-12 control-label">
        {{ trans("laravelroles::laravelroles.forms.roles-form.role-desc.label") }}
    </label>
    <div class="col-12">
        <textarea id="description" name="description" class="form-control" placeholder="{{ trans('laravelroles::laravelroles.forms.roles-form.role-desc.placeholder') }}">{{ $description }}</textarea>
    </div>
    @if ($errors->has('description'))
        <div class="col-12">
            <span class="help-block">
                <strong>{{ $errors->first('description') }}</strong>
            </span>
        </div>
    @endif
</div>
