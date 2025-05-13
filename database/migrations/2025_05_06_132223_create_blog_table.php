<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('blog', function (Blueprint $table) {
            $table->id()->comment('主鍵');
            $table->string('title')->comment('標題');
            $table->text('content')->comment('文章內容');

            // 預留欄位
            $table->unsignedBigInteger('author_id')->nullable()->comment('作者');
            $table->unsignedBigInteger('category_id')->nullable()->comment('分類');
            $table->json('tags')->nullable()->comment('標籤（可儲存陣列）');
            $table->timestampsTz(); // created_at 與 updated_at，含時區

        });

        // 資料表備註
        DB::statement("ALTER TABLE `blog` COMMENT = '部落格文章表';");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blog');
    }
};
