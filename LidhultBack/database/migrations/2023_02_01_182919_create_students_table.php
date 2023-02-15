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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('surnames');
            $table->string('email')->unique();
            $table->string('nick')->unique();
            $table->string('password');
            $table->foreignId('character_id')
                ->nullable()
                ->constrained('images')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->string('avatar')->default('/images/user_placeholder.png');
            $table->string('birth_date');
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
        Schema::dropIfExists('students');
    }
};
