@extends('layouts.admin.app')

@section('content')
<div class="container">

    <div class="row">
        <div class="col">
            <p class="text-white mt-5 mb-5">Welcome back, <b>Admin</b></p>
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
        <div class="col-md-3">
            <div class="form-group">
                <button class="btn btn-primary" onclick="applyFilters()">Apply Filters</button>
            </div>

        </div>
    </div>


<div id="filteredData">
    <div class="container mt-5">
        <div class="row tm-content-row">
            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 tm-block-col">
                <div class="tm-bg-primary-dark tm-block tm-block-products">
                    <div class="tm-product-table-container">
                        <table class="table table-hover tm-table-small tm-product-table">
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
        },
        error: function(xhr, status, error) {
            console.error(error);
        }
    });
}

</script>
@endsection
