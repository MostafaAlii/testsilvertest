<?php
namespace App\Console\Commands\DB;
use Illuminate\Console\Command;
use Symfony\Component\Process\Process;
use ZipArchive;
use App\Mail\DB\DatabaseExported;
use Illuminate\Support\Facades\{File, Mail};
class DBExportCommand extends Command {
    protected $signature = 'app:db-export';
    protected $description = 'Exporting Database';
    public function handle() {
        $databaseName = config('database.connections.mysql.database');
        $username = config('database.connections.mysql.username');
        $backupPath = storage_path('app/backups');
        if (!file_exists($backupPath)) {
            mkdir($backupPath, 0755, true);
        }
        $timestamp = now()->format('Ymd_His');
        $backupFile = "{$backupPath}/backup_{$databaseName}_{$timestamp}.sql";
        $zipFilePath = "{$backupPath}/backup_{$databaseName}_{$timestamp}.zip";
        $envPassword = env('DB_PASSWORD');
        $mysqldumpCommand = [
            'mysqldump',
            '-u' . $username,
            '--password=' . $envPassword,
            $databaseName,
        ];
        $mysqldumpCommandString = implode(' ', $mysqldumpCommand) . ' > ' . escapeshellarg($backupFile);
        $mysqldumpProcess = Process::fromShellCommandline($mysqldumpCommandString);
        $mysqldumpProcess->run();
        if (!$mysqldumpProcess->isSuccessful()) {
            $this->error('Failed to export the database. ' . $mysqldumpProcess->getErrorOutput());
            return;
        }
        $this->compressAndSendBackup($backupFile, $zipFilePath);
        $this->info('Database exported, compressed, and email sent successfully.');
        File::delete($zipFilePath);
        $this->info('Backup folder deleted.');
    }

    private function compressAndSendBackup($backupFile, $zipFilePath) {
        $zip = new ZipArchive();
        $zip->open($zipFilePath, ZipArchive::CREATE);
        $zip->addFile($backupFile, basename($backupFile));
        $zip->close();
        unlink($backupFile);
        Mail::to('backup@tripu.net')->send(new DatabaseExported($zipFilePath));
    }
}
