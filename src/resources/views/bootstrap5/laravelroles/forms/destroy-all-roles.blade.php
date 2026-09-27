<form action="{{ route('laravelroles::destroy-all-deleted-roles') }}" method="POST" accept-charset="utf-8" class="mb-0">
    {{ csrf_field() }}
    {{ method_field('DELETE') }}
    <button class="dropdown-item text-danger mt-2 pointer" type="button" style="width: 100%;" data-bs-toggle="modal" data-bs-target="#confirmDestroyRoles" data-title="{{ trans('laravelroles::laravelroles.modals.destroyAllRolesTitle') }}" data-message="{{ trans('laravelroles::laravelroles.modals.destroyAllRolesMessage') }}" >
        <i class="fa-solid fa-fw fa-trash-can" aria-hidden="true"></i>
        {!! trans('laravelroles::laravelroles.buttons.destroy-all-roles') !!}
    </button>
</form>

