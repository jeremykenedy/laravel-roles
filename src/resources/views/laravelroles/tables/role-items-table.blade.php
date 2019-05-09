<div class="table-responsive roles-table">
    <table class="table table-sm table-striped data-table roles-table">
        <caption class="p-1 pb-0">
            {!! trans_choice('laravelroles::laravelroles.roles-table.caption', $items->count(), ['count' => $items->count()]) !!}
        </caption>
        <thead class="thead">
            <tr>
                <th scope="col">
                    {!! trans('laravelroles::laravelroles.roles-table.id') !!}
                </th>
                <th scope="col">
                    {!! trans('laravelroles::laravelroles.roles-table.name') !!}
                </th>
                <th scope="col" class="hidden-xs ">
                    {!! trans('laravelroles::laravelroles.roles-table.desc') !!}
                </th>
                <th scope="col">
                    {!! trans('laravelroles::laravelroles.roles-table.level') !!}
                </th>
                <th scope="col" class="hidden-xs hidden-sm">
                    {!! trans('laravelroles::laravelroles.roles-table.permissons') !!}
                </th>
                <th scope="col" class="hidden-xs hidden-sm ">
                    {!! trans('laravelroles::laravelroles.roles-table.createdAt') !!}
                </th>
                <th scope="col" class="hidden-xs hidden-sm ">
                    {!! trans('laravelroles::laravelroles.roles-table.updatedAt') !!}
                </th>
                @if($tabletype == 'deleted')
                    <th scope="col" class="hidden-xs hidden-sm ">
                        {!! trans('laravelroles::laravelroles.roles-table.deletedAt') !!}
                    </th>
                @endif
                <th class="no-search no-sort " colspan="3">
                    {!! trans('laravelroles::laravelroles.roles-table.actions') !!}
                </th>
            </tr>
        </thead>
        <tbody class="roles-table-body">
            @if($items->count() > 0)
                @foreach($items as $item)
                    <tr>
                        <td>
                            {{ $item['role']->id }}
                        </td>
                        <td>
                            {{ $item['role']->name }}
                        </td>
                        <td class="hidden-xs">
                            {{ $item['role']->description }}
                        </td>
                        <td>
                            {{ $item['role']->level }}
                        </td>
                        <td class="hidden-xs hidden-sm">
                            @if($item['permissions']->count() > 0)
                                @foreach($item['permissions'] as $itemPermKey => $itemPerm)
                                    <span class="badge badge-pill badge-primary mb-1">
                                        {{ $itemPerm->name }}
                                    </span>
                                @endforeach
                            @else
                                <span class="badge badge-pill badge-default">
                                    {!! trans('laravelroles::laravelroles.cards.none-count') !!}
                                </span>
                            @endif
                        </td>
                        <td class="hidden-xs hidden-sm">
                            {{ $item['role']->created_at->format(trans('laravelroles::laravelroles.date-format')) }}
                        </td>
                        <td class="hidden-xs hidden-sm">
                            {{ $item['role']->updated_at->format(trans('laravelroles::laravelroles.date-format')) }}
                        </td>
                        @if($tabletype == 'deleted')
                            <td class="hidden-xs hidden-sm">
                                {{ $item['role']->deleted_at->format(trans('laravelroles::laravelroles.date-format')) }}
                            </td>
                        @endif
                        @if($tabletype == 'normal')
                            <td>
                                <a class="btn btn-sm btn-outline-info btn-block" href="{{ route('laravelroles::roles.show', $item['role']->id) }}" data-toggle="tooltip" title="{{ trans('laravelroles::laravelroles.tooltips.show-role') }}">
                                    {!! trans("laravelroles::laravelroles.buttons.show") !!}
                                </a>
                            </td>
                            <td>
                                <a class="btn btn-sm btn-outline-secondary btn-block" href="{{ route('laravelroles::roles.edit', $item['role']->id) }}" data-toggle="tooltip" title="{{ trans('laravelroles::laravelroles.tooltips.edit-role') }}">
                                    {!! trans("laravelroles::laravelroles.buttons.edit") !!}
                                </a>
                            </td>
                            <td>
                                @include('laravelroles::laravelroles.forms.delete-sm', ['type' => 'Role' ,'item' => $item['role']])
                            </td>
                        @endif
                        @if($tabletype == 'deleted')
                            <td>Show :: TODO</td>
                            <td>Restore :: TODO</td>
                            <td>Destroy :: TODO</td>
                        @endif
                    </tr>
                @endforeach
            @else
                <tr>
                    <td>{!! trans("laravelroles::laravelroles.roles-table.none") !!}</td>
                    <td></td>
                    <td class="hidden-xs"></td>
                    <td class="hidden-xs"></td>
                    <td class="hidden-xs"></td>
                    <td class="hidden-sm hidden-xs"></td>
                    <td class="hidden-sm hidden-xs hidden-md"></td>
                    <td class="hidden-sm hidden-xs hidden-md"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            @endif
        </tbody>
    </table>
</div>
