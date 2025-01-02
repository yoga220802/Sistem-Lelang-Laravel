<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('starting_price', 10, 2);
            $table->decimal('current_price', 10, 2)->default(0);
            $table->unsignedBigInteger('auction_id')->nullable();
            $table->timestamps();

            // $table->foreign('auction_id')->references('id')->on('auctions')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('items');
    }
}