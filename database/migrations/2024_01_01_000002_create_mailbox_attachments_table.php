<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mailbox_attachments', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('email_id')->constrained('mailbox_emails')->cascadeOnDelete();
            $table->string('filename');
            $table->string('content_type');
            $table->unsignedBigInteger('size');
            $table->string('content_id')->nullable();
            $table->string('uri');
            $table->json('data')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mailbox_attachments');
    }
};
