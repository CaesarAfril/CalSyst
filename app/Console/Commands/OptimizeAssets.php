<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class OptimizeAssets extends Command
{
    protected $signature = 'optimize:assets';

    public function handle()
    {
        $this->minifyCss();
        $this->minifyJs();
        $this->info('Assets optimized successfully!');
    }

    protected function minifyCss()
    {
        $cssFiles = glob(public_path('css/*.css'));

        foreach ($cssFiles as $file) {
            if (!str_contains($file, '.min.css')) {
                $process = new Process([
                    'npx',
                    'cleancss',
                    '-o',
                    str_replace('.css', '.min.css', $file),
                    $file
                ]);
                $process->run();
            }
        }
    }

    protected function minifyJs()
    {
        $jsFiles = glob(public_path('js/*.js'));

        foreach ($jsFiles as $file) {
            if (!str_contains($file, '.min.js')) {
                $process = new Process([
                    'npx',
                    'terser',
                    '-o',
                    str_replace('.js', '.min.js', $file),
                    '--compress',
                    '--mangle',
                    $file
                ]);
                $process->run();
            }
        }
    }
}