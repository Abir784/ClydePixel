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
        $legacyColumns = [
            'simple_clipping',
            'in_clip_2_in_1',
            'in_clip_3_in_1',
            'layer_masking',
            'retouch',
            'nechjoin',
            'recolor',
            'neek_joint_wit_lequefy',
            'clipping_with_liquefy',
            'vector_graphics',
            'complex_multi_path',
        ];

        $orders = DB::table('orders')->select(array_merge(['id', 'dynamic_fields', 'total_file'], $legacyColumns))->get();

        foreach ($orders as $order) {
            $dynamicFields = [];

            if (! empty($order->dynamic_fields)) {
                $decoded = json_decode((string) $order->dynamic_fields, true);
                if (is_array($decoded)) {
                    $dynamicFields = $decoded;
                }
            }

            foreach ($legacyColumns as $column) {
                $value = $order->{$column};
                if ($value === null) {
                    continue;
                }

                $fieldKey = $column === 'nechjoin' ? 'neckjoin' : $column;
                if (! array_key_exists($fieldKey, $dynamicFields)) {
                    $dynamicFields[$fieldKey] = (int) $value;
                }
            }

            $totalFiles = 0;
            foreach ($dynamicFields as $value) {
                $totalFiles += (int) $value;
            }

            DB::table('orders')->where('id', $order->id)->update([
                'dynamic_fields' => ! empty($dynamicFields) ? json_encode($dynamicFields) : null,
                'total_file' => $totalFiles,
            ]);
        }

        Schema::table('orders', function (Blueprint $table) use ($legacyColumns) {
            foreach ($legacyColumns as $column) {
                if (Schema::hasColumn('orders', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $legacyColumns = [
            'simple_clipping',
            'in_clip_2_in_1',
            'in_clip_3_in_1',
            'layer_masking',
            'retouch',
            'nechjoin',
            'recolor',
            'neek_joint_wit_lequefy',
            'clipping_with_liquefy',
            'vector_graphics',
            'complex_multi_path',
        ];

        Schema::table('orders', function (Blueprint $table) use ($legacyColumns) {
            foreach ($legacyColumns as $column) {
                if (! Schema::hasColumn('orders', $column)) {
                    $table->integer($column)->nullable();
                }
            }
        });

        $orders = DB::table('orders')->select('id', 'dynamic_fields')->get();

        foreach ($orders as $order) {
            if (empty($order->dynamic_fields)) {
                continue;
            }

            $decoded = json_decode((string) $order->dynamic_fields, true);
            if (! is_array($decoded)) {
                continue;
            }

            $payload = [];
            foreach ($legacyColumns as $column) {
                $fieldKey = $column === 'nechjoin' ? 'neckjoin' : $column;
                $payload[$column] = isset($decoded[$fieldKey]) ? (int) $decoded[$fieldKey] : null;
            }

            DB::table('orders')->where('id', $order->id)->update($payload);
        }
    }
};
