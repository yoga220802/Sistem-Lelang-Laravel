<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameCurrentPriceToFinalPriceInItemsTable extends Migration
{
    public function up()
    {
        Schema::table('items', function (Blueprint $table) {
            $table->renameColumn('current_price', 'final_price');
        });
    }

    public function down()
    {
        Schema::table('items', function (Blueprint $table) {
            $table->renameColumn('final_price', 'current_price');
        });
    }
}