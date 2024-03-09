@foreach($orders as $order)
<div class="media tm-notification-item" id="order_{{$order->id}}">
    <div class="tm-gray-circle"></div>
    <div class="media-body">
        <p class="mb-2"><b>{{ $order->user_name }}</b> ({{ $order->email }}) has placed a new order for Product id <b>{{ $order->product_id }}</b>.</p>
        <span class="tm-small tm-text-color-secondary pull-right"> Order created {{ $order->created_at->diffForHumans() }}</span>

        @if ($order->status != 'completed')
            <button class="btn btn-secondary btn-sm accept-order pull-right" style="float: right;" data-order-id="{{ $order->id }}">Accept Order</button>
        @else
            <span class="badge badge-success">Completed</span>
        @endif
    </div>
</div>
@endforeach