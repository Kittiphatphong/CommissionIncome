<?php

namespace App\Http\Controllers;

use App\Mail\Format1Mail;
use App\Models\Client;
use App\Models\KycClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
      return view('client.clientList')
          ->with('list_clients',Client::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {


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
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id)
    {


        $client = Client::find($id);
        if ($client->client_statuses->id == 1 && $client->firstname != null){
            $client->status_id = 2;
            $client->save();
        }
        $kyc_client = KycClient::where('client_id',$id)->get()->last();
        if ($request->kyc_id){
            $kyc_client = KycClient::find($request->kyc_id);

        }
        return view('client.clientDetail')
            ->with('list_clients','list_clients')
            ->with('kyc',$kyc_client)
            ->with('kyc_last',KycClient::where('client_id',$id)->get()->last())
            ->with('client',Client::find($id));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function edit(Client $client)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $client = Client::find($id);
        $kyc_client = KycClient::where('client_id',$id)->get()->last();

        $kyc = KycClient::find($kyc_client->id);
        $kyc->comment = $request->comment;
        $kyc->user_id = Auth::user()->id;
        if ($request->action == "approve"){
        $kyc->status = 1;
        $client->status_id = 4;
        $client->save();
            $status = "Approved";
        }else{
            $kyc->status = 0;
            $client->status_id = 3;
            $client->save();
            $status = "Rejected";
        }
        $kyc->save();

        Mail::to($client->email)->send(new Format1Mail('Client Verify KYC','Your Verify Is '. $status, $request->comment));

        return back()->with('success','Success');


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client)
    {
        $client->delete();
        return back();
    }
}
