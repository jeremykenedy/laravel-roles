<form action="{{ route('laravelroles::roles.store') }}" method="POST" accept-charset="utf-8" id="store_role_form" class="mb-0" enctype="multipart/form-data" role="form">
    {{ method_field('POST') }}
    <div class="px-4 py-4">
        @include('laravelroles::laravelroles.forms.role-form')
    </div>
    <div class="border-t border-gray-200 px-4 py-4 dark:border-gray-700">
        <div class="sm:w-1/2">
            <button type="submit" value="save" name="action"
                title="{{ trans('laravelroles::laravelroles.tooltips.save-role') }}"
                class="inline-flex w-full items-center justify-center gap-2 rounded-md bg-green-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-green-700 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-green-500 focus-visible:ring-offset-2 dark:bg-green-500 dark:hover:bg-green-400 dark:focus-visible:ring-offset-gray-800 motion-reduce:transition-none">
                <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true" focusable="false">
                    <path d="M3 3a2 2 0 00-2 2v10a2 2 0 002 2h14a2 2 0 002-2V7.414A2 2 0 0018.414 6L14 1.586A2 2 0 0012.586 1H3zm3 1h6v3H6V4zm-1 8h10v5H5v-5z" />
                </svg>
                <span class="sr-only">{!! trans("laravelroles::laravelroles.forms.roles-form.buttons.save-role.sr-icon") !!}</span>
                {!! trans("laravelroles::laravelroles.forms.roles-form.buttons.save-role.name") !!}
            </button>
        </div>
    </div>
</form>

@include('laravelroles::laravelroles.scripts.form-inputs-helpers')
