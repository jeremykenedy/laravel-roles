<form action="{{ route('laravelroles::destroy-all-deleted-permissions') }}" method="POST" accept-charset="utf-8" class="mb-0">
    {{ csrf_field() }}
    {{ method_field('DELETE') }}
    <button class="dropdown-item text-danger mt-2 pointer" type="button" style="width: 100%;" data-toggle="modal" data-target="#confirmDestroyPermissions" data-title="{{ trans('laravelroles::laravelroles.modals.destroyAllPermissionsTitle') }}" data-message="{{ trans('laravelroles::laravelroles.modals.destroyAllPermissionsMessage') }}" >
        <i class="fa fa-fw fa-trash-o" aria-hidden="true"></i>
        {!! trans('laravelroles::laravelroles.buttons.destroy-all-permissions') !!}
    </button>
</form>
