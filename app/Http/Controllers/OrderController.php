<?php

namespace App\Http\Controllers;

use App\Mail\Format1Mail;
use App\Models\Deposit;
use App\Models\Order;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('order.listOrder')
            ->with('list_orders',Order::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $order = Order::find($id);
        if ($order->status === 0 || $order->status ===1){
            return back()->with('warning','Stop');
        }
        $client = Client::find($order->client_id);
        $order->status =$request->status;
        $order->user_id = Auth::user()->id;
        $order->save();
        if($request->status === '1'){
            $status = "Approved";
            $content = "Your deposit is successful";
            $deposit = new Deposit();
            $deposit->crypto_amount = $order->your_crypto();
            $deposit->crypto_currency = $order->crypto_currency;
            $deposit->client_id = $order->client_id;
            $deposit->user_id = $order->user_id;
            $deposit->order_id = $order->id;
            $deposit->save();
        }else{
          $status = "Rejected";
            $content = "Your deposit is fail";
        }

        Mail::to($client->email)->send(new Format1Mail('Client Deposit Balance','Your Deposit is '.$status, $content));

        return back()->with('success','Success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }
}
