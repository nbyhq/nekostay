<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('medical_records', function (Blueprint $table) {

            $table->date('next_visit_date')->nullable()->after('visit_date');

            $table->string('next_visit_note')->nullable()->after('next_visit_date');

        });
    }

    public function down(): void
    {
        Schema::table('medical_records', function (Blueprint $table) {

            $table->dropColumn([
                'next_visit_date',
                'next_visit_note'
            ]);

        });
    }
};
