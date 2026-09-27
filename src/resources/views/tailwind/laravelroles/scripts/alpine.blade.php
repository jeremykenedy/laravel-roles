@if(config('roles.enableAlpineJsCDN'))
    <script>
        // The GUI views yield their script section twice, so requesting Alpine
        // with a plain tag would load and initialise it twice.
        if (!window.laravelRolesAlpineRequested) {
            window.laravelRolesAlpineRequested = true;

            var laravelRolesAlpine = document.createElement('script');
            laravelRolesAlpine.defer = true;
            laravelRolesAlpine.src = "{{ config('roles.alpineJsCDN') }}";
            document.head.appendChild(laravelRolesAlpine);
        }
    </script>
@endif
