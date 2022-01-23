@extends('layouts.app')

@section('title')
    Invoices | Analytics | {{ config('app.name', 'PM Software') }}
@endsection

@section('page-specific-head-scripts')
    <script src="{{ asset('assets/plugins/apexcharts-bundle/js/apexcharts.min.js') }}"></script>
@endsection

@section('content')
    {{-- Analytics With Boxes --}}
    <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4">
        <div class="col">
            <div class="card radius-10">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-0 text-secondary">Total Transactions
                                <i class='bx bx-info-circle' title="Records from the last 30 days"></i>
                            </p>
                            <h4 class="my-1">{{ number_format($currentMonthTransactionsCount, 0, '.', ',') }}</h4>
                            @php
                                $transactionsCountDifference = $currentMonthTransactionsCount - $lastMonthTransactionsCount;
                            @endphp

                            @if ($currentMonthTransactionsCount > $lastMonthTransactionsCount)
                                <p class="mb-0 font-13 text-success">
                                    <i class="bx bxs-up-arrow align-middle"></i>
                                    +{{ number_format($transactionsCountDifference, 0, '.', ',') }} from last month
                                </p>
                            @elseif ($currentMonthTransactionsCount == $lastMonthTransactionsCount)
                                <p class="mb-0 font-13 text-primary">
                                    <i class="bx bxs-right-arrow align-middle"></i>
                                    {{ number_format($transactionsCountDifference, 0, '.', ',') }} from last month
                                </p>
                            @elseif ($currentMonthTransactionsCount < $lastMonthTransactionsCount)
                                <p class="mb-0 font-13 text-danger">
                                    <i class="bx bxs-down-arrow align-middle"></i>
                                    {{ number_format($transactionsCountDifference, 0, '.', ',') }} from last month
                                </p>
                            @endif
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card radius-10">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-0 text-secondary">Revenue - Transactions
                                <i class='bx bx-info-circle' title="Records from the last 30 days"></i>
                            </p>
                            <h4 class="my-1">{{ number_format($currentMonthRevenue, 0, '.', ',') }} {{ $settings->currency }}</h4>
                            @php
                                $revenueDifference = $currentMonthRevenue - $lastMonthRevenue;
                            @endphp
                            @if ($currentMonthRevenue > $lastMonthRevenue)
                                <p class="mb-0 font-13 text-success">
                                    <i class="bx bxs-up-arrow align-middle"></i>
                                    +{{ number_format($revenueDifference, 0, '.', ',') }} AED from last month
                                </p>
                            @elseif ($currentMonthRevenue == $lastMonthRevenue)
                                <p class="mb-0 font-13 text-primary">
                                    <i class="bx bxs-right-arrow align-middle"></i>
                                    {{ number_format($revenueDifference, 0, '.', ',') }} AED from last month
                                </p>
                            @elseif ($currentMonthRevenue < $lastMonthRevenue)
                                <p class="mb-0 font-13 text-danger">
                                    <i class="bx bxs-down-arrow align-middle"></i>
                                    {{ number_format($revenueDifference, 0, '.', ',') }} AED from last month
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card radius-10">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-0 text-secondary">Revenue - Cards
                                <i class='bx bx-info-circle' title="Records from the last 30 days"></i>
                            </p>
                            <h4 class="my-1">{{ number_format($currentMonthCardRevenue, 0, '.', ',') }} {{ $settings->currency }}</h4>
                            @php
                                $cardRevenueDifference = $currentMonthCardRevenue - $lastMonthCardRevenue;
                            @endphp
                            @if ($currentMonthCardRevenue > $lastMonthCardRevenue)
                                <p class="mb-0 font-13 text-success">
                                    <i class="bx bxs-up-arrow align-middle"></i>
                                    +{{ number_format($cardRevenueDifference, 0, '.', ',') }} AED from last month
                                </p>
                            @elseif ($currentMonthCardRevenue == $lastMonthCardRevenue)
                                <p class="mb-0 font-13 text-primary">
                                    <i class="bx bxs-right-arrow align-middle"></i>
                                    {{ number_format($cardRevenueDifference, 0, '.', ',') }} AED from last month
                                </p>
                            @elseif ($currentMonthCardRevenue < $lastMonthCardRevenue)
                                <p class="mb-0 font-13 text-danger">
                                    <i class="bx bxs-down-arrow align-middle"></i>
                                    {{ number_format($cardRevenueDifference, 0, '.', ',') }} AED from last month
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card radius-10">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-0 text-secondary">Total Revenue
                                <i class='bx bx-info-circle' title="Records from the last 30 days"></i>
                            </p>
                            @php
                                $currentMonthTotalRevenue = $currentMonthCardRevenue + $currentMonthRevenue;
                                $lastMonthTotalRevenue = $lastMonthCardRevenue + $lastMonthCardRevenue;

                                $totalRevenueDifference = $currentMonthTotalRevenue - $lastMonthTotalRevenue;
                            @endphp
                            <h4 class="my-1">{{ number_format($currentMonthTotalRevenue, 0, '.', ',') }} {{ $settings->currency }}</h4>
                            @if ($currentMonthTotalRevenue > $lastMonthTotalRevenue)
                                <p class="mb-0 font-13 text-success">
                                    <i class="bx bxs-up-arrow align-middle"></i>
                                    +{{ number_format($totalRevenueDifference, 0, '.', ',') }} AED from last month
                                </p>
                            @elseif ($currentMonthTotalRevenue == $lastMonthTotalRevenue)
                                <p class="mb-0 font-13 text-primary">
                                    <i class="bx bxs-right-arrow align-middle"></i>
                                    {{ number_format($totalRevenueDifference, 0, '.', ',') }} AED from last month
                                </p>
                            @elseif ($currentMonthTotalRevenue < $lastMonthTotalRevenue)
                                <p class="mb-0 font-13 text-danger">
                                    <i class="bx bxs-down-arrow align-middle"></i>
                                    {{ number_format($totalRevenueDifference, 0, '.', ',') }} AED from last month
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Analytics With Charts --}}
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="mt-3" id="transactionsAmount"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('page-specific-js')
    <script>
        // Transactions Amount Line Chart
        var transactions = <?php echo $transactionsAmount ?>;

        var tmonths = transactions.map(function(transaction) {
            return transaction.monthname + ' ' + transaction.year;
        });

        var tamounts = transactions.map(function(transaction) {
            return transaction.total_price;
        });

        var options = {
            series: [{
                name: 'Total Amount',
                data: tamounts
            }],
            chart: {
                foreColor: '#9ba7b2',
                height: 500,
                type: 'line',
                animations: {
                    enabled: true,
                    easing: 'easeinout',
                    speed: 800,
                    animateGradually: {
                        enabled: true,
                        delay: 150
                    },
                    dynamicAnimation: {
                        enabled: true,
                        speed: 350
                    }
                },
                scaleLabel: function(label) {return  '$' + label.value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");},
                zoom: {
                    enabled: false
                },
                toolbar: {
                    show: true
                },
                dropShadow: {
                    enabled: true,
                    top: 3,
                    left: 14,
                    blur: 4,
                    opacity: 0.10,
                }
            },
            stroke: {
                width: 4,
                curve: 'smooth'
            },
            labels: tmonths,
            title: {
                text: 'Transaction Amount (Last 12 Months)',
                align: 'left',
                style: {
                    fontSize: "16px",
                    color: '#666'
                }
            },
            fill: {
                type: 'gradient',
                gradient: {
                    shade: 'light',
                    gradientToColors: ['#0008ed'],
                    shadeIntensity: 1,
                    type: 'horizontal',
                    opacityFrom: 1,
                    opacityTo: 1,
                    stops: [0, 100, 100, 100]
                },
            },
            markers: {
                size: 4,
                colors: ["#0008ed"],
                strokeColors: "#fff",
                strokeWidth: 2,
                hover: {
                    size: 7,
                }
            },
            colors: ["#0008ed"],
            yaxis: {
                title: {
                    text: 'Transaction Amount',
                }, // title
                labels: {
                    formatter: function(val, index) {
                        return val.toLocaleString('en-GB') + ' {{ $settings->currency }}';
                    },
                },
            } // yaxix
        };
        var chart = new ApexCharts(document.querySelector("#transactionsAmount"), options);
        chart.render();
    </script>
@endsection
