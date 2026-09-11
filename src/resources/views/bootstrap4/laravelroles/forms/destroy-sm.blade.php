@php
    $formClass  = '';
    $btnClass   = 'btn-outline-danger btn-sm';
    $btnText    = trans("laravelroles::laravelroles.buttons.destroy");
    $btnTooltip = trans('laravelroles::laravelroles.tooltips.destroy-role');
    $formAction = route('laravelroles::role-item-destroy', $item->id);
    $dataTarget = '#confirmDestroyRoles';
    if(isset($large)) {
        $formClass  = 'mb-0';
        $btnClass   = 'btn-outline-danger btn-md mb-0';
        $btnText    = trans("laravelroles::laravelroles.buttons.destroy-large");
    }
    if($type == 'Permission') {
        $btnTooltip = trans('laravelroles::laravelroles.tooltips.destroy-permission');
        $formAction = route('laravelroles::permissions.destroy', $item->id);
        $formAction = route('laravelroles::permission-item-destroy', $item->id);
        $dataTarget = '#confirmDestroyPermissions';
    }
@endphp

<form action="{{ $formAction }}" method="POST" accept-charset="utf-8" data-toggle="tooltip" title="{{ $btnTooltip }}" class="{{ $formClass }}" >
    {{ csrf_field() }}
    {{ method_field('DELETE') }}
    <button class="btn btn-block {{ $btnClass }}" type="button" style="width: 100%;" data-toggle="modal" data-target="{{ $dataTarget }}" data-title="{!! trans('laravelroles::laravelroles.modals.destroy_modal_title', ['type' => $type, 'item' => $item->name]) !!}" data-message="{!! trans('laravelroles::laravelroles.modals.destroy_modal_message', ['type' => $type, 'item' => $item->name]) !!}" >
        {!! $btnText !!}
        <i class="fa fa-trash fa-fw" aria-hidden="true"></i>
    </button>
</form>
