@php
    $formClass  = '';
    $btnClass   = 'border border-red-300 text-red-700 hover:bg-red-50 dark:border-red-500/60 dark:text-red-300 dark:hover:bg-red-500/10 px-2.5 py-1.5 text-xs';
    $btnText    = trans("laravelroles::laravelroles.buttons.destroy");
    $btnTooltip = trans('laravelroles::laravelroles.tooltips.destroy-role');
    $formAction = route('laravelroles::role-item-destroy', $item->id);
    $dataTarget = 'confirmDestroyRoles';
    if (isset($large)) {
        $formClass = 'mb-0';
        $btnClass  = 'border border-red-300 text-red-700 hover:bg-red-50 dark:border-red-500/60 dark:text-red-300 dark:hover:bg-red-500/10 px-4 py-2 text-sm';
        $btnText   = trans("laravelroles::laravelroles.buttons.destroy-large");
    }
    if ($type == 'Permission') {
        $btnTooltip = trans('laravelroles::laravelroles.tooltips.destroy-permission');
        $formAction = route('laravelroles::permission-item-destroy', $item->id);
        $dataTarget = 'confirmDestroyPermissions';
    }
@endphp

<form x-data action="{{ $formAction }}" method="POST" accept-charset="utf-8" title="{{ $btnTooltip }}" class="{{ $formClass }}">
    {{ csrf_field() }}
    {{ method_field('DELETE') }}
    <button type="button"
        data-modal="{{ $dataTarget }}"
        data-title="{{ trans('laravelroles::laravelroles.modals.destroy_modal_title', ['type' => $type, 'item' => $item->name]) }}"
        data-message="{{ trans('laravelroles::laravelroles.modals.destroy_modal_message', ['type' => $type, 'item' => $item->name]) }}"
        x-on:click="$dispatch('roles-confirm', { modal: $el.dataset.modal, title: $el.dataset.title, message: $el.dataset.message, form: $el.closest('form') })"
        class="inline-flex w-full items-center justify-center gap-1.5 rounded-md font-medium transition focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-red-500 focus-visible:ring-offset-2 dark:focus-visible:ring-offset-gray-800 motion-reduce:transition-none {{ $btnClass }}">
        {!! $btnText !!}
        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true" focusable="false">
            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
        </svg>
    </button>
</form>
