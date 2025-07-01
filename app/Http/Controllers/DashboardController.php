<?php
namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Division;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(): Response
    {
        $user = Auth::user();
        
        // Ensure user has role
        if (!$user->roles->first()) {
            $user->assignRole('user'); // Default role
        }

        // Get statistics
        $totalDocuments = Document::where('is_active', true)->count();
        $totalDivisions = Division::where('is_active', true)->count();
        $totalCategories = Category::where('is_active', true)->count();
        $totalUsers = User::where('is_active', true)->count();

        // Get recent documents (latest 5)
        $recentDocuments = Document::with(['division', 'category', 'uploader'])
            ->where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get()
            ->map(function ($document) {
                return [
                    'id' => $document->id,
                    'title' => $document->title,
                    'document_number' => $document->document_number,
                    'division' => $document->division->name,
                    'category' => $document->category->name,
                    'uploader' => $document->uploader->name,
                    'upload_date' => $document->upload_date,
                    'file_size' => $this->formatFileSize($document->file_size),
                    'created_at' => $document->created_at,
                ];
            });

        // Get documents per division
        $documentsPerDivision = Division::with('documents')
            ->where('is_active', true)
            ->get()
            ->map(function ($division) {
                return [
                    'id' => $division->id,
                    'name' => $division->name,
                    'total_documents' => $division->documents()->where('is_active', true)->count(),
                    'color' => $this->generateColor($division->id),
                ];
            })
            ->filter(function ($division) {
                return $division['total_documents'] > 0;
            })
            ->values();

        // Get documents per category
        $documentsPerCategory = Category::with('documents')
            ->where('is_active', true)
            ->get()
            ->map(function ($category) {
                return [
                    'id' => $category->id,
                    'name' => $category->name,
                    'total_documents' => $category->documents()->where('is_active', true)->count(),
                    'color' => $this->generateColor($category->id + 100),
                ];
            })
            ->filter(function ($category) {
                return $category['total_documents'] > 0;
            })
            ->values();

        // Get monthly upload statistics (last 6 months)
        $monthlyUploads = collect();
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $count = Document::where('is_active', true)
                ->whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();

            $monthlyUploads->push([
                'month' => $date->format('M Y'),
                'count' => $count,
            ]);
        }

        $dashboardData = [
            'statistics' => [
                'total_documents' => $totalDocuments,
                'total_divisions' => $totalDivisions,
                'total_categories' => $totalCategories,
                'total_users' => $totalUsers,
            ],
            'recent_documents' => $recentDocuments,
            'documents_per_division' => $documentsPerDivision,
            'documents_per_category' => $documentsPerCategory,
            'monthly_uploads' => $monthlyUploads,
        ];

        // Return different views based on user role
        if ($user->hasRole('admin')) {
            return Inertia::render('Dashboard', $dashboardData);
        } else {
            return Inertia::render('User/Dashboard', $dashboardData);
        }
    }

    private function formatFileSize($bytes)
    {
        $sizes = ['B', 'KB', 'MB', 'GB'];
        if ($bytes === 0) return '0 B';
        $i = floor(log($bytes) / log(1024));
        return round($bytes / pow(1024, $i), 2) . ' ' . $sizes[$i];
    }

    private function generateColor($seed)
    {
        $colors = [
            '#3B82F6', // Blue
            '#EF4444', // Red
            '#10B981', // Green
            '#F59E0B', // Yellow
            '#8B5CF6', // Purple
            '#06B6D4', // Cyan
            '#84CC16', // Lime
            '#F97316', // Orange
            '#EC4899', // Pink
            '#6B7280', // Gray
        ];

        return $colors[$seed % count($colors)];
    }
}
