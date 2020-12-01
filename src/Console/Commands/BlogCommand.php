<?php

namespace Techlink\Blog\Console\Commands;

use Illuminate\Console\Command;
use Techlink\Blog\Database\Seeders\BlogSeeder;

class BlogCommand extends Command
{
    protected $hidden = false;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'blog:setup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Setting up the techlink blog.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Installing Techlink Blog....');
        $this->info('Publishing configuration....');

        $this->call('vendor:publish', [
            '--provider' => "Techlink\Blog\Providers\BlogProvider",
            '--tag' => 'config'
        ]);

        $this->runMigrations();
        $this->runSeeders();

        $this->info('All done. Enjoy!');
    }

    /**
     * Running all the migrations
     */
    private function runMigrations()
    {
        if($this->confirm('Do you want to run DB migrations?')) {
            $this->call('migrate');
        }
    }

    /**
     * Running db seeders of the package
     */
    private function runSeeders()
    {
        if($this->confirm('Do you want to run DB seeders?')) {
            $this->call('db:seed', [
                '--class' => BlogSeeder::class
            ]);
        }
    }
}