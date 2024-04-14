<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePortfolioCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('portfolio_categories', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_block')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('p_c_translations', function (Blueprint $table) {
            $table->id();
            $table->string('locale')->index();
            $table->bigInteger('p_c_id')->unsigned();
            $table->string('name');
            $table->longText('description')->nullable();

            $table->unique(['p_c_id', 'locale']);
            $table->foreign('p_c_id')->references('id')->on('portfolio_categories')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('portfolio_categories');
        Schema::dropIfExists('portfolio_category_translations');
    }
}