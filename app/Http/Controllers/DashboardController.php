<?php
namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Division;
use App\Models\Category;
use App\Models\User;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function index(): Response
    {
        $totalDocuments = Document::where('is_active', true)->count();
        $totalDivisions = Division::where('is_active', true)->count();
        $totalCategories = Category::where('is_active', true)->count();
        $totalUsers = User::where('is_active', true)->count();

        $recentDocuments = Document::with(['division', 'category', 'uploader'])
            ->where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        $documentsByDivision = Document::selectRaw('divisions.name, COUNT(*) as total')
            ->join('divisions', 'documents.division_id', '=', 'divisions.id')
            ->where('documents.is_active', true)
            ->groupBy('divisions.name')
            ->get();

        $documentsByCategory = Document::selectRaw('categories.name, COUNT(*) as total')
            ->join('categories', 'documents.category_id', '=', 'categories.id')
            ->where('documents.is_active', true)
            ->groupBy('categories.name')
            ->get();

        return Inertia::render('Dashboard', [
            'stats' => [
                'total_documents' => $totalDocuments,
                'total_divisions' => $totalDivisions,
                'total_categories' => $totalCategories,
                'total_users' => $totalUsers,
            ],
            'recent_documents' => $recentDocuments,
            'documents_by_division' => $documentsByDivision,
            'documents_by_category' => $documentsByCategory,
        ]);
    }
}
