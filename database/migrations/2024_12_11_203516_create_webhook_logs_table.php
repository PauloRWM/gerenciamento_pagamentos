<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('webhook_logs', function (Blueprint $table) {
            $table->id();
            $table->string('stark_order');

            $table->string('type');
            $table->string('workspaceId');
            $table->text('payload');
            $table->text('error');
            $table->timestamps();


            $table->foreign('stark_order')
                ->references('stark_order')
                ->on('transactions')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('webhook_logs');
    }
};
