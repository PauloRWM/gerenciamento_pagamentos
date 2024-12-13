<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use StarkBank\Settings;
use App\Models\WebhookLog;
use App\Models\Transactions;
use Illuminate\Support\Facades\Log;
use StarkBank\Transfer;
use StarkBank\Project;

class Process implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $requesting;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($requesting)
    {
        $this->requesting = $requesting;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $request = $this->requesting;

            $starkOrder = $request['event']['log']['transfer']['id'];
            $transaction = Transactions::where('stark_order', (string)$starkOrder)->first();

            if (!$transaction) {
                Log::error('Transaction not found', ['stark_order' => $starkOrder]);
                return;
            }

            $webhookLog = new WebhookLog();
            $webhookLog->workspaceId = $request['event']['workspaceId'];
            $webhookLog->stark_order = (string)$starkOrder;
            $webhookLog->type = $request['event']['log']['type'];
            $webhookLog->error = json_encode($request['event']['log']['errors']);
            $webhookLog->payload = json_encode($request);
            $webhookLog->save();


            if ($request['event']['log']['transfer']['status'] == "success" || $request['event']['log']['transfer']['status'] == "failed") {


                Transactions::where('stark_order', $starkOrder)
                    ->update(['status' => $request['event']['log']['transfer']['status']]);


                $curl = curl_init();

                curl_setopt_array($curl, array(
                    CURLOPT_URL => 'https://webhook.site/d6ed2174-ed42-480d-a9a2-e57e8c8afcbd',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS => '{
                    "status":"' . $request['event']['log']['type'] . '",
                    "stark_order":' . $starkOrder . '
                }',
                    CURLOPT_HTTPHEADER => array(
                        'Content-Type: application/json'
                    ),
                ));

                curl_exec($curl);

                curl_close($curl);
            }

           

            $project = new Project([
                "environment" => env("ENVIRONMENT"),
                "id" => env("PROJECT_ID"),
                "privateKey" => env("PRIVATE_KEY")
            ]);

            Settings::setUser($project);


            if ($request['event']['log']['transfer']['status'] == "success") {
                $PdfContent = Transfer::pdf($starkOrder);
                Storage::disk('s3')->put("comprovantes/$starkOrder.pdf", $PdfContent);
                $saved = Storage::disk('s3')->put('bucket-paulo', $PdfContent);
                Storage::disk('s3')->setVisibility("comprovantes/$starkOrder.pdf", 'public');

                Transactions::where('stark_order', $starkOrder)
                    ->update(['url_proof' =>  Storage::disk('s3')->url("comprovantes/$starkOrder.pdf")]);


                if ($saved) {
                    Log::info("PDF salvo com sucesso no S3: $starkOrder");
                } else {
                    Log::error("Falha ao salvar o PDF no S3: $starkOrder");
                }
            }
        } catch (\Exception $e) {
            Log::error('Erro durante o upload no S3', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ]);
            //    dd($e->getTraceAsString());
            //dd('Erro capturado:', $e->getMessage(), $e->getTrace());
        }
    }





    // if (!file_exists($this->filePath)) {
    //     Log::error("Arquivo não encontrado: {$this->filePath}");
    //     return;
    // }

    // $fileContent = file_get_contents($this->filePath);


    // if ($saved) {
    //     Log::info("Arquivo salvo com sucesso no S3 como: {$this->s3FileName}");
    // } else {
    //     Log::error("Falha ao salvar o arquivo no S3: {$this->s3FileName}");
    // }
}
