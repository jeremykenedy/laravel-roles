<div class="col-sm-6 mb-4 d-flex">
    <div class="card">
        <div class="card-header bg-default">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <span id="card_title">
                    {!! trans('laravelroles::laravelroles.titles.roles-card') !!}
                </span>
                <span class="badge badge-pill badge-dark">
                    {!! count($items) !!}
                </span>
            </div>
        </div>
        <div class="list-group-flush flex-fill">
            <ul class="list-group list-group-flush">
                @if(count($items) != 0)
                    @foreach($items as $itemKey => $item)
@php
                       $indRoleBadgeClass = 'badge-';
                       $indRoleTextClass = 'text-';
                       $lug = strtolower($item['role']['slug']);
                       switch($lug) {#select
                            case strpos($lug,'admin')!==FALSE:
                                $indRoleBadgeClass .= 'warning';
                                $indRoleTextClass .= 'warning';
                                break;
                            case strpos($lug,'man')!==FALSE:#like manage
                                $indRoleBadgeClass .= 'primary';
                                $indRoleTextClass .= 'primary';
                                break;
                            case strpos($lug,'mod')!==FALSE:#like moderate
                                $indRoleBadgeClass .= 'secondary';
                                $indRoleTextClass .= 'secondary';
                                break;
                            case strpos($lug,'user')!==FALSE:
                                $indRoleBadgeClass .= 'info text-white';
                                $indRoleTextClass .= 'info';
                                break;
                            case strpos($lug,'unverif')!==FALSE:
                                $indRoleBadgeClass .= 'danger';
                                $indRoleTextClass .= 'danger';
                                break;
                            default:
                                $indRoleBadgeClass .= 'default';
                                $indRoleTextClass .= 'default';
                        }
@endphp
                        <li id="accordion_roles_{{ $itemKey }}" class="list-group-item accordion @if($item['users']->count() > 0 || $item['permissions']->count() > 0) list-group-item-action accordion-item collapsed @endif" data-toggle="collapse" href="#collapse_roles_{{ $itemKey }}">
                            <div class="d-flex justify-content-between align-items-center" @if($item['users']->count() > 0 || $item['permissions']->count() > 0) data-toggle="tooltip" title="{{ trans("laravelroles::laravelroles.tooltips.show-hide") }}" @endif>
                                <span class="badge badge-light role-name">
                                    {!! trans('laravelroles::laravelroles.titles.role-card') !!} <strong class="{{ $indRoleTextClass }}">{{ $item['role']->name }}</strong>
                                </span>
                                <div class="text-right">
                                    <span class="badge badge-dark">
                                        <small>
                                            {{ trans('laravelroles::laravelroles.cards.level', ['level' => $item['role']->level]) }}
                                        </small>
                                    </span>
                                    <span class="badge badge-pill {{ $indRoleBadgeClass }}">
                                        <small>
                                            {!! trans_choice('laravelroles::laravelroles.cards.users-count', count($item['users']), ['count' => count($item['users'])]) !!}
                                        </small>
                                    </span>
                                    <span class="badge badge-pill badge-primary">
                                        <small>
                                            {!! trans_choice('laravelroles::laravelroles.cards.permissions-count', count($item['permissions']), ['count' => count($item['permissions'])]) !!}
                                        </small>
                                    </span>
                                </div>
                            </div>
                            @if($item['users']->count() > 0 || $item['permissions']->count() > 0)
                                <div id="collapse_roles_{{ $itemKey }}" class="collapse" data-parent="#accordion_roles_{{ $itemKey }}" >

                                    @if($item['users']->count() > 0)
                                        <table class="table table-striped table-sm mt-3">
                                            <caption>
                                                {!! trans('laravelroles::laravelroles.cards.role-card.table-users-caption', ['role' => $item['role']->name]) !!}
                                            </caption>
                                            <thead>
                                                <tr>
                                                    <th>{!! trans('laravelroles::laravelroles.cards.role-card.user-id') !!}</th>
                                                    <th>{!! trans('laravelroles::laravelroles.cards.role-card.user-name') !!}</th>
                                                    <th>{!! trans('laravelroles::laravelroles.cards.role-card.user-email') !!}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($item['users'] as $itemUserKey => $itemUser)
                                                    <tr>
                                                        <td>{{ $itemUser->id }}</td>
                                                        <td>{{ $itemUser->name }}</td>
                                                        <td>{{ $itemUser->email }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    @endif
                                    @if($item['permissions']->count() > 0)
                                        <table class="table table-striped table-sm mt-3">
                                            <caption>
                                                {!! trans('laravelroles::laravelroles.cards.role-card.table-permissions-caption', ['role' => $item['role']->name]) !!}
                                            </caption>
                                            <thead>
                                                <tr>
                                                    <th>{!! trans('laravelroles::laravelroles.cards.role-card.permissions-id') !!}</th>
                                                    <th>{!! trans('laravelroles::laravelroles.cards.role-card.permissions-name') !!}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($item['permissions'] as $itemUserKey => $itemUser)
                                                    <tr>
                                                        <td>{{ $itemUser->id }}</td>
                                                        <td>{{ $itemUser->name }}</td>
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
