<script>
    $(document).ready(function() {
        $('input[name="start_date"]').on('change', function() {
            $.ajax({
                url: '{{ url("/ajax/settings") }}/',
                type: 'GET',
                dataType: 'JSON',
                success: function(settings) {
                    const price = $('input[name="price"]').val();
                    const sub_total = $('input[name="sub_total"]').val();
                    const start_date = $('input[name="start_date"]').val();
                    const jsStartDate = new Date(start_date);
                    const end_date = $('input[name="end_date"]').val();
                    const jsEndDate = new Date(end_date);
                    const get_time_difference = jsEndDate.getTime() - jsStartDate.getTime();
                    const get_days_difference = (get_time_difference / (1000 * 3600 * 24)) + 1;
                    const card_available = $('input[name="status"]').val();
                    const card_code = $('input[name="code"]').val();
                    const card_price = parseInt($('input[name="card_price"]').val());
                    const card_available_result = 'available ('+ settings.card_price +' '+ settings.currency +')';
                    const bedspace_id = $('select[name="bedspace_id"]').val();

                    if (get_days_difference <= 15) {
                        $('input[name="sub_total"]').val(.5 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                        if (card_available == card_available_result && card_code != '') {
                            $('input[name="grand_total"]').val((.5 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)) + settings.card_price);
                        } else if (card_price && card_code) {
                            $('input[name="grand_total"]').val((.5 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)) + (bedspace_id == 'both' || bedspace_id == 'current_both' ? card_price * 2 : card_price));
                        } else {
                            $('input[name="grand_total"]').val((.5 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)));
                        }
                    } else if (get_days_difference > 15 && get_days_difference <= 31) {
                        $('input[name="sub_total"]').val(1 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                        if (card_available == card_available_result && card_code != '') {
                            $('input[name="grand_total"]').val((1 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)) + settings.card_price);
                        } else if (card_price && card_code) {
                            $('input[name="grand_total"]').val((1 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)) + (bedspace_id == 'both' || bedspace_id == 'current_both' ? card_price * 2 : card_price));
                        } else {
                            $('input[name="grand_total"]').val((1 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)));
                        }
                    } else if (get_days_difference > 31 && get_days_difference <= 62) {
                        $('input[name="sub_total"]').val(2 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                        if (card_available == card_available_result && card_code != '') {
                            $('input[name="grand_total"]').val((2 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)) + settings.card_price);
                        } else if (card_price && card_code) {
                            $('input[name="grand_total"]').val((2 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)) + (bedspace_id == 'both' || bedspace_id == 'current_both' ? card_price * 2 : card_price));
                        } else {
                            $('input[name="grand_total"]').val((2 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)));
                        }
                    } else if (get_days_difference > 62 && get_days_difference <= 93) {
                        $('input[name="sub_total"]').val(3 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                        if (card_available == card_available_result && card_code != '') {
                            $('input[name="grand_total"]').val((3 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)) + settings.card_price);
                        } else if (card_price && card_code) {
                            $('input[name="grand_total"]').val((3 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)) + (bedspace_id == 'both' || bedspace_id == 'current_both' ? card_price * 2 : card_price));
                        } else {
                            $('input[name="grand_total"]').val((3 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)));
                        }
                    } else if (get_days_difference > 96 && get_days_difference <= 124) {
                        $('input[name="sub_total"]').val(4 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                        if (card_available == card_available_result && card_code != '') {
                            $('input[name="grand_total"]').val((4 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)) + settings.card_price);
                        } else if (card_price && card_code) {
                            $('input[name="grand_total"]').val((4 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)) + (bedspace_id == 'both' || bedspace_id == 'current_both' ? card_price * 2 : card_price));
                        } else {
                            $('input[name="grand_total"]').val((4 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)));
                        }
                    } else if (get_days_difference > 124 && get_days_difference <= 155) {
                        $('input[name="sub_total"]').val(5 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                        if (card_available == card_available_result && card_code != '') {
                            $('input[name="grand_total"]').val((5 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)) + settings.card_price);
                        } else if (card_price && card_code) {
                            $('input[name="grand_total"]').val((5 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)) + (bedspace_id == 'both' || bedspace_id == 'current_both' ? card_price * 2 : card_price));
                        } else {
                            $('input[name="grand_total"]').val((5 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)));
                        }
                    } else if (get_days_difference > 155 && get_days_difference <= 186) {
                        $('input[name="sub_total"]').val(6 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                        if (card_available == card_available_result && card_code != '') {
                            $('input[name="grand_total"]').val((6 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)) + settings.card_price);
                        } else if (card_price && card_code) {
                            $('input[name="grand_total"]').val((6 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)) + (bedspace_id == 'both' || bedspace_id == 'current_both' ? card_price * 2 : card_price));
                        } else {
                            $('input[name="grand_total"]').val((6 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)));
                        }
                    } else if (get_days_difference > 186 && get_days_difference <= 217) {
                        $('input[name="sub_total"]').val(7 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                        if (card_available == card_available_result && card_code != '') {
                            $('input[name="grand_total"]').val((7 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)) + settings.card_price);
                        } else if (card_price && card_code) {
                            $('input[name="grand_total"]').val((7 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)) + (bedspace_id == 'both' || bedspace_id == 'current_both' ? card_price * 2 : card_price));
                        } else {
                            $('input[name="grand_total"]').val((7 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)));
                        }
                    } else if (get_days_difference > 217 && get_days_difference <= 248) {
                        $('input[name="sub_total"]').val(8 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                        if (card_available == card_available_result && card_code != '') {
                            $('input[name="grand_total"]').val((8 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)) + settings.card_price);
                        } else if (card_price && card_code) {
                            $('input[name="grand_total"]').val((8 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)) + (bedspace_id == 'both' || bedspace_id == 'current_both' ? card_price * 2 : card_price));
                        } else {
                            $('input[name="grand_total"]').val((8 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)));
                        }
                    } else if (get_days_difference > 248 && get_days_difference <= 279) {
                        $('input[name="sub_total"]').val(9 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                        if (card_available == card_available_result && card_code != '') {
                            $('input[name="grand_total"]').val((9 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)) + settings.card_price);
                        } else if (card_price && card_code) {
                            $('input[name="grand_total"]').val((9 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)) + (bedspace_id == 'both' || bedspace_id == 'current_both' ? card_price * 2 : card_price));
                        } else {
                            $('input[name="grand_total"]').val((9 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)));
                        }
                    } else if (get_days_difference > 279 && get_days_difference <= 310) {
                        $('input[name="sub_total"]').val(10 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                        if (card_available == card_available_result && card_code != '') {
                            $('input[name="grand_total"]').val((10 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)) + settings.card_price);
                        } else if (card_price && card_code) {
                            $('input[name="grand_total"]').val((10 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)) + (bedspace_id == 'both' || bedspace_id == 'current_both' ? card_price * 2 : card_price));
                        } else {
                            $('input[name="grand_total"]').val((10 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)));
                        }
                    } else if (get_days_difference > 310 && get_days_difference <= 341) {
                        $('input[name="sub_total"]').val(11 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                        if (card_available == card_available_result && card_code != '') {
                            $('input[name="grand_total"]').val((11 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)) + settings.card_price);
                        } else if (card_price && card_code) {
                            $('input[name="grand_total"]').val((11 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)) + (bedspace_id == 'both' || bedspace_id == 'current_both' ? card_price * 2 : card_price));
                        } else {
                            $('input[name="grand_total"]').val((11 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)));
                        }
                    } else if (get_days_difference > 341 && get_days_difference <= 366) {
                        $('input[name="sub_total"]').val(12 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                        if (card_available == card_available_result && card_code != '') {
                            $('input[name="grand_total"]').val((12 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)) + settings.card_price);
                        } else if (card_price && card_code) {
                            $('input[name="grand_total"]').val((12 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)) + (bedspace_id == 'both' || bedspace_id == 'current_both' ? card_price * 2 : card_price));
                        } else {
                            $('input[name="grand_total"]').val((12 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)));
                        }
                    }
                }
            })
        })

        $('input[name="end_date"]').on('change', function() {
            $.ajax({
                url: '{{ url("/ajax/settings") }}/',
                type: 'GET',
                dataType: 'JSON',
                success: function(settings) {
                    const price = $('input[name="price"]').val();
                    const sub_total = $('input[name="sub_total"]').val();
                    const start_date = $('input[name="start_date"]').val();
                    const jsStartDate = new Date(start_date);
                    const end_date = $('input[name="end_date"]').val();
                    const jsEndDate = new Date(end_date);
                    const get_time_difference = jsEndDate.getTime() - jsStartDate.getTime();
                    const get_days_difference = (get_time_difference / (1000 * 3600 * 24)) + 1;
                    const card_available = $('input[name="status"]').val();
                    const card_code = $('input[name="code"]').val();
                    const card_price = parseInt($('input[name="card_price"]').val());
                    const card_available_result = 'available ('+ settings.card_price +' '+ settings.currency +')';
                    const bedspace_id = $('select[name="bedspace_id"]').val();

                    if (get_days_difference <= 15) {
                        $('input[name="sub_total"]').val(.5 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                        if (card_available == card_available_result && card_code != '') {
                            $('input[name="grand_total"]').val((.5 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)) + settings.card_price);
                        } else if (card_price && card_code) {
                            $('input[name="grand_total"]').val((.5 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)) + (bedspace_id == 'both' || bedspace_id == 'current_both' ? card_price * 2 : card_price));
                        } else {
                            $('input[name="grand_total"]').val((.5 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)));
                        }
                    } else if (get_days_difference > 15 && get_days_difference <= 31) {
                        $('input[name="sub_total"]').val(1 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                        if (card_available == card_available_result && card_code != '') {
                            $('input[name="grand_total"]').val((1 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)) + settings.card_price);
                        } else if (card_price && card_code) {
                            $('input[name="grand_total"]').val((1 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)) + (bedspace_id == 'both' || bedspace_id == 'current_both' ? card_price * 2 : card_price));
                        } else {
                            $('input[name="grand_total"]').val((1 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)));
                        }
                    } else if (get_days_difference > 31 && get_days_difference <= 62) {
                        $('input[name="sub_total"]').val(2 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                        if (card_available == card_available_result && card_code != '') {
                            $('input[name="grand_total"]').val((2 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)) + settings.card_price);
                        } else if (card_price && card_code) {
                            $('input[name="grand_total"]').val((2 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)) + (bedspace_id == 'both' || bedspace_id == 'current_both' ? card_price * 2 : card_price));
                        } else {
                            $('input[name="grand_total"]').val((2 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)));
                        }
                    } else if (get_days_difference > 62 && get_days_difference <= 93) {
                        $('input[name="sub_total"]').val(3 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                        if (card_available == card_available_result && card_code != '') {
                            $('input[name="grand_total"]').val((3 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)) + settings.card_price);
                        } else if (card_price && card_code) {
                            $('input[name="grand_total"]').val((3 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)) + (bedspace_id == 'both' || bedspace_id == 'current_both' ? card_price * 2 : card_price));
                        } else {
                            $('input[name="grand_total"]').val((3 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)));
                        }
                    } else if (get_days_difference > 96 && get_days_difference <= 124) {
                        $('input[name="sub_total"]').val(4 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                        if (card_available == card_available_result && card_code != '') {
                            $('input[name="grand_total"]').val((4 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)) + settings.card_price);
                        } else if (card_price && card_code) {
                            $('input[name="grand_total"]').val((4 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)) + (bedspace_id == 'both' || bedspace_id == 'current_both' ? card_price * 2 : card_price));
                        } else {
                            $('input[name="grand_total"]').val((4 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)));
                        }
                    } else if (get_days_difference > 124 && get_days_difference <= 155) {
                        $('input[name="sub_total"]').val(5 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                        if (card_available == card_available_result && card_code != '') {
                            $('input[name="grand_total"]').val((5 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)) + settings.card_price);
                        } else if (card_price && card_code) {
                            $('input[name="grand_total"]').val((5 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)) + (bedspace_id == 'both' || bedspace_id == 'current_both' ? card_price * 2 : card_price));
                        } else {
                            $('input[name="grand_total"]').val((5 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)));
                        }
                    } else if (get_days_difference > 155 && get_days_difference <= 186) {
                        $('input[name="sub_total"]').val(6 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                        if (card_available == card_available_result && card_code != '') {
                            $('input[name="grand_total"]').val((6 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)) + settings.card_price);
                        } else if (card_price && card_code) {
                            $('input[name="grand_total"]').val((6 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)) + (bedspace_id == 'both' || bedspace_id == 'current_both' ? card_price * 2 : card_price));
                        } else {
                            $('input[name="grand_total"]').val((6 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)));
                        }
                    } else if (get_days_difference > 186 && get_days_difference <= 217) {
                        $('input[name="sub_total"]').val(7 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                        if (card_available == card_available_result && card_code != '') {
                            $('input[name="grand_total"]').val((7 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)) + settings.card_price);
                        } else if (card_price && card_code) {
                            $('input[name="grand_total"]').val((7 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)) + (bedspace_id == 'both' || bedspace_id == 'current_both' ? card_price * 2 : card_price));
                        } else {
                            $('input[name="grand_total"]').val((7 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)));
                        }
                    } else if (get_days_difference > 217 && get_days_difference <= 248) {
                        $('input[name="sub_total"]').val(8 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                        if (card_available == card_available_result && card_code != '') {
                            $('input[name="grand_total"]').val((8 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)) + settings.card_price);
                        } else if (card_price && card_code) {
                            $('input[name="grand_total"]').val((8 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)) + (bedspace_id == 'both' || bedspace_id == 'current_both' ? card_price * 2 : card_price));
                        } else {
                            $('input[name="grand_total"]').val((8 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)));
                        }
                    } else if (get_days_difference > 248 && get_days_difference <= 279) {
                        $('input[name="sub_total"]').val(9 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                        if (card_available == card_available_result && card_code != '') {
                            $('input[name="grand_total"]').val((9 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)) + settings.card_price);
                        } else if (card_price && card_code) {
                            $('input[name="grand_total"]').val((9 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)) + (bedspace_id == 'both' || bedspace_id == 'current_both' ? card_price * 2 : card_price));
                        } else {
                            $('input[name="grand_total"]').val((9 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)));
                        }
                    } else if (get_days_difference > 279 && get_days_difference <= 310) {
                        $('input[name="sub_total"]').val(10 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                        if (card_available == card_available_result && card_code != '') {
                            $('input[name="grand_total"]').val((10 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)) + settings.card_price);
                        } else if (card_price && card_code) {
                            $('input[name="grand_total"]').val((10 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)) + (bedspace_id == 'both' || bedspace_id == 'current_both' ? card_price * 2 : card_price));
                        } else {
                            $('input[name="grand_total"]').val((10 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)));
                        }
                    } else if (get_days_difference > 310 && get_days_difference <= 341) {
                        $('input[name="sub_total"]').val(11 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                        if (card_available == card_available_result && card_code != '') {
                            $('input[name="grand_total"]').val((11 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)) + settings.card_price);
                        } else if (card_price && card_code) {
                            $('input[name="grand_total"]').val((11 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)) + (bedspace_id == 'both' || bedspace_id == 'current_both' ? card_price * 2 : card_price));
                        } else {
                            $('input[name="grand_total"]').val((11 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)));
                        }
                    } else if (get_days_difference > 341 && get_days_difference <= 366) {
                        $('input[name="sub_total"]').val(12 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                        if (card_available == card_available_result && card_code != '') {
                            $('input[name="grand_total"]').val((12 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)) + settings.card_price);
                        } else if (card_price && card_code) {
                            $('input[name="grand_total"]').val((12 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)) + (bedspace_id == 'both' || bedspace_id == 'current_both' ? card_price * 2 : card_price));
                        } else {
                            $('input[name="grand_total"]').val((12 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)));
                        }
                    }
                }
            })
        })

        // On price change
        $('input[name="price"]').on('change', function() {
            $.ajax({
                url: '{{ url("/ajax/settings") }}/',
                type: 'GET',
                dataType: 'JSON',
                success: function(settings) {
                    const price = $('input[name="price"]').val();
                    const sub_total = $('input[name="sub_total"]').val();
                    const start_date = $('input[name="start_date"]').val();
                    const jsStartDate = new Date(start_date);
                    const end_date = $('input[name="end_date"]').val();
                    const jsEndDate = new Date(end_date);
                    const get_time_difference = jsEndDate.getTime() - jsStartDate.getTime();
                    const get_days_difference = (get_time_difference / (1000 * 3600 * 24)) + 1;
                    const card_available = $('input[name="status"]').val();
                    const card_code = $('input[name="code"]').val();
                    const card_price = parseInt($('input[name="card_price"]').val());
                    const card_available_result = 'available ('+ settings.card_price +' '+ settings.currency +')';
                    const bedspace_id = $('select[name="bedspace_id"]').val();

                    if (get_days_difference <= 15) {
                        $('input[name="sub_total"]').val(.5 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                        if (card_available == card_available_result && card_code != '') {
                            $('input[name="grand_total"]').val((.5 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)) + settings.card_price);
                        } else if (card_price && card_code) {
                            $('input[name="grand_total"]').val((.5 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)) + (bedspace_id == 'both' || bedspace_id == 'current_both' ? card_price * 2 : card_price));
                        } else {
                            $('input[name="grand_total"]').val((.5 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)));
                        }
                    } else if (get_days_difference > 15 && get_days_difference <= 31) {
                        $('input[name="sub_total"]').val(1 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                        if (card_available == card_available_result && card_code != '') {
                            $('input[name="grand_total"]').val((1 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)) + settings.card_price);
                        } else if (card_price && card_code) {
                            $('input[name="grand_total"]').val((1 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)) + (bedspace_id == 'both' || bedspace_id == 'current_both' ? card_price * 2 : card_price));
                        } else {
                            $('input[name="grand_total"]').val((1 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)));
                        }
                    } else if (get_days_difference > 31 && get_days_difference <= 62) {
                        $('input[name="sub_total"]').val(2 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                        if (card_available == card_available_result && card_code != '') {
                            $('input[name="grand_total"]').val((2 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)) + settings.card_price);
                        } else if (card_price && card_code) {
                            $('input[name="grand_total"]').val((2 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)) + (bedspace_id == 'both' || bedspace_id == 'current_both' ? card_price * 2 : card_price));
                        } else {
                            $('input[name="grand_total"]').val((2 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)));
                        }
                    } else if (get_days_difference > 62 && get_days_difference <= 93) {
                        $('input[name="sub_total"]').val(3 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                        if (card_available == card_available_result && card_code != '') {
                            $('input[name="grand_total"]').val((3 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)) + settings.card_price);
                        } else if (card_price && card_code) {
                            $('input[name="grand_total"]').val((3 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)) + (bedspace_id == 'both' || bedspace_id == 'current_both' ? card_price * 2 : card_price));
                        } else {
                            $('input[name="grand_total"]').val((3 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)));
                        }
                    } else if (get_days_difference > 96 && get_days_difference <= 124) {
                        $('input[name="sub_total"]').val(4 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                        if (card_available == card_available_result && card_code != '') {
                            $('input[name="grand_total"]').val((4 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)) + settings.card_price);
                        } else if (card_price && card_code) {
                            $('input[name="grand_total"]').val((4 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)) + (bedspace_id == 'both' || bedspace_id == 'current_both' ? card_price * 2 : card_price));
                        } else {
                            $('input[name="grand_total"]').val((4 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)));
                        }
                    } else if (get_days_difference > 124 && get_days_difference <= 155) {
                        $('input[name="sub_total"]').val(5 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                        if (card_available == card_available_result && card_code != '') {
                            $('input[name="grand_total"]').val((5 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)) + settings.card_price);
                        } else if (card_price && card_code) {
                            $('input[name="grand_total"]').val((5 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)) + (bedspace_id == 'both' || bedspace_id == 'current_both' ? card_price * 2 : card_price));
                        } else {
                            $('input[name="grand_total"]').val((5 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)));
                        }
                    } else if (get_days_difference > 155 && get_days_difference <= 186) {
                        $('input[name="sub_total"]').val(6 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                        if (card_available == card_available_result && card_code != '') {
                            $('input[name="grand_total"]').val((6 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)) + settings.card_price);
                        } else if (card_price && card_code) {
                            $('input[name="grand_total"]').val((6 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)) + (bedspace_id == 'both' || bedspace_id == 'current_both' ? card_price * 2 : card_price));
                        } else {
                            $('input[name="grand_total"]').val((6 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)));
                        }
                    } else if (get_days_difference > 186 && get_days_difference <= 217) {
                        $('input[name="sub_total"]').val(7 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                        if (card_available == card_available_result && card_code != '') {
                            $('input[name="grand_total"]').val((7 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)) + settings.card_price);
                        } else if (card_price && card_code) {
                            $('input[name="grand_total"]').val((7 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)) + (bedspace_id == 'both' || bedspace_id == 'current_both' ? card_price * 2 : card_price));
                        } else {
                            $('input[name="grand_total"]').val((7 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)));
                        }
                    } else if (get_days_difference > 217 && get_days_difference <= 248) {
                        $('input[name="sub_total"]').val(8 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                        if (card_available == card_available_result && card_code != '') {
                            $('input[name="grand_total"]').val((8 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)) + settings.card_price);
                        } else if (card_price && card_code) {
                            $('input[name="grand_total"]').val((8 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)) + (bedspace_id == 'both' || bedspace_id == 'current_both' ? card_price * 2 : card_price));
                        } else {
                            $('input[name="grand_total"]').val((8 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)));
                        }
                    } else if (get_days_difference > 248 && get_days_difference <= 279) {
                        $('input[name="sub_total"]').val(9 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                        if (card_available == card_available_result && card_code != '') {
                            $('input[name="grand_total"]').val((9 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)) + settings.card_price);
                        } else if (card_price && card_code) {
                            $('input[name="grand_total"]').val((9 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)) + (bedspace_id == 'both' || bedspace_id == 'current_both' ? card_price * 2 : card_price));
                        } else {
                            $('input[name="grand_total"]').val((9 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)));
                        }
                    } else if (get_days_difference > 279 && get_days_difference <= 310) {
                        $('input[name="sub_total"]').val(10 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                        if (card_available == card_available_result && card_code != '') {
                            $('input[name="grand_total"]').val((10 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)) + settings.card_price);
                        } else if (card_price && card_code) {
                            $('input[name="grand_total"]').val((10 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)) + (bedspace_id == 'both' || bedspace_id == 'current_both' ? card_price * 2 : card_price));
                        } else {
                            $('input[name="grand_total"]').val((10 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)));
                        }
                    } else if (get_days_difference > 310 && get_days_difference <= 341) {
                        $('input[name="sub_total"]').val(11 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                        if (card_available == card_available_result && card_code != '') {
                            $('input[name="grand_total"]').val((11 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)) + settings.card_price);
                        } else if (card_price && card_code) {
                            $('input[name="grand_total"]').val((11 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)) + (bedspace_id == 'both' || bedspace_id == 'current_both' ? card_price * 2 : card_price));
                        } else {
                            $('input[name="grand_total"]').val((11 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)));
                        }
                    } else if (get_days_difference > 341 && get_days_difference <= 366) {
                        $('input[name="sub_total"]').val(12 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                        if (card_available == card_available_result && card_code != '') {
                            $('input[name="grand_total"]').val((12 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)) + settings.card_price);
                        } else if (card_price && card_code) {
                            $('input[name="grand_total"]').val((12 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)) + (bedspace_id == 'both' || bedspace_id == 'current_both' ? card_price * 2 : card_price));
                        } else {
                            $('input[name="grand_total"]').val((12 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)));
                        }
                    }
                }
            })
        })

        // Click price activate button
        $('#check_or_activate_price').on('click', function() {
            $('#check_or_activate_price').addClass('text-success');

            $.ajax({
                url: '{{ url("/ajax/settings") }}/',
                type: 'GET',
                dataType: 'JSON',
                success: function(settings) {
                    const price = $('input[name="price"]').val();
                    const sub_total = $('input[name="sub_total"]').val();
                    const start_date = $('input[name="start_date"]').val();
                    const jsStartDate = new Date(start_date);
                    const end_date = $('input[name="end_date"]').val();
                    const jsEndDate = new Date(end_date);
                    const get_time_difference = jsEndDate.getTime() - jsStartDate.getTime();
                    const get_days_difference = (get_time_difference / (1000 * 3600 * 24)) + 1;
                    const card_available = $('input[name="status"]').val();
                    const card_code = $('input[name="code"]').val();
                    const card_price = parseInt($('input[name="card_price"]').val());
                    const card_available_result = 'available ('+ settings.card_price +' '+ settings.currency +')';
                    const bedspace_id = $('select[name="bedspace_id"]').val();

                    if (get_days_difference <= 15) {
                        $('input[name="sub_total"]').val(.5 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                        if (card_available == card_available_result && card_code != '') {
                            $('input[name="grand_total"]').val((.5 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)) + settings.card_price);
                        } else if (card_price && card_code) {
                            $('input[name="grand_total"]').val((.5 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)) + (bedspace_id == 'both' || bedspace_id == 'current_both' ? card_price * 2 : card_price));
                        } else {
                            $('input[name="grand_total"]').val((.5 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)));
                        }
                    } else if (get_days_difference > 15 && get_days_difference <= 31) {
                        $('input[name="sub_total"]').val(1 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                        if (card_available == card_available_result && card_code != '') {
                            $('input[name="grand_total"]').val((1 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)) + settings.card_price);
                        } else if (card_price && card_code) {
                            $('input[name="grand_total"]').val((1 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)) + (bedspace_id == 'both' || bedspace_id == 'current_both' ? card_price * 2 : card_price));
                        } else {
                            $('input[name="grand_total"]').val((1 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)));
                        }
                    } else if (get_days_difference > 31 && get_days_difference <= 62) {
                        $('input[name="sub_total"]').val(2 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                        if (card_available == card_available_result && card_code != '') {
                            $('input[name="grand_total"]').val((2 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)) + settings.card_price);
                        } else if (card_price && card_code) {
                            $('input[name="grand_total"]').val((2 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)) + (bedspace_id == 'both' || bedspace_id == 'current_both' ? card_price * 2 : card_price));
                        } else {
                            $('input[name="grand_total"]').val((2 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)));
                        }
                    } else if (get_days_difference > 62 && get_days_difference <= 93) {
                        $('input[name="sub_total"]').val(3 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                        if (card_available == card_available_result && card_code != '') {
                            $('input[name="grand_total"]').val((3 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)) + settings.card_price);
                        } else if (card_price && card_code) {
                            $('input[name="grand_total"]').val((3 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)) + (bedspace_id == 'both' || bedspace_id == 'current_both' ? card_price * 2 : card_price));
                        } else {
                            $('input[name="grand_total"]').val((3 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)));
                        }
                    } else if (get_days_difference > 96 && get_days_difference <= 124) {
                        $('input[name="sub_total"]').val(4 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                        if (card_available == card_available_result && card_code != '') {
                            $('input[name="grand_total"]').val((4 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)) + settings.card_price);
                        } else if (card_price && card_code) {
                            $('input[name="grand_total"]').val((4 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)) + (bedspace_id == 'both' || bedspace_id == 'current_both' ? card_price * 2 : card_price));
                        } else {
                            $('input[name="grand_total"]').val((4 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)));
                        }
                    } else if (get_days_difference > 124 && get_days_difference <= 155) {
                        $('input[name="sub_total"]').val(5 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                        if (card_available == card_available_result && card_code != '') {
                            $('input[name="grand_total"]').val((5 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)) + settings.card_price);
                        } else if (card_price && card_code) {
                            $('input[name="grand_total"]').val((5 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)) + (bedspace_id == 'both' || bedspace_id == 'current_both' ? card_price * 2 : card_price));
                        } else {
                            $('input[name="grand_total"]').val((5 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)));
                        }
                    } else if (get_days_difference > 155 && get_days_difference <= 186) {
                        $('input[name="sub_total"]').val(6 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                        if (card_available == card_available_result && card_code != '') {
                            $('input[name="grand_total"]').val((6 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)) + settings.card_price);
                        } else if (card_price && card_code) {
                            $('input[name="grand_total"]').val((6 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)) + (bedspace_id == 'both' || bedspace_id == 'current_both' ? card_price * 2 : card_price));
                        } else {
                            $('input[name="grand_total"]').val((6 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)));
                        }
                    } else if (get_days_difference > 186 && get_days_difference <= 217) {
                        $('input[name="sub_total"]').val(7 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                        if (card_available == card_available_result && card_code != '') {
                            $('input[name="grand_total"]').val((7 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)) + settings.card_price);
                        } else if (card_price && card_code) {
                            $('input[name="grand_total"]').val((7 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)) + (bedspace_id == 'both' || bedspace_id == 'current_both' ? card_price * 2 : card_price));
                        } else {
                            $('input[name="grand_total"]').val((7 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)));
                        }
                    } else if (get_days_difference > 217 && get_days_difference <= 248) {
                        $('input[name="sub_total"]').val(8 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                        if (card_available == card_available_result && card_code != '') {
                            $('input[name="grand_total"]').val((8 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)) + settings.card_price);
                        } else if (card_price && card_code) {
                            $('input[name="grand_total"]').val((8 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)) + (bedspace_id == 'both' || bedspace_id == 'current_both' ? card_price * 2 : card_price));
                        } else {
                            $('input[name="grand_total"]').val((8 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)));
                        }
                    } else if (get_days_difference > 248 && get_days_difference <= 279) {
                        $('input[name="sub_total"]').val(9 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                        if (card_available == card_available_result && card_code != '') {
                            $('input[name="grand_total"]').val((9 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)) + settings.card_price);
                        } else if (card_price && card_code) {
                            $('input[name="grand_total"]').val((9 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)) + (bedspace_id == 'both' || bedspace_id == 'current_both' ? card_price * 2 : card_price));
                        } else {
                            $('input[name="grand_total"]').val((9 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)));
                        }
                    } else if (get_days_difference > 279 && get_days_difference <= 310) {
                        $('input[name="sub_total"]').val(10 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                        if (card_available == card_available_result && card_code != '') {
                            $('input[name="grand_total"]').val((10 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)) + settings.card_price);
                        } else if (card_price && card_code) {
                            $('input[name="grand_total"]').val((10 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)) + (bedspace_id == 'both' || bedspace_id == 'current_both' ? card_price * 2 : card_price));
                        } else {
                            $('input[name="grand_total"]').val((10 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)));
                        }
                    } else if (get_days_difference > 310 && get_days_difference <= 341) {
                        $('input[name="sub_total"]').val(11 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                        if (card_available == card_available_result && card_code != '') {
                            $('input[name="grand_total"]').val((11 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)) + settings.card_price);
                        } else if (card_price && card_code) {
                            $('input[name="grand_total"]').val((11 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)) + (bedspace_id == 'both' || bedspace_id == 'current_both' ? card_price * 2 : card_price));
                        } else {
                            $('input[name="grand_total"]').val((11 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)));
                        }
                    } else if (get_days_difference > 341 && get_days_difference <= 366) {
                        $('input[name="sub_total"]').val(12 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                        if (card_available == card_available_result && card_code != '') {
                            $('input[name="grand_total"]').val((12 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)) + settings.card_price);
                        } else if (card_price && card_code) {
                            $('input[name="grand_total"]').val((12 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)) + (bedspace_id == 'both' || bedspace_id == 'current_both' ? card_price * 2 : card_price));
                        } else {
                            $('input[name="grand_total"]').val((12 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)));
                        }
                    }
                }
            })
        })

        $('select[name="bedspace_id"]').on('change', function() {
            $.ajax({
                url: '{{ url("/ajax/settings") }}/',
                type: 'GET',
                dataType: 'JSON',
                success: function(settings) {
                    const price = $('input[name="price"]').val();
                    const sub_total = $('input[name="sub_total"]').val();
                    const start_date = $('input[name="start_date"]').val();
                    const jsStartDate = new Date(start_date);
                    const end_date = $('input[name="end_date"]').val();
                    const jsEndDate = new Date(end_date);
                    const get_time_difference = jsEndDate.getTime() - jsStartDate.getTime();
                    const get_days_difference = (get_time_difference / (1000 * 3600 * 24)) + 1;
                    const card_available = $('input[name="status"]').val();
                    const card_code = $('input[name="code"]').val();
                    const card_price = parseInt($('input[name="card_price"]').val());
                    const card_available_result = 'available ('+ settings.card_price +' '+ settings.currency +')';
                    const bedspace_id = $('select[name="bedspace_id"]').val();

                    if (get_days_difference <= 15) {
                        $('input[name="sub_total"]').val(.5 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                        if (card_available == card_available_result && card_code != '') {
                            $('input[name="grand_total"]').val((.5 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)) + settings.card_price);
                        } else if (card_price && card_code) {
                            $('input[name="grand_total"]').val((.5 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)) + (bedspace_id == 'both' || bedspace_id == 'current_both' ? card_price * 2 : card_price));
                        } else {
                            $('input[name="grand_total"]').val((.5 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)));
                        }
                    } else if (get_days_difference > 15 && get_days_difference <= 31) {
                        $('input[name="sub_total"]').val(1 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                        if (card_available == card_available_result && card_code != '') {
                            $('input[name="grand_total"]').val((1 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)) + settings.card_price);
                        } else if (card_price && card_code) {
                            $('input[name="grand_total"]').val((1 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)) + (bedspace_id == 'both' || bedspace_id == 'current_both' ? card_price * 2 : card_price));
                        } else {
                            $('input[name="grand_total"]').val((1 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)));
                        }
                    } else if (get_days_difference > 31 && get_days_difference <= 62) {
                        $('input[name="sub_total"]').val(2 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                        if (card_available == card_available_result && card_code != '') {
                            $('input[name="grand_total"]').val((2 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)) + settings.card_price);
                        } else if (card_price && card_code) {
                            $('input[name="grand_total"]').val((2 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)) + (bedspace_id == 'both' || bedspace_id == 'current_both' ? card_price * 2 : card_price));
                        } else {
                            $('input[name="grand_total"]').val((2 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)));
                        }
                    } else if (get_days_difference > 62 && get_days_difference <= 93) {
                        $('input[name="sub_total"]').val(3 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                        if (card_available == card_available_result && card_code != '') {
                            $('input[name="grand_total"]').val((3 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)) + settings.card_price);
                        } else if (card_price && card_code) {
                            $('input[name="grand_total"]').val((3 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)) + (bedspace_id == 'both' || bedspace_id == 'current_both' ? card_price * 2 : card_price));
                        } else {
                            $('input[name="grand_total"]').val((3 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)));
                        }
                    } else if (get_days_difference > 96 && get_days_difference <= 124) {
                        $('input[name="sub_total"]').val(4 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                        if (card_available == card_available_result && card_code != '') {
                            $('input[name="grand_total"]').val((4 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)) + settings.card_price);
                        } else if (card_price && card_code) {
                            $('input[name="grand_total"]').val((4 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)) + (bedspace_id == 'both' || bedspace_id == 'current_both' ? card_price * 2 : card_price));
                        } else {
                            $('input[name="grand_total"]').val((4 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)));
                        }
                    } else if (get_days_difference > 124 && get_days_difference <= 155) {
                        $('input[name="sub_total"]').val(5 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                        if (card_available == card_available_result && card_code != '') {
                            $('input[name="grand_total"]').val((5 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)) + settings.card_price);
                        } else if (card_price && card_code) {
                            $('input[name="grand_total"]').val((5 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)) + (bedspace_id == 'both' || bedspace_id == 'current_both' ? card_price * 2 : card_price));
                        } else {
                            $('input[name="grand_total"]').val((5 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)));
                        }
                    } else if (get_days_difference > 155 && get_days_difference <= 186) {
                        $('input[name="sub_total"]').val(6 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                        if (card_available == card_available_result && card_code != '') {
                            $('input[name="grand_total"]').val((6 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)) + settings.card_price);
                        } else if (card_price && card_code) {
                            $('input[name="grand_total"]').val((6 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)) + (bedspace_id == 'both' || bedspace_id == 'current_both' ? card_price * 2 : card_price));
                        } else {
                            $('input[name="grand_total"]').val((6 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)));
                        }
                    } else if (get_days_difference > 186 && get_days_difference <= 217) {
                        $('input[name="sub_total"]').val(7 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                        if (card_available == card_available_result && card_code != '') {
                            $('input[name="grand_total"]').val((7 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)) + settings.card_price);
                        } else if (card_price && card_code) {
                            $('input[name="grand_total"]').val((7 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)) + (bedspace_id == 'both' || bedspace_id == 'current_both' ? card_price * 2 : card_price));
                        } else {
                            $('input[name="grand_total"]').val((7 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)));
                        }
                    } else if (get_days_difference > 217 && get_days_difference <= 248) {
                        $('input[name="sub_total"]').val(8 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                        if (card_available == card_available_result && card_code != '') {
                            $('input[name="grand_total"]').val((8 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)) + settings.card_price);
                        } else if (card_price && card_code) {
                            $('input[name="grand_total"]').val((8 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)) + (bedspace_id == 'both' || bedspace_id == 'current_both' ? card_price * 2 : card_price));
                        } else {
                            $('input[name="grand_total"]').val((8 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)));
                        }
                    } else if (get_days_difference > 248 && get_days_difference <= 279) {
                        $('input[name="sub_total"]').val(9 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                        if (card_available == card_available_result && card_code != '') {
                            $('input[name="grand_total"]').val((9 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)) + settings.card_price);
                        } else if (card_price && card_code) {
                            $('input[name="grand_total"]').val((9 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)) + (bedspace_id == 'both' || bedspace_id == 'current_both' ? card_price * 2 : card_price));
                        } else {
                            $('input[name="grand_total"]').val((9 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)));
                        }
                    } else if (get_days_difference > 279 && get_days_difference <= 310) {
                        $('input[name="sub_total"]').val(10 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                        if (card_available == card_available_result && card_code != '') {
                            $('input[name="grand_total"]').val((10 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)) + settings.card_price);
                        } else if (card_price && card_code) {
                            $('input[name="grand_total"]').val((10 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)) + (bedspace_id == 'both' || bedspace_id == 'current_both' ? card_price * 2 : card_price));
                        } else {
                            $('input[name="grand_total"]').val((10 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)));
                        }
                    } else if (get_days_difference > 310 && get_days_difference <= 341) {
                        $('input[name="sub_total"]').val(11 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                        if (card_available == card_available_result && card_code != '') {
                            $('input[name="grand_total"]').val((11 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)) + settings.card_price);
                        } else if (card_price && card_code) {
                            $('input[name="grand_total"]').val((11 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)) + (bedspace_id == 'both' || bedspace_id == 'current_both' ? card_price * 2 : card_price));
                        } else {
                            $('input[name="grand_total"]').val((11 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)));
                        }
                    } else if (get_days_difference > 341 && get_days_difference <= 366) {
                        $('input[name="sub_total"]').val(12 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                        if (card_available == card_available_result && card_code != '') {
                            $('input[name="grand_total"]').val((12 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)) + settings.card_price);
                        } else if (card_price && card_code) {
                            $('input[name="grand_total"]').val((12 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)) + (bedspace_id == 'both' || bedspace_id == 'current_both' ? card_price * 2 : card_price));
                        } else {
                            $('input[name="grand_total"]').val((12 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)));
                        }
                    }
                }
            })
        })
    })
</script>
