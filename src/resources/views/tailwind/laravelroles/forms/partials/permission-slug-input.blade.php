<div class="mb-4">
    <label for="slug" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
        {{ trans("laravelroles::laravelroles.forms.permissions-form.permission-slug.label") }}
    </label>
    <input type="text" id="slug" name="slug" value="{{ $slug }}" onkeypress="return numbersAndLettersOnly()"
        placeholder="{{ trans('laravelroles::laravelroles.forms.permissions-form.permission-slug.placeholder') }}"
        @error('slug') aria-invalid="true" aria-describedby="slug-error" @enderror
        class="mt-1 block w-full rounded-md border px-3 py-2 text-gray-900 shadow-sm transition placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-900 dark:text-gray-100 dark:placeholder:text-gray-500 motion-reduce:transition-none @error('slug') border-red-500 dark:border-red-500 @else border-gray-300 dark:border-gray-600 @enderror">
    @error('slug')
        <p id="slug-error" class="mt-1 text-sm text-red-600 dark:text-red-400">
            <strong>{{ $message }}</strong>
        </p>
    @enderror
</div>
