<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Validation\ValidationException;

class CategoryService
{
    public function delete(Category $category): void
    {
        if ($category->activities()->exists()) {
            throw ValidationException::withMessages([
                'category' => "Kategori '{$category->name}' masih dipakai oleh kegiatan dan tidak dapat dihapus.",
            ]);
        }

        $category->delete();
    }
}