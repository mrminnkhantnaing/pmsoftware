<script>
    const grand_total = document.getElementById('grand_total');
    const balance = document.getElementById('balance');

    const payment_amount = document.getElementById('payment_amount');
    const deposit = document.getElementById('deposit');

    const check_payment_amount = document.getElementById('check_payment_amount');
    const check_deposit = document.getElementById('check_deposit');

    const rest_payment_date_option = document.getElementById('rest_payment_date_option');

    if (check_payment_amount) {
        check_payment_amount.addEventListener('click', function() {
            check_payment_amount.classList.add("text-success");

            if(deposit) {
                deposit.value = '';
                check_deposit.classList.remove("text-success");
            }
            balance.value = grand_total.value - payment_amount.value;

            if (balance.value != 0) {
                rest_payment_date_option.innerHTML = '';
                rest_payment_date_option.innerHTML = '<span class="text-danger">*</span>';
            } else if (balance.value == 0 && payment_amount.value) {
                rest_payment_date_option.innerHTML = '';
                rest_payment_date_option.innerHTML = '<span class="text-dark">(Optional)</span>';
            }
        });
    }

    if (check_deposit) {
        check_deposit.addEventListener('click', function() {
            console.log('hi');
            check_deposit.classList.add("text-success");

            if(payment_amount) {
                payment_amount.value = '';
                check_payment_amount.classList.remove("text-success");
            }
            balance.value = grand_total.value - deposit.value;
        });
    }
</script>
