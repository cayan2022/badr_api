<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBranchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('branches', function (Blueprint $table) {
            $table->id();
            $table->string('telephone');
            $table->string('whatsapp');
            $table->string('map');
            $table->boolean('is_block')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('branch_translations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('city');
            $table->longText('address');
            $table->longText('full_description');
            $table->string('locale')->index();
            $table->foreignId('branch_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->unique(['branch_id', 'locale']);
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
        Schema::dropIfExists('branches');
        Schema::dropIfExists('branch_translations');
    }
}
