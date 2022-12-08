<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreQuoteRequest;
use App\Http\Requests\UpdateQuoteRequest;
use App\Http\Resources\QuoteResource;
use App\Models\Quote;
use Illuminate\Http\Request;

class QuoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return QuoteResource::collection(Quote::paginate(5));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreQuoteRequest $request)
    {
        //
        return new QuoteResource(Quote::create($request->validated()));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Quote  $quote
     * @return \Illuminate\Http\Response
     */
    // public function show($id)
    // {
    //     //
    //     $quote = Quote::find($id);
    //     if ($quote) {
    //         return response()->json($quote);
    //     } else {
    //         return response()->json([
    //             'message' => 'Quote not found'
    //         ], 404);
    //     }
    // }
    public function show(Quote $quote)
    {
        //
        return new QuoteResource($quote);
    }
    // public function show($id)
    // {
    //     //
    //     $data = Quote::findOrFail($id);
    //     return response()->json($data);
    // }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Quote  $quote
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //validasi
        $validated = $request->validate([
            'text' => 'required|min:20',
            'author' => 'required|min:10',
        ]);
        //kalo berhasil di update
        if ($validated) {
            //ambil dulu datanya
            $data = Quote::find($id);
            //kalo ada datanya kita update
            if ($data) {
                $data->update($validated);
                return response()->json($data);
            } else {
                //kalo ga ada response 404
                return response()->json(["message" => "Quote not found"], 404);
            }
        }
    }

    // public function update(Request $request, $id)
    // {
    //     //validasi
    //     $validated = $request->validate([
    //         'text' => 'required|min:20',
    //         'author' => 'required|min:10',
    //     ]);
    //     //kalo berhasil di update
    //     if ($validated) {
    //         //ambil dulu datanya
    //         $data = Quote::findOrFail($id)->update($validated);
    //         return response()->json($data);
    //     }
    // }

    // public function update(UpdateQuoteRequest $request, Quote $quote)
    // {
    //     return new QuoteResource(tap($quote)->update($request->validated()));
    // }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Quote  $quote
     * @return \Illuminate\Http\Response
     */
    public function destroy(Quote $quote)
    {
        //find quote by id
        $quote->delete();
        return response()->noContent();
    }
}
