@extends(config('roles.bladeExtended'))

@section(config('roles.titleExtended'))
    {!! trans('laravelroles::laravelroles.titles.delete-roles-dashboard') !!}
@endsection

@php
    switch (config('roles.bootstapVersion')) {
        case '3':
            $rolesContainerClass = 'panel';
            $rolesContainerHeaderClass = 'panel-heading';
            $rolesContainerBodyClass = 'panel-body padding-0';
            break;
        case '4':
        default:
            $rolesContainerClass = 'card';
            $rolesContainerHeaderClass = 'card-header';
            $rolesContainerBodyClass = 'card-body p-0';
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

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                @include('laravelroles::laravelroles.tables.roles-table',['isDeletedRoles' => true])
            </div>
        </div>

        <div class="clearfix mb-4"></div>

    </div>

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
