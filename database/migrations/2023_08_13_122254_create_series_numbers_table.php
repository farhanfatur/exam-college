<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSeriesNumbersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('series_numbers', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("product_id")->unsigned();
            $table->integer("series_no");
            $table->float("price");
            $table->date("prod_date");
            $table->timestamp("warranty_start")->nullable();
            $table->timestamp("warranty_duration")->nullable();
            $table->boolean("used")->nullable();
            $table->timestamps();

            $table->foreign("product_id")->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('series_numbers');
    }
}
