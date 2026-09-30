<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Services\CategoryService;

class CategoryController extends Controller
{
    public function __construct(private CategoryService $categories) {}

    public function index()
    {
        $categories = Category::withCount('activities')->ordered()->get();

        return view('categories.index', compact('categories'));
    }

    public function destroy(Category $category)
    {
        $this->categories->delete($category);

        return redirect()->route('categories.index')
            ->with('success', "Kategori '{$category->name}' berhasil dihapus.");
    }
}