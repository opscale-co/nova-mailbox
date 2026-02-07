<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mailbox_emails', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('message_id')->unique();
            $table->string('in_reply_to')->nullable();
            $table->string('from')->index();
            $table->json('to')->index();
            $table->json('cc')->nullable();
            $table->json('bcc')->nullable();
            $table->json('reply_to')->nullable();
            $table->string('subject')->nullable();
            $table->timestamp('date')->nullable()->index();
            $table->string('uri');
            $table->json('data')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mailbox_emails');
    }
};
