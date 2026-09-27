<div class="table-responsive roles-table">
    <table class="table table-sm table-striped data-table roles-table">
        <caption class="p-1 pb-0">
            @if($tabletype == 'normal')
                {!! trans_choice('laravelroles::laravelroles.roles-table.caption', $items->count(), ['count' => $items->count()]) !!}
            @endif
            @if($tabletype == 'deleted')
                {!! trans_choice('laravelroles::laravelroles.roles-deleted-table.caption', $items->count(), ['count' => $items->count()]) !!}
            @endif
        </caption>
        <thead class="thead">
            <tr>
                <th scope="col">
                    {!! trans('laravelroles::laravelroles.roles-table.id') !!}
                </th>
                <th scope="col">
                    {!! trans('laravelroles::laravelroles.roles-table.name') !!}
                </th>
                <th scope="col" class="d-none d-sm-table-cell ">
                    {!! trans('laravelroles::laravelroles.roles-table.desc') !!}
                </th>
                <th scope="col">
                    {!! trans('laravelroles::laravelroles.roles-table.level') !!}
                </th>
                <th scope="col" class="d-none d-md-table-cell">
                    {!! trans('laravelroles::laravelroles.roles-table.permissons') !!}
                </th>
                <th scope="col" class="d-none d-md-table-cell ">
                    {!! trans('laravelroles::laravelroles.roles-table.createdAt') !!}
                </th>
                <th scope="col" class="d-none d-md-table-cell ">
                    {!! trans('laravelroles::laravelroles.roles-table.updatedAt') !!}
                </th>
                @if($tabletype == 'deleted')
                    <th scope="col" class="d-none d-md-table-cell ">
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
                            @if($tabletype == 'normal')
                                {{ $item['role']->id }}
                            @endif
                            @if($tabletype == 'deleted')
                                {{ $item->id }}
                            @endif
                        </td>
                        <td>
                            @if($tabletype == 'normal')
                                {{ $item['role']->name }}
                            @endif
                            @if($tabletype == 'deleted')
                                {{ $item->name }}
                            @endif
                        </td>
                        <td class="d-none d-sm-table-cell">
                            @if($tabletype == 'normal')
                                {{ $item['role']->description }}
                            @endif
                            @if($tabletype == 'deleted')
                                {{ $item->description }}
                            @endif
                        </td>
                        <td>
                            @if($tabletype == 'normal')
                                {{ $item['role']->level }}
                            @endif
                            @if($tabletype == 'deleted')
                                {{ $item->level }}
                            @endif
                        </td>
                        <td class="d-none d-md-table-cell">
                            @if($tabletype == 'normal')
                                @if($item['permissions']->count() > 0)
                                    @foreach($item['permissions'] as $itemPermKey => $itemPerm)
                                        <span class="badge rounded-pill bg-primary mb-1">
                                            {{ $itemPerm->name }}
                                        </span>
                                    @endforeach
                                @else
                                    <span class="badge rounded-pill bg-secondary">
                                        {!! trans('laravelroles::laravelroles.cards.none-count') !!}
                                    </span>
                                @endif
                            @endif
                            @if($tabletype == 'deleted')
                                @if($item->permissions()->count() > 0)
                                    @foreach($item->permissions()->get() as $itemPermKey => $itemPerm)
                                        <span class="badge rounded-pill bg-primary mb-1">
                                            {{ $itemPerm->name }}
                                        </span>
                                    @endforeach
                                @else
                                    <span class="badge rounded-pill bg-secondary">
                                        {!! trans('laravelroles::laravelroles.cards.none-count') !!}
                                    </span>
                                @endif
                            @endif
                        </td>
                        <td class="d-none d-md-table-cell">
                            @if($tabletype == 'normal')
                                {{ $item['role']->created_at->format(trans('laravelroles::laravelroles.date-format')) }}
                            @endif
                            @if($tabletype == 'deleted')
                                {{ $item->created_at->format(trans('laravelroles::laravelroles.date-format')) }}
                            @endif
                        </td>
                        <td class="d-none d-md-table-cell">
                            @if($tabletype == 'normal')
                                {{ $item['role']->updated_at->format(trans('laravelroles::laravelroles.date-format')) }}
                            @endif
                            @if($tabletype == 'deleted')
                                {{ $item->updated_at->format(trans('laravelroles::laravelroles.date-format')) }}
                            @endif
                        </td>
                        @if($tabletype == 'deleted')
                            <td class="d-none d-md-table-cell">
                                {{ $item->deleted_at->format(trans('laravelroles::laravelroles.date-format')) }}
                            </td>
                        @endif
                        @if($tabletype == 'normal')
                            <td>
                                <a class="btn btn-sm btn-outline-info w-100" href="{{ route('laravelroles::roles.show', $item['role']->id) }}" data-bs-toggle="tooltip" title="{{ trans('laravelroles::laravelroles.tooltips.show-role') }}">
                                    {!! trans("laravelroles::laravelroles.buttons.show") !!}
                                    <i class="fa-solid fa-eye fa-fw" aria-hidden="true"></i>
                                </a>
                            </td>
                            <td>
                                <a class="btn btn-sm btn-outline-secondary w-100" href="{{ route('laravelroles::roles.edit', $item['role']->id) }}" data-bs-toggle="tooltip" title="{{ trans('laravelroles::laravelroles.tooltips.edit-role') }}">
                                    {!! trans("laravelroles::laravelroles.buttons.edit") !!}
                                    <i class="fa-solid fa-pencil fa-fw" aria-hidden="true"></i>
                                </a>
                            </td>
                            <td>
                                @include('laravelroles::laravelroles.forms.delete-sm', ['type' => 'Role' ,'item' => $item['role']])
                            </td>
                        @endif
                        @if($tabletype == 'deleted')
                            <td>
                                <a class="btn btn-sm btn-outline-info w-100" href="{{ route('laravelroles::role-show-deleted', $item->id) }}" data-bs-toggle="tooltip" title="{{ trans('laravelroles::laravelroles.tooltips.show-deleted-role') }}">
                                    {!! trans("laravelroles::laravelroles.buttons.show-deleted-role") !!}
                                    <i class="fa-solid fa-eye fa-fw" aria-hidden="true"></i>
                                </a>
                            </td>
                            <td>
                                @include('laravelroles::laravelroles.forms.restore-item', ['style' => 'small', 'type' => 'role', 'item' => $item])
                            </td>
                            <td>
                                @include('laravelroles::laravelroles.forms.destroy-sm', ['type' => 'Role' ,'item' => $item])
                            </td>
                        @endif
                    </tr>
                @endforeach
            @else
                <tr>
                    <td>{!! trans("laravelroles::laravelroles.roles-table.none") !!}</td>
                    <td></td>
                    <td class="d-none d-sm-table-cell"></td>
                    <td class="d-none d-sm-table-cell"></td>
                    <td class="d-none d-sm-table-cell"></td>
                    <td class="d-none d-md-table-cell"></td>
                    <td class="d-none d-lg-table-cell"></td>
                    <td class="d-none d-lg-table-cell"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            @endif
        </tbody>
    </table>
</div>
