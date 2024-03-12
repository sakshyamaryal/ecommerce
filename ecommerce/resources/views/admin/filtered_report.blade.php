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