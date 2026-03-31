<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('diagnosis_results', function (Blueprint $table) {
            $table->id();
            $table->string('gender', 10);       // male / female
            $table->json('answers');              // 回答データ
            $table->boolean('is_extended')        // 追加問を含むか
                  ->default(false);
            $table->integer('hensachi');           // 偏差値
            $table->boolean('is_high_score')      // 55以上か
                  ->default(false);
            $table->timestamps();

            $table->index('gender');
            $table->index('hensachi');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('diagnosis_results');
    }
};
