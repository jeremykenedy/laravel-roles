<script type="text/javascript">
    (function () {
        var isTouchDevice = 'ontouchstart' in document.documentElement;

        if (isTouchDevice || typeof bootstrap === 'undefined' || !bootstrap.Tooltip) {
            return;
        }

        document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(function (element) {
            new bootstrap.Tooltip(element);
        });
    })();
</script>
