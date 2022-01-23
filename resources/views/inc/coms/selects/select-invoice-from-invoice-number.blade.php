<script>
    $(document).ready(function() {
        $('#check_invoice_no').on('click', function() {
            const invoice_no = $('input[name="invoice_no"]').val();

            if (invoice_no) {
                $.ajax({
                    url: '{{ url("/ajax/invoices/transactions") }}/' + invoice_no,
                    type: 'GET',
                    dataType: 'JSON',
                    success: function(invoice) {
                        $('#check_invoice_no').removeClass('text-danger');
                        $('#check_invoice_no').addClass('text-success');
                        $('#invoice_error').text('');

                        $('input[name="invoice_id"]').val(invoice.id);

                        $('input[name="idorpassport"]').val(invoice.tenant.idorpassport);
                        $('input[name="name"]').val(invoice.tenant.name);

                        $('input[name="building_id"]').val(invoice.building.name);
                        $('input[name="ibuilding_id"]').val(invoice.building_id);
                        $('input[name="floor_id"]').val(invoice.floor.name);
                        $('input[name="ifloor_id"]').val(invoice.floor_id);
                        $('input[name="flat_id"]').val(invoice.flat.flat_no);
                        $('input[name="iflat_id"]').val(invoice.flat_id);
                        $('input[name="partition_id"]').val(invoice.partition.p_number);
                        $('input[name="ipartition_id"]').val(invoice.partition_id);
                        $('input[name="no_of_tenant"]').val(invoice.no_of_tenant);
                        $('input[name="tenant_id"]').val(invoice.tenant_id);

                        $('input[name="price"]').val(invoice.price);

                        // Get Start Date With Specific Format
                        const convertedStartDate = new Date(invoice.start_date);
                        const getStartYear = convertedStartDate.getFullYear();
                        const getStartMonth = convertedStartDate.toLocaleString('default', { month: 'long' });
                        const getStartDay = convertedStartDate.getDate();

                        $('input[name="start_date"]').val(getStartDay + ' ' + getStartMonth + ', ' + getStartYear);

                        // Get End Date With Specific Format
                        const convertedEndDate = new Date(invoice.end_date);
                        const getEndYear = convertedEndDate.getFullYear();
                        const getEndMonth = convertedEndDate.toLocaleString('default', { month: 'long' });
                        const getEndDay = convertedEndDate.getDate();

                        $('input[name="end_date"]').val(getEndDay + ' ' + getEndMonth + ', ' + getEndYear);

                        $('input[name="sub_total"]').val(invoice.sub_total);

                        if (invoice.referrer_id) {
                            $('input[name="referrer_id"]').val(invoice.referrer.name);
                        }

                        if (invoice.card_id) {
                            $('input[name="code"]').val(invoice.card.code);
                            $('input[name="card_id"]').val(invoice.card_id);
                            $('input[name="status"]').val('Taken by this tenant');
                            $('input[name="code"]').prop('disabled', true);
                        } else {
                            $('input[name="code"]').val('');
                            $('input[name="code"]').prop('disabled', true);
                            $('input[name="status"]').val('No card is added');
                        }

                        $('input[name="grand_total"]').val(invoice.total_price);

                        // Calculate Initial Payment Amount
                        let paid_balance_amount = 0;

                        if (invoice.payment_amount) {
                            $('input[name="invoice_type"]').val('Payment');

                            if (invoice.paybalances) {

                                invoice.paybalances.map(function(paybalance) {
                                    paid_balance_amount += paybalance.current_payment_amount;
                                });

                                // console.log(parseInt(paid_balance_amount) + parseInt(invoice.payment_amount));

                                $('input[name="initial_payment_amount"]').val(parseInt(paid_balance_amount) + parseInt(invoice.payment_amount));
                            } else {
                                $('input[name="initial_payment_amount"]').val(invoice.payment_amount);
                            }

                        }

                        if (invoice.deposit) {
                            $('input[name="invoice_type"]').val('Reservation');
                            $('input[name="initial_payment_amount"]').val(invoice.deposit);
                        }

                        // Calculate Balance From Initial Payment Button
                        $('#calculate_balance_from_initial_payment').on('click', function() {
                            const total_price = parseInt($('input[name="grand_total"]').val());
                            const initial_payment_amount = parseInt($('input[name="initial_payment_amount"]').val());
                            const current_payment_amount = parseInt($('input[name="current_payment_amount"]').val());
                            const balance = $('input[name="balance"]');

                            balance.val(total_price - (initial_payment_amount + current_payment_amount));

                            $('#calculate_balance_from_initial_payment').addClass('text-success');
                        });

                        // Calculate Balance From Current Payment Button
                        $('#calculate_balance_from_current_payment').on('click', function() {
                            const total_price = parseInt($('input[name="grand_total"]').val());
                            const initial_payment_amount = parseInt($('input[name="initial_payment_amount"]').val());
                            const current_payment_amount = parseInt($('input[name="current_payment_amount"]').val());
                            const balance = $('input[name="balance"]');

                            balance.val(total_price - (initial_payment_amount + current_payment_amount));

                            $('#calculate_balance_from_current_payment').addClass('text-success');
                        });

                        if (invoice.paybalances) {
                            $('input[name="balance"]').val(parseInt(invoice.total_price) - (parseInt(paid_balance_amount) + parseInt(invoice.payment_amount)));
                        }

                        if (invoice.deposit) {
                            $('input[name="balance"]').val(invoice.balance);
                        }
                    },
                    error: function (xhr, status, error) {
                        $('#check_invoice_no').removeClass('text-success');
                        $('#check_invoice_no').addClass('text-danger');

                        if (xhr.status == 403) {
                            $('#invoice_error').text('Yoo. This invoice has already been paid.');
                        } else if (xhr.status == 404) {
                            $('#invoice_error').text('Oh gosh. Invoice number is invalid.');
                        }

                        // Empty every field
                        $('input[name="idorpassport"]').val('');
                        $('input[name="name"]').val('');
                        $('input[name="building_id"]').val('');
                        $('input[name="floor_id"]').val('');
                        $('input[name="flat_id"]').val('');
                        $('input[name="partition_id"]').val('');
                        $('input[name="no_of_tenant"]').val('');
                        $('input[name="price"]').val('');
                        $('input[name="start_date"]').val('');
                        $('input[name="end_date"]').val('');
                        $('input[name="sub_total"]').val('');
                        $('input[name="referrer_id"]').val('');
                        $('input[name="code"]').val('');
                        $('input[name="status"]').val('');
                        $('input[name="grand_total"]').val('');
                        $('input[name="invoice_type"]').val('');
                        $('input[name="initial_payment_amount"]').val('');
                        $('input[name="current_payment_amount"]').val('');
                        $('input[name="balance"]').val('');
                    }
                })
            }
        });

        // Calculate Balance From Initial Payment Button
        $('#calculate_balance_from_initial_payment').on('click', function() {
            const total_price = parseInt($('input[name="grand_total"]').val());
            const initial_payment_amount = parseInt($('input[name="initial_payment_amount"]').val());
            const current_payment_amount = parseInt($('input[name="current_payment_amount"]').val());
            const balance = $('input[name="balance"]');

            balance.val(total_price - (initial_payment_amount + current_payment_amount));

            $('#calculate_balance_from_initial_payment').addClass('text-success');
        });

        // Calculate Balance From Current Payment Button
        $('#calculate_balance_from_current_payment').on('click', function() {
            const total_price = parseInt($('input[name="grand_total"]').val());
            const initial_payment_amount = parseInt($('input[name="initial_payment_amount"]').val());
            const current_payment_amount = parseInt($('input[name="current_payment_amount"]').val());
            const balance = $('input[name="balance"]');

            balance.val(total_price - (initial_payment_amount + current_payment_amount));

            $('#calculate_balance_from_current_payment').addClass('text-success');
        });
    })
</script>
