@php
    $formClass  = '';
    $btnClass   = 'btn-outline-danger btn-sm';
    $btnText    = trans("laravelroles::laravelroles.buttons.delete");
    $btnTooltip = trans('laravelroles::laravelroles.tooltips.delete-role');
    $formAction = route('laravelroles::roles.destroy', $item->id);
    if(isset($large)) {
        $formClass  = 'mb-0';
        $btnClass   = 'btn-danger btn-sm mb-0';
        $btnText    = trans("laravelroles::laravelroles.buttons.delete-large");
    }
    if($type == 'Permission') {
        $btnTooltip = trans('laravelroles::laravelroles.tooltips.delete-permission');
        $formAction = route('laravelroles::permissions.destroy', $item->id);
    }
@endphp

<form action="{{ $formAction }}" method="POST" accept-charset="utf-8" data-toggle="tooltip" title="{{ $btnTooltip }}" class="{{ $formClass }}" >
    {{ csrf_field() }}
    {{ method_field('DELETE') }}
    <button class="btn btn-block {{ $btnClass }}" type="button" style="width: 100%;" data-toggle="modal" data-target="#confirmDelete" data-title="{!! trans('laravelroles::laravelroles.modals.delete_modal_title', ['type' => $type, 'item' => $item->name]) !!}" data-message="{!! trans('laravelroles::laravelroles.modals.delete_modal_message', ['type' => $type, 'item' => $item->name]) !!}" >
        {!! $btnText !!}
    </button>
</form>
