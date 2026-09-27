@php
    $thClass    = 'px-3 py-2 text-left text-xs font-semibold uppercase tracking-wide text-gray-600 dark:text-gray-300';
    $tdClass    = 'px-3 py-2 align-middle text-gray-700 dark:text-gray-300';
    $actionBase = 'inline-flex w-full items-center justify-center gap-1.5 rounded-md border px-2.5 py-1.5 text-xs font-medium transition focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 dark:focus-visible:ring-offset-gray-800 motion-reduce:transition-none';
    $showClass  = $actionBase.' border-sky-300 text-sky-700 hover:bg-sky-50 focus-visible:ring-sky-500 dark:border-sky-500/60 dark:text-sky-300 dark:hover:bg-sky-500/10';
    $editClass  = $actionBase.' border-gray-300 text-gray-700 hover:bg-gray-50 focus-visible:ring-gray-500 dark:border-gray-600 dark:text-gray-200 dark:hover:bg-gray-700';
@endphp

<div class="overflow-x-auto">
    <table class="min-w-full text-sm">
        <caption class="px-3 py-2 text-left text-xs text-gray-500 dark:text-gray-400">
            @if($tabletype == 'normal')
                {!! trans_choice('laravelroles::laravelroles.permissions-table.caption', $items->count(), ['count' => $items->count()]) !!}
            @endif
            @if($tabletype == 'deleted')
                {!! trans_choice('laravelroles::laravelroles.permissions-deleted-table.caption', $items->count(), ['count' => $items->count()]) !!}
            @endif
        </caption>
        <thead class="border-b border-gray-200 bg-gray-50 dark:border-gray-700 dark:bg-gray-900/40">
            <tr>
                <th scope="col" class="{{ $thClass }}">{!! trans('laravelroles::laravelroles.permissions-table.id') !!}</th>
                <th scope="col" class="{{ $thClass }}">{!! trans('laravelroles::laravelroles.permissions-table.name') !!}</th>
                <th scope="col" class="{{ $thClass }}">{!! trans('laravelroles::laravelroles.permissions-table.slug') !!}</th>
                <th scope="col" class="{{ $thClass }} hidden sm:table-cell">{!! trans('laravelroles::laravelroles.permissions-table.desc') !!}</th>
                <th scope="col" class="{{ $thClass }} hidden md:table-cell">{!! trans('laravelroles::laravelroles.permissions-table.roles') !!}</th>
                <th scope="col" class="{{ $thClass }} hidden md:table-cell">{!! trans('laravelroles::laravelroles.permissions-table.createdAt') !!}</th>
                <th scope="col" class="{{ $thClass }} hidden md:table-cell">{!! trans('laravelroles::laravelroles.permissions-table.updatedAt') !!}</th>
                @if($tabletype == 'deleted')
                    <th scope="col" class="{{ $thClass }} hidden md:table-cell">{!! trans('laravelroles::laravelroles.permissions-table.deletedAt') !!}</th>
                @endif
                <th scope="col" class="{{ $thClass }}" colspan="3">{!! trans('laravelroles::laravelroles.permissions-table.actions') !!}</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
            @if($items->count() > 0)
                @foreach($items as $item)
                    @php $permission = $tabletype == 'normal' ? $item['permission'] : $item; @endphp
                    <tr class="odd:bg-white even:bg-gray-50 dark:odd:bg-gray-800 dark:even:bg-gray-900/40">
                        <td class="{{ $tdClass }}">{{ $permission->id }}</td>
                        <td class="{{ $tdClass }}">{{ $permission->name }}</td>
                        <td class="{{ $tdClass }}">{{ $permission->slug }}</td>
                        <td class="{{ $tdClass }} hidden sm:table-cell">{{ $permission->description }}</td>
                        <td class="{{ $tdClass }} hidden md:table-cell">
                            @php
                                $permissionRoles = $tabletype == 'normal' ? $item['roles'] : $permission->roles()->get();
                            @endphp
                            @if($permissionRoles->count() > 0)
                                @foreach($permissionRoles as $itemUserKey => $subItem)
                                    <span class="mb-1 mr-1 inline-flex items-center rounded-full bg-gray-200 px-2 py-0.5 text-xs font-medium text-gray-800 dark:bg-gray-600 dark:text-gray-100">
                                        {{ $subItem->name }}
                                    </span>
                                @endforeach
                            @else
                                <span class="inline-flex items-center rounded-full bg-gray-100 px-2 py-0.5 text-xs font-medium text-gray-700 dark:bg-gray-700 dark:text-gray-200">
                                    {!! trans('laravelroles::laravelroles.cards.none-count') !!}
                                </span>
                            @endif
                        </td>
                        <td class="{{ $tdClass }} hidden md:table-cell">{{ $permission->created_at->format(trans('laravelroles::laravelroles.date-format')) }}</td>
                        <td class="{{ $tdClass }} hidden md:table-cell">{{ $permission->updated_at->format(trans('laravelroles::laravelroles.date-format')) }}</td>
                        @if($tabletype == 'deleted')
                            <td class="{{ $tdClass }} hidden md:table-cell">{{ $permission->deleted_at->format(trans('laravelroles::laravelroles.date-format')) }}</td>
                        @endif
                        @if($tabletype == 'normal')
                            <td class="{{ $tdClass }}">
                                <a class="{{ $showClass }}" href="{{ route('laravelroles::permissions.show', $permission->id) }}" title="{{ trans('laravelroles::laravelroles.tooltips.show-permission') }}">
                                    {!! trans("laravelroles::laravelroles.buttons.show") !!}
                                    <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true" focusable="false"><path d="M10 12a2 2 0 100-4 2 2 0 000 4z" /><path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" /></svg>
                                </a>
                            </td>
                            <td class="{{ $tdClass }}">
                                <a class="{{ $editClass }}" href="{{ route('laravelroles::permissions.edit', $permission->id) }}" title="{{ trans('laravelroles::laravelroles.tooltips.edit-permission') }}">
                                    {!! trans("laravelroles::laravelroles.buttons.edit") !!}
                                    <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true" focusable="false"><path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" /></svg>
                                </a>
                            </td>
                            <td class="{{ $tdClass }}">
                                @include('laravelroles::laravelroles.forms.delete-sm', ['type' => 'Permission', 'item' => $permission])
                            </td>
                        @endif
                        @if($tabletype == 'deleted')
                            <td class="{{ $tdClass }}">
                                <a class="{{ $showClass }}" href="{{ route('laravelroles::permission-show-deleted', $permission->id) }}" title="{{ trans('laravelroles::laravelroles.tooltips.show-deleted-permission') }}">
                                    {!! trans("laravelroles::laravelroles.buttons.show-deleted-permission") !!}
                                    <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true" focusable="false"><path d="M10 12a2 2 0 100-4 2 2 0 000 4z" /><path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" /></svg>
                                </a>
                            </td>
                            <td class="{{ $tdClass }}">
                                @include('laravelroles::laravelroles.forms.restore-item', ['style' => 'small', 'type' => 'permission', 'item' => $permission])
                            </td>
                            <td class="{{ $tdClass }}">
                                @include('laravelroles::laravelroles.forms.destroy-sm', ['type' => 'Permission', 'item' => $permission])
                            </td>
                        @endif
                    </tr>
                @endforeach
            @else
                <tr>
                    <td class="{{ $tdClass }}" colspan="{{ $tabletype == 'deleted' ? 11 : 10 }}">
                        {!! trans("laravelroles::laravelroles.permissions-table.none") !!}
                    </td>
                </tr>
            @endif
        </tbody>
    </table>
</div>
