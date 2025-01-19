<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusToAuctionsTable extends Migration
{
    public function up()
    {
        Schema::table('auctions', function (Blueprint $table) {
            $table->string('status')->default('not started');
        });
    }

    public function down()
    {
        Schema::table('auctions', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
}