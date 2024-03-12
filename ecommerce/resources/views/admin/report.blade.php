@extends('layouts.admin.app')

@section('content')
<div class="container">

    <div class="row">
        <div class="col">
            <p class="text-white mt-5 mb-5">Welcome back, <b>{{ auth()->user()->name }}</b></p>
        </div>
    </div>

    <div class="row">
       
        <div class="col-md-4">
            <div class="card text-white bg-primary mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Revenue</h5>
                    <p class="card-text">{{ $totalRevenue }}</p>
                </div>
            </div>
        </div>

     
        <div class="col-md-4">
            <div class="card text-white bg-success mb-3">
                <div class="card-body">
                    <h5 class="card-title">Check-in Count</h5>
                    <p class="card-text">{{ $checkInCount }}</p>
                </div>
            </div>
        </div>

        
        <div class="col-md-4">
            <div class="card text-white bg-warning mb-3">
                <div class="card-body">
                    <h5 class="card-title">Order Count</h5>
                    <p class="card-text">{{ $orderCount }}</p>
                </div>
            </div>
        </div>

   
    </div>

    <div class="row">
      
        <div class="col-md-4">
            <div class="card text-white bg-info mb-3">
                <div class="card-body">
                    <h5 class="card-title">Low Stock Product Count</h5>
                    <p class="card-text">{{ $lowStockProductCount }}</p>
                </div>
            </div>
        </div>

      
        <div class="col-md-4">
            <div class="card text-white bg-danger mb-3">
                <div class="card-body">
                    <h5 class="card-title">Zero Stock Product Count</h5>
                    <p class="card-text">{{ $zeroStockProductCount }}</p>
                </div>
            </div>
        </div>

        
        <div class="col-md-4">
            <div class="card text-white bg-secondary mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Orders Count</h5>
                    <p class="card-text">{{ $totalOrdersCount }}</p>
                </div>
            </div>
        </div>
    </div>

</div>


<div class="container">
    <div class="row mb-3 d-flex align-items-end">
        <div class="col-md-3">
            <div class="form-group">
                <label for="startDate">Start Date:</label>
                <input type="date" class="form-control" id="startDate">
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="endDate">End Date:</label>
                <input type="date" class="form-control" id="endDate">
            </div>
        </div>
       <div class="col-md-3 d-flex align-items-end">
    <div class="form-group d-flex">
        <button class="btn btn-primary mr-2" onclick="applyFilters()">Apply Filters</button>
        <!-- <button class="btn btn-success" onclick="exportToExcel()">Export to Excel</button> -->
    </div>
</div>

    </div>

    



<div id="filteredData">
    <div class="container mt-5">
        <div class="row tm-content-row">
            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 tm-block-col">
                <div class="tm-bg-primary-dark tm-block tm-block-products">
                    <div class="tm-product-table-container">
                        <table class="table table-hover tm-table-small tm-product-table" id="reportTable">
                            <thead>
                                <tr>
                                    <th scope="col">Product Name</th>
                                    <th scope="col">Total Quantity Sold</th>
                                    <th scope="col">Total Revenue</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($reportData as $item)
                                <tr class="tm-product-row">
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->total_quantity_sold }}</td>
                                    <td>{{ $item->total_price }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="text-white">Total Revenue: {{ $totalRevenue }}</div>
                </div>
            </div>
        </div>
    </div>
    </div>
</div>
<!-- Include DataTables CSS and JavaScript -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
<script type="text/javascript" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

<!-- Include DataTables Buttons extension CSS and JavaScript -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.0.0/css/buttons.dataTables.min.css">
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.0.0/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.7.1/jszip.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.0.0/js/buttons.html5.min.js"></script>

<script>
    $(document).ready(function() {
        // Initialize DataTable
        $('#reportTable').DataTable({
            dom: 'Bfrtip', // Add buttons to the DOM
            buttons: [
                'excel' // Enable Excel export button
            ]
        });
    });
</script>
<style>
   
    #reportTable_wrapper {
        color: #000; /* Set text color */
    }

    #reportTable th,
    #reportTable td {

        padding: 8px; /* Add padding */
        background-color: #435c70; /* Set background color */
        color: #fff; /* Set text color */
    }

    #reportTable th {
        background-color: #354856; /* Set header background color */
    }
</style>



<script>
function applyFilters() {
    var startDate = $('#startDate').val();
    var endDate = $('#endDate').val();

    $.ajax({
        url: "{{ route('admin.report.filter') }}",
        type: 'POST',
        data: { 
            startDate: startDate,
            endDate: endDate,
            _token: '{{ csrf_token() }}',
        },
        success: function(response) {
            $('#filteredData').html(response.html);

            if ($.fn.DataTable.isDataTable('#reportTable')) {
                $('#reportTable').DataTable().destroy();
            }

            $('#reportTable').DataTable({
                dom: 'Bfrtip', // Add buttons to the DOM
                buttons: [
                    'excel' // Enable Excel export button
                ]
            });
        },
        error: function(xhr, status, error) {
            console.error(error);
        }
    });
}



</script>
@endsection
