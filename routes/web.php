<?php

use Illuminate\Support\Facades\Route;
use Opscale\NovaMailbox\Http\Controllers\DownloadController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you may register web routes for your package.
|
*/

Route::get('mailbox/emails/{id}', [DownloadController::class, 'downloadEmail'])->name('mailbox.emails.download')->middleware('nova');
Route::get('mailbox/attachments/{id}', [DownloadController::class, 'downloadAttachment'])->name('mailbox.attachments.download')->middleware('nova');
