<form action="{{ route('laravelroles::permissions.update', $id) }}" method="POST" accept-charset="utf-8" id="edit_permission_form" class="mb-0 needs-validation" enctype="multipart/form-data" role="form" >
    {{ method_field('PATCH') }}
    <div class="card-body">
        <input type="hidden" name="id" value="{{ $id }}">
        @include('laravelroles::laravelroles.forms.permission-form')
    </div>
    <div class="card-footer">
        <div class="row ">
            <div class="col-md-6">
                <span data-toggle="tooltip" title="{!! trans('laravelroles::laravelroles.tooltips.update-permission') !!}">
                    <button type="submit" class="btn btn-success btn-lg btn-block" value="save" name="action">
                        <i class="fa fa-save fa-fw">
                            <span class="sr-only">
                                 {!! trans("laravelroles::laravelroles.forms.permissions-form.buttons.save-permission.sr-icon") !!}
                            </span>
                        </i>
                        {!! trans("laravelroles::laravelroles.forms.permissions-form.buttons.update-permission.name") !!}
                    </button>
                </span>
            </div>
        </div>
    </div>
</form>
