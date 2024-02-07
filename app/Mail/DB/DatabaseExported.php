<?php
namespace App\Mail\DB;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
class DatabaseExported extends Mailable {
    use Queueable, SerializesModels;
    public $zipFilePath;
    public function __construct($zipFilePath) {
        $this->zipFilePath = $zipFilePath;
    }

    public function build() {
        $filename = basename($this->zipFilePath);
        $filePath = storage_path("app/backups/{$filename}");
        $downloadLink = asset("storage/app/backups/{$filename}");
        return $this->subject('Database Export')->view('mail.DB.export')
            ->attach($this->zipFilePath, [
                'as' => $filename,
                'mime' => 'application/zip',
            ])
            ->with([
                'filename' => $filename,
                'downloadLink' => route('download', ['filename' => $filename]),
            ]);
    }    
}
