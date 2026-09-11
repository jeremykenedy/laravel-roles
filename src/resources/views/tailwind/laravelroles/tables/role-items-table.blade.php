@php
    $thClass       = 'px-3 py-2 text-left text-xs font-semibold uppercase tracking-wide text-gray-600 dark:text-gray-300';
    $tdClass       = 'px-3 py-2 align-middle text-gray-700 dark:text-gray-300';
    $actionBase    = 'inline-flex w-full items-center justify-center gap-1.5 rounded-md border px-2.5 py-1.5 text-xs font-medium transition focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 dark:focus-visible:ring-offset-gray-800 motion-reduce:transition-none';
    $showClass     = $actionBase.' border-sky-300 text-sky-700 hover:bg-sky-50 focus-visible:ring-sky-500 dark:border-sky-500/60 dark:text-sky-300 dark:hover:bg-sky-500/10';
    $editClass     = $actionBase.' border-gray-300 text-gray-700 hover:bg-gray-50 focus-visible:ring-gray-500 dark:border-gray-600 dark:text-gray-200 dark:hover:bg-gray-700';
@endphp

<div class="overflow-x-auto">
    <table class="min-w-full text-sm">
        <caption class="px-3 py-2 text-left text-xs text-gray-500 dark:text-gray-400">
            @if($tabletype == 'normal')
                {!! trans_choice('laravelroles::laravelroles.roles-table.caption', $items->count(), ['count' => $items->count()]) !!}
            @endif
            @if($tabletype == 'deleted')
                {!! trans_choice('laravelroles::laravelroles.roles-deleted-table.caption', $items->count(), ['count' => $items->count()]) !!}
            @endif
        </caption>
        <thead class="border-b border-gray-200 bg-gray-50 dark:border-gray-700 dark:bg-gray-900/40">
            <tr>
                <th scope="col" class="{{ $thClass }}">{!! trans('laravelroles::laravelroles.roles-table.id') !!}</th>
                <th scope="col" class="{{ $thClass }}">{!! trans('laravelroles::laravelroles.roles-table.name') !!}</th>
                <th scope="col" class="{{ $thClass }} hidden sm:table-cell">{!! trans('laravelroles::laravelroles.roles-table.desc') !!}</th>
                <th scope="col" class="{{ $thClass }}">{!! trans('laravelroles::laravelroles.roles-table.level') !!}</th>
                <th scope="col" class="{{ $thClass }} hidden md:table-cell">{!! trans('laravelroles::laravelroles.roles-table.permissons') !!}</th>
                <th scope="col" class="{{ $thClass }} hidden md:table-cell">{!! trans('laravelroles::laravelroles.roles-table.createdAt') !!}</th>
                <th scope="col" class="{{ $thClass }} hidden md:table-cell">{!! trans('laravelroles::laravelroles.roles-table.updatedAt') !!}</th>
                @if($tabletype == 'deleted')
                    <th scope="col" class="{{ $thClass }} hidden md:table-cell">{!! trans('laravelroles::laravelroles.roles-table.deletedAt') !!}</th>
                @endif
                <th scope="col" class="{{ $thClass }}" colspan="3">{!! trans('laravelroles::laravelroles.roles-table.actions') !!}</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
            @if($items->count() > 0)
                @foreach($items as $item)
                    @php $role = $tabletype == 'normal' ? $item['role'] : $item; @endphp
                    <tr class="odd:bg-white even:bg-gray-50 dark:odd:bg-gray-800 dark:even:bg-gray-900/40">
                        <td class="{{ $tdClass }}">{{ $role->id }}</td>
                        <td class="{{ $tdClass }}">{{ $role->name }}</td>
                        <td class="{{ $tdClass }} hidden sm:table-cell">{{ $role->description }}</td>
                        <td class="{{ $tdClass }}">{{ $role->level }}</td>
                        <td class="{{ $tdClass }} hidden md:table-cell">
                            @php
                                $rolePermissions = $tabletype == 'normal' ? $item['permissions'] : $role->permissions()->get();
                            @endphp
                            @if($rolePermissions->count() > 0)
                                @foreach($rolePermissions as $itemPermKey => $itemPerm)
                                    <span class="mb-1 mr-1 inline-flex items-center rounded-full bg-indigo-100 px-2 py-0.5 text-xs font-medium text-indigo-800 dark:bg-indigo-500/20 dark:text-indigo-200">
                                        {{ $itemPerm->name }}
                                    </span>
                                @endforeach
                            @else
                                <span class="inline-flex items-center rounded-full bg-gray-100 px-2 py-0.5 text-xs font-medium text-gray-700 dark:bg-gray-700 dark:text-gray-200">
                                    {!! trans('laravelroles::laravelroles.cards.none-count') !!}
                                </span>
                            @endif
                        </td>
                        <td class="{{ $tdClass }} hidden md:table-cell">{{ $role->created_at->format(trans('laravelroles::laravelroles.date-format')) }}</td>
                        <td class="{{ $tdClass }} hidden md:table-cell">{{ $role->updated_at->format(trans('laravelroles::laravelroles.date-format')) }}</td>
                        @if($tabletype == 'deleted')
                            <td class="{{ $tdClass }} hidden md:table-cell">{{ $role->deleted_at->format(trans('laravelroles::laravelroles.date-format')) }}</td>
                        @endif
                        @if($tabletype == 'normal')
                            <td class="{{ $tdClass }}">
                                <a class="{{ $showClass }}" href="{{ route('laravelroles::roles.show', $role->id) }}" title="{{ trans('laravelroles::laravelroles.tooltips.show-role') }}">
                                    {!! trans("laravelroles::laravelroles.buttons.show") !!}
                                </a>
                            </td>
                            <td class="{{ $tdClass }}">
                                <a class="{{ $editClass }}" href="{{ route('laravelroles::roles.edit', $role->id) }}" title="{{ trans('laravelroles::laravelroles.tooltips.edit-role') }}">
                                    {!! trans("laravelroles::laravelroles.buttons.edit") !!}
                                </a>
                            </td>
                            <td class="{{ $tdClass }}">
                                @include('laravelroles::laravelroles.forms.delete-sm', ['type' => 'Role', 'item' => $role])
                            </td>
                        @endif
                        @if($tabletype == 'deleted')
                            <td class="{{ $tdClass }}">
                                <a class="{{ $showClass }}" href="{{ route('laravelroles::role-show-deleted', $role->id) }}" title="{{ trans('laravelroles::laravelroles.tooltips.show-deleted-role') }}">
                                    {!! trans("laravelroles::laravelroles.buttons.show-deleted-role") !!}
                                </a>
                            </td>
                            <td class="{{ $tdClass }}">
                                @include('laravelroles::laravelroles.forms.restore-item', ['style' => 'small', 'type' => 'role', 'item' => $role])
                            </td>
                            <td class="{{ $tdClass }}">
                                @include('laravelroles::laravelroles.forms.destroy-sm', ['type' => 'Role', 'item' => $role])
                            </td>
                        @endif
                    </tr>
                @endforeach
            @else
                <tr>
                    <td class="{{ $tdClass }}" colspan="{{ $tabletype == 'deleted' ? 11 : 10 }}">
                        {!! trans("laravelroles::laravelroles.roles-table.none") !!}
                    </td>
                </tr>
            @endif
        </tbody>
    </table>
</div>
