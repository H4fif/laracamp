<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCampBenefitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('camp_benefits', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            // 1st way
            // $table->unsignedBigInteger('camp_id');

            // 2nd way
            $table->foreignId('camp_id')->references('id')->on('camps')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->timestamps();
            $table->softDeletes();

            // 1st way
            // $table->foreign('camp_id')->references('id')->on('camps')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('camp_benefits');
    }
}
