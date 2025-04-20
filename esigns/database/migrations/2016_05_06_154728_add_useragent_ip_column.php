<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUseragentIpColumn extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('recipients', function(Blueprint $table)
		{
			$table->string('user_agent')->nullable();
			$table->string('recip_ip')->nullable();
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
			$table->dropColumn('user_agent');
			$table->dropColumn('recip_ip');
		});
	}

}
