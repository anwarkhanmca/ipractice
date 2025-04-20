<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSignPlaceColumnAdd extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('recipients', function(Blueprint $table)
		{
			$table->binary('sign_image')->nullable();
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
			$table->dropColumn('sign_image');
		});
	}

}
