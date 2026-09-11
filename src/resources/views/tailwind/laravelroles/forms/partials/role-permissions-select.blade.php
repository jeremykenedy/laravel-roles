<div class="mb-4">
    <label for="permissions" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
        {{ trans("laravelroles::laravelroles.forms.roles-form.role-permissions.label") }}
    </label>
    <select name="permissions[]" id="permissions" multiple size="6"
        @error('permissions') aria-invalid="true" aria-describedby="permissions-error" @enderror
        class="mt-1 block w-full rounded-md border px-3 py-2 text-gray-900 shadow-sm transition focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-900 dark:text-gray-100 motion-reduce:transition-none @error('permissions') border-red-500 dark:border-red-500 @else border-gray-300 dark:border-gray-600 @enderror">
        @foreach ($allPermissions as $permission)
            <option @if (in_array($permission->id, $rolePermissionsIds)) selected @endif value="{{ $permission }}">
                {{ $permission->name }}
            </option>
        @endforeach
    </select>
    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
        {{ trans("laravelroles::laravelroles.forms.roles-form.role-permissions.placeholder") }}
    </p>
    @error('permissions')
        <p id="permissions-error" class="mt-1 text-sm text-red-600 dark:text-red-400">
            <strong>{{ $message }}</strong>
        </p>
    @enderror
</div>
