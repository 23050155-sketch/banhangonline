<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();                 // mã: SALE10
            $table->string('name')->nullable();               // tên hiển thị
            $table->enum('type', ['fixed','percent']);        // giảm tiền / giảm %
            $table->unsignedInteger('value');                 // fixed: 50000 | percent: 10
            $table->unsignedInteger('min_order_total')->default(0);
            $table->unsignedInteger('max_discount')->nullable(); // nếu percent thì chặn trần
            $table->unsignedInteger('usage_limit')->nullable();  // số lần dùng tối đa
            $table->unsignedInteger('used_count')->default(0);
            $table->tinyInteger('status')->default(1);        // 1=active
            $table->timestamp('starts_at')->nullable();
            $table->timestamp('ends_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
