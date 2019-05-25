@php
    $formClass      = '';
    $btnClass       = 'btn btn-outline-success pointer';
    $btnText        = '';
    $btnTooltip     = '';
    $formAction     = '';
    $modalTitle     = '';
    $modalMessage   = '';

    if($type == 'role') {
        $formAction     = route('laravelroles::role-restore', $item->id);
        $btnTooltip     = trans('laravelroles::laravelroles.tooltips.restore-role');
        $btnText        = trans("laravelroles::laravelroles.buttons.restore-role");
        $modalTitle     = trans('laravelroles::laravelroles.modals.restore_modal_title', ['type' => $type, 'item' => $item->name]);
        $modalMessage   = trans('laravelroles::laravelroles.modals.restore_modal_message', ['type' => $type, 'item' => $item->name]);
    }
    if($style == 'small') {
        $btnClass .= ' btn-sm';
    }
    if($style == 'large' && $type == 'role') {
        $btnText    = trans("laravelroles::laravelroles.buttons.restore-role-large");
        $btnClass   .= ' btn-md mb-0';
        $formClass  = 'mb-0';
    }

@endphp

<form action="{{ $formAction }}" method="POST" accept-charset="utf-8" data-toggle="tooltip" title="{{ $btnTooltip }}" class="{{ $formClass }}" >
    {{ csrf_field() }}
    {{ method_field('PUT') }}
    <button class="btn btn-block {{ $btnClass }}" type="button" style="width: 100%;" data-toggle="modal" data-target="#confirmRestoreRoles" data-title="{!! $modalTitle !!}" data-message="{!! $modalMessage !!}" >
        {!! $btnText !!}
        <i class="fa fa-fw fa-history" aria-hidden="true"></i>
    </button>
</form>
