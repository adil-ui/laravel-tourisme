<?php

use App\Models\City;
use App\Models\User;
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
        Schema::create('bookmarks', function (Blueprint $table) {
            $table->id();
            $table->string('name',50)->unique();
            $table->string('address',255)->nullable();
            $table->string('phone',10)->nullable();
            $table->string('description');
            $table->double('price')->nullable();
            $table->double('star')->nullable();
            $table->string('link')->nullable();
            $table->string('email',50)->unique()->nullable();
            $table->string('picture',255);
            $table->string('longitude',50)->nullable();
            $table->string('latitude',50)->nullable();
            $table->foreignIdFor(City::class)->nullable();
            $table->foreignIdFor(User::class);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookmarks');
    }
};
