<div class="col-sm-6 mb-4 d-flex">
    <div class="card">
        <div class="card-header bg-default">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <span id="card_title">
                    {!! trans('laravelroles::laravelroles.titles.permissions-card') !!}
                </span>
                <span class="badge badge-pill badge-dark">
                    {{ count($items) }}
                </span>
            </div>
        </div>
        <div class="flex-fill">
            <ul class="list-group list-group-flush">
                @if(count($items) != 0)
                    @foreach($items as $itemKey => $item)
                        <li id="accordion_permissions_{{ $itemKey }}" class="list-group-item accordion @if($item['roles']->count() > 0 || $item['users']->count() > 0) list-group-item-action accordion-item collapsed @endif" data-toggle="collapse" href="#collapse_permissions_{{ $itemKey }}">

                            <div class="d-flex justify-content-between align-items-center" @if($item['roles']->count() > 0 || $item['users']->count() > 0) data-toggle="tooltip" title="{{ trans("laravelroles::laravelroles.tooltips.show-hide") }}" @endif>
                                <span class="badge badge-light permission-name">
                                    {{ $item['permission']->name }}
                                </span>
                                <div>
                                    <span class="badge badge-primary badge-pill">
                                        {!! trans_choice('laravelroles::laravelroles.cards.roles-count', count($item['roles']), ['count' => count($item['roles'])]) !!}
                                    </span>
                                    <span class="badge badge-secondary badge-pill">
                                        {!! trans_choice('laravelroles::laravelroles.cards.users-count', count($item['users']), ['count' => count($item['users'])]) !!}
                                    </span>
                                </div>
                            </div>


                            @if($item['roles']->count() > 0 || $item['users']->count() > 0)
                                <div id="collapse_permissions_{{ $itemKey }}" class="collapse" data-parent="#accordion_permissions_{{ $itemKey }}" >
                                    @if($item['roles']->count() > 0)
                                        <table class="table table-striped table-sm mt-3">
                                            <caption>
                                                {!! trans('laravelroles::laravelroles.cards.permissions-card.permissions-table-roles-caption', ['permission' => $item['permission']->name]) !!}
                                            </caption>
                                            <thead>
                                                <tr>
                                                    <th>{!! trans('laravelroles::laravelroles.cards.permissions-card.role-id') !!}</th>
                                                    <th>{!! trans('laravelroles::laravelroles.cards.permissions-card.role-name') !!}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($item['roles'] as $itemUserKey => $itemRole)
                                                    <tr>
                                                        <td>{{ $itemRole->id }}</td>
                                                        <td>{{ $itemRole->name }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    @endif
                                    @if($item['users']->count() > 0)
                                        <table class="table table-striped table-sm">
                                            <caption>
                                                {!! trans('laravelroles::laravelroles.cards.permissions-card.permissions-table-users-caption', ['permission' => $item['permission']->name]) !!}
                                            </caption>
                                            <thead>
                                                <tr>
                                                    <th>{!! trans('laravelroles::laravelroles.cards.role-card.user-id') !!}</th>
                                                    <th>{!! trans('laravelroles::laravelroles.cards.role-card.user-name') !!}</th>
                                                    <th>{!! trans('laravelroles::laravelroles.cards.role-card.user-email') !!}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($item['users'] as $itemUserKey => $itemRole)
                                                    <tr>
                                                        <td>{{ $itemRole->id }}</td>
                                                        <td>{{ $itemRole->name }}</td>
                                                        <td>{{ $itemRole->email }}</td>
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
                    <li class="list-group-item">
                        {!! trans('laravelroles::laravelroles.cards.none-count') !!}
                    </li>
                @endif
            </ul>
        </div>
    </div>
</div>
