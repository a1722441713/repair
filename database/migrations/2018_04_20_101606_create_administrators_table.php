<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdministratorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('administrators', function (Blueprint $table) {
            $table->increments('id');
            $table->String('name');
            $table->String('password');
            $table->integer('count')->default(0)->comment('维修数');
            $table->integer('praise')->default(0)->comment('好评');
            $table->integer('general')->default(0)->comment('一般');
            $table->integer('bad')->default(0)->comment('差评');
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
        Schema::dropIfExists('administrators');
    }
}
