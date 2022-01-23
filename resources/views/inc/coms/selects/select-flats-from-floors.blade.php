<script>
    $(document).ready(function() {
        $('select[name="floor_id"]').on('change', function() {
            const floor_id = $(this).val();
            if(floor_id) {
                $.ajax({
                    url: '{{ url("/ajax/building/floor/flat/") }}/' + floor_id,
                    type: 'GET',
                    dataType: 'JSON',
                    success: function(flats) {
                        $('select[name="partition_id"]').empty();
                        $('select[name="partition_id"]').append('<option value="">Select A Partition</option>');

                        $('#bedspace_ids').empty();
                        $('#bedspace_ids').append('<option value="">Select A Bedspace</option>');

                        $('select[name="flat_id"]').empty();
                        $('select[name="flat_id"]').append('<option value="">Select A Flat</option>');

                        $.each(flats, function(key, value) {
                            $('select[name="flat_id"]').append('<option value="'+ value.id +'">'+ value.flat_no +'</option>')
                        })
                    }
                })
            }
        })
    })
</script>
