@extends('layouts.app')

@section('content')
<style>
    /* Global Styles */
    body {
        background: linear-gradient(to right, #00AA13,rgb(67, 182, 115));
        font-family: 'Poppins', sans-serif;
        color: #2d3748;
    }

    /* Container */
    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
    }

    /* Title */
    .page-title {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 30px;
    }

    /* Button Create Task */
    .btn-create {
        background: linear-gradient(135deg, #6a11cb, #2575fc);
        border: none;
        color: white;
        padding: 12px 30px;
        border-radius: 50px;
        font-size: 1rem;
        font-weight: 600;
        box-shadow: 0 6px 18px rgba(37, 117, 252, 0.2);
        transition: background 0.3s ease, transform 0.3s ease, box-shadow 0.3s ease;
    }

    .btn-create:hover {
        background: linear-gradient(135deg, #2575fc, #6a11cb);
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(37, 117, 252, 0.3);
    }

    /* Task Cards */
    .task-card {
        background-color: white;
        border-radius: 15px;
        padding: 20px;
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        position: relative;
        height: 100%;
    }

    .task-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.2);
    }

    /* Task Title */
    .task-title {
        font-size: 1.25rem;
        font-weight: 600;
        margin-bottom: 10px;
        transition: color 0.3s ease;
    }

    .task-title.task-done {
        color: #a0aec0;
        text-decoration: line-through;
    }

    /* Badge Priority */
    .badge-priority {
        padding: 8px 20px;
        border-radius: 25px;
        font-size: 1rem;
        font-weight: 700;
        color: white;
        text-transform: capitalize;
        display: inline-block;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        transition: background-color 0.3s ease;
    }

    .badge-low {
        background-color: #48bb78; /* Green */
    }

    .badge-medium {
        background-color: #f6ad55; /* Orange */
    }

    .badge-high {
        background-color: #f56565; /* Red */
    }

    /* Deadline */
    .deadline {
        font-size: 0.9rem;
        color: #4a5568;
        margin-top: 10px;
    }

    /* Form Check */
    .form-check-input {
        width: 1.5rem;
        height: 1.5rem;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 60px 0;
        color:rgb(0, 0, 0);
        font-size: 1.25rem;
    }

    /* Action Buttons */
    .btn-sm {
        font-size: 0.875rem;
        padding: 8px 18px;
        border-radius: 25px;
        transition: background 0.3s ease;
    }

    .btn-warning {
        background-color: #ecc94b;
        color: #2d3748;
        border: none;
        box-shadow: 0 4px 12px rgba(237, 199, 80, 0.2);
    }

    .btn-danger {
        background-color: #e53e3e;
        color: white;
        border: none;
    }

    .btn-warning:hover {
        background-color: #d69e2e;
    }

    .btn-danger:hover {
        background-color: #c53030;
    }

    /* Task Card Form */
    .task-card .form-check {
        margin-top: auto;
    }

    /* Media Queries for Responsiveness */
    @media (max-width: 768px) {
        .task-card {
            padding: 15px;
            margin-bottom: 20px;
        }
    }

    @media (max-width: 576px) {
        .btn-create {
            width: 100%;
            font-size: 1.1rem;
        }
    }
    .task-card.overdue {
    border: 2px solid #e53e3e;
    background-color: #fff5f5;
}
.task-card.overdue .task-title {
    color: #e53e3e;
}
.task-card.overdue .deadline::before {
    content: '⚠️ ';
    color: #e53e3e;
}
</style>

<div class="container mt-4">
    <div class="row mb-4 align-items-center">
        <div class="col-md-4">
            <form method="GET" action="{{ route('tugas.index') }}" class="d-flex">
                <input type="text" name="search" class="form-control me-2" placeholder="Cari tugas..." value="{{ request('search') }}">
                <button type="submit" class="btn btn-primary">🔍</button>
            </form>
        </div>
        <div class="col-md-4 text-center">
            <h2 class="page-title m-0">📘 Daftar Tugas</h2>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('tugas.create') }}" class="btn btn-create">+ Tambah Tugas</a>
        </div>
    </div>

    <div class="row">
        @forelse($tugas as $task)
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card task-card {{ \Carbon\Carbon::parse($task->due_date)->isPast() && !$task->is_done ? 'overdue' : '' }}">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <h5 class="task-title {{ $task->is_done ? 'task-done' : '' }}">
                                📌 {{ $task->title }}
                            </h5>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox"
                                       {{ $task->is_done ? 'checked disabled' : '' }}
                                       data-task-id="{{ $task->id }}"
                                       onchange="updateStatus(this)">
                            </div>
                        </div>

                        <span class="badge badge-priority badge-{{ $task->priority }}">
                            {{ ucfirst($task->priority) }}
                        </span>

                       <div class="deadline">
                         📅 Deadline: {{ \Carbon\Carbon::parse($task->due_date)->format('d M Y') }}
                       </div>

                      <div class="mt-2" style="color: #4a5568;">
                        <strong>📝 Deskripsi:</strong>
                        <p style="margin: 0;">{{ $task->description ?: 'Tidak ada deskripsi.' }}</p>
                      </div>

                        <div class="d-flex justify-content-between mt-3">
                            <a href="{{ route('tugas.edit', $task->id) }}" class="btn btn-warning btn-sm">
                                ✏️ Edit
                            </a>
                            <form action="{{ route('tugas.destroy', $task->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm">🗑️ Hapus</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="empty-state">
                    🎉 Belum ada tugas. Yuk tambah tugas pertama kamu!
                </div>
            </div>
        @endforelse
    </div>
</div>

<script>
    function updateStatus(checkbox) {
        const taskId = checkbox.getAttribute('data-task-id');
        const isDone = checkbox.checked;

        fetch(`/tugas/${taskId}/update-status`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
            body: JSON.stringify({ is_done: isDone })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            }
        })
        .catch(error => console.error('Gagal update status:', error));
    }
</script>
@endsection
