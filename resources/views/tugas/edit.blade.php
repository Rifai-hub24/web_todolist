@extends('layouts.app')

@section('content')
<style>
    body {
        background: linear-gradient(to right, #00AA13,rgb(67, 182, 115));
        min-height: 100vh;
    }

    .edit-task-card {
        background: #fff;
        border-radius: 16px;
        padding: 40px;
        box-shadow: 0 8px 24px rgba(0,0,0,0.15);
        max-width: 600px;
        margin: 50px auto;
        animation: fadeIn 0.5s ease-in-out;
    }

    .edit-task-card h1 {
        font-size: 28px;
        margin-bottom: 30px;
        text-align: center;
        color:rgb(0, 0, 0);
    }

    .form-label {
        font-weight: bold;
    }

    .form-control, .form-select {
        border-radius: 8px;
    }

    .btn-primary {
        background-color:rgb(16, 98, 192);
        border: none;
        padding: 10px 20px;
        border-radius: 8px;
        transition: background 0.3s;
    }

    .btn-primary:hover {
        background-color:rgb(13, 196, 202);
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

<div class="edit-task-card">
    <h1>📝 Edit Tugas</h1>
    <form action="{{ route('tugas.update', $tugas->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="title" class="form-label">Judul Tugas</label>
            <input type="text" name="title" id="title" class="form-control" value="{{ $tugas->title }}" placeholder="Contoh: Belajar Laravel" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Deskripsi</label>
            <textarea name="description" id="description" class="form-control" rows="4" placeholder="Masukkan deskripsi tugas...">{{ $tugas->description }}</textarea>
        </div>

        <div class="mb-3">
            <label for="priority" class="form-label">Prioritas</label>
            <select name="priority" id="priority" class="form-select" required>
                <option value="low" {{ $tugas->priority == 'low' ? 'selected' : '' }}>🟢 Rendah</option>
                <option value="medium" {{ $tugas->priority == 'medium' ? 'selected' : '' }}>🟠 Sedang</option>
                <option value="high" {{ $tugas->priority == 'high' ? 'selected' : '' }}>🔴 Tinggi</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="due_date" class="form-label">Deadline</label>
            <input type="date" name="due_date" id="due_date" class="form-control" value="{{ $tugas->due_date }}" required>
        </div>

        <div class="d-grid mt-4">
            <button type="submit" class="btn btn-primary">💾 Simpan Perubahan</button>
        </div>
    </form>
</div>
@endsection
