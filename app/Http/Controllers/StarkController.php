<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Transactions;
use StarkBank\Project;

use StarkBank\Settings;
use StarkBank\Transfer;

use Illuminate\Support\Facades\Log;


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

        try {


            $Transaction = new Transactions();


           
            


            $project = new Project([
                "environment" => env("ENVIRONMENT"),
                "id" => env("PROJECT_ID"),
                "privateKey" => env("PRIVATE_KEY")
            ]);

            Settings::setUser($project);





            $data = $request->input();
            // dd($data['bankCode']);
            if (isset($data['bankCode']) && isset($data['branch']) && isset($data['account']) && isset($data['amount'])) {

                $transfers = Transfer::create([
                    new Transfer([
                        "amount" => intval($data['amount']) * 100,
                        "bankCode" => strval($data['bankCode']),
                        "branchCode" => strval($data['branch']),
                        "accountNumber" => strval($data['account']),
                        "taxId" => strval($data['document']),
                        "name" => strval($data['name']),

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
        } catch (\Exception $e) {

            dd($e);

            Log::error('To make a transfer, enter the account, bank branch and amount fields, make sure the data is valid!', [
                'error' => $e->getMessage(),
                'stark_order' => $starkOrder ?? null
            ]);

            return response()->json(['error' => 'To make a transfer, enter the account, bank branch and amount fields, make sure the data is valid!'], 500);
        }
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
