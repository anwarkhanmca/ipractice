<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnRecepTypeToDocs extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('docs', function(Blueprint $table)
		{
			$table->integer('recep_type')->default(1);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('docs', function(Blueprint $table)
		{
			$table->dropColumn('recep_type');
		});
	}

}
