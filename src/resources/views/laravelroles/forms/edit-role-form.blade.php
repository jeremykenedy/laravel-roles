<form action="{{ route('laravelroles::roles.update', $id) }}" method="POST" accept-charset="utf-8" id="edit_role_form" class="mb-0 needs-validation" enctype="multipart/form-data" role="form" >
    {{ method_field('PATCH') }}
    <div class="card-body">
        <input type="hidden" name="id" value="{{ $id }}">
        @include('laravelroles::laravelroles.forms.role-form')
    </div>
    <div class="card-footer">
        <div class="row ">
            <div class="col-md-6">
                <span data-toggle="tooltip" title="{!! trans('laravelroles::laravelroles.tooltips.update-role') !!}">
                    <button type="submit" class="btn btn-success btn-lg btn-block" value="save" name="action">
                        <i class="fa fa-save fa-fw">
                            <span class="sr-only">
                                 {!! trans("laravelroles::laravelroles.forms.roles-form.buttons.save-role.sr-icon") !!}
                            </span>
                        </i>
                        {!! trans("laravelroles::laravelroles.forms.roles-form.buttons.update-role.name") !!}
                    </button>
                </span>
            </div>
        </div>
    </div>
</form>

@include('laravelroles::laravelroles.scripts.form-inputs-helpers')
