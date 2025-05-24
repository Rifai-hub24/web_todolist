<?php

namespace App\Http\Controllers;

use App\Models\Tugas;
use Illuminate\Http\Request;

class TugasController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $tugas = Tugas::where('user_id', auth()->id())
            ->when($search, function($query, $search) {
                return $query->where('title', 'like', '%' . $search . '%');
            })
            ->orderBy('is_done') // false (belum selesai) ditampilkan dulu
            ->orderBy('due_date')
            ->get();

        return view('tugas.index', compact('tugas', 'search'));
    }

    public function create()
    {
        return view('tugas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'priority' => 'required|in:low,medium,high',
            'due_date' => 'required|date',
            'description' => 'nullable|string',
        ]);

        Tugas::create([
            'user_id' => auth()->id(),
            'title' => $request->title,
            'priority' => $request->priority,
            'due_date' => $request->due_date,
            'description' => $request->description,
            'is_done' => false,
        ]);

        return redirect()->route('tugas.index');
    }

    public function edit(Tugas $tugas)
    {
        $this->authorizeTask($tugas);
        return view('tugas.edit', compact('tugas'));
    }

    public function update(Request $request, Tugas $tugas)
    {
        $this->authorizeTask($tugas);

        $request->validate([
            'title' => 'required',
            'priority' => 'required|in:low,medium,high',
            'due_date' => 'required|date',
            'description' => 'nullable|string',
        ]);

        $tugas->update($request->only('title', 'priority', 'due_date', 'description'));

        return redirect()->route('tugas.index');
    }

    public function destroy(Tugas $tugas)
    {
        $this->authorizeTask($tugas);
        $tugas->delete();
        return redirect()->route('tugas.index');
    }

    public function updateStatus(Request $request, $id)
    {
        $task = Tugas::findOrFail($id);
        $this->authorizeTask($task);

        // Hanya bisa update dari false ke true (tidak bisa uncheck jika sudah true)
        if (!$task->is_done && filter_var($request->is_done, FILTER_VALIDATE_BOOLEAN)) {
            $task->is_done = true;
            $task->save();

            return response()->json(['success' => true, 'status' => 'checked']);
        }

        return response()->json(['success' => false, 'message' => 'Task already completed or invalid request']);
    }

    protected function authorizeTask($tugas)
    {
        if ($tugas->user_id !== auth()->id()) {
            abort(403);
        }
    }
}