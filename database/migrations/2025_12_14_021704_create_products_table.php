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
            $table->id();

            $table->foreignId('category_id')
                ->constrained('categories')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->string('name');
            $table->string('slug')->unique();

            $table->unsignedInteger('price');
            $table->unsignedInteger('compare_price')->nullable(); // giá gốc nếu muốn hiển thị giảm giá

            $table->text('description')->nullable();
            $table->string('image')->nullable();

            $table->unsignedInteger('stock')->default(0);
            $table->boolean('status')->default(true);      // 1 bán, 0 ẩn
            $table->boolean('is_featured')->default(false); // nổi bật

            $table->timestamps();

            $table->index(['category_id', 'price']);
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
