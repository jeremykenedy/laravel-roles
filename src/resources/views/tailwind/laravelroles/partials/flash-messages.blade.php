@if(config('roles.builtInFlashMessagesEnabled'))
    <div class="mx-auto w-full max-w-7xl px-4">
        @include('laravelroles::laravelroles.partials.form-status')
    </div>
@endif
