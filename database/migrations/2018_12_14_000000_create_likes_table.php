<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

final class CreateLikesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(config('like.likes_table'), function (Blueprint $table): void {
            $table->bigIncrements('id');
            $table->unsignedBigInteger(config('like.user_foreign_key'))->index()->comment('user_id');
            $table->morphs('likeable');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(config('like.likes_table'));
    }
}
