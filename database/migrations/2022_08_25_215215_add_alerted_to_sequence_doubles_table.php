<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAlertedToSequenceDoublesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sequence_doubles', function (Blueprint $table) {
            $table->boolean('alerted')->default(0)->after('acertos');
            $table->timestamp('alerted_at')->nullable()->default(null)->after('acertos');
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
