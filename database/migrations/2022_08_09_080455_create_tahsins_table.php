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
        Schema::create('tahsins', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->integer('teacher_id')->nullable();
            $table->integer('student_id');
            $table->string('jilid')->nullable();
            $table->string('halaman')->nullable();
            $table->string('murajaah')->nullable();
            $table->string('ziyadah')->nullable();
            $table->string('nilai')->nullable();
            $table->text('ket')->nullable();
            $table->boolean('is_deleted')->default(false);
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
        Schema::dropIfExists('tahsins');
    }
};
