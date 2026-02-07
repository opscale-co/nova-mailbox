<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Opscale\NovaMailbox\Models\Enums\ExtractionStatus;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mailbox_extractions', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('email_id')->constrained('mailbox_emails')->cascadeOnDelete();
            $table->foreignUlid('template_id')->constrained('dynamic_resources_templates')->cascadeOnDelete();
            $table->enum('status', array_column(ExtractionStatus::cases(), 'value'))->default(ExtractionStatus::Pending->value);
            $table->text('message')->nullable();
            $table->json('data')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mailbox_extractions');
    }
};
