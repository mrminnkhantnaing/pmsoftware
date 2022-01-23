<script>
    $(document).ready(function() {
        $('select[name="flat_id"]').on('change', function() {
            const flat_id = $(this).val();

            if(flat_id) {
                $.ajax({
                    url: '{{ url("/ajax/building/floor/flat/partition") }}/' + flat_id,
                    type: 'GET',
                    dataType: 'JSON',
                    success: function(partitions) {
                        $('#bedspace_ids').empty();
                        $('#bedspace_ids').append('<option value="">Select A Bedspace</option>');

                        $('select[name="partition_id"]').empty();
                        $('select[name="partition_id"]').append('<option value="">Select A Partition</option>');

                        $.each(partitions, function(key, value) {
                            if (value.status == 'available') {
                                $('select[name="partition_id"]').append('<option value="'+ value.id +'">'+ value.p_number +'</option>')
                            }
                        })
                    }
                })
            }
        })
    })
</script>
