<script type="text/javascript">
    (function () {
        var modal = document.querySelector('{{ $formTrigger }}');

        if (!modal) {
            return;
        }

        var pendingForm = null;

        modal.addEventListener('show.bs.modal', function (event) {
            var trigger = event.relatedTarget;

            if (!trigger) {
                return;
            }

            pendingForm = trigger.closest('form');

            var title = modal.querySelector('.modal-title');
            var body = modal.querySelector('.modal-body p');

            if (title) {
                title.textContent = trigger.getAttribute('data-title') || '';
            }

            if (body) {
                body.textContent = trigger.getAttribute('data-message') || '';
            }
        });

        var confirmButton = modal.querySelector('.modal-footer #confirm');

        if (confirmButton) {
            confirmButton.addEventListener('click', function () {
                if (pendingForm) {
                    pendingForm.submit();
                }
            });
        }
    })();
</script>
