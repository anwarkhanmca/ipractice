<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('docs', function(Blueprint $table)
		{
			$table->bigIncrements('id');
			$table->string('title');
			$table->string('file');
			$table->unsignedInteger('created_by');
			$table->timestamp('created_on');
			$table->integer('recep_count')->default(0);
			$table->integer('signed_count')->default(0);
			$table->string('signed_file')->nullable();
			$table->integer('status')->default(0);
			$table->timestamp('deleted_on')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('docs');
	}

}
