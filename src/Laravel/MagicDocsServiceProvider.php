<?php

namespace MagicDocs\Laravel;

use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;
use MagicDocs\Documentor;
use Illuminate\Foundation\Console\AboutCommand;
use MagicDocs\Laravel\Commands\Clear;
use MagicDocs\Laravel\Commands\Generate;
use MagicDocs\Laravel\Commands\Watch;

class MagicDocsServiceProvider extends ServiceProvider
{
    public const MAGICDOCS_VERSION = '0.1.0';

    public function register()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                Generate::class,
                Clear::class,
                Watch::class,
            ]);
        }

        $this->app['events']->listen('cache:cleared', function () {
            if ($this->app->runningInConsole()) {
                [$class, $message] = Clear::runDelete();

                $output = new \Symfony\Component\Console\Output\ConsoleOutput();
                $output->writeln("<fg={$class}>{$message}</>");
            }
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/../../config/docwatch.php' => config_path('docwatch.php'),
        ], 'docwatch');

        AboutCommand::add('Magic Docs', fn () => [
            'Magic Docs Version' => static::MAGICDOCS_VERSION,
            'Has Generated?' => ($exists = file_exists($file = Documentor::getOutputFile())) ? '<fg=green;>YES</>' : '<fg=bright-yellow>NO</>',
            'Output File' => $file,
            'Last Updated At' => ($exists)
                ? Carbon::parse(filemtime($file))->setTimezone('Australia/Perth')->format('d M Y @ h:ia')
                : '--',
        ]);
    }
}