{{ csrf_field() }}
<div class="grid grid-cols-1 gap-x-6 md:grid-cols-3">
    <div class="md:col-span-2">
        @include('laravelroles::laravelroles.forms.partials.role-name-input')
        @include('laravelroles::laravelroles.forms.partials.role-slug-input')
        @include('laravelroles::laravelroles.forms.partials.role-desc-input')
    </div>
    <div class="md:col-span-1">
        @include('laravelroles::laravelroles.forms.partials.role-level-input')
        @include('laravelroles::laravelroles.forms.partials.role-permissions-select')
    </div>
</div>
