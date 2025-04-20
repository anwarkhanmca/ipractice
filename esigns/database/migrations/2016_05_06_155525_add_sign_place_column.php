<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSignPlaceColumn extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('recipients', function(Blueprint $table)
		{
			$table->string('place_holder')->nullable();
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
			$table->dropColumn('place_holder');
		});
	}

}
