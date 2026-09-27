@extends(config('roles.bladeExtended'))

@section(config('roles.titleExtended'))
    {!! trans('laravelroles::laravelroles.titles.show-permission') !!}
@endsection

@php
    if (isset($typeDeleted)) {
        $permission = $item;
        $permissionRoles = $item->roles()->get();
        $permissionUsers = collect($item['users']);
    } else {
        $permission = $item['permission'];
        $permissionRoles = $item['roles'];
        $permissionUsers = $item['users'];
    }

    $rowClass = 'flex items-center justify-between gap-3 px-4 py-3';
    $labelClass = 'text-sm text-gray-700 dark:text-gray-300';
    $valueClass = 'inline-flex items-center rounded-full bg-gray-100 px-2.5 py-0.5 text-xs font-medium text-gray-800 dark:bg-gray-700 dark:text-gray-100';
    $mutedClass = 'text-xs text-gray-500 dark:text-gray-400';
@endphp

@section(config('roles.bladePlacementCss'))
    @include('laravelroles::laravelroles.partials.styles')
    @include('laravelroles::laravelroles.partials.bs-visibility-css')
@endsection

@section('content')

    @include('laravelroles::laravelroles.partials.flash-messages')

    <div class="mx-auto w-full max-w-5xl px-4 py-6">
        <div class="overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm dark:border-gray-700 dark:bg-gray-800">
            <div class="border-b border-gray-200 bg-gray-50 px-4 py-3 dark:border-gray-700 dark:bg-gray-900/40">
                <div class="flex items-center justify-between gap-2">
                    <span id="card_title" class="font-semibold text-gray-900 dark:text-gray-100">
                        @isset($typeDeleted)
                            {!! trans('laravelroles::laravelroles.titles.show-permission-deleted', ['name' => e($permission->name)]) !!}
                        @else
                            {!! trans('laravelroles::laravelroles.titles.show-permission', ['name' => e($permission->name)]) !!}
                        @endisset
                    </span>
                    @isset($typeDeleted)
                        <a href="{{ route('laravelroles::permissions-deleted') }}" title="{{ trans('laravelroles::laravelroles.tooltips.back-permissions-deleted') }}"
                            class="inline-flex items-center gap-1.5 rounded-md border border-red-300 px-2.5 py-1.5 text-xs font-medium text-red-700 transition hover:bg-red-50 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-red-500 dark:border-red-500/60 dark:text-red-300 dark:hover:bg-red-500/10 motion-reduce:transition-none">
                            {!! trans('laravelroles::laravelroles.buttons.back-to-permissions-deleted') !!}
                        </a>
                    @else
                        <a href="{{ route('laravelroles::roles.index') }}" title="{{ trans('laravelroles::laravelroles.tooltips.back-permissions') }}"
                            class="inline-flex items-center gap-1.5 rounded-md border border-gray-300 px-2.5 py-1.5 text-xs font-medium text-gray-700 transition hover:bg-gray-50 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500 dark:border-gray-600 dark:text-gray-200 dark:hover:bg-gray-700 motion-reduce:transition-none">
                            {!! trans('laravelroles::laravelroles.buttons.back-to-permissions') !!}
                        </a>
                    @endisset
                </div>
            </div>

            <div class="px-4 py-4">
                <ul class="divide-y divide-gray-200 overflow-hidden rounded-lg border border-gray-200 dark:divide-gray-700 dark:border-gray-700">
                    <li class="{{ $rowClass }}">
                        <span class="{{ $labelClass }}">{!! trans('laravelroles::laravelroles.cards.permission-info-card.permission-id') !!}</span>
                        <span class="{{ $valueClass }}">{{ $permission->id }}</span>
                    </li>
                    <li class="{{ $rowClass }}">
                        <span class="{{ $labelClass }}">{!! trans('laravelroles::laravelroles.cards.permission-info-card.permission-name') !!}</span>
                        <span class="{{ $valueClass }}">{{ $permission->name }}</span>
                    </li>
                    <li class="{{ $rowClass }}">
                        <span class="{{ $labelClass }}">{!! trans('laravelroles::laravelroles.cards.permission-info-card.permission-slug') !!}</span>
                        <span class="{{ $valueClass }}">{{ $permission->slug }}</span>
                    </li>
                    <li class="{{ $rowClass }}">
                        <span class="{{ $labelClass }}">{!! trans('laravelroles::laravelroles.cards.permission-info-card.permission-model') !!}</span>
                        <span class="{{ $valueClass }}">{{ $permission->model }}</span>
                    </li>
                    <li class="{{ $rowClass }}">
                        <span class="{{ $labelClass }}">{!! trans('laravelroles::laravelroles.cards.permission-info-card.permission-desc') !!}</span>
                        @if($permission->description)
                            <span class="{{ $valueClass }}">{{ $permission->description }}</span>
                        @else
                            <span class="{{ $mutedClass }}">{!! trans('laravelroles::laravelroles.cards.permission-info-card.none') !!}</span>
                        @endif
                    </li>
                    <li class="{{ $rowClass }}">
                        <span class="{{ $labelClass }}">{!! trans('laravelroles::laravelroles.cards.permission-info-card.permission-roles') !!}</span>
                        @if($permissionRoles->count() > 0)
                            <div class="flex flex-wrap justify-end gap-1">
                                @foreach($permissionRoles as $itemUserKey => $itemValue)
                                    <span class="inline-flex items-center rounded-full bg-indigo-100 px-2 py-0.5 text-xs font-medium text-indigo-800 dark:bg-indigo-500/20 dark:text-indigo-200">
                                        {{ $itemValue->name }}
                                    </span>
                                @endforeach
                            </div>
                        @else
                            <span class="{{ $mutedClass }}">{!! trans('laravelroles::laravelroles.cards.none-count') !!}</span>
                        @endif
                    </li>

                    <li x-data="{ open: false }" class="px-4 py-3">
                        <div @if($permissionUsers->count() > 0) x-on:click="open = !open" x-on:keydown.enter.prevent="open = !open" role="button" tabindex="0" :aria-expanded="open ? 'true' : 'false'" title="{{ trans('laravelroles::laravelroles.tooltips.show-hide') }}" class="cursor-pointer rounded focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500" @endif>
                            <div class="flex items-center justify-between gap-3">
                                <span class="{{ $labelClass }}">{!! trans('laravelroles::laravelroles.cards.permission-info-card.permission-users') !!}</span>
                                <span class="inline-flex items-center rounded-full bg-gray-800 px-2.5 py-0.5 text-xs font-medium text-white dark:bg-gray-200 dark:text-gray-900">
                                    @if($permissionUsers->count() > 0)
                                        {!! trans_choice('laravelroles::laravelroles.cards.users-count', $permissionUsers->count(), ['count' => $permissionUsers->count()]) !!}
                                    @else
                                        {!! trans('laravelroles::laravelroles.cards.none-count') !!}
                                    @endif
                                </span>
                            </div>
                        </div>
                        @if($permissionUsers->count() > 0)
                            <div x-show="open" x-cloak
                                x-transition:enter="transition ease-out duration-150 motion-reduce:transition-none"
                                x-transition:enter-start="opacity-0"
                                x-transition:enter-end="opacity-100"
                                class="mt-3 overflow-x-auto">
                                <table class="min-w-full text-xs">
                                    <caption class="pb-1 text-left text-gray-500 dark:text-gray-400">
                                        {!! trans('laravelroles::laravelroles.cards.permissions-card.permissions-table-users-caption', ['permission' => e($permission->name)]) !!}
                                    </caption>
                                    <thead>
                                        <tr class="text-left text-gray-600 dark:text-gray-300">
                                            <th class="px-2 py-1">{!! trans('laravelroles::laravelroles.cards.role-card.user-id') !!}</th>
                                            <th class="px-2 py-1">{!! trans('laravelroles::laravelroles.cards.role-card.user-name') !!}</th>
                                            <th class="px-2 py-1">{!! trans('laravelroles::laravelroles.cards.role-card.user-email') !!}</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-gray-700 dark:text-gray-300">
                                        @foreach($permissionUsers as $itemUserKey => $itemUser)
                                            <tr class="odd:bg-gray-50 dark:odd:bg-gray-900/40">
                                                <td class="px-2 py-1">{{ $itemUser->id }}</td>
                                                <td class="px-2 py-1">{{ $itemUser->name }}</td>
                                                <td class="px-2 py-1">{{ $itemUser->email }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </li>

                    <li class="{{ $rowClass }}">
                        <span class="{{ $labelClass }}">{!! trans('laravelroles::laravelroles.cards.permission-info-card.created') !!}</span>
                        <span class="{{ $valueClass }}">{!! $permission->created_at->format(trans('laravelroles::laravelroles.date-format')) !!}</span>
                    </li>
                    <li class="{{ $rowClass }}">
                        <span class="{{ $labelClass }}">{!! trans('laravelroles::laravelroles.cards.permission-info-card.updated') !!}</span>
                        <span class="{{ $valueClass }}">{!! $permission->updated_at->format(trans('laravelroles::laravelroles.date-format')) !!}</span>
                    </li>
                    @if ($permission->deleted_at)
                        <li class="{{ $rowClass }}">
                            <span class="{{ $labelClass }}">{!! trans('laravelroles::laravelroles.cards.permission-info-card.deleted') !!}</span>
                            <span class="{{ $valueClass }}">{!! $permission->deleted_at->format(trans('laravelroles::laravelroles.date-format')) !!}</span>
                        </li>
                    @endif
                </ul>

                <div class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        @isset($typeDeleted)
                            @include('laravelroles::laravelroles.forms.restore-item', ['style' => 'large', 'type' => 'permission', 'item' => $permission])
                        @else
                            <a class="inline-flex w-full items-center justify-center gap-1.5 rounded-md bg-gray-700 px-4 py-2 text-sm font-medium text-white transition hover:bg-gray-800 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-gray-500 focus-visible:ring-offset-2 dark:bg-gray-600 dark:hover:bg-gray-500 dark:focus-visible:ring-offset-gray-800 motion-reduce:transition-none"
                                href="{{ route('laravelroles::permissions.edit', $permission->id) }}" title="{{ trans("laravelroles::laravelroles.tooltips.edit-permission") }}">
                                {!! trans("laravelroles::laravelroles.buttons.edit-larger") !!}
                                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true" focusable="false"><path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" /></svg>
                            </a>
                        @endisset
                    </div>
                    <div>
                        @isset($typeDeleted)
                            @include('laravelroles::laravelroles.forms.destroy-sm', ['large' => 'large', 'type' => 'Permission', 'item' => $permission])
                        @else
                            @include('laravelroles::laravelroles.forms.delete-sm', ['type' => 'Permission', 'item' => $permission, 'large' => true])
                        @endisset
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('laravelroles::laravelroles.modals.confirm-modal', ['formTrigger' => 'confirmDelete', 'modalClass' => 'danger'])
    @include('laravelroles::laravelroles.modals.confirm-modal', ['formTrigger' => 'confirmDestroyPermissions', 'modalClass' => 'danger'])
    @include('laravelroles::laravelroles.modals.confirm-modal', ['formTrigger' => 'confirmRestorePermissions', 'modalClass' => 'success'])

@endsection

@section(config('roles.bladePlacementJs'))
    @include('laravelroles::laravelroles.scripts.alpine')
    @include('laravelroles::laravelroles.scripts.confirm-modal')
@endsection

@yield('inline_template_linked_css')
@yield('inline_footer_scripts')
