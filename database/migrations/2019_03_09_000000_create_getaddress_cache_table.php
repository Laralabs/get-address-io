<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGetAddressCacheTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('getaddress_cache', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('line_1')->index();
            $table->string('line_2')->nullable();
            $table->string('line_3')->nullable();
            $table->string('line_4')->nullable();
            $table->string('locality')->nullable();
            $table->string('town_or_city')->nullable();
            $table->string('county')->nullable();
            $table->string('postcode')->index();
            $table->string('thoroughfare')->nullable();
            $table->string('building_name')->nullable();
            $table->string('sub_building_name')->nullable();
            $table->string('sub_building_number')->nullable();
            $table->string('building_number')->nullable();
            $table->string('district')->nullable();
            $table->string('country')->nullable();
            $table->decimal('latitude', 16, 12)->nullable();
            $table->decimal('longitude', 16, 12)->nullable();
            $table->boolean('expanded_result')->default(false);
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
        Schema::dropIfExists('getaddress_cache');
    }
}
