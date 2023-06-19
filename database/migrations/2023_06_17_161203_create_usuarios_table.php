<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {   
        //aqui estaremos criando nossa table usuarios...
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id();
            $table->string('name',60);
            $table->integer('idade');
            $table->integer('cep');
            $table->string('email',150);
            $table->string('phone');
            $table->date('dataAniversario');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};
