<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEquipmentsTable extends Migration
{
    public function up()
    {
        Schema::create('equipments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('equipment_type_id')->constrained('equipment_types');
            $table->string('serial_number');
            $table->text('desc')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['equipment_type_id', 'serial_number']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('equipments');
    }
}
