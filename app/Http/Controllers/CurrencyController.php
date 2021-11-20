<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Trail\UploadImage;
use App\Models\Currency;
use App\Models\Rate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CurrencyController extends Controller
{
    use UploadImage;
    public function index()
    {
        return view('currencies.listCurrency')
            ->with('list_currencies',Currency::all());
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
            'name' => 'required',
            'image' => 'required|file|image|max:50000|mimes:jpeg,png,jpg'
        ]);
        $currency = new Currency();
        $currency->name = $request->name;
        $currency->image = $this->upload($request,'logo_currencies');
        $currency->save();

        return back()->with('success','Success');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Currency  $currency
     * @return \Illuminate\Http\Response
     */
    public function show(Currency $currency)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Currency  $currency
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('currencies.editCurrency')
            ->with('list_currencies','list_currencies')
            ->with('edit',Currency::find($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Currency  $currency
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'image' => 'file|image|max:50000|mimes:jpeg,png,jpg'
        ]);
        $currency = Currency::find($id);
        $currency->name = $request->name;
        if ($request->image){
            $currency->image = $this->editImage($request,$currency->image,'logo_currencies');
        }

        $currency->save();

        return redirect()->route('currencies.index')->with('success','Success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Currency  $currency
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $currency = Currency::find($id);
        $this->deleteImageJ($currency->image,'logo_currencies');
        $currency->delete();
        return back()->with('success','Success');
    }

    public function updateRate(Request $request,$id){
      $rate = new Rate();
      $rate->rate = $request->rate;
      $rate->rate_sell = $request->rate_sell;
      $rate->user_id = Auth::user()->id;
      $rate->currency_id = $id;
      $rate->save();

      return redirect()->route('currencies.index')->with('success','Success');
    }
}
