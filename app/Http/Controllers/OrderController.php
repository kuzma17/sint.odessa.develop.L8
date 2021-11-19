<?php

namespace App\Http\Controllers;

use App\Models\ActRepair;
use App\Models\History;
use App\Models\Office;
use App\Models\Order;
use App\Models\TypeClient;
use App\Models\TypeOrder;
use Auth;
use Illuminate\Http\Request;
use Session;


class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $orders = $user->orders->paginate(15);
        return view('user.order_list', ['orders'=>$orders]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $type_order = TypeOrder::all();
        $offices = Office::all();
        $type_client = TypeClient::all();
        $user = Auth::user();

        return view('order.order', [
            'type_clients' => $type_client,
            'type_order' => $type_order,
            'offices' => $offices,
            'user' => $user
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Order $order)
    {
       if ($request->all_order){
           $request->flash();
           return redirect(route('user.orders.create'));
       }

       $user = Auth::user();
       $order = $user->orders()->create($request->request->all());

        $history = new History([
            'order_id' => $order->id,
            'status_info' => 'Создан новый заказ № '.$order->id
        ]);
        $history->save();

       session()->flash('ok_message', 'Ваш заказ успешно создан и будет обработан в ближайшее время.');

       return redirect(route('user.orders.index'));

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        $order->load('history', 'act_repair');
        $user = Auth::user();
      //  dd($order);
        return view('user.order', ['order'=>$order, 'user'=>$user]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function user_consent(Request $request){
        $order_id = $request->input('order_id');
        $repair = ActRepair::where('order_id', $order_id)->first();
        $repair->user_consent_id = $request->input('user_consent');
        $repair->comment = $request->input('comment');
        $repair->save();

        // Save History
        $history = new \App\Models\History();
        $history->order_id = $order_id;
        $history->status_info = $repair->user_consent->name;
        $history->comment = $repair->comment;
        $history->save();
        // End Save History

        Session::flash('ok_message', 'Ваш заказ успешно подтвержден и будет обработан в ближайшее время.');
        return redirect(route('user.orders.show', $order_id));
    }
}
