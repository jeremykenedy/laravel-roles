<div class="{{ $rolesContainerClass }} {{ $bootstrapCardClasses }}">
    <div class="{{ $rolesContainerHeaderClass }}">
        <div style="display: flex; justify-content: space-between; align-items: center;">

            <span id="card_title">
                {!! trans('laravelroles::laravelroles.titles.permissions-table') !!}
            </span>

            @if($deletedPermissionsItems->count() > 0)
                <div class="btn-group pull-right btn-group-xs">
                    <button type="button" class="btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-ellipsis-v fa-fw" aria-hidden="true"></i>
                        <span class="sr-only">
                            {!! trans('laravelroles::laravelroles.dropdown-menu-alt') !!}
                        </span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="{{ route('laravelroles::permissions.create') }}">
                            <i class="fa fa-fw fa-plus" aria-hidden="true"></i>
                            {!! trans('laravelroles::laravelroles.buttons.create-new-permission') !!}
                        </a>
                        <a class="dropdown-item" href="">
                            <i class="fa fa-fw fa-trash-o" aria-hidden="true"></i>
                            {!! trans('laravelroles::laravelroles.buttons.show-deleted-permissions') !!}
                            <span class="badge-pill badge badge-danger">
                                {{ $deletedPermissionsItems->count() }}
                            </span>
                        </a>
                    </div>
                </div>
            @else
                <div class="float-right">
                    <a class="btn btn-sm" href="{{ route('laravelroles::permissions.create') }}">
                        <i class="fa fa-fw fa-plus" aria-hidden="true"></i>
                        {!! trans('laravelroles::laravelroles.buttons.create-new-permission') !!}
                    </a>
                </div>
            @endif
        </div>
    </div>
    <div class="{{ $rolesContainerBodyClass }}">
        @include('laravelroles::laravelroles.tables.permission-items-table', ['tabletype' => 'normal', 'items' => $sortedPermissionsRolesUsers])
    </div>
</div>
