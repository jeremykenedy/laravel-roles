@extends(config('roles.bladeExtended'))

@section(config('roles.titleExtended'))
    {!! trans('laravelroles::laravelroles.titles.dashboard') !!}
@endsection

@section(config('roles.bladePlacementCss'))
    @include('laravelroles::laravelroles.partials.styles')
    @include('laravelroles::laravelroles.partials.bs-visibility-css')
@endsection

@section('content')

    @include('laravelroles::laravelroles.partials.flash-messages')

    <div class="mx-auto w-full max-w-7xl space-y-6 px-4 py-6">
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
            @include('laravelroles::laravelroles.cards.roles-card', ['items' => $sortedRolesWithPermissionsAndUsers])
            @include('laravelroles::laravelroles.cards.permissions-card', ['items' => $sortedPermissionsRolesUsers])
        </div>

        @include('laravelroles::laravelroles.tables.roles-table')

        @include('laravelroles::laravelroles.tables.permissions-table')
    </div>

    @include('laravelroles::laravelroles.modals.confirm-modal', [
        'formTrigger' => 'confirmDelete',
        'modalClass' => 'danger',
    ])

@endsection

@section(config('roles.bladePlacementJs'))
    @include('laravelroles::laravelroles.scripts.alpine')
    @include('laravelroles::laravelroles.scripts.confirm-modal')
@endsection

@yield('inline_template_linked_css')
@yield('inline_footer_scripts')
