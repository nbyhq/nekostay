<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('medical_records', function (Blueprint $table) {

            $table->id();

            $table->foreignId('cat_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->date('visit_date');

            $table->string('doctor');

            $table->text('diagnosis');

            $table->text('treatment')->nullable();

            $table->text('notes')->nullable();

            $table->decimal('weight',5,2)->nullable();

            $table->decimal('temperature',4,1)->nullable();

            $table->enum('status',[
                'Healthy',
                'Treatment',
                'Recovery'
            ]);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('medical_records');
    }
};
