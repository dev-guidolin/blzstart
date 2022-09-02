<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCobrancasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cobrancas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->decimal('valor',15,2);
            $table->string('plano');
            $table->timestamp('validade_plano');
            $table->string('collection_id')->nullable();
            $table->string('collection_status')->nullable();
            $table->string('payment_id')->nullable();
            $table->string('status')->default('created');
            $table->string('external_reference')->nullable();
            $table->string('payment_type')->nullable();
            $table->string('merchant_order_id')->nullable();
            $table->string('preference_id')->nullable()->index();
            $table->string('site_id')->nullable();
            $table->string('processing_mode')->nullable();
            $table->string('merchant_account_id')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cobrancas');
    }
}
