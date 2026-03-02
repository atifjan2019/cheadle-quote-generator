<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('quotes', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('project_ref', 100);
            $table->string('client_name', 255);
            $table->text('client_address')->nullable();
            $table->text('project_description')->nullable();
            $table->string('architect', 255)->default('Not yet appointed');
            $table->string('structural_engineer', 255)->default('Not yet appointed');
            $table->string('prepared_by', 255)->default('Joanne Fowler');
            $table->enum('status', ['draft', 'sent', 'accepted', 'declined'])->default('draft');
            $table->string('project_photo')->nullable();
            $table->timestamps();
        });

        Schema::create('revision_notes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quote_id')->constrained()->cascadeOnDelete();
            $table->text('note_text');
            $table->boolean('is_bold')->default(false);
            $table->integer('sort_order')->default(0);
        });

        Schema::create('scope_sections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quote_id')->constrained()->cascadeOnDelete();
            $table->string('section_name', 255);
            $table->text('section_description')->nullable();
            $table->boolean('is_heading')->default(false);
            $table->integer('sort_order')->default(0);
        });

        Schema::create('pricings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quote_id')->unique()->constrained()->cascadeOnDelete();
            $table->string('base_cost_label')->nullable();
            $table->decimal('base_cost', 12, 2)->nullable();
            $table->string('additional_cost_label')->nullable();
            $table->decimal('additional_cost', 12, 2)->nullable();
            $table->decimal('total_cost', 12, 2)->nullable();
            $table->string('total_cost_label')->nullable();
            $table->text('price_breakdown')->nullable();
            $table->text('notes')->nullable();
            $table->text('exclusions')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pricings');
        Schema::dropIfExists('scope_sections');
        Schema::dropIfExists('revision_notes');
        Schema::dropIfExists('quotes');
    }
};
