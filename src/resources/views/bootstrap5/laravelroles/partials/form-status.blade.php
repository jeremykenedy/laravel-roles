@if (session('message'))
    <div class="alert alert-{{ Session::get('status') }} status-box alert-dismissible fade show" role="alert">
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="{{ trans('laravelroles::laravelroles.flash-messages.close') }}"></button>
        {!! session('message') !!}
    </div>
@endif

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="{{ trans('laravelroles::laravelroles.flash-messages.close') }}"></button>
        <h4>
            <i class="fa-solid fa-check fa-fw" aria-hidden="true"></i>
            {!! trans('laravelroles::laravelroles.flash-messages.success') !!}
        </h4>
        {!! session('success') !!}
    </div>
@endif

@if(session()->has('status'))
    @if(session()->get('status') == 'wrong')
        <div class="alert alert-danger status-box alert-dismissible fade show" role="alert">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="{{ trans('laravelroles::laravelroles.flash-messages.close') }}"></button>
            {!! session('message') !!}
        </div>
    @endif
@endif

@if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="{{ trans('laravelroles::laravelroles.flash-messages.close') }}"></button>
        <h4>
            <i class="fa-solid fa-triangle-exclamation fa-fw" aria-hidden="true"></i>
            {!! trans('laravelroles::laravelroles.flash-messages.error') !!}
        </h4>
        {!! session('error') !!}
    </div>
@endif

@if (session('errors') && count($errors) > 0)
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="{{ trans('laravelroles::laravelroles.flash-messages.close') }}"></button>
        <h4>
            <i class="fa-solid fa-triangle-exclamation fa-fw" aria-hidden="true"></i>
            <strong>
                {!! trans('laravelroles::laravelroles.flash-messages.whoops') !!}
            </strong>
            {!! trans('laravelroles::laravelroles.flash-messages.someProblems') !!}
        </h4>
        <ul>
            @foreach ($errors->all() as $error)
                <li>
                    {!! $error !!}
                </li>
            @endforeach
        </ul>
    </div>
@endif
