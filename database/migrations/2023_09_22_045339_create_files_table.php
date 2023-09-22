<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFilesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('files', function (Blueprint $table) {
      $table->id('file_id');
      $table->string('operation_name', 50);
      $table->unsignedBigInteger('table_id')->comment('id of operations table');
      $table->string('filepath', 150);
      $table->string('filename', 100);
      $table->unsignedBigInteger('created_by');
      $table->unsignedBigInteger('deleted_by')->nullable();
      $table->softDeletes();
      $table->timestamps();

      $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
      $table->foreign('deleted_by')->references('id')->on('users')->onDelete('cascade');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('files');
  }
}
