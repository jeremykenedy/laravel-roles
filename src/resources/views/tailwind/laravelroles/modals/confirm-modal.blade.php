@php
    if (!isset($modalClass)) {
        $modalClass = 'danger';
    }
    if (!isset($btnSubmitText)) {
        $btnSubmitText = trans('laravelroles::laravelroles.modals.btnConfirm');
    }

    $headerClasses = [
        'danger'  => 'bg-red-600 text-white dark:bg-red-700',
        'success' => 'bg-green-600 text-white dark:bg-green-700',
        'warning' => 'bg-amber-500 text-white dark:bg-amber-600',
        'info'    => 'bg-sky-500 text-white dark:bg-sky-600',
        'primary' => 'bg-indigo-600 text-white dark:bg-indigo-700',
    ];

    $confirmClasses = [
        'danger'  => 'bg-red-600 hover:bg-red-700 focus-visible:ring-red-500 dark:bg-red-500 dark:hover:bg-red-400',
        'success' => 'bg-green-600 hover:bg-green-700 focus-visible:ring-green-500 dark:bg-green-500 dark:hover:bg-green-400',
        'warning' => 'bg-amber-500 hover:bg-amber-600 focus-visible:ring-amber-500 dark:bg-amber-600 dark:hover:bg-amber-500',
        'info'    => 'bg-sky-500 hover:bg-sky-600 focus-visible:ring-sky-500 dark:bg-sky-600 dark:hover:bg-sky-500',
        'primary' => 'bg-indigo-600 hover:bg-indigo-700 focus-visible:ring-indigo-500 dark:bg-indigo-500 dark:hover:bg-indigo-400',
    ];

    $headerClass  = $headerClasses[$modalClass] ?? $headerClasses['danger'];
    $confirmClass = $confirmClasses[$modalClass] ?? $confirmClasses['danger'];
@endphp

<div
    x-data="{ open: false, title: '', message: '', form: null }"
    x-on:roles-confirm.window="if ($event.detail.modal === '{{ $formTrigger }}') { title = $event.detail.title; message = $event.detail.message; form = $event.detail.form; open = true; $nextTick(() => $refs.confirmButton && $refs.confirmButton.focus()); }"
    x-on:keydown.escape.window="open = false"
    x-show="open"
    x-cloak
    id="{{ $formTrigger }}"
    class="fixed inset-0 z-50 flex items-center justify-center p-4"
    role="dialog"
    aria-modal="true"
    aria-labelledby="{{ $formTrigger }}Label"
>
    <div
        x-show="open"
        x-cloak
        x-transition:enter="transition ease-out duration-200 motion-reduce:transition-none"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-150 motion-reduce:transition-none"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        x-on:click="open = false"
        class="fixed inset-0 bg-gray-900/50 dark:bg-black/70"
        aria-hidden="true"
    ></div>

    <div
        x-show="open"
        x-cloak
        x-transition:enter="transition ease-out duration-200 motion-reduce:transition-none"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-150 motion-reduce:transition-none"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="relative w-full max-w-lg overflow-hidden rounded-lg bg-white shadow-xl dark:bg-gray-800"
    >
        <div class="flex items-center justify-between px-4 py-3 {{ $headerClass }}">
            <h5 class="text-base font-semibold" id="{{ $formTrigger }}Label" x-text="title"></h5>
            <button type="button" x-on:click="open = false"
                class="rounded p-1 opacity-80 transition hover:opacity-100 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-white motion-reduce:transition-none"
                aria-label="{{ trans('laravelroles::laravelroles.flash-messages.close') }}">
                <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true" focusable="false">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </button>
        </div>

        <div class="px-4 py-5">
            <p class="text-sm text-gray-700 dark:text-gray-300" x-text="message"></p>
        </div>

        <div class="flex items-center justify-between gap-3 border-t border-gray-200 px-4 py-3 dark:border-gray-700">
            <button type="button" x-on:click="open = false"
                class="inline-flex items-center gap-1.5 rounded-md border border-gray-300 px-3 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-50 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-gray-500 focus-visible:ring-offset-2 dark:border-gray-600 dark:text-gray-200 dark:hover:bg-gray-700 dark:focus-visible:ring-offset-gray-800 motion-reduce:transition-none">
                <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true" focusable="false">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
                {!! trans('laravelroles::laravelroles.modals.btnCancel') !!}
            </button>
            <button type="button" id="confirm" x-ref="confirmButton" x-on:click="if (form) { form.submit(); } open = false;"
                class="inline-flex items-center gap-1.5 rounded-md px-3 py-2 text-sm font-semibold text-white shadow-sm transition focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 dark:focus-visible:ring-offset-gray-800 motion-reduce:transition-none {{ $confirmClass }}">
                {{ $btnSubmitText }}
            </button>
        </div>
    </div>
</div>
