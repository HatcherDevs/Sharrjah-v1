<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class DeployRefresh extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'deploy:refresh {--no-pull : Skip git pull}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Pull latest code from v10 branch and clear all caches';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('🚀 Starting deployment refresh...');
        $this->newLine();

        // Git pull (unless --no-pull flag is used)
        if (!$this->option('no-pull')) {
            $this->info('📥 Pulling latest code from v10...');
            $result = $this->runCommand('git pull origin v10');
            if ($result !== 0) {
                $this->error('❌ Git pull failed!');
                return 1;
            }
            $this->info('✅ Git pull completed');
            $this->newLine();
        }

        // Clear application cache
        $this->info('🧹 Clearing application cache...');
        $this->call('cache:clear');
        $this->info('✅ Application cache cleared');
        $this->newLine();

        // Clear config cache
        $this->info('🧹 Clearing config cache...');
        $this->call('config:clear');
        $this->info('✅ Config cache cleared');
        $this->newLine();

        // Clear route cache
        $this->info('🧹 Clearing route cache...');
        $this->call('route:clear');
        $this->info('✅ Route cache cleared');
        $this->newLine();

        // Clear view cache
        $this->info('🧹 Clearing view cache...');
        $this->call('view:clear');
        $this->info('✅ View cache cleared');
        $this->newLine();

        $this->info('🎉 Deployment refresh completed successfully!');

        return 0;
    }

    /**
     * Run a shell command and return the exit code.
     *
     * @param string $command
     * @return int
     */
    protected function runCommand(string $command): int
    {
        $process = Process::fromShellCommandline($command, base_path());
        $process->setTimeout(300);
        
        $process->run(function ($type, $buffer) {
            $this->output->write($buffer);
        });

        return $process->getExitCode();
    }
}