<script>
    $(document).ready(function() {
        $('#check_idorpassport').on('click', function() {
            const idorpassport = $('input[name="idorpassport"]').val();

            if (idorpassport) {
                $.ajax({
                    url: '{{ url("/ajax/tenants") }}/' + idorpassport,
                    type: 'GET',
                    dataType: 'JSON',
                    success: function(tenant) {
                        if (tenant.transaction) {
                            $('#check_idorpassport').removeClass('text-danger');
                            $('#check_idorpassport').addClass('text-success');
                            $('input[name="name"]').empty();
                            $('input[name="name"]').val(tenant.name);
                            $('input[name="tenant_id"]').val(tenant.id);
                            $('input[name="tenants_fixed_deposit"]').val(tenant.fixed_deposit);
                            $('input[name="tenants_previous_balance"]').val(tenant.previous_balance);
                            $('input[name="name"]').css('color', 'black');

                            $('select[name="building_id"]').val(tenant.transaction.building_id);

                            $('select[name="floor_id"]').empty();
                            $('select[name="floor_id"]').append('<option value="' + tenant.transaction.floor_id + '">' + tenant.transaction.floor.name +'</option>');

                            $('select[name="flat_id"]').empty();
                            $('select[name="flat_id"]').append('<option value="' + tenant.transaction.flat_id + '">' + tenant.transaction.flat.flat_no +'</option>');

                            $('select[name="partition_id"]').empty();
                            $('select[name="partition_id"]').append('<option value="' + tenant.transaction.partition_id + '">' + tenant.transaction.partition.p_number +'</option>');

                            $('input[name="no_of_tenant"]').empty();
                            $('input[name="no_of_tenant"]').val(tenant.transaction.no_of_tenant);

                            $('input[name="price"]').empty();
                            $('input[name="price"]').val(tenant.transaction.price);

                            // Get Start Date With Specific Format
                            const convertedStartDate = new Date(tenant.transaction.end_date);
                            const getStartYear = convertedStartDate.getFullYear();
                            const getStartMonth = convertedStartDate.toLocaleString('default', { month: 'long' });
                            const getStartDay = convertedStartDate.getDate() + 1;

                            $('input[name="start_date"]').val(getStartDay + ' ' + getStartMonth + ', ' + getStartYear);

                        } else {
                            $('#check_idorpassport').removeClass('text-danger');
                            $('#check_idorpassport').addClass('text-success');

                            $('input[name="name"]').empty();
                            $('input[name="name"]').val(tenant.name);
                            $('input[name="tenant_id"]').val(tenant.id);
                            $('input[name="tenants_fixed_deposit"]').val(tenant.fixed_deposit);
                            $('input[name="tenants_previous_balance"]').val(tenant.previous_balance);
                            $('input[name="name"]').css('color', 'black');

                            // $('select[name="building_id"]').append('<option selected>Select A Building</option>');

                            $('select[name="floor_id"]').empty();
                            $('select[name="floor_id"]').append('<option>Select A Floor</option>');

                            $('select[name="flat_id"]').empty();
                            $('select[name="flat_id"]').append('<option>Select A Flat</option>');

                            $('select[name="partition_id"]').empty();
                            $('select[name="partition_id"]').append('<option>Select A Partition</option>');

                            $('input[name="no_of_tenant"]').val('');
                            $('input[name="price"]').empty();
                            $('input[name="start_date"]').empty();
                        }
                    },
                    error: function (xhr, status, error) {
                        // var errorMessage = xhr.status + ': ' + xhr.statusText
                        // console.log('Error - ' + errorMessage);
                        $('#check_idorpassport').removeClass('text-success');
                        $('#check_idorpassport').addClass('text-danger');

                        $('input[name="name"]').val('No tenant found.');
                        $('input[name="name"]').css({'text-transform': 'capitalize', 'color': 'red', 'font-size': '15px'});

                        $('#addTenant').modal('show');
                    }
                })
            }
        })
    })
</script>
