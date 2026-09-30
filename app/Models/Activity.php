<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $fillable = [
        'category_id',
        'code',
        'title',
        'description',
        'activity_date',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'activity_date' => 'date',
        ];
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}