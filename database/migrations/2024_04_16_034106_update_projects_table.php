<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->string('developer_name')->nullable();
            $table->string('owner_name')->nullable();
            $table->string('area')->nullable();
            $table->string('building_area')->nullable();
            $table->string('buildings_number')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('projects', function (Blueprint $table) {
            // Dropping columns if the migration is rolled back
            $table->dropColumn('developer_name');
            $table->dropColumn('owner_name');
            $table->dropColumn('area');
            $table->dropColumn('building_area');
            $table->dropColumn('buildings_number');
        });
    }
}
