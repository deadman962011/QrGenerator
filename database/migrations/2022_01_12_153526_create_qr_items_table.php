<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQrItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('qr_items', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('prefix');
            $table->string('value');
            $table->BigInteger('collection_id')->unsigned()->index();
            $table->foreign('collection_id')->references('id')->on('qr_collections')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('qr_items');
    }
}
