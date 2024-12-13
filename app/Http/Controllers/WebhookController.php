<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WebhookLog;
use App\Models\Transactions;
use Illuminate\Support\Facades\Log;
use App\Jobs\Process;

class WebhookController extends Controller
{
    public function store(Request $request)
    {
        try {

            $data = $request->all();


            Process::dispatch($data);

            return response()->json(['message' => ' sending to webhook processing queue']);
        } catch (\Exception $e) {
            Log::error('error sending to webhook processing queue', [
                'error' => $e->getMessage(),
                'stark_order' => $starkOrder ?? null
            ]);
            // dd($e);
            return response()->json(['error' => 'error sending to webhook processing queue'], 500);
        }
    }
}
