<script>
    $(document).ready(function() {
        const clear_rest_payment_date = $('#clear_rest_payment_date');
        const rest_payment_date = $('input[name="rest_payment_date"]');

        clear_rest_payment_date.on('click', function() {
            rest_payment_date.val('');
        })
    })
</script>
