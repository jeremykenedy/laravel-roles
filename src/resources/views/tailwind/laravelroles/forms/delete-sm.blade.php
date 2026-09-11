@php
    $formClass  = '';
    $btnClass   = 'border border-red-300 text-red-700 hover:bg-red-50 dark:border-red-500/60 dark:text-red-300 dark:hover:bg-red-500/10 px-2.5 py-1.5 text-xs';
    $btnText    = trans("laravelroles::laravelroles.buttons.delete");
    $btnTooltip = trans('laravelroles::laravelroles.tooltips.delete-role');
    $formAction = route('laravelroles::roles.destroy', $item->id);
    if (isset($large)) {
        $formClass = 'mb-0';
        $btnClass  = 'bg-red-600 text-white hover:bg-red-700 dark:bg-red-500 dark:hover:bg-red-400 px-4 py-2 text-sm';
        $btnText   = trans("laravelroles::laravelroles.buttons.delete-large");
    }
    if ($type == 'Permission') {
        $btnTooltip = trans('laravelroles::laravelroles.tooltips.delete-permission');
        $formAction = route('laravelroles::permissions.destroy', $item->id);
    }
@endphp

<form x-data action="{{ $formAction }}" method="POST" accept-charset="utf-8" title="{{ $btnTooltip }}" class="{{ $formClass }}">
    {{ csrf_field() }}
    {{ method_field('DELETE') }}
    <button type="button"
        data-modal="confirmDelete"
        data-title="{{ trans('laravelroles::laravelroles.modals.delete_modal_title', ['type' => $type, 'item' => $item->name]) }}"
        data-message="{{ trans('laravelroles::laravelroles.modals.delete_modal_message', ['type' => $type, 'item' => $item->name]) }}"
        x-on:click="$dispatch('roles-confirm', { modal: $el.dataset.modal, title: $el.dataset.title, message: $el.dataset.message, form: $el.closest('form') })"
        class="inline-flex w-full items-center justify-center gap-1.5 rounded-md font-medium transition focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-red-500 focus-visible:ring-offset-2 dark:focus-visible:ring-offset-gray-800 motion-reduce:transition-none {{ $btnClass }}">
        {!! $btnText !!}
    </button>
</form>
