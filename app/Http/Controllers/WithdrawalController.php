<?php

namespace App\Http\Controllers;

use App\Mail\Format1Mail;
use App\Models\Client;
use App\Models\Withdrawal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class WithdrawalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('withdrawals.listWithdrawal')
            ->with('list_withdrawals',Withdrawal::all());
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
     * @param  \App\Models\Withdrawal  $withdrawal
     * @return \Illuminate\Http\Response
     */
    public function show(Withdrawal $withdrawal)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Withdrawal  $withdrawal
     * @return \Illuminate\Http\Response
     */
    public function edit(Withdrawal $withdrawal)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Withdrawal  $withdrawal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $withdrawal = Withdrawal::find($id);
        if ($withdrawal->status === 0 || $withdrawal->status ===1){
            return back()->with('warning','Stop');
        }
        $client = Client::find($withdrawal->client_id);
        $withdrawal->status =$request->status;
        $withdrawal->user_id = Auth::user()->id;
        $withdrawal->save();
        if($request->status === '1'){
            $status = "Approved";
            $content = "Your withdrawal is successful";

        }else{
            $status = "Rejected";
            $content = "Your withdrawal is fail";
        }

        Mail::to($client->email)->send(new Format1Mail('Client Withdrawal','Your Withdrawal Is '.$status, $content));

        return back()->with('success','Success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Withdrawal  $withdrawal
     * @return \Illuminate\Http\Response
     */
    public function destroy(Withdrawal $withdrawal)
    {
        //
    }
}
