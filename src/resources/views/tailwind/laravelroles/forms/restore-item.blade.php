@php
    $formClass    = '';
    $btnClass     = 'border border-green-300 text-green-700 hover:bg-green-50 dark:border-green-500/60 dark:text-green-300 dark:hover:bg-green-500/10 px-2.5 py-1.5 text-xs';
    $btnText      = '';
    $btnTooltip   = '';
    $formAction   = '';
    $modalTitle   = '';
    $modalMessage = '';
    $dataTarget   = '';

    if ($type == 'role') {
        $formAction   = route('laravelroles::role-restore', $item->id);
        $btnTooltip   = trans('laravelroles::laravelroles.tooltips.restore-role');
        $btnText      = trans("laravelroles::laravelroles.buttons.restore-role");
        $modalTitle   = trans('laravelroles::laravelroles.modals.restore_modal_title', ['type' => $type, 'item' => $item->name]);
        $modalMessage = trans('laravelroles::laravelroles.modals.restore_modal_message', ['type' => $type, 'item' => $item->name]);
        $dataTarget   = 'confirmRestoreRoles';
    }
    if ($type == 'permission') {
        $formAction   = route('laravelroles::permission-restore', $item->id);
        $btnTooltip   = trans('laravelroles::laravelroles.tooltips.restore-permission');
        $btnText      = trans("laravelroles::laravelroles.buttons.restore-permission");
        $modalTitle   = trans('laravelroles::laravelroles.modals.restore_modal_title', ['type' => $type, 'item' => $item->name]);
        $modalMessage = trans('laravelroles::laravelroles.modals.restore_modal_message', ['type' => $type, 'item' => $item->name]);
        $dataTarget   = 'confirmRestorePermissions';
    }
    if ($style == 'large' && $type == 'role') {
        $btnText   = trans("laravelroles::laravelroles.buttons.restore-role-large");
        $btnClass  = 'border border-green-300 text-green-700 hover:bg-green-50 dark:border-green-500/60 dark:text-green-300 dark:hover:bg-green-500/10 px-4 py-2 text-sm';
        $formClass = 'mb-0';
    }
    if ($style == 'large' && $type == 'permission') {
        $btnText   = trans("laravelroles::laravelroles.buttons.restore-permission-large");
        $btnClass  = 'border border-green-300 text-green-700 hover:bg-green-50 dark:border-green-500/60 dark:text-green-300 dark:hover:bg-green-500/10 px-4 py-2 text-sm';
        $formClass = 'mb-0';
    }
@endphp

<form x-data action="{{ $formAction }}" method="POST" accept-charset="utf-8" title="{{ $btnTooltip }}" class="{{ $formClass }}">
    {{ csrf_field() }}
    {{ method_field('PUT') }}
    <button type="button"
        data-modal="{{ $dataTarget }}"
        data-title="{{ $modalTitle }}"
        data-message="{{ $modalMessage }}"
        x-on:click="$dispatch('roles-confirm', { modal: $el.dataset.modal, title: $el.dataset.title, message: $el.dataset.message, form: $el.closest('form') })"
        class="inline-flex w-full items-center justify-center gap-1.5 rounded-md font-medium transition focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-green-500 focus-visible:ring-offset-2 dark:focus-visible:ring-offset-gray-800 motion-reduce:transition-none {{ $btnClass }}">
        {!! $btnText !!}
        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true" focusable="false">
            <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd" />
        </svg>
    </button>
</form>
