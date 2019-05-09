<div class="table-responsive permissions-table">
    <table class="table table-sm table-striped data-table permissions-table">
        <caption class="p-1 pb-0">
            {!! trans_choice('laravelroles::laravelroles.permissions-table.caption', $items->count(), ['count' => $items->count()]) !!}
        </caption>
        <thead class="thead">
            <tr>
                <th scope="col">
                    {!! trans('laravelroles::laravelroles.permissions-table.id') !!}
                </th>
                <th scope="col">
                    {!! trans('laravelroles::laravelroles.permissions-table.name') !!}
                </th>
                <th scope="col">
                    {!! trans('laravelroles::laravelroles.permissions-table.slug') !!}
                </th>
                <th scope="col" class="hidden-xs">
                    {!! trans('laravelroles::laravelroles.permissions-table.desc') !!}
                </th>
                <th scope="col" class="hidden-xs hidden-sm">
                    {!! trans('laravelroles::laravelroles.permissions-table.roles') !!}
                </th>
                <th scope="col" class="hidden-xs hidden-sm ">
                    {!! trans('laravelroles::laravelroles.permissions-table.createdAt') !!}
                </th>
                <th scope="col" class="hidden-xs hidden-sm ">
                    {!! trans('laravelroles::laravelroles.permissions-table.updatedAt') !!}
                </th>
                @if($tabletype == 'deleted')
                    <th scope="col" class="hidden-xs hidden-sm ">
                        {!! trans('laravelroles::laravelroles.permissions-table.deletedAt') !!}
                    </th>
                @endif
                <th class="no-search no-sort " colspan="3">
                    {!! trans('laravelroles::laravelroles.permissions-table.actions') !!}
                </th>
            </tr>
        </thead>
        <tbody class="permissions-table-body">
            @if($items->count() > 0)
                @foreach($items as $item)
                    <tr>
                        <td>
                            {{ $item['permission']->id }}
                        </td>
                        <td>
                            {{ $item['permission']->name }}
                        </td>
                        <td>
                            {{ $item['permission']->slug }}
                        </td>
                        <td class="hidden-xs">
                            {{ $item['permission']->description }}
                        </td>
                        <td class="hidden-xs hidden-sm">
                            @if($item['roles']->count() > 0)
                                @foreach($item['roles'] as $itemUserKey => $itemUser)
                                    <span class="badge badge-pill badge-secondary mb-1">
                                        {{ $itemUser->name }}
                                    </span>
                                @endforeach
                            @else
                                <span class="badge badge-pill badge-default">
                                    {!! trans('laravelroles::laravelroles.cards.none-count') !!}
                                </span>
                            @endif
                        </td>
                        <td class="hidden-xs hidden-sm">
                            {{ $item['permission']->created_at->format(trans('laravelroles::laravelroles.date-format')) }}
                        </td>
                        <td class="hidden-xs hidden-sm">
                            {{ $item['permission']->updated_at->format(trans('laravelroles::laravelroles.date-format')) }}
                        </td>
                        @if($tabletype == 'deleted')
                            <td class="hidden-xs hidden-sm">
                                {{ $item['permission']->deleted_at->format(trans('laravelroles::laravelroles.date-format')) }}
                            </td>
                        @endif
                        @if($tabletype == 'normal')
                            <td>
                                <a class="btn btn-sm btn-outline-info btn-block" href="{{ route('laravelroles::permissions.show', $item['permission']->id) }}" data-toggle="tooltip" title="{{ trans('laravelroles::laravelroles.tooltips.show-permission') }}">
                                    {!! trans("laravelroles::laravelroles.buttons.show") !!}
                                </a>
                            </td>
                            <td>
                                <a class="btn btn-sm btn-outline-secondary btn-block" href="{{ route('laravelroles::permissions.edit', $item['permission']->id) }}" data-toggle="tooltip" title="{{ trans('laravelroles::laravelroles.tooltips.edit-permission') }}">
                                    {!! trans("laravelroles::laravelroles.buttons.edit") !!}
                                </a>
                            </td>
                            <td>
                                @include('laravelroles::laravelroles.forms.delete-sm', ['type' => 'Permission' ,'item' => $item['permission']])
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
                    <td>{!! trans("laravelroles::laravelroles.permissions-table.none") !!}</td>
                    <td></td>
                    <td></td>
                    <td class="hidden-xs"></td>
                    <td class="hidden-xs hidden-sm"></td>
                    <td class="hidden-xs hidden-sm"></td>
                    <td class="hidden-xs hidden-sm"></td>
                    @if($tabletype == 'deleted')
                        <td class="hidden-sm hidden-xs"></td>
                    @endif
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            @endif
        </tbody>
    </table>
</div>
