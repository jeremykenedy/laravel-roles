@php
    $formClass  = '';
    $btnClass   = 'btn-outline-danger btn-sm';
    $btnText    = trans("laravelroles::laravelroles.buttons.destroy");
    $btnTooltip = trans('laravelroles::laravelroles.tooltips.destroy-role');
    $formAction = route('laravelroles::role-item-destroy', $item->id);
    $dataTarget = '#confirmDestroyRoles';
    if(isset($large)) {
        $formClass  = 'mb-0';
        $btnClass   = 'btn-outline-danger btn-sm mb-0';
        $btnText    = trans("laravelroles::laravelroles.buttons.destroy-large");
    }
    if($type == 'Permission') {
        $btnTooltip = trans('laravelroles::laravelroles.tooltips.destroy-permission');
        $formAction = route('laravelroles::permissions.destroy', $item->id);
        $formAction = route('laravelroles::permission-item-destroy', $item->id);
        $dataTarget = '#confirmDestroyPermissions';
    }
@endphp

<form action="{{ $formAction }}" method="POST" accept-charset="utf-8" data-bs-toggle="tooltip" title="{{ $btnTooltip }}" class="{{ $formClass }}" >
    {{ csrf_field() }}
    {{ method_field('DELETE') }}
    <button class="btn w-100 {{ $btnClass }}" type="button" style="width: 100%;" data-bs-toggle="modal" data-bs-target="{{ $dataTarget }}" data-title="{!! trans('laravelroles::laravelroles.modals.destroy_modal_title', ['type' => e($type), 'item' => e($item->name)]) !!}" data-message="{!! trans('laravelroles::laravelroles.modals.destroy_modal_message', ['type' => e($type), 'item' => e($item->name)]) !!}" >
        {!! $btnText !!}
        <i class="fa-solid fa-trash fa-fw" aria-hidden="true"></i>
    </button>
</form>
