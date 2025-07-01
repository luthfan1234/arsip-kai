<?php
namespace App\Http\Controllers;

use App\Models\Division;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class DivisionController extends Controller
{
    use \Illuminate\Foundation\Auth\Access\AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $this->authorize('viewAny', Division::class);

        $divisions = Division::withCount('documents')
            ->orderBy('name')
            ->get();

        return Inertia::render('Divisions/Index', [
            'divisions' => $divisions,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        $this->authorize('create', Division::class);

        return Inertia::render('Divisions/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Division::class);

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:divisions',
            'description' => 'nullable|string|max:1000',
        ]);

        Division::create($validated);

        return Redirect::route('divisions.index')
            ->with('success', 'Divisi berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Division $division): Response
    {
        $this->authorize('update', $division);

        return Inertia::render('Divisions/Edit', [
            'division' => $division,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Division $division)
    {
        $this->authorize('update', $division);

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:divisions,name,' . $division->id,
            'description' => 'nullable|string|max:1000',
        ]);

        $division->update($validated);

        return Redirect::route('divisions.index')
            ->with('success', 'Divisi berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Division $division)
    {
        $this->authorize('delete', $division);

        // Check if division has documents
        if ($division->documents()->count() > 0) {
            return redirect()->route('divisions.index')
                ->with('error', 'Divisi tidak dapat dihapus karena masih memiliki dokumen terkait.');
        }

        $division->delete();

        return Redirect::route('divisions.index')
            ->with('success', 'Divisi berhasil dihapus.');
    }
}
