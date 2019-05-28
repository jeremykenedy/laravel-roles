<div class="form-group has-feedback row {{ $errors->has('model') ? ' has-error ' : '' }}">
    <label for="model" class="col-12 control-label">
        {{ trans("laravelroles::laravelroles.forms.permissions-form.permission-model.label") }}
    </label>
    <div class="col-12">
        <select name="model" id="model">
            <option value="">{{ trans("laravelroles::laravelroles.forms.permissions-form.permission-model.placeholder") }}</option>

            @foreach ($permissionModels as $permissionModel)
                <option @if ($permissionModel == $model) selected @endif value="{{ $permissionModel }}">
                    {{ $permissionModel }}
                </option>}
            @endforeach
        </select>
    </div>
    @if ($errors->has('model'))
        <div class="col-12">
            <span class="help-block">
                <strong>{{ $errors->first('model') }}</strong>
            </span>
        </div>
    @endif
</div>
