<script type="text/javascript">
    var noConflictMode = jQuery.noConflict(true);
    (function ($) {
        $(document).ready(function () {
            $("#permissions").selectize({
                placeholder: ' {{ trans("laravelroles::laravelroles.forms.roles-form.role-permissions.placeholder") }} ',
                allowClear: true,
                create: false,
                highlight: true,
                diacritics: true
            });
        });
    }(noConflictMode));
</script>
