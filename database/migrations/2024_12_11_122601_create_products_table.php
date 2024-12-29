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
        Schema::create('products', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->string("name", 255);
            $table->text("description");
            $table->string("price", 255);
            $table->uuid("outlet_id");
            $table->uuid("product_category_id");
            
            $table->foreign("outlet_id")->references("id")->on("outlets");
            $table->foreign("product_category_id")->references("id")->on("product_category");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
