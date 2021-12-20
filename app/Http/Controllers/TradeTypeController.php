<?php

namespace App\Http\Controllers;

use App\Models\TradeType;
use Illuminate\Http\Request;

class TradeTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('tradeTypes.listTradeType')
            ->with('list_trade_types',TradeType::all());
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
        $request->validate([
           'timeout' => 'required'
        ]);

        $trade_type = new TradeType();
        $trade_type->timeout = $request->timeout;
        $trade_type->save();

        return back()->with('success','success');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TradeType  $tradeType
     * @return \Illuminate\Http\Response
     */
    public function show(TradeType $tradeType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TradeType  $tradeType
     * @return \Illuminate\Http\Response
     */
    public function edit(TradeType $tradeType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TradeType  $tradeType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TradeType $tradeType)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TradeType  $tradeType
     * @return \Illuminate\Http\Response
     */
    public function destroy(TradeType $tradeType)
    {
        //
    }
}
