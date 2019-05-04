@extends(config('roles.bladeExtended'))

@section(config('roles.titleExtended'))
    {!! trans('roles::roles.titles.dashboard') !!}
@endsection

@php
    switch (config('roles.bootstapVersion')) {
        case '3':
            $rolesContainerClass = 'panel panel-success';
            $rolesContainerHeaderClass = 'panel-heading';
            $rolesContainerBodyClass = 'panel-body';
            break;
        case '4':
        default:
            $rolesContainerClass = 'card';
            $rolesContainerHeaderClass = 'card-header bg-success text-white';
            $rolesContainerBodyClass = 'card-body';
            break;
    }

    $bootstrapCardClasses = (is_null(config('roles.bootstrapCardClasses')) ? '' : config('roles.bootstrapCardClasses'));

    /*
    $totalUserItems = count($sortedRolesWithPermissionsAndUsers);
    $modulus = $totalUserItems % 3;
    if($modulus == 0) {
        $cardColClass = 'col-sm-6 col-md-4';
    } elseif($modulus == 1) {
        $cardColClass = 'col-sm-6 col-md-3';
    } elseif($modulus == 2) {
        $cardColClass = 'col-sm-6 col-md-4';
    } else {
        $cardColClass = 'col-sm-6';
    }
    */

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
            @include('laravelroles::laravelroles.cards.roles-card', ['items' => $sortedRolesWithPermissionsAndUsers])
            @include('laravelroles::laravelroles.cards.permissions-card', ['items' => $sortedPermissionsRolesUsers])
        </div>

        <div class="clearfix mb-4"></div>

    </div>

@endsection

@section(config('roles.bladePlacementJs'))
    @if(config('roles.enablejQueryCDN'))
        <script type="text/javascript" src="{{ config('roles.JQueryCDN') }}"></script>
    @endif
    @if (config('roles.enabledDatatablesJs'))
        @include('laravelroles::laravelroles.scripts.datatables')
    @endif
    @if(config('roles.tooltipsEnabled'))
        @include('laravelroles::laravelroles.scripts.tooltips')
    @endif
@endsection

@yield('inline_template_linked_css')
@yield('inline_footer_scripts')
