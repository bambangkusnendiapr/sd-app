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
            $table->integer('user_id')->nullable();
            $table->string('gambar')->nullable();
            $table->string('nis')->nullable();
            $table->string('nisn')->nullable();
            $table->string('nama');
            $table->string('tempat_lahir')->nullable();
            $table->date('tgl_lahir')->nullable();
            $table->string('jk')->nullable();
            $table->string('agama')->nullable();
            $table->string('sekolah_asal')->nullable();
            $table->text('alamat')->nullable();
            $table->string('nama_ayah')->nullable();
            $table->string('nama_ibu')->nullable();
            $table->string('kerja_ayah')->nullable();
            $table->string('kerja_ibu')->nullable();
            $table->text('jalan_ortu')->nullable();
            $table->text('kel_ortu')->nullable();
            $table->text('kec_ortu')->nullable();
            $table->string('kota_ortu')->nullable();
            $table->string('prov_ortu')->nullable();
            $table->string('hp_ortu')->nullable();
            $table->string('nama_wali')->nullable();
            $table->string('kerja_wali')->nullable();
            $table->string('agama_wali')->nullable();
            $table->text('alamat_wali')->nullable();
            $table->string('hp_wali')->nullable();
            $table->string('status')->default('AKTIF');
            $table->string('kelas')->nullable();
            $table->integer('class_id')->nullable();
            $table->integer('point')->default(0);
            $table->string('surat_awal')->nullable();
            $table->integer('surat_id')->nullable();
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
        Schema::dropIfExists('students');
    }
};
