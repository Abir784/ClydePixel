<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('order_fields', function (Blueprint $table) {
            $table->id();
            $table->string('label');
            $table->string('field_key')->unique();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_required')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        $now = now();
        $defaults = [
            ['Simple Clipping', 'simple_clipping'],
            ['In Clip 2 In 1', 'in_clip_2_in_1'],
            ['In Clip 3 In 1', 'in_clip_3_in_1'],
            ['Layer Masking', 'layer_masking'],
            ['Retouch', 'retouch'],
            ['Neckjoin', 'neckjoin'],
            ['Recolor', 'recolor'],
            ['Neek Joint With Lequefy', 'neek_joint_wit_lequefy'],
            ['Clipping With Liquefy', 'clipping_with_liquefy'],
            ['Vector Graphics', 'vector_graphics'],
            ['Complex Multi Path', 'complex_multi_path'],
        ];

        foreach ($defaults as $index => [$label, $fieldKey]) {
            DB::table('order_fields')->insert([
                'label' => $label,
                'field_key' => $fieldKey,
                'sort_order' => $index,
                'is_required' => false,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_fields');
    }
};
