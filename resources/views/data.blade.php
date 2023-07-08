<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css" rel="stylesheet">


</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">{{ __('Data') }}</div>
        
                            <div class="card-body">
                                <table class="table table-bordered table-striped" id="myTable">
                                    <thead>
                                        <tr> 
                                            <td>Date</td>
                                            <td>Open</td>
                                            <td>High</td>
                                            <td>Low</td>
                                            <td>Close</td>
                                            <td>Volume</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($dataInRages as $dataInRage)
                                            @php 
                                                array_push($chartLables,date('d M Y',$dataInRage['date']??'not found'));
                                                array_push($chartHighData,$dataInRage['high']??'not found');
                                                array_push($chartLowData,$dataInRage['low']??'not found');
                                            @endphp

                                            <tr>
                                                <td>{{ date('d M Y',$dataInRage['date'])??'not found' }}</td>
                                                <td>{{ $dataInRage['open']??'not found' }}</td>
                                                <td>{{ $dataInRage['high']??'not found' }}</td>
                                                <td>{{ $dataInRage['low']??'not found' }}</td>
                                                <td>{{ $dataInRage['close']??'not found' }}</td>
                                                <td>{{ $dataInRage['volume']??'not found' }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td class="d-none"></td>
                                                <td class="d-none"></td>
                                                <td class="d-none"></td>
                                                <td class="d-none"></td>
                                                <td class="d-none"></td>
                                                <td colspan="6" class="text-danger">
                                                    Although there are total {{ count($data) }} data, 
                                                    but no data exist between <b>{{ date('d M Y',strtotime($start_date)) }}</b>
                                                    to <b>{{ date('d M Y',strtotime($end_date)) }}</b>, please re-submit with a good date;
                                                    <br><br>
                                                    plese submit with a valid date where data exist between: <b>{{ date('d M Y',min(array_column($data->toArray(), 'date'))) }}</b> to <b>{{ date('d M Y',max(array_column($data->toArray(), 'date'))) }}</b>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <canvas id="chart"></canvas>

            </div>
        </main>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
    <script>
        $('#myTable').DataTable({"ordering": false});
    </script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Sample data for the last 12 months
        const data = {
          labels: @json($chartLables).reverse(),
          highData: @json($chartHighData).reverse(),
          lowData: @json($chartLowData).reverse()
        };
    
    
        // Create the chart
        const ctx = document.getElementById('chart').getContext('2d');
        new Chart(ctx, {
          type: 'line',
          data: {
            labels: data.labels,
            datasets: [
              {
                label: 'High',
                data: data.highData,
                borderColor: 'rgb(75, 192, 192)',
                fill: false
              },
              {
                label: 'Low',
                data: data.lowData,
                borderColor: 'rgb(255, 99, 132)',
                fill: false
              }
            ]
          },
          options: {
            responsive: true,
            scales: {
              x: {
                display: true,
                title: {
                  display: true,
                  text: 'Month'
                }
              },
              y: {
                display: true,
                title: {
                  display: true,
                  text: 'Value'
                }
              }
            }
          }
        });
      </script>
    
    
</body>
</html>
