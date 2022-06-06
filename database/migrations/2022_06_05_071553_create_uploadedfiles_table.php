<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUploadedfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('uploadedfiles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->unsignedBigInteger('admin_id');
            $table->foreign('admin_id')->references('id')->on('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('file_name', '255')->nullable();
            $table->string('file_path', '255');
            $table->timestamps();
        });
    }

    /**
     * Reverse   the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('uploadedfiles');
    }
}
