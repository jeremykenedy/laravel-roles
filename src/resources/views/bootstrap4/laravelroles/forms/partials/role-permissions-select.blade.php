<div class="form-group has-feedback row {{ $errors->has('permissions') ? ' has-error ' : '' }}">
    <label for="permissions" class="col-12 control-label">
        {{ trans("laravelroles::laravelroles.forms.roles-form.role-permissions.label") }}
    </label>
    <div class="col-12">
        <select name="permissions[]" id="permissions" multiple>
            <option value="">{{ trans("laravelroles::laravelroles.forms.roles-form.role-permissions.placeholder") }}</option>
            @foreach ($allPermissions as $permission)
                <option @if (in_array($permission->id, $rolePermissionsIds)) selected @endif value="{{ $permission }}">
                    {{ $permission->name }}
                </option>
            @endforeach
        </select>
    </div>
    @if ($errors->has('permissions'))
        <div class="col-12">
            <span class="help-block">
                <strong>{{ $errors->first('permissions') }}</strong>
            </span>
        </div>
    @endif
</div>
