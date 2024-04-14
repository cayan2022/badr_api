<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAboutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('abouts', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_block')->default(false);
            $table->timestamps();
        });
        Schema::create('about_translations', function (Blueprint $table) {
            $table->id();
            $table->text('title');
            $table->longText('description');
            $table->string('locale')->index();
            $table->foreignId('about_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->unique(['about_id', 'locale']);
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
        Schema::dropIfExists('abouts');
        Schema::dropIfExists('about_translations');
    }
}
