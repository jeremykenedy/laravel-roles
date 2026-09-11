<form x-data action="{{ route('laravelroles::roles-deleted-restore-all') }}" method="POST" accept-charset="utf-8" class="mb-0">
    {{ csrf_field() }}
    {{ method_field('POST') }}
    <button type="button"
        data-modal="confirmRestoreRoles"
        data-title="{{ trans('laravelroles::laravelroles.modals.restoreAllRolesTitle') }}"
        data-message="{{ trans('laravelroles::laravelroles.modals.restoreAllRolesMessage') }}"
        x-on:click="$dispatch('roles-confirm', { modal: $el.dataset.modal, title: $el.dataset.title, message: $el.dataset.message, form: $el.closest('form') })"
        class="flex w-full items-center gap-2 px-4 py-2 text-left text-sm text-green-600 transition hover:bg-green-50 focus-visible:outline-none focus-visible:bg-green-50 dark:text-green-400 dark:hover:bg-green-500/10 dark:focus-visible:bg-green-500/10 motion-reduce:transition-none">
        <svg class="h-4 w-4 shrink-0" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true" focusable="false"><path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd" /></svg>
        {!! trans('laravelroles::laravelroles.buttons.restore-all-roles') !!}
    </button>
</form>
