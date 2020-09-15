<?php

namespace SchantlDev\GitWebhook\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Process\Process;

class DefaultGithubDeploy extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'github:deploy';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Pull changes from git and deploy.';


    public function handle()
    {
        $process = new Process([storage_path('/git-webhook/git_deploy.sh')], base_path());
        $process->run();

        Log::info('====================== DEPLOY ======================');
        Log::info($process->getOutput());
        Log::info('===================== END DEPLOY =====================');
    }
}
