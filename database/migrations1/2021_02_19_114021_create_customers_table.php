<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name',50);
            $table->string('email')->unique();
            $table->string('email_verification_code')->nullable();
            $table->string('password');
            $table->string('phone')->nullable();
            $table->string('mobile');
            $table->unsignedBigInteger('gender_id');
            $table->string('temp_address')->nullable();
            $table->string('perm_address');
            $table->timestamp('dob');
            $table->string('photo')->nullable();
            $table->boolean('status')->default(0);
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('gender_id')->references('id')->on('genders');
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
}
