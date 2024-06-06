

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

    <div class="container mt-5">
        <div class="row mb-3">
            <div class="col-md-6 mb-3">
                <button type="button" class="btn btn-primary btn-lg d-grid gap-2 btn-hover" data-bs-toggle="modal" data-bs-target="#comparisonModal">
                    <i class="bi bi-pie-chart-fill fs-4 me-2"></i> Case Contested Chart
                </button>
            </div>
            <div class="col-md-6 mb-3">
                <button type="button" class="btn btn-primary btn-lg d-grid gap-2 btn-hover" data-bs-toggle="modal" data-bs-target="#chartModal">
                    <i class="bi bi-car-front-fill fs-4 me-2"></i> Vehicle Chart
                </button>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-6 mb-3">
                <button type="button" class="btn btn-primary btn-lg d-grid gap-2 btn-hover" data-bs-toggle="modal" data-bs-target="#pieChartModal">
                    <i class="bi bi-cone-striped fs-4 me-2"></i> Open Traffic Violations Distribution
                </button>
            </div>
            <div class="col-md-6 mb-3">
                <button type="button" class="btn btn-primary btn-lg d-grid gap-2 btn-hover" data-bs-toggle="modal" data-bs-target="#rankingModal">
                    <i class="bi bi-list-ul fs-4 me-2"></i> View Violation Rankings
                </button>
            </div>
        </div>
    </div>
<div class="modal fade" id="pieChartModal" tabindex="-1" aria-labelledby="pieChartModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" style="max-width: 80%;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="pieChartModalLabel">Traffic Violations Chart</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="mb-3 row">
                    <label for="monthPicker" class="form-label">Select a month to generate the traffic violations chart:</label>
                    <div class="col">
                            <input type="month" id="monthPicker" class="form-control">
                        </div>
                        <div class="col-auto">
                            <button id="fetchDataBtn" class="btn btn-primary">Generate Chart</button>
                        </div>
                    </div>
                    <canvas id="codeCount"></canvas>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


<!-- Modal -->
<div class="modal fade" id="rankingModal" tabindex="-1" aria-labelledby="rankingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" style="max-width: 90%;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="rankingModalLabel">Contested Cases Rankings</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Violation</th>
                            <th>Count</th>
                        </tr>
                    </thead>
                    <tbody id="rankingTableBody"></tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

{{-- JavaScript to fetch data and populate the table --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const rankingTableBody = document.getElementById('rankingTableBody');

        // Function to fetch data and populate the table
        function populateRankingTable() {
            fetch('/api/violation-rankings')
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok ' + response.statusText);
                    }
                    return response.json();
                })
                .then(data => {
                    // Clear existing table rows
                    rankingTableBody.innerHTML = '';

                    // Populate table rows with received data
                    data.forEach(violation => {
                        const row = `
                            <tr>
                                <td>${violation.violation}</td>
                                <td>${violation.count}</td>
                            </tr>
                        `;
                        rankingTableBody.innerHTML += row;
                    });
                })
                .catch(error => {
                    console.error('Error fetching violation rankings:', error);
                    alert('Failed to load violation rankings: ' + error.message);
                });
        }

        // Populate the table when the modal is shown
        $('#rankingModal').on('shown.bs.modal', function () {
            populateRankingTable();
        });
    });
</script>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    let pieChart;

    function fetchPieChartData(month) {
        let url = '/api/pie-chart-data';
        if (month) {
            url += `?month=${month}`;
        }

        return fetch(url)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok ' + response.statusText);
                }
                return response.json();
            });
    }

    function updateChart(data) {
        const labels = data.map(item => item.violation);
        const counts = data.map(item => item.count);
        const totalCount = counts.reduce((acc, count) => acc + count, 0); // Total count of violations

        if (pieChart) {
            pieChart.destroy();
        }

        const ctx = document.getElementById('codeCount').getContext('2d');
        pieChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: labels,
                datasets: [{
                    data: counts,
                    backgroundColor: [
                        'red', 'blue', 'green', 'yellow', 'orange', 'purple', 'pink', 'cyan',
                        'teal', 'maroon', 'navy', 'olive', 'indigo', 'salmon', 'darkorange', 'darkslategray',
                        'darkorchid', 'gold', 'mediumspringgreen', 'steelblue', 'darkred', 'darkkhaki', 'mediumpurple', 'saddlebrown',
                        'darkcyan', 'darkmagenta', 'lightcoral', 'mediumaquamarine', 'mediumvioletred', 'midnightblue', 'darkgoldenrod',
                        'mediumseagreen', 'lightsalmon', 'darkslateblue', 'cadetblue', 'firebrick', 'darkseagreen', 'mediumorchid',
                        'cornflowerblue', 'orangered', 'slateblue', 'mediumblue', 'royalblue', 'forestgreen', 'crimson', 'peru',
                        'darkolivegreen', 'darkturquoise', 'chocolate', 'darkviolet', 'dodgerblue', 'greenyellow', 'lightseagreen',
                        'limegreen', 'rosybrown', 'sienna', 'tomato', 'mediumturquoise', 'orangered', 'cornsilk', 'darkslategrey',
                        'hotpink', 'lightcoral', 'palevioletred', 'powderblue', 'seagreen', 'springgreen', 'darkred', 'darkseagreen',
                        'darkslateblue', 'darkslategrey', 'darkviolet', 'deepskyblue', 'dimgray', 'dimgrey', 'dodgerblue', 'firebrick',
                        'forestgreen', 'fuchsia', 'goldenrod', 'greenyellow', 'indianred', 'limegreen', 'mediumaquamarine', 'mediumblue',
                        'mediumorchid', 'mediumturquoise', 'mediumvioletred', 'midnightblue', 'navajowhite', 'olivedrab', 'orangered',
                        'palegreen', 'paleturquoise', 'palevioletred', 'papayawhip', 'peachpuff', 'peru', 'plum', 'powderblue',
                        'rosybrown', 'royalblue', 'saddlebrown', 'salmon', 'sandybrown', 'seagreen', 'sienna', 'skyblue', 'slateblue',
                        'slategray', 'slategrey', 'snow', 'springgreen', 'steelblue', 'tan', 'teal', 'thistle', 'tomato', 'turquoise',
                        'violet', 'wheat', 'whitesmoke', 'yellow', 'yellowgreen'
                    ]
                }]
            },
            options: {
                responsive: true,
                tooltips: {
                    callbacks: {
                        label: function(tooltipItem, data) {
                            const label = data.labels[tooltipItem.index];
                            const value = data.datasets[0].data[tooltipItem.index];
                            const percentage = ((value / totalCount) * 100).toFixed(2);
                            return `${label}: ${value} (${percentage}%)`;
                        }
                    }
                }
            }
        });
    }

    // Initial fetch for the current month's data
    fetchPieChartData()
        .then(data => updateChart(data))
        .catch(error => {
            console.error('Error fetching pie chart data:', error);
            alert('Failed to load pie chart data: ' + error.message);
        });

    // Event listener for the "Generate Chart" button
    const fetchDataBtn = document.getElementById('fetchDataBtn');
    fetchDataBtn.addEventListener('click', function () {
        const monthPicker = document.getElementById('monthPicker');
        const selectedMonth = monthPicker.value;
        fetchPieChartData(selectedMonth)
            .then(data => updateChart(data))
            .catch(error => {
                console.error('Error fetching pie chart data:', error);
                alert('Failed to load pie chart data: ' + error.message);
            });
    });
});
</script>

<!-- Modal -->
<div class="modal fade" id="pieChartModal" tabindex="-1" aria-labelledby="pieChartModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" style="max-width: 70%;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="pieChartModalLabel">Traffic Violations Chart</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="mb-3 row">
                    <label for="monthPicker" class="form-label col-sm-2">Select a month:</label>
                    <div class="col-sm-4">
                        <input type="month" id="monthPicker" class="form-control">
                    </div>
                    <div class="col-auto">
                        <button id="fetchDataBtn" class="btn btn-primary">Generate Chart</button>
                    </div>
                </div>
                <canvas id="codeCount"></canvas>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>



<!-- Modal -->
<div class="modal fade" id="chartModal" tabindex="-1" aria-labelledby="chartModalLabel" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered modal-lg" style="max-width: 90%;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="chartModalLabel">Monthly Type of Vehicle Chart</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Month Selection Form -->
                <div class="form-group mb-4">
                    <label for="selected_month">Select Month:</label>
                    <input type="month" id="selected_month" class="form-control">
                </div>

                <!-- Comparison Form Group -->
                <div class="form-group mb-4">
                    <label for="comparison_month">Comparison Month:</label>
                    <input type="month" id="comparison_month" class="form-control">
                </div>

                <!-- Chart Canvas -->
                <canvas id="myChart"></canvas>
            </div>
            <div class="modal-footer">
                <!-- Button to Generate Chart -->
                <button id="fetch-vehicle" class="btn btn-primary">
                    <i class="fas fa-chart-bar me-2"></i>Generate Chart
                </button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

    <!-- Modal -->
<div class="modal fade" id="comparisonModal" tabindex="-1" aria-labelledby="comparisonModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" style="max-width: 90%;">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="comparisonModalLabel">
                    <i class="fas fa-calendar-alt me-2"></i> Contested Cases Analytics
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
             

                <!-- Chart Display -->
                <div class="card mt-4 mb-4">
                    <div class="card-header bg-success text-white">
                        <i class="fas fa-chart-pie me-2"></i> Compare Cases Occurence
                    </div>
                    <div class="card-body">
            <!-- Month and Year Selection Form for Data 1 -->
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

<!-- Month and Year Selection Form for Data 2 -->
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

<!-- Button to Generate Chart -->
<button id="fetch-data" class="btn btn-primary mt-3">
    <i class="fas fa-chart-bar me-2"></i>Generate Chart
</button>

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

                 <!-- Date Received Selection Section -->
                 <div class="card mt-4">
                    <div class="card-header bg-info text-white">
                        <i class="fas fa-calendar-alt me-2"></i> Number of Contested Cases Chart
                    </div>
                    <div class="card-body">

                    <div id="dateReceivedChart" style="height: 400px;"></div>
                    <hr>
                <div class="form-group">
                    <label for="monthSelect">Select Month:</label>
                    <select class="form-control" id="monthSelect">
                        <option value="1">January</option>
                        <option value="2">February</option>
                        <option value="3">March</option>
                        <option value="4">April</option>
                        <option value="5">May</option>
                        <option value="6">June</option>
                        <option value="7">July</option>
                        <option value="8">August</option>
                        <option value="9">September</option>
                        <option value="10">October</option>
                        <option value="11">November</option>
                        <option value="12">December</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="yearInput">Select Year:</label>
                    <select class="form-control" id="yearInput">
                        <option value="">Select Year</option>
                        @foreach ($yearsWithData as $year)
                            <option value="{{ $year }}">{{ $year }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="button" class="btn btn-primary" id="submitBtn">Generate Chart</button>
            
            </div>
        </div>
    </div>
</div>
</div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Initialize ApexCharts instance
        const dateReceivedChart = new ApexCharts(document.querySelector("#dateReceivedChart"), {
            chart: {
                type: 'bar',
                height: 350
            },
            series: [{
                name: 'Occurrences',
                data: []
            }],
            xaxis: {
                type: 'datetime',
                labels: {
                    datetimeUTC: false
                }
            }
        });

        // Function to fetch data for the selected month and year
        const fetchData = () => {
            const month = document.getElementById('monthSelect').value;
            const year = document.getElementById('yearInput').value;

            fetch(`/date-received-data?month=${month}&year=${year}`)
                .then(response => response.json())
                .then(data => {
                    const labels = data.map(item => new Date(item.date).getTime());
                    const counts = data.map(item => item.count);

                    dateReceivedChart.updateSeries([{
                        data: counts
                    }]);
                    dateReceivedChart.updateOptions({
                        xaxis: {
                            categories: labels
                        }
                    });
                });
        };

        // Add event listener to submit button
        document.getElementById('submitBtn').addEventListener('click', fetchData);

        // Render the chart
        dateReceivedChart.render();
    });
</script>

<script>
// Function to fetch data for the selected month and generate the chart
function fetchDataAndGenerateChart() {
    // Get the selected month and comparison month from the input
    var selectedMonth = $('#selected_month').val();
    var comparisonMonth = $('#comparison_month').val();

    // AJAX request to fetch data for the selected month
    $.ajax({
        url: '/monthly-type-of-vehicle', // Replace with your actual route
        method: 'GET',
        data: {
            month: selectedMonth,
            comparison_month: comparisonMonth
        },
        success: function(response) {
            // Generate the chart using the fetched data and the selected dates
            generateChart(response.labels, response.datasets, selectedMonth, comparisonMonth);
        },
        error: function(xhr, status, error) {
            console.error('Error fetching data:', error);
        }
    });
}

function generateChart(labels, datasets, selectedMonth, comparisonMonth) {
    // Get the canvas element
    var ctx = document.getElementById('myChart').getContext('2d');

    // Check if labels is undefined
    if (typeof labels === 'undefined') {
        console.error('Labels are undefined.');
        return;
    }

    // Check if there's an existing chart instance
    if (window.myChart && typeof window.myChart.destroy === 'function') {
        // If yes, destroy it
        window.myChart.destroy();
    }

    // Format the date strings
    var selectedDate = new Date(selectedMonth);
    var selectedDateStr = selectedDate.toLocaleString('default', { month: 'long', year: 'numeric' });
    var comparisonDate = new Date(comparisonMonth);
    var comparisonDateStr = comparisonDate.toLocaleString('default', { month: 'long', year: 'numeric' });

    // Update the labels with date information
    labels = labels.map(label => `${label} (${selectedDateStr} vs ${comparisonDateStr})`);

    // Create a new chart
    window.myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: datasets
        },
        options: {
            animation: {
                duration: 1000,
                easing: 'easeInOutQuad'
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            var label = context.dataset.label || '';
                            if (label) {
                                label += ': ';
                            }
                            label += context.parsed.y;
                            return label;
                        },
                        footer: function(context) {
                            var selectedDateStr = new Date(selectedMonth).toLocaleDateString('default', { month: 'long', year: 'numeric' });
                            var comparisonDateStr = new Date(comparisonMonth).toLocaleDateString('default', { month: 'long', year: 'numeric' });
                            return `Selected Month: ${selectedDateStr} | Comparison Month: ${comparisonDateStr}`;
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
}

// Event listener for the "Generate Chart" button
$('#fetch-vehicle').click(function() {
    fetchDataAndGenerateChart();
});
</script>


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
                toastr.error('Please select both months and years.');
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

<script>
    // Assuming you're using ApexCharts library
var options = {
    chart: {
        type: 'pie',
        events: {
            dataPointSelection: function(event, chartContext, config) {
                if (config.dataPointIndex !== undefined) {
                    var selectedMonth = config.w.config.labels[config.dataPointIndex];
                    var selectedYear = config.w.config.series[0][config.dataPointIndex];
                    fetchForecast(selectedYear, selectedMonth);
                }
            }
        }
    },
    series: [30, 40, 20, 10], // Example data
    labels: ['January 2024', 'February 2024', 'March 2024', 'April 2024'], // Example labels
};

var chart = new ApexCharts(document.querySelector("#chart"), options);
chart.render();

function fetchForecast(year, month) {
    fetch(`/forecast/${year}/${month}`)
        .then(response => response.json())
        .then(data => {
            // Handle the fetched forecast data
            console.log(data);
            // Display the data in a modal or on the page
        })
        .catch(error => console.error('Error fetching forecast:', error));
}

</script>

  </main><!-- End #main -->
 @include('layouts.footer')
</body>

</html>
