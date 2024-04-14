<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTidingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tidings', function (Blueprint $table) {
            $table->id();
            $table->string('link');
            $table->date('date');
            $table->boolean('is_block')->default(false);
            $table->timestamps();
        });

        Schema::create('tiding_translations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('short_description');
            $table->longText('description');
            $table->string('locale')->index();
            $table->unique(['tiding_id', 'locale']);
            $table->foreignId('tiding_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
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
        Schema::dropIfExists('tidings');
        Schema::dropIfExists('tiding_translations');
    }
}
