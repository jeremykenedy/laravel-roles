@php
    if (!isset($actionBtnIcon)) {
        $actionBtnIcon = null;
    } else {
        $actionBtnIcon = $actionBtnIcon . ' fa-fw';
    }
    if (!isset($modalClass)) {
        $modalClass = null;
    }
    if (!isset($btnSubmitText)) {
        $btnSubmitText = trans('laravelroles::laravelroles.modals.btnConfirm');
    }
@endphp
<div class="modal fade modal-{{ $modalClass }}" id="{{ $formTrigger }}" tabindex="-1" aria-labelledby="{{ $formTrigger }}Label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header {{ $modalClass }}">
                <h5 class="modal-title" id="{{ $formTrigger }}Label">
                    {!! trans('laravelroles::laravelroles.modals.btnConfirm') !!}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ trans('laravelroles::laravelroles.flash-messages.close') }}"></button>
            </div>
            <div class="modal-body">
                <p></p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-outline-secondary me-auto" type="button" data-bs-dismiss="modal">
                    <i class="fa-solid fa-fw fa-xmark" aria-hidden="true"></i>
                    {!! trans('laravelroles::laravelroles.modals.btnCancel') !!}
                </button>
                <button class="btn btn-{{ $modalClass }}" id="confirm" type="button">
                    <i class="{{ $actionBtnIcon }}" aria-hidden="true"></i>
                    {{ $btnSubmitText }}
                </button>
            </div>
        </div>
    </div>
</div>
