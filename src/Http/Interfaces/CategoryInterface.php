<?php


namespace Techlink\Blog\Http\Interfaces;


use Techlink\Blog\Http\Requests\CategoryRequest;
use Techlink\Blog\Models\Category;

interface CategoryInterface
{
    public function index();
    public function create(Category $category);
    public function edit(Category $category);
    public function store(CategoryRequest $request);
    public function update(CategoryRequest $request, Category $category);
    public function destroy(Category $category);
}