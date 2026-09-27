@extends(config('roles.bladeExtended'))

@section(config('roles.titleExtended'))
    {!! trans('laravelroles::laravelroles.titles.create-permission') !!}
@endsection

@section(config('roles.bladePlacementCss'))
    @include('laravelroles::laravelroles.partials.styles')
    @include('laravelroles::laravelroles.partials.bs-visibility-css')
@endsection

@section('content')

    @include('laravelroles::laravelroles.partials.flash-messages')

    <div class="mx-auto w-full max-w-5xl px-4 py-6">
        <div class="overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm dark:border-gray-700 dark:bg-gray-800">
            <div class="border-b border-gray-200 bg-gray-50 px-4 py-3 dark:border-gray-700 dark:bg-gray-900/40">
                <div class="flex items-center justify-between gap-2">
                    <span id="card_title" class="font-semibold text-gray-900 dark:text-gray-100">
                        {!! trans('laravelroles::laravelroles.titles.create-permission') !!}
                    </span>
                    <a href="{{ route('laravelroles::roles.index') }}" title="{{ trans('laravelroles::laravelroles.tooltips.back-roles') }}"
                        class="inline-flex items-center gap-1.5 rounded-md border border-gray-300 px-2.5 py-1.5 text-xs font-medium text-gray-700 transition hover:bg-gray-50 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500 dark:border-gray-600 dark:text-gray-200 dark:hover:bg-gray-700 motion-reduce:transition-none">
                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true" focusable="false">
                            <path fill-rule="evenodd" d="M7.707 3.293a1 1 0 010 1.414L5.414 7H11a7 7 0 017 7v2a1 1 0 11-2 0v-2a5 5 0 00-5-5H5.414l2.293 2.293a1 1 0 11-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                        {!! trans('laravelroles::laravelroles.buttons.back-to-roles') !!}
                    </a>
                </div>
            </div>
            @include('laravelroles::laravelroles.forms.create-permission-form')
        </div>
    </div>

@endsection

@section(config('roles.bladePlacementJs'))
    @include('laravelroles::laravelroles.scripts.alpine')
@endsection

@yield('inline_template_linked_css')
@yield('inline_footer_scripts')
