<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentReactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::create('comment_reactions', function (Blueprint $table) {
			$table->increments('id');
			$table->string('content')->nullable();
			$table->integer('author_id')->unsigned();
			$table->integer('comment_id')->unsigned();
			$table->timestamps();
		});

		Schema::table(
			'comment_reactions', function ($table) {
			$table
				->foreign('comment_id')
				->references('id')
				->on('comments')
				->onDelete('cascade');
			}
		);

		Schema::table(
			'comment_reactions', function ($table) {
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
		Schema::dropIfExists('comment_reactions');
    }
}
