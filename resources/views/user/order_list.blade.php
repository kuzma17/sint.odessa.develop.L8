@extends('user.app')
@section('profile')
    <div class="rcol-sm-6 col-md-9 col-lg-9">
        <h4>Заказы</h4>
        <table class="table table-hover table-bordered">
            <thead>
            <tr>
                <th>№</th>
                <th>вид работ</th>
                <th>дата</th>
                <th>статус заказа</th>
                <th>статус ремонта</th>
            </tr>
            </thead>
            <tbody>
            @foreach($orders as $order)
                <tr class="link_order" onclick="document.location.href='{{ route('user.orders.show', $order->id ) }}'">
                    <td>{{ $order['1c_id'] or ''}}</td>
                    <td>{{ $order->type_order->name }}</td>
                    <td>{{ date_format($order->created_at, "d.m.Y") }}</td>
                    <td>{{ $order->status->name_site }}</td>
                    <td>{{ $order->act_repair? $order->act_repair->status_repair->name:'' }}</td>
                </tr>
             @endforeach
            </tbody>
        </table>
        {{ $orders->render() }}
    </div>
@endsection
