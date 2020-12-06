<?php

namespace App\Console\Commands\Helpers;

use Illuminate\Console\Command;
use Illuminate\Console\Application;
use Symfony\Component\Console\Output\OutputInterface;

class CommandExecutor implements CommandExecutorInterface
{
    /**
     * @var Command
     */
    protected $command;

    /**
     * Create a new CommandExecutor.
     *
     * @param Command $command base
     */
    public function __construct(Command $command)
    {
        $this->command = $command;
    }

    /**
     * @codeCoverageIgnore
     */
    public function exec($message, $command)
    {
        $this->command->info($message);
        $this->command->line($command, null, OutputInterface::VERBOSITY_VERBOSE);
        exec($command.' 2>&1', $output);
        foreach ($output as $line) {
            $this->command->line($line, null, OutputInterface::VERBOSITY_VERY_VERBOSE);
        }
        $this->command->line('', null, OutputInterface::VERBOSITY_VERBOSE);
    }

    /**
     * @codeCoverageIgnore
     */
    public function artisan($message, $command, array $arguments = [])
    {
        $info = '';
        foreach ($arguments as $key => $value) {
            if (is_string($key)) {
                $info .= ' '.$key.'="'.$value.'"';
            } else {
                $info .= ' '.$value;
            }
        }
        $this->exec($message, Application::formatCommandString($command.$info));
    }
}
