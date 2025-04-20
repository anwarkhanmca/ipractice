<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecipientsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('recipients', function(Blueprint $table)
		{
			$table->bigIncrements('id');
			$table->integer('doc_id');
			$table->string('name');
			$table->string('email');
			$table->string('passcode');
			$table->string('url_key');
			$table->boolean('status')->default(0);
			$table->timestamp('sent_on');
			$table->timestamp('signed_on')->nullable();
			$table->string('sign_image')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('recipients');
	}

}
