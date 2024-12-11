<?php

namespace App\Models;

use App\Models\WebhookLog;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transactions extends Model
{
    use HasFactory;
    public function webhookLogs()
    {
        return $this->hasMany(WebhookLog::class);
    }
}
