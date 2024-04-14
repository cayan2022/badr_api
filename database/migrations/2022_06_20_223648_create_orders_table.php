<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('category_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();

            $table->foreignId('source_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();

            $table->foreignId('status_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('branch_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();

            $table->timestamps();
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
        Schema::dropIfExists('orders');
    }
}
