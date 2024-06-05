

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
    <div class="row">
        <div class="col-md-12">
            <!-- Card for month and year selection -->
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <i class="fas fa-calendar-alt me-2"></i> Select Months and Years for Comparison
                </div>
                <div class="card-body">
                    <div class="form-group mb-4">
                        <label for="month_1">Data 1:</label>
                        <div class="row">
                            <div class="col-sm-6">
                                <select class="form-control" id="year_1" name="year_1">
                                    <option value="">Select Year</option>
                                    @for ($year = 2020; $year <= date('Y'); $year++)
                                        <option value="{{ $year }}">{{ $year }}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-sm-6">
                                <select class="form-control" id="month_1" name="month_1">
                                    <option value="">Select Month</option>
                                    @for ($i = 1; $i <= 12; $i++)
                                        <option value="{{ $i }}">{{ date('F', mktime(0, 0, 0, $i, 10)) }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="month_2">Data 2:</label>
                        <div class="row">
                            <div class="col-sm-6">
                                <select class="form-control" id="year_2" name="year_2">
                                    <option value="">Select Year</option>
                                    @for ($year = 2020; $year <= date('Y'); $year++)
                                        <option value="{{ $year }}">{{ $year }}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-sm-6">
                                <select class="form-control" id="month_2" name="month_2">
                                    <option value="">Select Month</option>
                                    @for ($i = 1; $i <= 12; $i++)
                                        <option value="{{ $i }}">{{ date('F', mktime(0, 0, 0, $i, 10)) }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                    </div>
                    <button id="fetch-data" class="btn btn-primary mt-3"><i class="fas fa-chart-bar me-2"></i> Compare</button>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <!-- Card for displaying the chart -->
            <div class="card mb-4">
                <div class="card-header bg-success text-white">
                    <i class="fas fa-chart-pie me-2"></i> Case Contested Comparison Chart
                </div>
                <div class="card-body">
                    <div id="violationCountChart"></div>
                    <div class="mt-3">
                        <div class="btn-group" role="group">
                        <button id="change-chart-pie" class="btn btn-chart-type btn-secondary active" data-chart-type="pie">
    <i class="fas fa-chart-pie me-2"></i> Pie
</button>
 
<button id="change-chart-donut" class="btn btn-chart-type btn-secondary" data-chart-type="donut">
    <i class="fas fa-chart-pie me-2"></i> Donut
</button>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <!-- Additional Information -->
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title bg-info text-white p-3 mb-4"><i class="fas fa-info-circle me-2"></i> Case Contested Report</h5>
                    <ul class="list-group">
                        @foreach ($additionalMessages as $message)
                            <li class="list-group-item">{{ $message }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        var options = {
            chart: {
                type: 'pie',
                height: 400,
                toolbar: {
                    show: false,
                },
            },
            series: [],
            labels: [],
        };

        var chart = new ApexCharts(document.querySelector("#violationCountChart"), options);
        chart.render();

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
                    chart.updateSeries(data.series);
                    chart.updateOptions({
                        labels: data.labels
                    });
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

        // Event listener for changing chart type
        document.querySelectorAll('.btn-chart-type').forEach(function(btn) {
            btn.addEventListener('click', function () {
                var newType = this.getAttribute('data-chart-type');
                updateChartType(newType);
            });
        });

        function updateChartType(newType) {
            chart.updateOptions({
                chart: {
                    type: newType
                }
            });

            // Remove active class from all buttons
            document.querySelectorAll('.btn-chart-type').forEach(function(btn) {
                btn.classList.remove('active');
            });

            // Add active class to the clicked button
            document.getElementById('change-chart-' + newType).classList.add('active');

            // Additional logic for handling different chart types
            if (newType === 'pie') {
                // Handle pie chart data
            } else if (newType === 'line') {
                // Handle line chart data
            } else if (newType === 'bar') {
                // Handle bar chart data
            } else if (newType === 'donut') {
                // Handle donut chart data
            }
        }
    });
</script>

  </main><!-- End #main -->
 @include('layouts.footer')
</body>

</html>
