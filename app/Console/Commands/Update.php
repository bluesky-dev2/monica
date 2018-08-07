<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Console\ConfirmableTrait;
use App\Console\Commands\Helpers\CommandExecutor;
use App\Console\Commands\Helpers\CommandExecutorInterface;

class Update extends Command
{
    use ConfirmableTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'monica:update {--force} {--composer-install} {--dev}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update monica dependencies and migrations after a new release';

    /**
     * The Command Executor.
     *
     * @var CommandExecutorInterface
     */
    public $commandExecutor;

    /**
     * Create a new command.
     *
     * @param CommandExecutorInterface
     */
    public function __construct()
    {
        $this->commandExecutor = new CommandExecutor($this);
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if ($this->confirmToProceed()) {
            try {
                $this->commandExecutor->artisan('✓ Maintenance mode: on', 'down', [
                    '--message' => 'Upgrading Monica v'.config('monica.app_version'),
                    '--retry' => '10',
                    ]);

                // Clear or rebuild all cache
                if (config('cache.default') != 'database' || Schema::hasTable('cache')) {
                    $this->commandExecutor->artisan('✓ Resetting application cache', 'cache:clear');
                }

                if ($this->getLaravel()->environment() == 'production') {
                    $this->commandExecutor->artisan('✓ Resetting route cache', 'route:cache');
                    if ($this->getLaravel()->version() > '5.6') {
                        $this->commandExecutor->artisan('✓ Resetting view cache', 'view:cache');
                    } else {
                        $this->commandExecutor->artisan('✓ Resetting view cache', 'view:clear');
                    }
                } else {
                    $this->commandExecutor->artisan('✓ Clear config cache', 'config:clear');
                    $this->commandExecutor->artisan('✓ Clear route cache', 'route:clear');
                    $this->commandExecutor->artisan('✓ Clear view cache', 'view:clear');
                }

                if ($this->option('composer-install') === true) {
                    $this->commandExecutor->exec('✓ Updating composer dependencies', 'composer install --no-interaction --no-suggest --ignore-platform-reqs'.($this->option('dev') === false ? '--no-dev' : ''));
                }

                if ($this->getLaravel()->environment() != 'testing' && ! file_exists(public_path('storage'))) {
                    $this->commandExecutor->artisan('✓ Symlink the storage folder', 'storage:link');
                }

                if ($this->migrateCollationTest()) {
                    $this->commandExecutor->artisan('✓ Performing collation migrations', 'migrate:collation', ['--force' => 'true']);
                }

                $this->commandExecutor->artisan('✓ Performing migrations', 'migrate', ['--force' => 'true']);

                $this->commandExecutor->artisan('✓ Ping for new version', 'monica:ping', ['--force' => 'true']);
            } finally {
                $this->commandExecutor->artisan('✓ Maintenance mode: off', 'up');
            }

            $this->line('Monica v'.config('monica.app_version').' is set up, enjoy.');
        }
    }

    private function migrateCollationTest()
    {
        $connection = DB::connection();

        if ($connection->getDriverName() != 'mysql') {
            return false;
        }

        $databasename = $connection->getDatabaseName();

        $schemata = $connection->table('information_schema.schemata')
                ->select('DEFAULT_CHARACTER_SET_NAME')
                ->where('schema_name', '=', $databasename)
                ->get();

        $schema = $schemata->first()->DEFAULT_CHARACTER_SET_NAME;

        return config('database.use_utf8mb4') && $schema == 'utf8'
            || ! config('database.use_utf8mb4') && $schema == 'utf8mb4';
    }
}
