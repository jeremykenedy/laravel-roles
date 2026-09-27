@extends(config('roles.bladeExtended'))

@section(config('roles.titleExtended'))
    {!! trans('laravelroles::laravelroles.titles.delete-permissions-dashboard') !!}
@endsection

@section(config('roles.bladePlacementCss'))
    @include('laravelroles::laravelroles.partials.styles')
    @include('laravelroles::laravelroles.partials.bs-visibility-css')
@endsection

@section('content')

    @include('laravelroles::laravelroles.partials.flash-messages')

    <div class="mx-auto w-full max-w-7xl space-y-6 px-4 py-6">
        @include('laravelroles::laravelroles.tables.permissions-table', ['isDeletedPermissions' => true])
    </div>

    @include('laravelroles::laravelroles.modals.confirm-modal', [
        'formTrigger' => 'confirmDestroyPermissions',
        'modalClass' => 'danger',
    ])

    @include('laravelroles::laravelroles.modals.confirm-modal', [
        'formTrigger' => 'confirmRestorePermissions',
        'modalClass' => 'success',
    ])

@endsection

@section(config('roles.bladePlacementJs'))
    @include('laravelroles::laravelroles.scripts.alpine')
    @include('laravelroles::laravelroles.scripts.confirm-modal')
@endsection

@yield('inline_template_linked_css')
@yield('inline_footer_scripts')
