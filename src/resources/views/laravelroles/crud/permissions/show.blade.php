@extends(config('roles.bladeExtended'))

@section(config('roles.titleExtended'))
    {!! trans('laravelroles::laravelroles.titles.show-permission') !!}
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
                                    {!! trans('laravelroles::laravelroles.titles.show-permission-deleted', ['name' => $item->name]) !!}
                                @else
                                    {!! trans('laravelroles::laravelroles.titles.show-permission', ['name' => $item['permission']->name]) !!}
                                @endisset
                            </span>
                            <div class="pull-right">
                                @isset($typeDeleted)
                                    <a href="{{ route('laravelroles::permissions-deleted') }}" class="btn btn-outline-danger btn-sm float-right" data-toggle="tooltip" data-placement="left" title="{{ trans('laravelroles::laravelroles.tooltips.back-permissions-deleted') }}">
                                        <i class="fa fa-fw fa-reply-all" aria-hidden="true"></i>
                                        {!! trans('laravelroles::laravelroles.buttons.back-to-permissions-deleted') !!}
                                    </a>
                                @else
                                    <a href="{{ route('laravelroles::roles.index') }}" class="btn btn-outline-secondary btn-sm float-right" data-toggle="tooltip" data-placement="left" title="{{ trans('laravelroles::laravelroles.tooltips.back-permissions') }}">
                                        <i class="fa fa-fw fa-reply-all" aria-hidden="true"></i>
                                        {!! trans('laravelroles::laravelroles.buttons.back-to-permissions') !!}
                                    </a>
                                @endisset
                            </div>
                        </div>
                    </div>
                    <div class="{{ $containerBodyClass }}">
                        <ul class="list-group">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {!! trans('laravelroles::laravelroles.cards.permission-info-card.permission-id') !!}
                                <span class="badge badge-pill">
                                    @isset($typeDeleted)
                                        {{ $item->id }}
                                    @else
                                        {{ $item['permission']->id }}
                                    @endisset
                                </span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {!! trans('laravelroles::laravelroles.cards.permission-info-card.permission-name') !!}
                                <span class="badge badge-pill">
                                    @isset($typeDeleted)
                                        {{ $item->name }}
                                    @else
                                        {{ $item['permission']->name }}
                                    @endisset
                                </span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {!! trans('laravelroles::laravelroles.cards.permission-info-card.permission-slug') !!}
                                <span class="badge badge-pill">
                                    @isset($typeDeleted)
                                        {{ $item->slug }}
                                    @else
                                        {{ $item['permission']->slug }}
                                    @endisset
                                </span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {!! trans('laravelroles::laravelroles.cards.permission-info-card.permission-model') !!}
                                <span class="badge badge-pill">
                                    @isset($typeDeleted)
                                        {{ $item->model }}
                                    @else
                                        {{ $item['permission']->model }}
                                    @endisset
                                </span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {!! trans('laravelroles::laravelroles.cards.permission-info-card.permission-desc') !!}
                                <span class="badge badge-pill">
                                    @isset($typeDeleted)
                                        @if($item->desc)
                                            {{ $item->desc }}
                                        @else
                                            <span class="text-muted">
                                                {!! trans('laravelroles::laravelroles.cards.permission-info-card.none') !!}
                                            </span>
                                        @endif
                                    @else
                                        @if($item['permission']->desc)
                                            {{ $item['permission']->desc }}
                                        @else
                                            <span class="text-muted">
                                                {!! trans('laravelroles::laravelroles.cards.permission-info-card.none') !!}
                                            </span>
                                        @endif
                                    @endisset
                                </span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {!! trans('laravelroles::laravelroles.cards.permission-info-card.permission-roles') !!}
                                @isset($typeDeleted)
                                    @if($item->roles()->count() > 0)
                                        <div>
                                            @foreach($item->roles()->get() as $itemUserKey => $itemValue)
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
                                @else
                                    @if($item['roles']->count() > 0)
                                        <div>
                                            @foreach($item['roles'] as $itemUserKey => $itemValue)
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
                                @endisset
                            </li>
                            <li id="accordion_roles_users" class="list-group-item accordion @if($item['users']->count() > 0) list-group-item-action accordion-item collapsed @endif" data-toggle="collapse" href="#collapse_roles_users">
                                <div class="d-flex justify-content-between align-items-center" @if($item['users']->count() > 0) data-toggle="tooltip" title="{{ trans("laravelroles::laravelroles.tooltips.show-hide") }}" @endif>
                                    {!! trans('laravelroles::laravelroles.cards.permission-info-card.permission-users') !!}
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
                                                @isset($typeDeleted)
                                                    {!! trans('laravelroles::laravelroles.cards.permissions-card.permissions-table-users-caption', ['permission' => $item->name]) !!}
                                                @else
                                                    {!! trans('laravelroles::laravelroles.cards.permissions-card.permissions-table-users-caption', ['permission' => $item['permission']->name]) !!}
                                                @endisset
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
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {!! trans('laravelroles::laravelroles.cards.role-info-card.created') !!}
                                <span class="badge badge-pill">
                                    @isset($typeDeleted)
                                        {!! $item->created_at->format(trans('laravelroles::laravelroles.date-format')) !!}
                                    @else
                                        {!! $item['permission']->created_at->format(trans('laravelroles::laravelroles.date-format')) !!}
                                    @endisset
                                </span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {!! trans('laravelroles::laravelroles.cards.role-info-card.updated') !!}
                                <span class="badge badge-pill">
                                    @isset($typeDeleted)
                                        {!! $item->updated_at->format(trans('laravelroles::laravelroles.date-format')) !!}
                                    @else
                                        {!! $item['permission']->updated_at->format(trans('laravelroles::laravelroles.date-format')) !!}
                                    @endisset
                                </span>
                            </li>
                            @isset($typeDeleted)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    {!! trans('laravelroles::laravelroles.cards.role-info-card.deleted') !!}
                                    <span class="badge badge-pill">
                                        {!! $item->deleted_at->format(trans('laravelroles::laravelroles.date-format')) !!}
                                    </span>
                                </li>
                            @endisset
                        </ul>
                        <div class="row">
                            <div class="col-sm-6 mt-3">
                                @isset($typeDeleted)
                                    @include('laravelroles::laravelroles.forms.restore-item', ['style' => 'large', 'type' => 'permission', 'item' => $item])
                                @else
                                    <a class="btn btn-sm btn-secondary btn-block text-white mb-0" href="{{ route('laravelroles::permissions.edit', $item['permission']->id) }}" data-toggle="tooltip" title="{{ trans("laravelroles::laravelroles.tooltips.edit-permission") }}">
                                        {!! trans("laravelroles::laravelroles.buttons.edit-larger") !!}
                                    </a>
                                @endisset
                            </div>
                            <div class="col-sm-6 mt-3">
                                @isset($typeDeleted)
                                    @include('laravelroles::laravelroles.forms.destroy-sm', ['large' => 'large', 'type' => 'Permission' ,'item' => $item])
                                @else
                                     @include('laravelroles::laravelroles.forms.delete-sm', ['type' => 'Permission' ,'item' => $item['permission'], 'large' => true])
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
        'formTrigger' => 'confirmRestorePermissions',
        'modalClass' => 'success',
        'actionBtnIcon' => 'fa-check'
    ])

    @include('laravelroles::laravelroles.modals.confirm-modal',[
        'formTrigger' => 'confirmDestroyPermissions',
        'modalClass' => 'danger',
        'actionBtnIcon' => 'fa-trash-o'
    ])

@endsection

@section(config('roles.bladePlacementJs'))
    @if(config('roles.enablejQueryCDN'))
        <script type="text/javascript" src="{{ config('roles.JQueryCDN') }}"></script>
    @endif
    @include('laravelroles::laravelroles.scripts.confirm-modal', ['formTrigger' => '#confirmRestore'])
    @include('laravelroles::laravelroles.scripts.confirm-modal', ['formTrigger' => '#confirmDelete'])
    @include('laravelroles::laravelroles.scripts.confirm-modal', ['formTrigger' => '#confirmRestorePermissions'])
    @include('laravelroles::laravelroles.scripts.confirm-modal', ['formTrigger' => '#confirmDestroyPermissions'])
    @if (config('roles.enabledDatatablesJs'))
        @include('laravelroles::laravelroles.scripts.datatables')
    @endif
    @if(config('roles.tooltipsEnabled'))
        @include('laravelroles::laravelroles.scripts.tooltips')
    @endif
@endsection

@yield('inline_template_linked_css')
@yield('inline_footer_scripts')
