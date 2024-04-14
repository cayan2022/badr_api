<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->double('price');
            $table->double('discount_percentage');
            $table->longText('url');
            $table->boolean('is_block')->default(false);
            $table->timestamps();
        });

        Schema::create('offer_translations', function(Blueprint $table) {
            $table->increments('id');
            $table->string('locale')->index();
            $table->string('name');
            $table->longText('description');
            $table->foreignId('offer_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->unique(['offer_id', 'locale']);
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
        Schema::dropIfExists('offers');
        Schema::dropIfExists('offer_translations');
    }
}
