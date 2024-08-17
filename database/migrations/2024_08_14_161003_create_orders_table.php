<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('folder_name');
            $table->integer('added_by');
            $table->integer('last_updated_by')->nullable();
            $table->integer('simple_clipping')->nullable();
            $table->integer('in_clip_2_in_1')->nullable();
            $table->integer('in_clip_3_in_1')->nullable();
            $table->integer('layer_masking')->nullable();
            $table->integer('retouch')->nullable();
            $table->integer('nechjoin')->nullable();
            $table->integer('recolor')->nullable();
            $table->integer('neek_joint_wit_lequefy')->nullable();
            $table->integer('clipping_with_liquefy')->nullable();
            $table->integer('vector_graphics')->nullable();
            $table->integer('complex_multi_path')->nullable();
            $table->integer('total_file')->nullable();
            $table->integer('status')->default(0);
            $table->timestamp('deadline');
            $table->text('comment')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
