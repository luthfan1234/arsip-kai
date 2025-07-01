<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'document_number',
        'title',
        'description',
        'division_id',
        'category_id',
        'version',
        'file_path',
        'file_name',
        'file_type',
        'file_size',
        'uploaded_by',
        'upload_date',
        'is_active'
    ];

    protected function casts(): array
    {
        return [
            'upload_date' => 'datetime',
            'is_active' => 'boolean',
        ];
    }

    // Relationships
    public function division()
    {
        return $this->belongsTo(Division::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByDivision($query, $divisionId)
    {
        return $query->where('division_id', $divisionId);
    }

    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function($q) use ($search) {
            $q->where('title', 'like', "%{$search}%")
              ->orWhere('document_number', 'like', "%{$search}%")
              ->orWhere('description', 'like', "%{$search}%");
        });
    }

    // Accessors
    public function getFormattedFileSizeAttribute()
    {
        $bytes = $this->file_size;
        $sizes = ['B', 'KB', 'MB', 'GB'];

        if ($bytes === 0) return '0 B';

        $i = floor(log($bytes) / log(1024));
        return round($bytes / pow(1024, $i), 2) . ' ' . $sizes[$i];
    }

    // Boot method to generate document number
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($document) {
            if (empty($document->document_number)) {
                $document->document_number = self::generateDocumentNumber();
            }
        });
    }

    private static function generateDocumentNumber()
    {
        $prefix = 'DOC';
        $year = date('Y');
        $month = date('m');

        $lastDocument = self::whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->orderBy('id', 'desc')
            ->first();

        $sequence = $lastDocument ? (intval(substr($lastDocument->document_number, -4)) + 1) : 1;

        return $prefix . $year . $month . str_pad($sequence, 4, '0', STR_PAD_LEFT);
    }
}
