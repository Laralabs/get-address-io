<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('getaddress_cache', static function (Blueprint $table): void {
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

    public function down(): void
    {
        Schema::dropIfExists('getaddress_cache');
    }
};
