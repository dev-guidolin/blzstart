<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SequenceDoubleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sequence_doubles', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('chat_id');
            $table->foreign('chat_id')->references('chat_id')->on('chats');
            $table->text('sequencia');
            $table->string('titulo')->nullable()->default(null);
            $table->text('descricao')->nullable()->default(null);
            $table->integer('lenght')->unsigned();
            $table->string('entrada');
            $table->unsignedBigInteger('acertos');
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
        Schema::dropIfExists('sequence_doubles');
    }
}
