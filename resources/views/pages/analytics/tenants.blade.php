@extends('layouts.app')

@section('title')
    Tenants | Analytics | {{ config('app.name', 'PM Software') }}
@endsection

@section('page-specific-head-scripts')
    <script src="{{ asset('assets/plugins/apexcharts-bundle/js/apexcharts.min.js') }}"></script>
@endsection

@section('content')
    {{-- Analytics With Boxes --}}
    <div class="row">
        <div class="col-md-3">
            <div class="card radius-10">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-0"><a class="text-secondary" href="{{ route('analytics.newTenants') }}">New Tenants</a>
                                <i class='bx bx-info-circle' title="Records from the last 30 days"></i>
                            </p>
                            <h4 class="my-1"><a class="text-dark" href="{{ route('analytics.newTenants') }}">{{ number_format($currentMonthTenantsCount, 0, '.', ',') }}</a></h4>
                            @php
                                $tenantsCountDifference = $currentMonthTenantsCount - $lastMonthTenantsCount;
                            @endphp

                            @if ($currentMonthTenantsCount > $lastMonthTenantsCount)
                                <p class="mb-0 font-13 text-success">
                                    <i class="bx bxs-up-arrow align-middle"></i>
                                    +{{ number_format($tenantsCountDifference, 0, '.', ',') }} from last month
                                </p>
                            @elseif ($currentMonthTenantsCount == $lastMonthTenantsCount)
                                <p class="mb-0 font-13 text-primary">
                                    <i class="bx bxs-right-arrow align-middle"></i>
                                    {{ number_format($tenantsCountDifference, 0, '.', ',') }} from last month
                                </p>
                            @elseif ($currentMonthTenantsCount < $lastMonthTenantsCount)
                                <p class="mb-0 font-13 text-danger">
                                    <i class="bx bxs-down-arrow align-middle"></i>
                                    {{ number_format($tenantsCountDifference, 0, '.', ',') }} from last month
                                </p>
                            @endif
                        </div>

                    </div>
                </div>
            </div>

            <div class="card radius-10">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-0"><a class="text-secondary" href="{{ route('analytics.activeTenants') }}">Active Tenants</a>
                                <i class='bx bx-info-circle' title="Records from the last 30 days"></i>
                            </p>
                            <h4 class="my-1"><a class="text-dark" href="{{ route('analytics.activeTenants') }}">{{ number_format($activeTenantsCount, 0, '.', ',') }}</a></h4>
                            @php
                                $activeTenantsCountDifference = $currentMonthActiveTenantsCount - $lastMonthActiveTenantsCount;
                            @endphp

                            @if ($currentMonthActiveTenantsCount > $lastMonthActiveTenantsCount)
                                <p class="mb-0 font-13 text-success">
                                    <i class="bx bxs-up-arrow align-middle"></i>
                                    +{{ number_format($activeTenantsCountDifference, 0, '.', ',') }} from last month
                                </p>
                            @elseif ($currentMonthActiveTenantsCount == $lastMonthActiveTenantsCount)
                                <p class="mb-0 font-13 text-primary">
                                    <i class="bx bxs-right-arrow align-middle"></i>
                                    {{ number_format($activeTenantsCountDifference, 0, '.', ',') }} from last month
                                </p>
                            @elseif ($currentMonthActiveTenantsCount < $lastMonthActiveTenantsCount)
                                <p class="mb-0 font-13 text-danger">
                                    <i class="bx bxs-down-arrow align-middle"></i>
                                    {{ number_format($activeTenantsCountDifference, 0, '.', ',') }} from last month
                                </p>
                            @endif
                        </div>

                    </div>
                </div>
            </div>

            <div class="card radius-10">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-0 text-secondary">Total Tenants
                                <i class='bx bx-info-circle' title="All the records from the past"></i>
                            </p>
                            <h4 class="my-1">{{ number_format($totalTenantsCount, 0, '.', ',') }}</h4>
                            <p class="mb-0 font-13">Total tenants from the past to now</p>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        {{-- Analytics With Chart --}}
        <div class="col-md-9">
            <div class="card">
                <div class="card-body">
                    <div class="mt-3" id="tenantsCount"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-5">
            <div class="card">
                <div class="card-body">
                    <h6 class="ms-3 my-3">Tenants - Gender</h6>
                    <div class="mt-3" id="tenantsGender"></div>
                </div>
            </div>
        </div>
        <div class="col-md-7">
            <div class="card">
                <div class="card-body">
                    <h6 class="ms-3 my-3">Tenants - Country (Total - {{ $totalCountryCount }})</h6>
                    <div class="mt-3" id="tenantsCountries"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('page-specific-js')
<script>
        // Tenants Count Line Chart
        var newTenants = <?php echo $newTenantsChart ?>;

        var tmonths = newTenants.map(function(tenant) {
            return tenant.monthname + ' ' + tenant.year;
        });

        var tcount = newTenants.map(function(tenant) {
            return tenant.new_tenants_count;
        });

        var options = {
            series: [{
                name: 'New Tenants',
                data: tcount
            }],
            chart: {
                foreColor: '#9ba7b2',
                height: 320,
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
                text: 'New Tenants (Last 6 Months)',
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
                min: 0,
                max: Math.max(...tcount) + 1,
                tickAmount: Math.max(...tcount) + 1,
                title: {
                    text: 'Tenants Count',
                }, // title
                labels: {
                    formatter: function(val) {
                        return val.toFixed();
                    },
                },
            } // yaxix
        };
        var chart = new ApexCharts(document.querySelector("#tenantsCount"), options);
        chart.render();

        // Tenants' Gender
        var tenantsFemaleCount = <?php echo $tenantsFemaleCount ?>;
        var tenantsMaleCount = <?php echo $tenantsMaleCount ?>;

        var options = {
            series: [tenantsMaleCount, tenantsFemaleCount],
            chart: {
                foreColor: '#9ba7b2',
                height: 330,
                type: 'pie',
            },
            colors: ["#0d6efd", "#6c757d"],
            labels: ['Male', 'Female'],
            responsive: [{
                breakpoint: 480,
                options: {
                    chart: {
                        height: 360
                    },
                    legend: {
                        position: 'bottom'
                    }
                }
            }]
        };
        var chart = new ApexCharts(document.querySelector("#tenantsGender"), options);
        chart.render();

        // Donut Chart
        var tenantsCountriesChart = <?php echo $tenantsCountriesChart ?>;
        var tenantsTotalCountry = tenantsCountriesChart.map(function(tenant) {
            return tenant.total_country;
        });
        var tenantsCountryName = tenantsCountriesChart.map(function(tenant) {
            return tenant.name;
        });

        var options = {
            series: tenantsTotalCountry,
            chart: {
                foreColor: '#9ba7b2',
                height: 330,
                type: 'pie',
            },
            colors: ["#0d6efd", "#6c757d", "#8f8f8f", "#000", "#05368b"],
            labels: tenantsCountryName,
            responsive: [{
                breakpoint: 480,
                options: {
                    chart: {
                        height: 360
                    },
                    legend: {
                        position: 'bottom'
                    }
                }
            }]
        };
	    var chart = new ApexCharts(document.querySelector("#tenantsCountries"), options);
	    chart.render();
    </script>

@endsection
