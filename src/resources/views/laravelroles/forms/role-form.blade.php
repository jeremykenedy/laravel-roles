{{ csrf_field() }}
<div class="row">
    <div class="col-md-8">
        @include('laravelroles::laravelroles.forms.partials.role-name-input')
        @include('laravelroles::laravelroles.forms.partials.role-slug-input')
        @include('laravelroles::laravelroles.forms.partials.role-desc-input')
    </div>
    <div class="col-12 col-md-4">
        @include('laravelroles::laravelroles.forms.partials.role-level-input')
        @include('laravelroles::laravelroles.forms.partials.role-permissions-select')
    </div>
</div>
