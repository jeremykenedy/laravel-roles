@php
    if(!$level){
        $level = 0;
    }
@endphp

<div class="form-group has-feedback row {{ $errors->has('level') ? ' has-error ' : '' }}">
    <label for="level" class="col-12 control-label">
        {{ trans("laravelroles::laravelroles.forms.roles-form.role-level.label") }}
    </label>
    <div class="col-12">
        <input type="number" id="level" name="level" min="0" step="1" onkeypress="return event.charCode >= 48" class="form-control" value="{{ $level }}" placeholder="{{ trans('laravelroles::laravelroles.forms.roles-form.role-level.placeholder') }}">
    </div>
    @if ($errors->has('level'))
        <div class="col-12">
            <span class="help-block">
                <strong>{{ $errors->first('level') }}</strong>
            </span>
        </div>
    @endif
</div>
