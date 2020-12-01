<?php

namespace Techlink\Blog\Tests;

use Orchestra\Testbench\TestCase as BaseTestCase;
use Techlink\Blog\Providers\BlogProvider;

class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        //creating the users
        User::factory(10)->create();
    }

    protected function getPackageProviders($app)
    {
        return [
          BlogProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
       //
    }
}