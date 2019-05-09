<div class="{{ $rolesContainerClass }} {{ $bootstrapCardClasses }}">
    <div class="{{ $rolesContainerHeaderClass }}">
        <div style="display: flex; justify-content: space-between; align-items: center;">

            <span id="card_title">
                {!! trans('laravelroles::laravelroles.titles.roles-table') !!}
            </span>

            @if($deletedRoleItems->count() > 0)
                <div class="btn-group pull-right btn-group-xs">
                    <button type="button" class="btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-ellipsis-v fa-fw" aria-hidden="true"></i>
                        <span class="sr-only">
                            {!! trans('laravelroles::laravelroles.dropdown-menu-alt') !!}
                        </span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="{{ route('laravelroles::roles.create') }}">
                            <i class="fa fa-fw fa-plus" aria-hidden="true"></i>
                            {!! trans('laravelroles::laravelroles.buttons.create-new-role') !!}
                        </a>
                        <a class="dropdown-item" href="">
                            <i class="fa fa-fw fa-trash-o" aria-hidden="true"></i>
                            {!! trans('laravelroles::laravelroles.buttons.show-deleted-roles') !!}
                            <span class="badge-pill badge badge-danger">
                                {{ $deletedRoleItems->count() }}
                            </span>
                        </a>
                    </div>
                </div>
            @else
                <div class="float-right">
                    <a class="btn btn-sm" href="{{ route('laravelroles::roles.create') }}">
                        <i class="fa fa-fw fa-plus" aria-hidden="true"></i>
                        {!! trans('laravelroles::laravelroles.buttons.create-new-role') !!}
                    </a>
                </div>
            @endif
        </div>
    </div>
    <div class="{{ $rolesContainerBodyClass }}">
        @include('laravelroles::laravelroles.tables.role-items-table', ['tabletype' => 'normal', 'items' => $sortedRolesWithPermissionsAndUsers])
    </div>
</div>
