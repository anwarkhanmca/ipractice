<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDocId extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('recipients', function(Blueprint $table)
		{
			$table->integer('doc_id')->after('id');
		});

		Schema::table('docs', function(Blueprint $table)
		{
			$table->dropColumn('doc_id');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('recipients', function(Blueprint $table)
		{
			//
		});
	}

}
