@php
    $alertBase = 'relative mb-4 rounded-lg border p-4 text-sm';
    $alertVariants = [
        'success' => 'border-green-300 bg-green-50 text-green-800 dark:border-green-500/40 dark:bg-green-500/10 dark:text-green-200',
        'danger'  => 'border-red-300 bg-red-50 text-red-800 dark:border-red-500/40 dark:bg-red-500/10 dark:text-red-200',
        'warning' => 'border-amber-300 bg-amber-50 text-amber-800 dark:border-amber-500/40 dark:bg-amber-500/10 dark:text-amber-200',
        'info'    => 'border-sky-300 bg-sky-50 text-sky-800 dark:border-sky-500/40 dark:bg-sky-500/10 dark:text-sky-200',
    ];
    $dismissClasses = 'absolute right-2 top-2 rounded p-1 opacity-60 transition hover:opacity-100 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-current motion-reduce:transition-none';
@endphp

@if (session('message'))
    @php $variant = $alertVariants[Session::get('status')] ?? $alertVariants['info']; @endphp
    <div x-data="{ show: true }" x-show="show" x-cloak class="{{ $alertBase }} {{ $variant }}" role="alert" aria-live="polite">
        <button type="button" x-on:click="show = false" class="{{ $dismissClasses }}" aria-label="{{ trans('laravelroles::laravelroles.flash-messages.close') }}">
            <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true" focusable="false">
                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
            </svg>
        </button>
        {{ session('message') }}
    </div>
@endif

@if (session('success'))
    <div x-data="{ show: true }" x-show="show" x-cloak class="{{ $alertBase }} {{ $alertVariants['success'] }}" role="alert" aria-live="polite">
        <button type="button" x-on:click="show = false" class="{{ $dismissClasses }}" aria-label="{{ trans('laravelroles::laravelroles.flash-messages.close') }}">
            <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true" focusable="false">
                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
            </svg>
        </button>
        <h4 class="mb-1 flex items-center gap-2 font-semibold">
            <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true" focusable="false">
                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
            </svg>
            {!! trans('laravelroles::laravelroles.flash-messages.success') !!}
        </h4>
        {{ session('success') }}
    </div>
@endif

@if(session()->has('status'))
    @if(session()->get('status') == 'wrong')
        <div x-data="{ show: true }" x-show="show" x-cloak class="{{ $alertBase }} {{ $alertVariants['danger'] }}" role="alert" aria-live="polite">
            <button type="button" x-on:click="show = false" class="{{ $dismissClasses }}" aria-label="{{ trans('laravelroles::laravelroles.flash-messages.close') }}">
                <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true" focusable="false">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </button>
            {{ session('message') }}
        </div>
    @endif
@endif

@if (session('error'))
    <div x-data="{ show: true }" x-show="show" x-cloak class="{{ $alertBase }} {{ $alertVariants['danger'] }}" role="alert" aria-live="polite">
        <button type="button" x-on:click="show = false" class="{{ $dismissClasses }}" aria-label="{{ trans('laravelroles::laravelroles.flash-messages.close') }}">
            <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true" focusable="false">
                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
            </svg>
        </button>
        <h4 class="mb-1 flex items-center gap-2 font-semibold">
            <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true" focusable="false">
                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
            </svg>
            {!! trans('laravelroles::laravelroles.flash-messages.error') !!}
        </h4>
        {{ session('error') }}
    </div>
@endif

@if (session('errors') && count($errors) > 0)
    <div x-data="{ show: true }" x-show="show" x-cloak class="{{ $alertBase }} {{ $alertVariants['danger'] }}" role="alert" aria-live="polite">
        <button type="button" x-on:click="show = false" class="{{ $dismissClasses }}" aria-label="{{ trans('laravelroles::laravelroles.flash-messages.close') }}">
            <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true" focusable="false">
                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
            </svg>
        </button>
        <h4 class="mb-1 flex items-center gap-2 font-semibold">
            <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true" focusable="false">
                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
            </svg>
            <strong>{!! trans('laravelroles::laravelroles.flash-messages.whoops') !!}</strong>
            {!! trans('laravelroles::laravelroles.flash-messages.someProblems') !!}
        </h4>
        <ul class="ms-5 list-disc">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
