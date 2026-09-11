<div class="mb-4">
    <label for="model" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
        {{ trans("laravelroles::laravelroles.forms.permissions-form.permission-model.label") }}
    </label>
    <select name="model" id="model"
        @error('model') aria-invalid="true" aria-describedby="model-error" @enderror
        class="mt-1 block w-full rounded-md border px-3 py-2 text-gray-900 shadow-sm transition focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-900 dark:text-gray-100 motion-reduce:transition-none @error('model') border-red-500 dark:border-red-500 @else border-gray-300 dark:border-gray-600 @enderror">
        <option value="">{{ trans("laravelroles::laravelroles.forms.permissions-form.permission-model.placeholder") }}</option>
        @foreach ($permissionModels as $permissionModel)
            <option @if ($permissionModel == $model) selected @endif value="{{ $permissionModel }}">
                {{ $permissionModel }}
            </option>
        @endforeach
    </select>
    @error('model')
        <p id="model-error" class="mt-1 text-sm text-red-600 dark:text-red-400">
            <strong>{{ $message }}</strong>
        </p>
    @enderror
</div>
