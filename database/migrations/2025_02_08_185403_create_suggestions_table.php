<?php

use App\Models\Region;
use App\Models\Suggestion;
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
        Schema::create('suggestions', function (Blueprint $table) {
            $table->id();
            $table->string('status');
            $table->string('word');
            $table->string('description');
            $table->text('example');
            $table->text('characteristics');
            $table->timestamps();
        });

        Schema::create('region_suggestion', function (Blueprint $table): void {
            $table->foreignIdFor(Suggestion::class)->references('id')->on('suggestions')->onDelete('CASCADE');
            $table->foreignIdFor(Region::class)->references('id')->on('regions')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('region_suggestion');
        Schema::dropIfExists('suggestions');
    }
};
