<?php
namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Division;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class DocumentController extends Controller
{
    use AuthorizesRequests;
    public function index(Request $request): \Inertia\Response
    {
        $user = \Illuminate\Support\Facades\Auth::user();

        $query = Document::with(['division', 'category', 'uploader'])
            ->where('is_active', true)
            ->orderBy('created_at', 'desc');

        // Search functionality
        if ($request->has('search') && $request->search) {
            $query->search($request->search);
        }

        // Filter by division
        if ($request->has('division') && $request->division) {
            $query->byDivision($request->division);
        }

        // Filter by category
        if ($request->has('category') && $request->category) {
            $query->byCategory($request->category);
        }

        $data = [
            'documents' => $query->paginate(12)->withQueryString(),
            'divisions' => Division::where('is_active', true)->get(),
            'categories' => Category::where('is_active', true)->get(),
            'filters' => $request->only(['search', 'division', 'category']),
        ];

        // Return different views based on user role
        // Adjust this check according to your user model's role implementation
        if ($user && isset($user->role) && $user->role === 'admin') {
            return Inertia::render('Documents/Index', $data);
        } else {
            return Inertia::render('User/Documents/Index', $data);
        }
    }

    public function create(): \Inertia\Response
    {
        $this->authorize('create', Document::class);

        return Inertia::render('Documents/Create', [
            'divisions' => Division::where('is_active', true)->get(),
            'categories' => Category::where('is_active', true)->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $this->authorize('create', Document::class);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'division_id' => 'required|exists:divisions,id',
            'category_id' => 'required|exists:categories,id',
            'version' => 'required|string|max:10',
            'file' => 'required|file|mimes:pdf,doc,docx,xls,xlsx|max:10240',
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('documents', $fileName, 'public');

            Document::create([
                ...$validated,
                'file_path' => $filePath,
                'file_name' => $file->getClientOriginalName(),
                'file_type' => $file->getClientMimeType(),
                'file_size' => $file->getSize(),
                'uploaded_by' => \Illuminate\Support\Facades\Auth::id(),
                'upload_date' => now(),
            ]);

            return Redirect::route('documents.index')
                ->with('success', 'Dokumen berhasil diupload.');
        }

        return back()->withErrors(['file' => 'File gagal diupload.']);
    }

    public function show(Document $document): \Inertia\Response
    {
        $document->load(['division', 'category', 'uploader']);

        return Inertia::render('Documents/Show', [
            'document' => $document,
        ]);
    }

    public function edit(Document $document): \Inertia\Response
    {
        $this->authorize('update', $document);

        return Inertia::render('Documents/Edit', [
            'document' => $document,
            'divisions' => Division::where('is_active', true)->get(),
            'categories' => Category::where('is_active', true)->get(),
        ]);
    }

    public function update(Request $request, Document $document): RedirectResponse
    {
        $this->authorize('update', $document);

        $validated = $request->validate([
            'document_number' => 'required|string|max:255|unique:documents,document_number,' . $document->id,
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'division_id' => 'required|exists:divisions,id',
            'category_id' => 'required|exists:categories,id',
            'version' => 'required|string|max:10',
            'file' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx|max:10240',
        ]);

        if ($request->hasFile('file')) {
            if ($document->file_path && Storage::disk('public')->exists($document->file_path)) {
                Storage::disk('public')->delete($document->file_path);
            }

            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('documents', $fileName, 'public');

            $validated['file_path'] = $filePath;
            $validated['file_name'] = $file->getClientOriginalName();
            $validated['file_type'] = $file->getClientMimeType();
            $validated['file_size'] = $file->getSize();
        }

        $document->update($validated);

        return Redirect::route('documents.index')
            ->with('success', 'Dokumen berhasil diperbarui.');
    }

    public function destroy(Document $document): RedirectResponse
    {
        $this->authorize('delete', $document);

        if ($document->file_path && Storage::disk('public')->exists($document->file_path)) {
            Storage::disk('public')->delete($document->file_path);
        }

        $document->update(['is_active' => false]);

        return Redirect::route('documents.index')
            ->with('success', 'Dokumen berhasil dihapus.');
    }

    public function download(Document $document)
    {
        if (!Storage::disk('public')->exists($document->file_path)) {
            return back()->withErrors(['file' => 'File tidak ditemukan.']);
        }

        $filePath = Storage::disk('public')->path($document->file_path);
        return response()->download($filePath, $document->file_name);
    }
}
