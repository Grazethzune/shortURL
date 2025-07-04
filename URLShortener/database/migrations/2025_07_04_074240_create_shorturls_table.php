<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('short_urls', function (Blueprint $table) {
            $table->id();
            $table->text('original_url');
            $table->string('short_code')->unique();
            $table->unsignedBigInteger('jumlah_akses')->default(0);
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('short_urls');
    }
};

