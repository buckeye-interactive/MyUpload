<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class AddMediaLibraryV9ColumnsToMediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('media', function (Blueprint $table) {
            $table->uuid('uuid')->nullable()->unique();
            $table->string('conversions_disk')->nullable();
            $table->json('generated_conversions')->nullable();
        });

        DB::table('media')->orderBy('id')->chunkById(100, function ($rows) {
            foreach ($rows as $row) {
                $customProperties = json_decode($row->custom_properties, true) ?? [];

                DB::table('media')->where('id', $row->id)->update([
                    'uuid' => (string) Str::uuid(),
                    'conversions_disk' => $row->disk,
                    'generated_conversions' => json_encode($customProperties['generated_conversions'] ?? []),
                ]);
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('media', function (Blueprint $table) {
            $table->dropColumn(['uuid', 'conversions_disk', 'generated_conversions']);
        });
    }
}
