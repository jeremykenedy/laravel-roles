@if(config('roles.builtInFlashMessagesEnabled'))
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                @include('laravelroles::laravelroles.partials.form-status')
            </div>
        </div>
    </div>
@endif
