<?php

/*use Illuminate\Support\Facades\Route;
Route::middleware('web')->get('/download/{filename}', function ($filename) {
    $filePath = storage_path("app/backups/{$filename}");
    if (file_exists($filePath)) {
        return response()->download($filePath, $filename);
    }
    abort(404, 'File not found');
})->name('download');*/