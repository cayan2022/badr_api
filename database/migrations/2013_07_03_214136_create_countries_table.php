<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCountriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('countries', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('iso_code')->unique();
            $table->timestamps();
        });
        Schema::create('country_translations', function(Blueprint $table) {
            $table->increments('id');
            $table->string('locale')->index();
            $table->string('name');

            $table->foreignId('country_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->unique(['country_id', 'locale']);
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
        Schema::dropIfExists('countries');
        Schema::dropIfExists('country_translations');
    }
}
