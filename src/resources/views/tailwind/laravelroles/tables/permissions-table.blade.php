@php
    $tableType = 'normal';
    if (isset($isDeletedPermissions)) {
        $tableItems = $deletedPermissions;
        $tableType = 'deleted';
    } else {
        $tableItems = $sortedPermissionsRolesUsers;
    }

    $menuLink = 'flex w-full items-center gap-2 px-4 py-2 text-left text-sm text-gray-700 transition hover:bg-gray-50 focus-visible:bg-gray-50 focus-visible:outline-none dark:text-gray-200 dark:hover:bg-gray-700 dark:focus-visible:bg-gray-700 motion-reduce:transition-none';
@endphp

<div class="overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm dark:border-gray-700 dark:bg-gray-800">
    <div class="border-b border-gray-200 bg-gray-50 px-4 py-3 dark:border-gray-700 dark:bg-gray-900/40">
        <div class="flex items-center justify-between gap-2">
            <span id="card_title" class="font-semibold text-gray-900 dark:text-gray-100">
                @isset($isDeletedPermissions)
                    {!! trans('laravelroles::laravelroles.titles.permissions-deleted-table') !!}
                @else
                    {!! trans('laravelroles::laravelroles.titles.permissions-table') !!}
                @endisset
            </span>
            @isset($isDeletedPermissions)
                <div x-data="{ open: false }" class="relative">
                    <button type="button" x-on:click="open = !open" :aria-expanded="open ? 'true' : 'false'" aria-haspopup="true"
                        class="inline-flex items-center rounded-md p-1.5 text-gray-600 transition hover:bg-gray-200 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500 dark:text-gray-300 dark:hover:bg-gray-700 motion-reduce:transition-none">
                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true" focusable="false">
                            <path d="M10 6a2 2 0 110-4 2 2 0 010 4zm0 6a2 2 0 110-4 2 2 0 010 4zm0 6a2 2 0 110-4 2 2 0 010 4z" />
                        </svg>
                        <span class="sr-only">{!! trans('laravelroles::laravelroles.titles.dropdown-menu-alt') !!}</span>
                    </button>
                    <div x-show="open" x-cloak x-on:click.outside="open = false" x-on:keydown.escape.window="open = false"
                        x-transition:enter="transition ease-out duration-150 motion-reduce:transition-none"
                        x-transition:enter-start="opacity-0 scale-95"
                        x-transition:enter-end="opacity-100 scale-100"
                        class="absolute right-0 z-20 mt-2 w-64 origin-top-right overflow-hidden rounded-md border border-gray-200 bg-white py-1 shadow-lg dark:border-gray-700 dark:bg-gray-800">
                        <a href="{{ route('laravelroles::roles.index') }}" class="{{ $menuLink }}">
                            <svg class="h-4 w-4 shrink-0" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true" focusable="false">
                                <path fill-rule="evenodd" d="M7.707 3.293a1 1 0 010 1.414L5.414 7H11a7 7 0 017 7v2a1 1 0 11-2 0v-2a5 5 0 00-5-5H5.414l2.293 2.293a1 1 0 11-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                            {!! trans('laravelroles::laravelroles.buttons.back-to-roles-dashboard') !!}
                        </a>
                        <hr class="my-1 border-gray-200 dark:border-gray-700">
                        @include('laravelroles::laravelroles.forms.destroy-all-permissions')
                        @include('laravelroles::laravelroles.forms.restore-all-permissions')
                    </div>
                </div>
            @else
                @if($deletedPermissionsItems->count() > 0)
                    <div x-data="{ open: false }" class="relative">
                        <button type="button" x-on:click="open = !open" :aria-expanded="open ? 'true' : 'false'" aria-haspopup="true"
                            class="inline-flex items-center rounded-md p-1.5 text-gray-600 transition hover:bg-gray-200 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500 dark:text-gray-300 dark:hover:bg-gray-700 motion-reduce:transition-none">
                            <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true" focusable="false">
                                <path d="M10 6a2 2 0 110-4 2 2 0 010 4zm0 6a2 2 0 110-4 2 2 0 010 4zm0 6a2 2 0 110-4 2 2 0 010 4z" />
                            </svg>
                            <span class="sr-only">{!! trans('laravelroles::laravelroles.titles.dropdown-menu-alt') !!}</span>
                        </button>
                        <div x-show="open" x-cloak x-on:click.outside="open = false" x-on:keydown.escape.window="open = false"
                            x-transition:enter="transition ease-out duration-150 motion-reduce:transition-none"
                            x-transition:enter-start="opacity-0 scale-95"
                            x-transition:enter-end="opacity-100 scale-100"
                            class="absolute right-0 z-20 mt-2 w-64 origin-top-right overflow-hidden rounded-md border border-gray-200 bg-white py-1 shadow-lg dark:border-gray-700 dark:bg-gray-800">
                            <a class="{{ $menuLink }}" href="{{ route('laravelroles::permissions.create') }}">
                                <svg class="h-4 w-4 shrink-0" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true" focusable="false">
                                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                                </svg>
                                {!! trans('laravelroles::laravelroles.buttons.create-new-permission') !!}
                            </a>
                            <a class="{{ $menuLink }}" href="{{ route('laravelroles::permissions-deleted') }}">
                                <svg class="h-4 w-4 shrink-0" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true" focusable="false">
                                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9z" clip-rule="evenodd" />
                                </svg>
                                {!! trans('laravelroles::laravelroles.buttons.show-deleted-permissions') !!}
                                <span class="ml-auto inline-flex items-center rounded-full bg-red-100 px-2 py-0.5 text-xs font-medium text-red-800 dark:bg-red-500/20 dark:text-red-200">
                                    {{ $deletedPermissionsItems->count() }}
                                </span>
                            </a>
                        </div>
                    </div>
                @else
                    <a class="inline-flex items-center gap-1.5 rounded-md border border-gray-300 px-2.5 py-1.5 text-xs font-medium text-gray-700 transition hover:bg-gray-50 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500 dark:border-gray-600 dark:text-gray-200 dark:hover:bg-gray-700 motion-reduce:transition-none" href="{{ route('laravelroles::permissions.create') }}">
                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true" focusable="false">
                            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                        </svg>
                        {!! trans('laravelroles::laravelroles.buttons.create-new-permission') !!}
                    </a>
                @endif
            @endisset
        </div>
    </div>
    <div>
        @include('laravelroles::laravelroles.tables.permission-items-table', ['tabletype' => $tableType, 'items' => $tableItems])
    </div>
</div>
