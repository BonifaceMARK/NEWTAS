

@section('title', env('APP_NAME'))

@include('layouts.title')

<body>
    <style>
        /* Hide the spinner arrows for number input */
        input[type="number"] {
            -moz-appearance: textfield; /* Firefox */
        }
    
        input[type="number"]::-webkit-outer-spin-button,
        input[type="number"]::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
        .capitalize {
    text-transform: uppercase;
    }
    #violationCountChart {
  height: 400px; /* Ensure the chart container has a defined height */
}
    </style>
  <!-- ======= Header ======= -->
@include('layouts.header')

  <!-- ======= Sidebar ======= -->
 @include('layouts.sidebar')

 <main id="main" class="main">
    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif
    @if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif
    <div class="container">
        <div class="card mb-3">
            <div class="row g-0">
                <div class="col-md-6">
                    <!-- Additional Information -->
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Case Contested Report</h5>
                            <ul class="list-group">
                                @foreach ($additionalMessages as $message)
                                    <li class="list-group-item">{{ $message }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <!-- Card for month and year selection -->
                    <div class="card mb-3">
                        <div class="card-header">
                            Select Months and Years for Comparison
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="month_1">Data 1:</label>
                                <select class="form-control" id="year_1" name="year_1">
                                    <option value="">In What Year:</option>
                                    @for ($year = 2020; $year <= date('Y'); $year++)
                                        <option value="{{ $year }}">{{ $year }}</option>
                                    @endfor
                                </select>
                                <select class="form-control" id="month_1" name="month_1">
                                    <option value="">In What Month:</option>
                                    @for ($i = 1; $i <= 12; $i++)
                                        <option value="{{ $i }}">{{ date('F', mktime(0, 0, 0, $i, 10)) }}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="month_2">Data 2:</label>
                                <select class="form-control" id="year_2" name="year_2">
                                    <option value="">In What Year:</option>
                                    @for ($year = 2020; $year <= date('Y'); $year++)
                                        <option value="{{ $year }}">{{ $year }}</option>
                                    @endfor
                                </select>
                                <select class="form-control" id="month_2" name="month_2">
                                    <option value="">In What Month:</option>
                                    @for ($i = 1; $i <= 12; $i++)
                                        <option value="{{ $i }}">{{ date('F', mktime(0, 0, 0, $i, 10)) }}</option>
                                    @endfor
                                </select>
                            </div>
                            <button id="fetch-data" class="btn btn-primary">Compare</button>
                        </div>
                    </div>

                    <!-- Card for displaying the chart -->
                    <div class="card mb-3">
                        <div class="card-header">
                            Case Contested Comparison Chart
                        </div>
                        <div class="card-body">
                            <div id="violationCountChart"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            function fetchData(month1, year1, month2, year2) {
                $.ajax({
                    url: '/fetch-violations',
                    method: 'GET',
                    data: {
                        month_1: month1,
                        year_1: year1,
                        month_2: month2,
                        year_2: year2
                    },
                    success: function (data) {
                        var options = {
                            chart: {
                                type: 'pie',
                                height: 400,
                                toolbar: {
                                    show: false,
                                },
                            },
                            series: data.series,
                            labels: data.labels,
                        };

                        var chart = new ApexCharts(document.querySelector("#violationCountChart"), options);
                        chart.render();
                    },
                    error: function (error) {
                        console.log('Error fetching data', error);
                    }
                });
            }

            document.getElementById('fetch-data').addEventListener('click', function () {
                var month1 = document.getElementById('month_1').value;
                var year1 = document.getElementById('year_1').value;
                var month2 = document.getElementById('month_2').value;
                var year2 = document.getElementById('year_2').value;

                if (month1 && year1 && month2 && year2) {
                    fetchData(month1, year1, month2, year2);
                } else {
                    alert('Please select both months and years.');
                }
            });
        });
    </script>
  </main><!-- End #main -->
 @include('layouts.footer')
</body>

</html>
