<form x-data action="{{ route('laravelroles::destroy-all-deleted-roles') }}" method="POST" accept-charset="utf-8" class="mb-0">
    {{ csrf_field() }}
    {{ method_field('DELETE') }}
    <button type="button"
        data-modal="confirmDestroyRoles"
        data-title="{{ trans('laravelroles::laravelroles.modals.destroyAllRolesTitle') }}"
        data-message="{{ trans('laravelroles::laravelroles.modals.destroyAllRolesMessage') }}"
        x-on:click="$dispatch('roles-confirm', { modal: $el.dataset.modal, title: $el.dataset.title, message: $el.dataset.message, form: $el.closest('form') })"
        class="flex w-full items-center gap-2 px-4 py-2 text-left text-sm text-red-600 transition hover:bg-red-50 focus-visible:outline-none focus-visible:bg-red-50 dark:text-red-400 dark:hover:bg-red-500/10 dark:focus-visible:bg-red-500/10 motion-reduce:transition-none">
        <svg class="h-4 w-4 shrink-0" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true" focusable="false"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" /></svg>
        {!! trans('laravelroles::laravelroles.buttons.destroy-all-roles') !!}
    </button>
</form>
