<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use StarkBank\Transaction;
use App\Models\Transactions;
use StarkBank\Project;
use StarkBank\Organization;
use StarkBank\Settings;
use StarkBank\Transfer;
use StarkBank\Balance;

class starkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {




        $Transaction = new Transactions();


        // dd(env("PRIVATE_KEY"));
        $privateKeyContent = env("PRIVATE_KEY");


        $project = new Project([
            "environment" => "sandbox",
            "id" => "6486646136504320",
            "privateKey" => $privateKeyContent
        ]);

        $data = $request->input();
        // dd($data['bankCode']);
        if (isset($data['bankCode']) && isset($data['branch']) && isset($data['account']) && isset($data['amount'])) {
        Settings::setUser($project);
        $transfers = Transfer::create([
            new Transfer([
                "amount" => intval($data['amount']),
                "bankCode" => strval($data['bankCode']),  # TED
                "branchCode" => strval($data['branch']),
                "accountNumber" => strval($data['account']),
                "taxId" => strval($data['document']),
                "name" => strval($data['name']),
                // "tags" => ["iron", "suit"]
            ]),

        ]);

        $Transaction->stark_order = $transfers[0]->id;
        $Transaction->status = "pending";
        $Transaction->type = "bank_transfer";
        $Transaction->save();


        return response()->json([
            'message' => 'Payment created successfully',
            'data' =>   $transfers[0],
        ], 200);
        }
        return response()->json([
            'message' => 'To make a transfer, enter the bank branch account and amount fields.',
        ], 500);
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
}
