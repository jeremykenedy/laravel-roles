{{ csrf_field() }}
<div class="row">
    <div class="col-md-8">
        @include('laravelroles::laravelroles.forms.partials.permission-name-input')
        @include('laravelroles::laravelroles.forms.partials.permission-slug-input')
        @include('laravelroles::laravelroles.forms.partials.permission-desc-input')
    </div>
    <div class="col-12 col-md-4">
        @include('laravelroles::laravelroles.forms.partials.permissions-model-select')
    </div>
</div>
