<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePortfoliosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('portfolios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('portfolio_category_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('url')->nullable();
            $table->boolean('is_block')->default(false);
            $table->timestamps();
        });

        Schema::create('portfolio_translations', function (Blueprint $table) {
            $table->id();
            $table->string('locale')->index();
            $table->foreignId('portfolio_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('name');
            $table->text('short_description');
            $table->longText('full_description');

            $table->unique(['portfolio_id', 'locale']);
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
        Schema::dropIfExists('portfolios');
        Schema::dropIfExists('portfolio_translations');
    }
}