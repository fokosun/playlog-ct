<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::create('comments', function (Blueprint $table) {
			$table->increments('id');
			$table->string('content')->nullable();
			$table->string('photo_url')->nullable();
			$table->integer('author_id')->unsigned();
			$table->timestamps();
		});

		Schema::table(
			'comments', function ($table) {
			$table
				->foreign('author_id')
				->references('id')
				->on('users')
				->onDelete('cascade');
			}
		);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
		Schema::dropIfExists('comments');
    }
}
