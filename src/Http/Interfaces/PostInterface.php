<?php


namespace Techlink\Blog\Http\Interfaces;

use Techlink\Blog\Http\Requests\PostRequest;
use Techlink\Blog\Models\Post;

interface PostInterface
{
    public function index();
    public function create(Post $post);
    public function edit(Post $post);
    public function store(PostRequest $request);
    public function update(PostRequest $request, Post $post);
    public function destroy(Post $post);
}