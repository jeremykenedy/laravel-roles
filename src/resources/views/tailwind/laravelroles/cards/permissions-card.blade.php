<div class="flex">
    <div class="flex w-full flex-col overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm dark:border-gray-700 dark:bg-gray-800">
        <div class="border-b border-gray-200 bg-gray-50 px-4 py-3 dark:border-gray-700 dark:bg-gray-900/40">
            <div class="flex items-center justify-between">
                <span id="card_title" class="font-semibold text-gray-900 dark:text-gray-100">
                    {!! trans('laravelroles::laravelroles.titles.permissions-card') !!}
                </span>
                <span class="inline-flex items-center rounded-full bg-gray-800 px-2.5 py-0.5 text-xs font-medium text-white dark:bg-gray-200 dark:text-gray-900">
                    {{ count($items) }}
                </span>
            </div>
        </div>
        <ul class="flex-1 divide-y divide-gray-200 dark:divide-gray-700">
            @if(count($items) != 0)
                @foreach($items as $itemKey => $item)
                    @php $permissionExpandable = $item['roles']->count() > 0 || $item['users']->count() > 0; @endphp
                    <li x-data="{ open: false }" class="px-4 py-3">
                        <div @if($permissionExpandable) x-on:click="open = !open" x-on:keydown.enter.prevent="open = !open" x-on:keydown.space.prevent="open = !open" role="button" tabindex="0" :aria-expanded="open ? 'true' : 'false'" title="{{ trans('laravelroles::laravelroles.tooltips.show-hide') }}" class="cursor-pointer rounded focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500" @endif>
                            <div class="flex items-center justify-between gap-2">
                                <span class="flex items-center gap-1.5 text-sm font-medium text-gray-800 dark:text-gray-200">
                                    @if($permissionExpandable)
                                        <svg class="h-3 w-3 shrink-0 transition-transform motion-reduce:transition-none" :class="open ? 'rotate-90' : ''" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true" focusable="false">
                                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                        </svg>
                                    @endif
                                    {{ $item['permission']->name }}
                                </span>
                                <div class="flex shrink-0 flex-wrap items-center justify-end gap-1">
                                    <span class="inline-flex items-center rounded-full bg-indigo-100 px-2 py-0.5 text-xs font-medium text-indigo-800 dark:bg-indigo-500/20 dark:text-indigo-200">
                                        {!! trans_choice('laravelroles::laravelroles.cards.roles-count', count($item['roles']), ['count' => count($item['roles'])]) !!}
                                    </span>
                                    <span class="inline-flex items-center rounded-full bg-gray-200 px-2 py-0.5 text-xs font-medium text-gray-800 dark:bg-gray-600 dark:text-gray-100">
                                        {!! trans_choice('laravelroles::laravelroles.cards.users-count', count($item['users']), ['count' => count($item['users'])]) !!}
                                    </span>
                                </div>
                            </div>
                        </div>
                        @if($permissionExpandable)
                            <div x-show="open" x-cloak
                                x-transition:enter="transition ease-out duration-150 motion-reduce:transition-none"
                                x-transition:enter-start="opacity-0"
                                x-transition:enter-end="opacity-100"
                                class="mt-3">
                                @if($item['roles']->count() > 0)
                                    <table class="w-full table-fixed text-xs">
                                        <caption class="pb-1 text-left text-gray-500 dark:text-gray-400">
                                            {!! trans('laravelroles::laravelroles.cards.permissions-card.permissions-table-roles-caption', ['permission' => e($item['permission']->name)]) !!}
                                        </caption>
                                        <thead>
                                            <tr class="text-left text-gray-600 dark:text-gray-300">
                                                <th class="px-1 py-1">{!! trans('laravelroles::laravelroles.cards.permissions-card.role-id') !!}</th>
                                                <th class="px-1 py-1">{!! trans('laravelroles::laravelroles.cards.permissions-card.role-name') !!}</th>
                                            </tr>
                                        </thead>
                                        <tbody class="text-gray-700 dark:text-gray-300">
                                            @foreach($item['roles'] as $itemUserKey => $itemRole)
                                                <tr class="odd:bg-gray-50 dark:odd:bg-gray-900/40">
                                                    <td class="truncate px-1 py-1">{{ $itemRole->id }}</td>
                                                    <td class="truncate px-1 py-1">{{ $itemRole->name }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @endif
                                @if($item['users']->count() > 0)
                                    <table class="mt-3 w-full table-fixed text-xs">
                                        <caption class="pb-1 text-left text-gray-500 dark:text-gray-400">
                                            {!! trans('laravelroles::laravelroles.cards.permissions-card.permissions-table-users-caption', ['permission' => e($item['permission']->name)]) !!}
                                        </caption>
                                        <thead>
                                            <tr class="text-left text-gray-600 dark:text-gray-300">
                                                <th class="px-1 py-1">{!! trans('laravelroles::laravelroles.cards.role-card.user-id') !!}</th>
                                                <th class="px-1 py-1">{!! trans('laravelroles::laravelroles.cards.role-card.user-name') !!}</th>
                                                <th class="px-1 py-1">{!! trans('laravelroles::laravelroles.cards.role-card.user-email') !!}</th>
                                            </tr>
                                        </thead>
                                        <tbody class="text-gray-700 dark:text-gray-300">
                                            @foreach($item['users'] as $itemUserKey => $itemRole)
                                                <tr class="odd:bg-gray-50 dark:odd:bg-gray-900/40">
                                                    <td class="truncate px-1 py-1">{{ $itemRole->id }}</td>
                                                    <td class="truncate px-1 py-1">{{ $itemRole->name }}</td>
                                                    <td class="truncate px-1 py-1">{{ $itemRole->email }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @endif
                            </div>
                        @endif
                    </li>
                @endforeach
            @else
                <li class="px-4 py-3 text-sm text-gray-500 dark:text-gray-400">
                    {!! trans('laravelroles::laravelroles.cards.none-count') !!}
                </li>
            @endif
        </ul>
    </div>
</div>
