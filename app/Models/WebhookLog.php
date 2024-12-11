<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Transactions;

class WebhookLog extends Model
{
    use HasFactory;
    public function transaction()
    {
        return $this->belongsTo(Transactions::class);
    }
}
