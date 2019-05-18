<script type="text/javascript">
    function numbersAndLettersOnly() {
        var ek = event.keyCode;
        if(48 <= ek && ek <= 57) {
            return true;
        }
        if(65 <= ek && ek <= 90) {
            return true;
        }
        if(97 <= ek && ek <= 122) {
            return true;
        }
        return false;
    }
</script>
