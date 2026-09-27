@php
    $formClass      = '';
    $btnClass       = 'btn btn-outline-success pointer';
    $btnText        = '';
    $btnTooltip     = '';
    $formAction     = '';
    $modalTitle     = '';
    $modalMessage   = '';
    $dataTarget     = '';

    if($type == 'role') {
        $formAction     = route('laravelroles::role-restore', $item->id);
        $btnTooltip     = trans('laravelroles::laravelroles.tooltips.restore-role');
        $btnText        = trans("laravelroles::laravelroles.buttons.restore-role");
        $modalTitle     = trans('laravelroles::laravelroles.modals.restore_modal_title', ['type' => $type, 'item' => $item->name]);
        $modalMessage   = trans('laravelroles::laravelroles.modals.restore_modal_message', ['type' => $type, 'item' => $item->name]);
        $dataTarget     = '#confirmRestoreRoles';
    }
    if($type == 'permission') {
        $formAction     = route('laravelroles::permission-restore', $item->id);
        $btnTooltip     = trans('laravelroles::laravelroles.tooltips.restore-permission');
        $btnText        = trans("laravelroles::laravelroles.buttons.restore-permission");
        $modalTitle     = trans('laravelroles::laravelroles.modals.restore_modal_title', ['type' => $type, 'item' => $item->name]);
        $modalMessage   = trans('laravelroles::laravelroles.modals.restore_modal_message', ['type' => $type, 'item' => $item->name]);
        $dataTarget     = '#confirmRestorePermissions';
    }
    if($style == 'small') {
        $btnClass .= ' btn-sm';
    }
    if($style == 'large' && $type == 'role') {
        $btnText    = trans("laravelroles::laravelroles.buttons.restore-role-large");
        $btnClass   .= ' btn-sm mb-0';
        $formClass  = 'mb-0';
    }
    if($style == 'large' && $type == 'permission') {
        $btnText    = trans("laravelroles::laravelroles.buttons.restore-permission-large");
        $btnClass   .= ' btn-sm mb-0';
        $formClass  = 'mb-0';
    }

@endphp

<form action="{{ $formAction }}" method="POST" accept-charset="utf-8" data-bs-toggle="tooltip" title="{{ $btnTooltip }}" class="{{ $formClass }}" >
    {{ csrf_field() }}
    {{ method_field('PUT') }}
    <button class="btn w-100 {{ $btnClass }}" type="button" style="width: 100%;" data-bs-toggle="modal" data-bs-target="{{ $dataTarget }}" data-title="{!! $modalTitle !!}" data-message="{!! $modalMessage !!}" >
        {!! $btnText !!}
        <i class="fa-solid fa-fw fa-clock-rotate-left" aria-hidden="true"></i>
    </button>
</form>
