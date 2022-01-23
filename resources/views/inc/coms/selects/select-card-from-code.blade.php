<script>
    $(document).ready(function() {
        $('input[name="code"]').on('change', function() {
            const code = $(this).val();
            const price = $('input[name="price"]').val();
            const sub_total = $('input[name="sub_total"]').val();
            const start_date = $('input[name="start_date"]').val();
            const jsStartDate = new Date(start_date);
            const end_date = $('input[name="end_date"]').val();
            const jsEndDate = new Date(end_date);
            const get_time_difference = jsEndDate.getTime() - jsStartDate.getTime();
            const get_days_difference = (get_time_difference / (1000 * 3600 * 24)) + 1;
            const bedspace_id = $('select[name="bedspace_id"]').val();

            if (code) {
                $.ajax({
                    url: '{{ url("/ajax/cards") }}/' + code,
                    type: 'GET',
                    dataType: 'JSON',
                    success: function(card) {
                        $('input[name="status"]').empty();

                        if (card.status == 'active') {
                            $('input[name="status"]').val(card.status + ' (Unavailable)');
                            $('input[name="card_id"]').val(card.id);

                            $('input[name="status"]').css({'text-transform': 'capitalize', 'color': 'red', 'font-size': '15px'});

                            if (get_days_difference <= 15) {
                                $('input[name="sub_total"]').val(.5 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                                $('input[name="grand_total"]').val(.5 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                            } else if (get_days_difference > 15 && get_days_difference <= 31) {
                                $('input[name="sub_total"]').val(1 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                                $('input[name="grand_total"]').val(1 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                            } else if (get_days_difference > 31 && get_days_difference <= 62) {
                                $('input[name="sub_total"]').val(2 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                                $('input[name="grand_total"]').val(2 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                            } else if (get_days_difference > 62 && get_days_difference <= 93) {
                                $('input[name="sub_total"]').val(3 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                                $('input[name="grand_total"]').val(3 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                            } else if (get_days_difference > 96 && get_days_difference <= 124) {
                                $('input[name="sub_total"]').val(4 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                                $('input[name="grand_total"]').val(4 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                            } else if (get_days_difference > 124 && get_days_difference <= 155) {
                                $('input[name="sub_total"]').val(5 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                                $('input[name="grand_total"]').val(5 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                            } else if (get_days_difference > 155 && get_days_difference <= 186) {
                                $('input[name="sub_total"]').val(6 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                                $('input[name="grand_total"]').val(6 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                            } else if (get_days_difference > 186 && get_days_difference <= 217) {
                                $('input[name="sub_total"]').val(7 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                                $('input[name="grand_total"]').val(7 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                            } else if (get_days_difference > 217 && get_days_difference <= 248) {
                                $('input[name="sub_total"]').val(8 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                                $('input[name="grand_total"]').val(8 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                            } else if (get_days_difference > 248 && get_days_difference <= 279) {
                                $('input[name="sub_total"]').val(9 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                                $('input[name="grand_total"]').val(9 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                            } else if (get_days_difference > 279 && get_days_difference <= 310) {
                                $('input[name="sub_total"]').val(10 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                                $('input[name="grand_total"]').val(10 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                            } else if (get_days_difference > 310 && get_days_difference <= 341) {
                                $('input[name="sub_total"]').val(11 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                                $('input[name="grand_total"]').val(11 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                            } else if (get_days_difference > 341 && get_days_difference <= 366) {
                                $('input[name="sub_total"]').val(12 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                                $('input[name="grand_total"]').val(12 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                            }
                        } else if (card.status == 'available') {
                            $('input[name="card_id"]').val(card.id);
                            $('input[name="status"]').css({'text-transform': 'capitalize', 'color': 'green', 'font-size': '15px'});

                            $.ajax({
                                url: '{{ url("/ajax/settings") }}',
                                type: 'GET',
                                dataType: 'JSON',
                                success: function(settings) {
                                    if (bedspace_id == 'both') {
                                        $('input[name="card_price"]').val(settings.card_price / 2);
                                    } else {
                                        $('input[name="card_price"]').val(settings.card_price);
                                    }

                                    $('input[name="status"]').val(card.status + ' ('+ settings.card_price +' '+ settings.currency +')');
                                }
                            })

                            if (get_days_difference <= 15) {
                                $('input[name="sub_total"]').val(.5 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                                $('input[name="grand_total"]').val((.5 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)) + 50);
                            } else if (get_days_difference > 15 && get_days_difference <= 31) {
                                $('input[name="sub_total"]').val(1 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                                $('input[name="grand_total"]').val((1 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)) + 50);
                            } else if (get_days_difference > 31 && get_days_difference <= 62) {
                                $('input[name="sub_total"]').val(2 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                                $('input[name="grand_total"]').val((2 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)) + 50);
                            } else if (get_days_difference > 62 && get_days_difference <= 93) {
                                $('input[name="sub_total"]').val(3 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                                $('input[name="grand_total"]').val((3 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)) + 50);
                            } else if (get_days_difference > 96 && get_days_difference <= 124) {
                                $('input[name="sub_total"]').val(4 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                                $('input[name="grand_total"]').val((4 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)) + 50);
                            } else if (get_days_difference > 124 && get_days_difference <= 155) {
                                $('input[name="sub_total"]').val(5 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                                $('input[name="grand_total"]').val((5 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)) + 50);
                            } else if (get_days_difference > 155 && get_days_difference <= 186) {
                                $('input[name="sub_total"]').val(6 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                                $('input[name="grand_total"]').val((6 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)) + 50);
                            } else if (get_days_difference > 186 && get_days_difference <= 217) {
                                $('input[name="sub_total"]').val(7 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                                $('input[name="grand_total"]').val((7 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)) + 50);
                            } else if (get_days_difference > 217 && get_days_difference <= 248) {
                                $('input[name="sub_total"]').val(8 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                                $('input[name="grand_total"]').val((8 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)) + 50);
                            } else if (get_days_difference > 248 && get_days_difference <= 279) {
                                $('input[name="sub_total"]').val(9 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                                $('input[name="grand_total"]').val((9 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)) + 50);
                            } else if (get_days_difference > 279 && get_days_difference <= 310) {
                                $('input[name="sub_total"]').val(10 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                                $('input[name="grand_total"]').val((10 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)) + 50);
                            } else if (get_days_difference > 310 && get_days_difference <= 341) {
                                $('input[name="sub_total"]').val(11 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                                $('input[name="grand_total"]').val((11 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)) + 50);
                            } else if (get_days_difference > 341 && get_days_difference <= 366) {
                                $('input[name="sub_total"]').val(12 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                                $('input[name="grand_total"]').val((12 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1)) + 50);
                            }
                        } else if (card.status == 'lost') {
                            $('input[name="status"]').val(card.status + ' (Unavailable)');
                            $('input[name="status"]').css({'text-transform': 'capitalize', 'color': 'red', 'font-size': '15px'});

                            if (get_days_difference <= 15) {
                                $('input[name="sub_total"]').val(.5 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                                $('input[name="grand_total"]').val(.5 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                            } else if (get_days_difference > 15 && get_days_difference <= 31) {
                                $('input[name="sub_total"]').val(1 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                                $('input[name="grand_total"]').val(1 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                            } else if (get_days_difference > 31 && get_days_difference <= 62) {
                                $('input[name="sub_total"]').val(2 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                                $('input[name="grand_total"]').val(2 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                            } else if (get_days_difference > 62 && get_days_difference <= 93) {
                                $('input[name="sub_total"]').val(3 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                                $('input[name="grand_total"]').val(3 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                            } else if (get_days_difference > 96 && get_days_difference <= 124) {
                                $('input[name="sub_total"]').val(4 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                                $('input[name="grand_total"]').val(4 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                            } else if (get_days_difference > 124 && get_days_difference <= 155) {
                                $('input[name="sub_total"]').val(5 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                                $('input[name="grand_total"]').val(5 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                            } else if (get_days_difference > 155 && get_days_difference <= 186) {
                                $('input[name="sub_total"]').val(6 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                                $('input[name="grand_total"]').val(6 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                            } else if (get_days_difference > 186 && get_days_difference <= 217) {
                                $('input[name="sub_total"]').val(7 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                                $('input[name="grand_total"]').val(7 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                            } else if (get_days_difference > 217 && get_days_difference <= 248) {
                                $('input[name="sub_total"]').val(8 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                                $('input[name="grand_total"]').val(8 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                            } else if (get_days_difference > 248 && get_days_difference <= 279) {
                                $('input[name="sub_total"]').val(9 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                                $('input[name="grand_total"]').val(9 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                            } else if (get_days_difference > 279 && get_days_difference <= 310) {
                                $('input[name="sub_total"]').val(10 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                                $('input[name="grand_total"]').val(10 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                            } else if (get_days_difference > 310 && get_days_difference <= 341) {
                                $('input[name="sub_total"]').val(11 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                                $('input[name="grand_total"]').val(11 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                            } else if (get_days_difference > 341 && get_days_difference <= 366) {
                                $('input[name="sub_total"]').val(12 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                                $('input[name="grand_total"]').val(12 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                            }
                        }
                    },
                    error: function (xhr, status, error) {
                        $('input[name="status"]').val('No card found with this ID.');
                        $('input[name="status"]').css({'text-transform': 'capitalize', 'color': 'red', 'font-size': '15px'});

                        if (get_days_difference <= 15) {
                            $('input[name="sub_total"]').val(.5 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                            $('input[name="grand_total"]').val(.5 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                        } else if (get_days_difference > 15 && get_days_difference <= 31) {
                            $('input[name="sub_total"]').val(1 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                            $('input[name="grand_total"]').val(1 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                        } else if (get_days_difference > 31 && get_days_difference <= 62) {
                            $('input[name="sub_total"]').val(2 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                            $('input[name="grand_total"]').val(2 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                        } else if (get_days_difference > 62 && get_days_difference <= 93) {
                            $('input[name="sub_total"]').val(3 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                            $('input[name="grand_total"]').val(3 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                        } else if (get_days_difference > 96 && get_days_difference <= 124) {
                            $('input[name="sub_total"]').val(4 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                            $('input[name="grand_total"]').val(4 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                        } else if (get_days_difference > 124 && get_days_difference <= 155) {
                            $('input[name="sub_total"]').val(5 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                            $('input[name="grand_total"]').val(5 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                        } else if (get_days_difference > 155 && get_days_difference <= 186) {
                            $('input[name="sub_total"]').val(6 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                            $('input[name="grand_total"]').val(6 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                        } else if (get_days_difference > 186 && get_days_difference <= 217) {
                            $('input[name="sub_total"]').val(7 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                            $('input[name="grand_total"]').val(7 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                        } else if (get_days_difference > 217 && get_days_difference <= 248) {
                            $('input[name="sub_total"]').val(8 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                            $('input[name="grand_total"]').val(8 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                        } else if (get_days_difference > 248 && get_days_difference <= 279) {
                            $('input[name="sub_total"]').val(9 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                            $('input[name="grand_total"]').val(9 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                        } else if (get_days_difference > 279 && get_days_difference <= 310) {
                            $('input[name="sub_total"]').val(10 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                            $('input[name="grand_total"]').val(10 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                        } else if (get_days_difference > 310 && get_days_difference <= 341) {
                            $('input[name="sub_total"]').val(11 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                            $('input[name="grand_total"]').val(11 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                        } else if (get_days_difference > 341 && get_days_difference <= 366) {
                            $('input[name="sub_total"]').val(12 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                            $('input[name="grand_total"]').val(12 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                        }
                    }
                })
            }

            if (code == "") {
                if (get_days_difference <= 15) {
                    $('input[name="sub_total"]').val(.5 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                    $('input[name="grand_total"]').val(.5 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                } else if (get_days_difference > 15 && get_days_difference <= 31) {
                    $('input[name="sub_total"]').val(1 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                    $('input[name="grand_total"]').val(1 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                } else if (get_days_difference > 31 && get_days_difference <= 62) {
                    $('input[name="sub_total"]').val(2 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                    $('input[name="grand_total"]').val(2 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                } else if (get_days_difference > 62 && get_days_difference <= 93) {
                    $('input[name="sub_total"]').val(3 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                    $('input[name="grand_total"]').val(3 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                } else if (get_days_difference > 96 && get_days_difference <= 124) {
                    $('input[name="sub_total"]').val(4 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                    $('input[name="grand_total"]').val(4 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                } else if (get_days_difference > 124 && get_days_difference <= 155) {
                    $('input[name="sub_total"]').val(5 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                    $('input[name="grand_total"]').val(5 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                } else if (get_days_difference > 155 && get_days_difference <= 186) {
                    $('input[name="sub_total"]').val(6 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                    $('input[name="grand_total"]').val(6 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                } else if (get_days_difference > 186 && get_days_difference <= 217) {
                    $('input[name="sub_total"]').val(7 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                    $('input[name="grand_total"]').val(7 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                } else if (get_days_difference > 217 && get_days_difference <= 248) {
                    $('input[name="sub_total"]').val(8 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                    $('input[name="grand_total"]').val(8 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                } else if (get_days_difference > 248 && get_days_difference <= 279) {
                    $('input[name="sub_total"]').val(9 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                    $('input[name="grand_total"]').val(9 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                } else if (get_days_difference > 279 && get_days_difference <= 310) {
                    $('input[name="sub_total"]').val(10 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                    $('input[name="grand_total"]').val(10 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                } else if (get_days_difference > 310 && get_days_difference <= 341) {
                    $('input[name="sub_total"]').val(11 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                    $('input[name="grand_total"]').val(11 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                } else if (get_days_difference > 341 && get_days_difference <= 366) {
                    $('input[name="sub_total"]').val(12 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                    $('input[name="grand_total"]').val(12 * price * (bedspace_id == 'both' || bedspace_id == 'current_both' ? 2 : 1));
                }
            }
        })

        // Remove Card From Invoice
        $('span#clear_card').on('click', function() {
            $('input[name="card_id"]').val('');
            $('input[name="card_price"]').val('');
            $('input[name="code"]').val('');
            $('input[name="status"]').val('Add Card ID To See Status');
            $('input[name="status"]').css({'text-transform': 'capitalize', 'color': 'black', 'font-size': '15px'});

            $.ajax({
                url: '{{ url("/ajax/settings") }}/',
                type: 'GET',
                dataType: 'JSON',
                success: function(settings) {
                    const sub_total = $('input[name="sub_total"]').val();
                    const grand_total = $('input[name="grand_total"]').val();

                    if (sub_total < grand_total) {
                        $('input[name="grand_total"]').val(grand_total - settings.card_price);
                    }
                }
            })
        })
    })
</script>
