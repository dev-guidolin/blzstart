<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAguardarToSequenceDoublesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sequence_doubles', function (Blueprint $table) {
            $table->unsignedBigInteger('aguardar')->default(0)->after('alerted');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sequence_doubles', function (Blueprint $table) {
            //
        });
    }
}
