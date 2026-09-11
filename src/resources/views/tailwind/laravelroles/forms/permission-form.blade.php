{{ csrf_field() }}
<div class="grid grid-cols-1 gap-x-6 md:grid-cols-3">
    <div class="md:col-span-2">
        @include('laravelroles::laravelroles.forms.partials.permission-name-input')
        @include('laravelroles::laravelroles.forms.partials.permission-slug-input')
        @include('laravelroles::laravelroles.forms.partials.permission-desc-input')
    </div>
    <div class="md:col-span-1">
        @include('laravelroles::laravelroles.forms.partials.permissions-model-select')
    </div>
</div>
