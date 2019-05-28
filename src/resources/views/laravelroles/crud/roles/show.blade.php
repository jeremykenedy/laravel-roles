@extends(config('roles.bladeExtended'))

@section(config('roles.titleExtended'))
    {!! trans('laravelroles::laravelroles.titles.show-role') !!}
@endsection

@php
    switch (config('roles.bootstapVersion')) {
        case '3':
            $containerClass = 'panel';
            $containerHeaderClass = 'panel-heading';
            $containerBodyClass = 'panel-body';
            break;
        case '4':
        default:
            $containerClass = 'card';
            $containerHeaderClass = 'card-header';
            $containerBodyClass = 'card-body';
            break;
    }
    $bootstrapCardClasses = (is_null(config('roles.bootstrapCardClasses')) ? '' : config('roles.bootstrapCardClasses'));
@endphp

@section(config('roles.bladePlacementCss'))
    @if(config('roles.enabledDatatablesJs'))
        <link rel="stylesheet" type="text/css" href="{{ config('roles.datatablesCssCDN') }}">
    @endif
    @if(config('roles.enableFontAwesomeCDN'))
        <link rel="stylesheet" type="text/css" href="{{ config('roles.fontAwesomeCDN') }}">
    @endif
    @include('laravelroles::laravelroles.partials.styles')
    @include('laravelroles::laravelroles.partials.bs-visibility-css')
@endsection

@section('content')

    @include('laravelroles::laravelroles.partials.flash-messages')

    <div class="container">
        <div class="row">
            <div class="col-md-12 col-lg-10 offset-lg-1">
                <div class="{{ $containerClass }} {{ $bootstrapCardClasses }}">
                    <div class="{{ $containerHeaderClass }}">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <span id="card_title">
                                @isset($typeDeleted)
                                    {!! trans('laravelroles::laravelroles.titles.show-role-deleted', ['name' => $item->name]) !!}
                                @else
                                    {!! trans('laravelroles::laravelroles.titles.show-role', ['name' => $item->name]) !!}
                                @endisset
                            </span>
                            <div class="pull-right">
                                @isset($typeDeleted)
                                    <a href="{{ route('laravelroles::roles-deleted') }}" class="btn btn-outline-danger btn-sm float-right" data-toggle="tooltip" data-placement="left" title="{{ trans('laravelroles::laravelroles.tooltips.back-roles-deleted') }}">
                                        <i class="fa fa-fw fa-reply-all" aria-hidden="true"></i>
                                        {!! trans('laravelroles::laravelroles.buttons.back-to-roles-deleted') !!}
                                    </a>
                                @else
                                    <a href="{{ route('laravelroles::roles.index') }}" class="btn btn-outline-secondary btn-sm float-right" data-toggle="tooltip" data-placement="left" title="{{ trans('laravelroles::laravelroles.tooltips.back-roles') }}">
                                        <i class="fa fa-fw fa-reply-all" aria-hidden="true"></i>
                                        {!! trans('laravelroles::laravelroles.buttons.back-to-roles') !!}
                                    </a>
                                @endisset
                            </div>
                        </div>
                    </div>
                    <div class="{{ $containerBodyClass }}">
                        <ul class="list-group">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {!! trans('laravelroles::laravelroles.cards.role-info-card.role-id') !!}
                                <span class="badge badge-pill">
                                    {{ $item->id }}
                                </span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {!! trans('laravelroles::laravelroles.cards.role-info-card.role-name') !!}
                                <span class="badge badge-pill">
                                    {{ $item->name }}
                                </span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {!! trans('laravelroles::laravelroles.cards.role-info-card.role-desc') !!}
                                <span class="badge badge-pill">
                                    @if($item->desc)
                                        {{ $item->desc }}
                                    @else
                                        <span class="text-muted">
                                            {!! trans('laravelroles::laravelroles.cards.role-info-card.none') !!}
                                        </span>
                                    @endif
                                </span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {!! trans('laravelroles::laravelroles.cards.role-info-card.role-level') !!}
                                <span class="badge badge-pill">
                                    @if($item->level)
                                        {{ $item->level }}
                                    @else
                                        <span class="text-muted">
                                            {!! trans('laravelroles::laravelroles.cards.role-info-card.none') !!}
                                        </span>
                                    @endif
                                </span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {!! trans('laravelroles::laravelroles.cards.role-info-card.role-permissions') !!}
                                @if($item['permissions']->count() > 0)
                                    <div>
                                        @foreach($item['permissions'] as $itemUserKey => $itemValue)
                                            <span class="badge badge-pill badge-primary float-right">
                                                {{ $itemValue->name }}
                                            </span>
                                            <br />
                                        @endforeach
                                    </div>
                                @else
                                    <span class="text-muted">
                                        {!! trans('laravelroles::laravelroles.cards.none-count') !!}
                                    </span>
                                @endif
                            </li>
                            <li id="accordion_roles_users" class="list-group-item accordion @if($item['users']->count() > 0) list-group-item-action accordion-item collapsed @endif" data-toggle="collapse" href="#collapse_roles_users">
                                <div class="d-flex justify-content-between align-items-center" @if($item['users']->count() > 0) data-toggle="tooltip" title="{{ trans("laravelroles::laravelroles.tooltips.show-hide") }}" @endif>
                                    {!! trans('laravelroles::laravelroles.cards.role-info-card.role-users') !!}
                                    <span class="badge badge-pill badge-dark">
                                        @if($item['users']->count() > 0)
                                            {!! trans_choice('laravelroles::laravelroles.cards.users-count', count($item['users']), ['count' => count($item['users'])]) !!}
                                        @else
                                            {!! trans('laravelroles::laravelroles.cards.none-count') !!}
                                        @endif
                                    </span>
                                </div>
                                @if($item['users']->count() > 0)
                                    <div id="collapse_roles_users" class="collapse" data-parent="#accordion_roles_users" >
                                        <table class="table table-striped table-sm mt-3">
                                            <caption>
                                                {!! trans('laravelroles::laravelroles.cards.role-card.table-users-caption', ['role' => $item->name]) !!}
                                            </caption>
                                            <thead>
                                                <tr>
                                                    <th>{!! trans('laravelroles::laravelroles.cards.role-card.user-id') !!}</th>
                                                    <th>{!! trans('laravelroles::laravelroles.cards.role-card.user-name') !!}</th>
                                                    <th>{!! trans('laravelroles::laravelroles.cards.role-card.user-email') !!}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if($item['users']->count() > 0)
                                                    @foreach($item['users'] as $itemUserKey => $itemUser)
                                                        <tr>
                                                            <td>{{ $itemUser->id }}</td>
                                                            <td>{{ $itemUser->name }}</td>
                                                            <td>{{ $itemUser->email }}</td>
                                                        </tr>
                                                    @endforeach
                                                @else
                                                    <tr>
                                                        <td colspan="3">
                                                            {!! trans('laravelroles::laravelroles.cards.none-count') !!}
                                                        </td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                @endif
                            </li>
                            <li id="accordion_roles_permissions" class="list-group-item accordion @if($item['permissions']->count() > 0) list-group-item-action accordion-item collapsed @endif" data-toggle="collapse" href="#collapse_roles_permissions">
                                <div class="d-flex justify-content-between align-items-center" @if($item['permissions']->count() > 0) data-toggle="tooltip" title="{{ trans("laravelroles::laravelroles.tooltips.show-hide") }}" @endif>
                                    {!! trans('laravelroles::laravelroles.cards.role-info-card.role-permissions') !!}
                                    <span class="badge badge-pill badge-dark">
                                        @if($item['permissions']->count() > 0)
                                            {!! trans_choice('laravelroles::laravelroles.cards.permissions-count', count($item['permissions']), ['count' => count($item['permissions'])]) !!}
                                        @else
                                            {!! trans('laravelroles::laravelroles.cards.none-count') !!}
                                        @endif
                                    </span>
                                </div>
                                @if($item['permissions']->count() > 0)
                                    <div id="collapse_roles_permissions" class="collapse" data-parent="#accordion_roles_permissions" >
                                        <table class="table table-striped table-sm mt-3">
                                            <caption>
                                                {!! trans('laravelroles::laravelroles.cards.role-card.table-permissions-caption', ['role' => $item->name]) !!}
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
                                    </div>
                                @endif
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {!! trans('laravelroles::laravelroles.cards.role-info-card.created') !!}
                                <span class="badge badge-pill">
                                    {!! $item->created_at->format(trans('laravelroles::laravelroles.date-format')) !!}
                                </span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {!! trans('laravelroles::laravelroles.cards.role-info-card.updated') !!}
                                <span class="badge badge-pill">
                                    {!! $item->updated_at->format(trans('laravelroles::laravelroles.date-format')) !!}
                                </span>
                            </li>
                            @if ($item->deleted_at)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    {!! trans('laravelroles::laravelroles.cards.role-info-card.deleted') !!}
                                    <span class="badge badge-pill">
                                        {!! $item->deleted_at->format(trans('laravelroles::laravelroles.date-format')) !!}
                                    </span>
                                </li>
                            @endif
                        </ul>
                        <div class="row">
                            <div class="col-sm-6 mt-3">
                                @isset($typeDeleted)
                                    @include('laravelroles::laravelroles.forms.restore-item', ['style' => 'large', 'type' => 'role', 'item' => $item])
                                @else
                                    <a class="btn btn-sm btn-secondary btn-block text-white mb-0" href="{{ route('laravelroles::roles.edit', $item->id) }}" data-toggle="tooltip" title="{{ trans("laravelroles::laravelroles.tooltips.edit-role") }}">
                                        {!! trans("laravelroles::laravelroles.buttons.edit-larger") !!}
                                    </a>
                                @endisset
                            </div>
                            <div class="col-sm-6 mt-3">
                                @isset($typeDeleted)
                                    @include('laravelroles::laravelroles.forms.destroy-sm', ['large' => 'large', 'type' => 'Role' ,'item' => $item])
                                @else
                                     @include('laravelroles::laravelroles.forms.delete-sm', ['type' => 'Role' ,'item' => $item, 'large' => true])
                                @endisset
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('laravelroles::laravelroles.modals.confirm-modal',[
        'formTrigger' => 'confirmRestore',
        'modalClass' => 'success',
        'actionBtnIcon' => 'fa-check'
    ])

    @include('laravelroles::laravelroles.modals.confirm-modal',[
        'formTrigger' => 'confirmDelete',
        'modalClass' => 'danger',
        'actionBtnIcon' => 'fa-trash-o'
    ])

    @include('laravelroles::laravelroles.modals.confirm-modal',[
        'formTrigger' => 'confirmDestroyRoles',
        'modalClass' => 'danger',
        'actionBtnIcon' => 'fa-trash-o'
    ])

    @include('laravelroles::laravelroles.modals.confirm-modal',[
        'formTrigger' => 'confirmRestoreRoles',
        'modalClass' => 'success',
        'actionBtnIcon' => 'fa-check'
    ])

@endsection

@section(config('roles.bladePlacementJs'))
    @if(config('roles.enablejQueryCDN'))
        <script type="text/javascript" src="{{ config('roles.JQueryCDN') }}"></script>
    @endif
    @include('laravelroles::laravelroles.scripts.confirm-modal', ['formTrigger' => '#confirmDelete'])
    @include('laravelroles::laravelroles.scripts.confirm-modal', ['formTrigger' => '#confirmDestroyRoles'])
    @include('laravelroles::laravelroles.scripts.confirm-modal', ['formTrigger' => '#confirmRestoreRoles'])
    @if (config('roles.enabledDatatablesJs'))
        @include('laravelroles::laravelroles.scripts.datatables')
    @endif
    @if(config('roles.tooltipsEnabled'))
        @include('laravelroles::laravelroles.scripts.tooltips')
    @endif
@endsection

@yield('inline_template_linked_css')
@yield('inline_footer_scripts')
