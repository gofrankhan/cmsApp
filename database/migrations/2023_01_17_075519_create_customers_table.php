<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username');
            $table->string('taxid')->unique();
            $table->string('customertype');
            $table->string('company');
            $table->string('firstname');
            $table->string('lastname');
            $table->string('telephone');
            $table->string('mobile');
            $table->date('dateofbirth');
            $table->string('citizenship');
            $table->string('addressline1');
            $table->string('addressline2');
            $table->string('city');
            $table->string('region');
            $table->string('postcode');
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
        Schema::dropIfExists('customers');
    }
};
