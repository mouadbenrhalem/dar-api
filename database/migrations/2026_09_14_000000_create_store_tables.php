<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('customers', function (Blueprint $table) { $table->id(); $table->string('name'); $table->string('phone')->unique(); $table->string('email')->nullable(); $table->string('address'); $table->timestamps(); });
        Schema::create('products', function (Blueprint $table) { $table->id(); $table->string('name'); $table->string('category')->nullable(); $table->decimal('price', 10, 2); $table->string('image_path')->nullable(); $table->text('description')->nullable(); $table->boolean('is_available')->default(true); $table->unsignedInteger('stock')->nullable(); $table->timestamps(); });
        Schema::create('orders', function (Blueprint $table) { $table->id(); $table->string('order_number')->unique(); $table->foreignId('customer_id')->constrained()->cascadeOnDelete(); $table->enum('status', ['pending','confirmed','preparing','out_for_delivery','completed','cancelled'])->default('pending'); $table->decimal('subtotal', 10, 2); $table->decimal('total', 10, 2); $table->timestamps(); });
        Schema::create('order_items', function (Blueprint $table) { $table->id(); $table->foreignId('order_id')->constrained()->cascadeOnDelete(); $table->foreignId('product_id')->nullable()->constrained()->nullOnDelete(); $table->string('product_name'); $table->unsignedInteger('quantity'); $table->decimal('unit_price', 10, 2); $table->decimal('subtotal', 10, 2); $table->timestamps(); });
        Schema::create('admin_activities', function (Blueprint $table) { $table->id(); $table->string('action'); $table->string('admin_name')->default('Admin'); $table->string('subject_type')->nullable(); $table->unsignedBigInteger('subject_id')->nullable(); $table->string('description'); $table->timestamps(); });
    }
    public function down() { Schema::dropIfExists('admin_activities'); Schema::dropIfExists('order_items'); Schema::dropIfExists('orders'); Schema::dropIfExists('products'); Schema::dropIfExists('customers'); }
};
