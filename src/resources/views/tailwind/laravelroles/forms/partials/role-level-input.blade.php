@php
    if (!$level) {
        $level = 0;
    }
@endphp

<div class="mb-4">
    <label for="level" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
        {{ trans("laravelroles::laravelroles.forms.roles-form.role-level.label") }}
    </label>
    <input type="number" id="level" name="level" min="0" step="1" value="{{ $level }}"
        onkeypress="return event.charCode >= 48"
        placeholder="{{ trans('laravelroles::laravelroles.forms.roles-form.role-level.placeholder') }}"
        @error('level') aria-invalid="true" aria-describedby="level-error" @enderror
        class="mt-1 block w-full rounded-md border px-3 py-2 text-gray-900 shadow-sm transition placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-900 dark:text-gray-100 dark:placeholder:text-gray-500 motion-reduce:transition-none @error('level') border-red-500 dark:border-red-500 @else border-gray-300 dark:border-gray-600 @enderror">
    @error('level')
        <p id="level-error" class="mt-1 text-sm text-red-600 dark:text-red-400">
            <strong>{{ $message }}</strong>
        </p>
    @enderror
</div>
