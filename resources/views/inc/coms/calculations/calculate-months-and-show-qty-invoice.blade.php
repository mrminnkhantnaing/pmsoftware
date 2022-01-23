{{-- This only works under transactions loop --}}

@php
    $startDateTime = strtotime($transaction->start_date);
    $endDateTime = strtotime($transaction->end_date);
    $timeLeft = $endDateTime - $startDateTime;
    $daysLeft = round((($timeLeft/24)/60)/60);

    if ($daysLeft < 31) {
        echo 1;
    } else if ($daysLeft < 62) {
        echo 2;
    } else if ($daysLeft < 93) {
        echo 3;
    } else if ($daysLeft < 124) {
        echo 4;
    } else if ($daysLeft < 155) {
        echo 5;
    } else if ($daysLeft < 186) {
        echo 6;
    } else if ($daysLeft < 217) {
        echo 7;
    } else if ($daysLeft < 248) {
        echo 8;
    } else if ($daysLeft < 279) {
        echo 9;
    } else if ($daysLeft < 310) {
        echo 10;
    } else if ($daysLeft < 341) {
        echo 11;
    } else if ($daysLeft < 366) {
        echo 12;
    }
@endphp
