<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDropdownValuesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('dropdown_values', function (Blueprint $table) {
      $table->id('dropdown_value_id');
      $table->string('value', 255);
      $table->string('text_value', 255);
      $table->enum('type', ['user_type', 'status', 'gender', 'marital_status']);
      $table->unsignedTinyInteger('status')->default(1)->comment('1=acitve, 2=inactive');
      $table->unsignedBigInteger('created_by')->default(1);
      $table->unsignedBigInteger('updated_by')->default(NULL)->nullable();
      $table->unsignedBigInteger('deleted_by')->default(NULL)->nullable();
      $table->softDeletes();
      $table->timestamps();

      $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
      $table->foreign('updated_by')->references('id')->on('users')->onDelete('cascade');
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
    Schema::dropIfExists('dropdown_values');
  }
}
