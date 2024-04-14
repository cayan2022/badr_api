<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->longText('reference_link')->nullable();
            $table->date('date')->useCurrent();
            $table->boolean('is_block')->default(false);
            $table->timestamps();
        });

        Schema::create('blog_translations', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('short_description');
            $table->longText('long_description');
            $table->string('locale')->index();
            $table->foreignId('blog_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->unique(['blog_id', 'locale']);
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
        Schema::dropIfExists('blogs');
        Schema::dropIfExists('blog_translations');
    }
}
