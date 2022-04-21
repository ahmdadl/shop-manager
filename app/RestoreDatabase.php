<?php

namespace App;

use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class RestoreDatabase
{
    /**
     * @var Process
     */
    protected $process;

    /**
     *
     * @return void
     */
    public function __construct(protected string $path)
    {
    }

    /**
     * handle db restoring
     *
     * @return mixed
     */
    public function handle(): bool
    {
        $this->process = Process::fromShellCommandline(
            sprintf(
                "mysql --user=%s --password=%s --port=%s %s < %s",
                config("database.connections.mysql.username"),
                config("database.connections.mysql.password"),
                config("database.connections.mysql.port"),
                '"${:DB_NAME}"',
                $this->path
            )
        );

        $done = true;

        try {
            $this->process->mustRun(null, [
                "DB_NAME" => config("database.connections.mysql.database"),
            ]);
        } catch (ProcessFailedException $exception) {
            logger()->error("restore exception", compact("exception"));

            $done = false;
        }

        return $done;
    }
}
