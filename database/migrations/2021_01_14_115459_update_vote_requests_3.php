<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateVoteRequests3 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vote_requests', function (Blueprint $table) {
            $table->string('tipe')->default('normal'); // 'normal', 'irv'
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vote_requests', function (Blueprint $table) {
            $table->dropColumn('tipe');
        });
    }
}
