<div class="table-responsive roles-table">
    <table class="table table-sm table-striped data-table">
        <caption id="roles_count">
            {!! trans_choice('laravelroles::laravelroles.roles-table.caption', $roles->count(), ['count' => $roles->count()]) !!}
        </caption>
        <thead class="thead">
            <tr>
                <th scope="col">
                    {!! trans('laravelroles::laravelroles.roles-table.id') !!}
                </th>
                <th scope="col">
                    {!! trans('laravelroles::laravelroles.roles-table.name') !!}
                </th>
                <th scope="col" class="hidden-xs">
                    {!! trans('laravelroles::laravelroles.roles-table.desc') !!}
                </th>
                <th scope="col">
                    {!! trans('laravelroles::laravelroles.roles-table.level') !!}
                </th>
                <th scope="col" class="hidden-xs hidden-sm">
                    {!! trans('laravelroles::laravelroles.roles-table.createdAt') !!}
                </th>
                <th scope="col" class="hidden-xs hidden-sm">
                    {!! trans('laravelroles::laravelroles.roles-table.updatedAt') !!}
                </th>
                @if($tabletype == 'deleted')
                    <th scope="col" class="hidden-xs hidden-sm">
                        {!! trans('laravelroles::laravelroles.roles-table.deletedAt') !!}
                    </th>
                @endif
                <th class="no-search no-sort" colspan="3">
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
                            {{ $item['role']->created_at }}
                        </td>
                        <td class="hidden-xs hidden-sm">
                            {{ $item['role']->updated_at }}
                        </td>
                        @if($tabletype == 'deleted')
                            <td class="hidden-xs hidden-sm">
                                {{ $item['role']->deleted_at }}
                            </td>
                        @endif

                        <td>
                            @if($tabletype == 'normal')
                                // Normal Actions
                            @endif
                            @if($tabletype == 'deleted')
                                // Deleted Actions
                            @endif
                        </td>
                        <td></td>

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
