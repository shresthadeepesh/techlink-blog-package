<?php


namespace Techlink\Blog\Tests\Unit;


use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Techlink\Blog\Tests\TestCase;

class BlogCommandTest extends TestCase
{
    /**
     * @test
     */
    public function test_install_command_copies_the_configuration()
    {
        if(File::exists(config_path('blog.php'))) {
            unlink(config_path('blog.php'));
        }

        $this->assertFalse(File::exists(config_path('blog.php')));

        Artisan::call('blog:setup');

        $this->assertTrue(File::exists(config_path('blog.php')));
    }

    /**
     * @test
     */
    public function test_install_command_runs_the_migrations()
    {
        $this->artisan('blog:setup')
            ->expectsConfirmation('Do you want to run DB migrations?', 'yes')
            ->expectsConfirmation('Do you want to run DB seeders?', 'no')
            ->expectsOutput('All done. Enjoy!')
            ->assertExitCode(0);

        $this->assertDatabaseCount('posts', 0);
        $this->assertDatabaseCount('categories', 0);
    }

    /**
     * @test
     */
    public function test_install_command_runs_the_seeders()
    {
        $this->artisan('blog:setup')
            ->expectsConfirmation('Do you want to run DB migrations?', 'yes')
            ->expectsConfirmation('Do you want to run DB seeders?', 'yes')
            ->expectsOutput('All done. Enjoy!')
            ->assertExitCode(0);

        $this->assertDatabaseCount('posts', 10);
        $this->assertDatabaseCount('categories', 10);
    }
}