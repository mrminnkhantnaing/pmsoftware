<script>
    $(document).ready(function() {
        $('#invoice_type').on('change', function() {
            const invoice_type = $('#invoice_type').val();

            if (invoice_type == 'payment') {
                $('.invoice_type_payment').removeClass('d-none'); // Remove d-none in invoice type - payment
                $('.invoice_type_reservation').addClass('d-none'); // Add d-none in invoice type - reservation
            } else {
                $('.invoice_type_reservation').removeClass('d-none'); // Remove d-none in invoice type - reservation
                $('.invoice_type_payment').addClass('d-none'); // Add d-none in invoice type - payment
            }
        })

        setTimeout(function() {
            const invoice_type = $('#invoice_type').val();

            if (invoice_type == 'payment') {
                $('.invoice_type_payment').removeClass('d-none'); // Remove d-none in invoice type - payment
                $('.invoice_type_reservation').addClass('d-none'); // Add d-none in invoice type - reservation
            }

            if (invoice_type == 'reservation') {
                $('.invoice_type_reservation').removeClass('d-none'); // Remove d-none in invoice type - reservation
                $('.invoice_type_payment').addClass('d-none'); // Add d-none in invoice type - payment
            }
        }, 1)
    })
</script>
