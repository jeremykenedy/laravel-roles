<div class="flex">
    <div class="flex w-full flex-col overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm dark:border-gray-700 dark:bg-gray-800">
        <div class="border-b border-gray-200 bg-gray-50 px-4 py-3 dark:border-gray-700 dark:bg-gray-900/40">
            <div class="flex items-center justify-between">
                <span id="card_title" class="font-semibold text-gray-900 dark:text-gray-100">
                    {!! trans('laravelroles::laravelroles.titles.roles-card') !!}
                </span>
                <span class="inline-flex items-center rounded-full bg-gray-800 px-2.5 py-0.5 text-xs font-medium text-white dark:bg-gray-200 dark:text-gray-900">
                    {!! count($items) !!}
                </span>
            </div>
        </div>
        <ul class="flex-1 divide-y divide-gray-200 dark:divide-gray-700">
            @if(count($items) != 0)
                @foreach($items as $itemKey => $item)
                    @php
                        $slug = strtolower($item['role']['slug']);
                        if (strpos($slug, 'admin') !== false) {
                            $roleBadgeClass = 'bg-amber-100 text-amber-800 dark:bg-amber-500/20 dark:text-amber-200';
                            $roleTextClass  = 'text-amber-700 dark:text-amber-300';
                        } elseif (strpos($slug, 'man') !== false) {
                            $roleBadgeClass = 'bg-indigo-100 text-indigo-800 dark:bg-indigo-500/20 dark:text-indigo-200';
                            $roleTextClass  = 'text-indigo-700 dark:text-indigo-300';
                        } elseif (strpos($slug, 'mod') !== false) {
                            $roleBadgeClass = 'bg-gray-200 text-gray-800 dark:bg-gray-600 dark:text-gray-100';
                            $roleTextClass  = 'text-gray-700 dark:text-gray-300';
                        } elseif (strpos($slug, 'user') !== false) {
                            $roleBadgeClass = 'bg-sky-100 text-sky-800 dark:bg-sky-500/20 dark:text-sky-200';
                            $roleTextClass  = 'text-sky-700 dark:text-sky-300';
                        } elseif (strpos($slug, 'unverif') !== false) {
                            $roleBadgeClass = 'bg-red-100 text-red-800 dark:bg-red-500/20 dark:text-red-200';
                            $roleTextClass  = 'text-red-700 dark:text-red-300';
                        } else {
                            $roleBadgeClass = 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200';
                            $roleTextClass  = 'text-gray-700 dark:text-gray-300';
                        }
                        $roleExpandable = $item['users']->count() > 0 || $item['permissions']->count() > 0;
                    @endphp
                    <li x-data="{ open: false }" class="px-4 py-3">
                        <div @if($roleExpandable) x-on:click="open = !open" x-on:keydown.enter.prevent="open = !open" x-on:keydown.space.prevent="open = !open" role="button" tabindex="0" :aria-expanded="open ? 'true' : 'false'" title="{{ trans('laravelroles::laravelroles.tooltips.show-hide') }}" class="cursor-pointer focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500 rounded" @endif>
                            <div class="flex items-center justify-between gap-2">
                                <span class="flex items-center gap-1.5 text-sm text-gray-700 dark:text-gray-300">
                                    @if($roleExpandable)
                                        <svg class="h-3 w-3 shrink-0 transition-transform motion-reduce:transition-none" :class="open ? 'rotate-90' : ''" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true" focusable="false">
                                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                        </svg>
                                    @endif
                                    {!! trans('laravelroles::laravelroles.titles.role-card') !!}
                                    <strong class="{{ $roleTextClass }}">{{ $item['role']->name }}</strong>
                                </span>
                                <div class="flex shrink-0 flex-wrap items-center justify-end gap-1">
                                    <span class="inline-flex items-center rounded bg-gray-800 px-2 py-0.5 text-xs font-medium text-white dark:bg-gray-200 dark:text-gray-900">
                                        {{ trans('laravelroles::laravelroles.cards.level', ['level' => $item['role']->level]) }}
                                    </span>
                                    <span class="inline-flex items-center rounded-full px-2 py-0.5 text-xs font-medium {{ $roleBadgeClass }}">
                                        {!! trans_choice('laravelroles::laravelroles.cards.users-count', count($item['users']), ['count' => count($item['users'])]) !!}
                                    </span>
                                    <span class="inline-flex items-center rounded-full bg-indigo-100 px-2 py-0.5 text-xs font-medium text-indigo-800 dark:bg-indigo-500/20 dark:text-indigo-200">
                                        {!! trans_choice('laravelroles::laravelroles.cards.permissions-count', count($item['permissions']), ['count' => count($item['permissions'])]) !!}
                                    </span>
                                </div>
                            </div>
                        </div>
                        @if($roleExpandable)
                            <div x-show="open" x-cloak
                                x-transition:enter="transition ease-out duration-150 motion-reduce:transition-none"
                                x-transition:enter-start="opacity-0"
                                x-transition:enter-end="opacity-100"
                                class="mt-3">
                                @if($item['users']->count() > 0)
                                    <table class="w-full table-fixed text-xs">
                                        <caption class="pb-1 text-left text-gray-500 dark:text-gray-400">
                                            {!! trans('laravelroles::laravelroles.cards.role-card.table-users-caption', ['role' => e($item['role']->name)]) !!}
                                        </caption>
                                        <thead>
                                            <tr class="text-left text-gray-600 dark:text-gray-300">
                                                <th class="px-1 py-1">{!! trans('laravelroles::laravelroles.cards.role-card.user-id') !!}</th>
                                                <th class="px-1 py-1">{!! trans('laravelroles::laravelroles.cards.role-card.user-name') !!}</th>
                                                <th class="px-1 py-1">{!! trans('laravelroles::laravelroles.cards.role-card.user-email') !!}</th>
                                            </tr>
                                        </thead>
                                        <tbody class="text-gray-700 dark:text-gray-300">
                                            @foreach($item['users'] as $itemUserKey => $itemUser)
                                                <tr class="odd:bg-gray-50 dark:odd:bg-gray-900/40">
                                                    <td class="truncate px-1 py-1">{{ $itemUser->id }}</td>
                                                    <td class="truncate px-1 py-1">{{ $itemUser->name }}</td>
                                                    <td class="truncate px-1 py-1">{{ $itemUser->email }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @endif
                                @if($item['permissions']->count() > 0)
                                    <table class="mt-3 w-full table-fixed text-xs">
                                        <caption class="pb-1 text-left text-gray-500 dark:text-gray-400">
                                            {!! trans('laravelroles::laravelroles.cards.role-card.table-permissions-caption', ['role' => e($item['role']->name)]) !!}
                                        </caption>
                                        <thead>
                                            <tr class="text-left text-gray-600 dark:text-gray-300">
                                                <th class="px-1 py-1">{!! trans('laravelroles::laravelroles.cards.role-card.permissions-id') !!}</th>
                                                <th class="px-1 py-1">{!! trans('laravelroles::laravelroles.cards.role-card.permissions-name') !!}</th>
                                            </tr>
                                        </thead>
                                        <tbody class="text-gray-700 dark:text-gray-300">
                                            @foreach($item['permissions'] as $itemUserKey => $itemUser)
                                                <tr class="odd:bg-gray-50 dark:odd:bg-gray-900/40">
                                                    <td class="truncate px-1 py-1">{{ $itemUser->id }}</td>
                                                    <td class="truncate px-1 py-1">{{ $itemUser->name }}</td>
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
