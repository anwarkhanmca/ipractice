<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropAddColumns extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('docs', function (Blueprint $table) {
	        //$table->dropTimestamps();
	        $table->dropColumn(['title', 'file', 'recep_count', 'signed_count', 'signed_file', 'status', 'deleted_on', 'recep_type']);
	    });

	    Schema::table('docs', function (Blueprint $table) {
	        $table->integer('request_id');
	        $table->string('file_name');
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
			//
		});
	}

}
