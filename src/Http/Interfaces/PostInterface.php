<?php


namespace Techlink\Blog\Http\Interfaces;


use Techlink\Blog\Models\Post;

interface AuthInterface
{
    public function index();
    public function create();
    public function edit();
    public function store();
    public function update();
    public function destroy(Post $post);
}