<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_block')->default(false);
            $table->timestamps();
        });
        Schema::create('project_translations', function (Blueprint $table) {
            $table->id();
            $table->string('locale')->index();
            $table->string('name');
            $table->string('classification');
            $table->text('short_description');
            $table->longText('full_description');
            $table->foreignId('project_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->unique(['project_id', 'locale']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('projects');
        Schema::dropIfExists('project_translations');
    }
}
