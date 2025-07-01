<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Division extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'is_active'
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function getTotalDocumentsAttribute()
    {
        return $this->documents()->where('is_active', true)->count();
    }
}
