<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequestsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('requests', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('title');
			$table->unsignedInteger('created_by');
			$table->timestamp('created_on');
			$table->integer('docs_count');
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
		Schema::drop('requests');
	}

}
