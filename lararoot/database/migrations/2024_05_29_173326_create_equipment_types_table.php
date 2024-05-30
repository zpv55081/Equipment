<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEquipmentTypesTable extends Migration
{
    public function up()
    {
        Schema::create('equipment_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('mask');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('equipment_types');
    }
}
