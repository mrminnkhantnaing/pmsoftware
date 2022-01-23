<script>
    $(document).ready(function() {
        $('select[name="building_id"]').on('change', function() {
            const building_id = $(this).val();
            if(building_id) {
                $.ajax({
                    url: '{{ url("/ajax/building/floor") }}/' + building_id,
                    type: 'GET',
                    dataType: 'JSON',
                    success: function(floors) {
                        $('select[name="flat_id"]').empty();
                        $('select[name="flat_id"]').append('<option value="">Select A Flat</option>');

                        $('select[name="partition_id"]').empty();
                        $('select[name="partition_id"]').append('<option value="">Select A Partition</option>');

                        $('#bedspace_ids').empty();
                        $('#bedspace_ids').append('<option value="">Select A Bedspace</option>');

                        $('select[name="floor_id"]').empty();
                        $('select[name="floor_id"]').append('<option value="">Select A Floor</option>');

                        $.each(floors, function(key, value) {
                            $('select[name="floor_id"]').append('<option value="'+ value.id +'">'+ value.name +'</option>')
                        })
                    }
                })
            }
        })
    })
</script>
