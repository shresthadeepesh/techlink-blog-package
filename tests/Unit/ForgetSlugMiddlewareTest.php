<?php


namespace Techlink\Blog\Tests\Unit;

use Illuminate\Http\Request;
use Techlink\Blog\Http\Middleware\ForgetSlugMiddleware;
use Techlink\Blog\Tests\TestCase;

class ForgetSlugMiddlewareTest extends TestCase
{
    /**
     * @test
     */
    public function test_it_forgets_the_slug_param_in_the_url()
    {
        $request = new Request;

        $request->merge([
           'slug' => 'this-is-the-title'
        ]);

        $middleware = new ForgetSlugMiddleware();

        $middleware->handle($request, function($req) {
           $this->assertEquals('', $req->route('slug'));
        });
    }
}