<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_transactions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("transaksi_id")->unsigned();
            $table->bigInteger("produk_id")->unsigned();
            $table->integer("serial_no");
            $table->float("price");
            $table->float("discount");
            $table->timestamps();

            $table->foreign("transaksi_id")->references('id')->on('transactions')->onDelete('cascade');
            $table->foreign("produk_id")->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detail_transactions');
    }
}
