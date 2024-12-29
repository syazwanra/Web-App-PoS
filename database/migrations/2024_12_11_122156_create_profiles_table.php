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
        Schema::create('profile', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->string("image_url")->nullable();
            $table->text("gender");
            $table->string("fullname", 255);
            $table->uuid("user_id");
            $table->uuid("outlet_id");
            
            $table->foreign("user_id")->references("id")->on("users");
            $table->foreign("outlet_id")->references("id")->on("outlets");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
