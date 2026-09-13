@extends('layouts.app')

@section('title', 'Semua Tugas')

@section('content')
    <h1 class="h4 mb-3">Semua Tugas Pengguna</h1>

    <div class="row g-3 mb-4">
        @foreach ($users as $user)
            <div class="col-6 col-md-3">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="fw-semibold">{{ $user->name }}</div>
                        <div class="text-muted small">{{ $user->email }}</div>
                        <div class="fs-4 fw-bold">{{ $user->tasks_count }} <span class="fs-6 fw-normal text-muted">tugas</span></div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <form method="GET" action="{{ route('admin.tasks.index') }}" class="card card-body mb-3">
        <div class="row g-2">
            <div class="col-md-5">
                <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Cari judul tugas...">
            </div>
            <div class="col-md-3">
                <select name="status" class="form-select">
                    <option value="">Semua Status</option>
                    @foreach (\App\Models\Task::STATUSES as $status)
                        <option value="{{ $status }}" @selected(request('status') === $status)>{{ ucfirst($status) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <select name="priority" class="form-select">
                    <option value="">Semua Prioritas</option>
                    @foreach (\App\Models\Task::PRIORITIES as $priority)
                        <option value="{{ $priority }}" @selected(request('priority') === $priority)>{{ ucfirst($priority) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2 d-grid">
                <button class="btn btn-outline-secondary">Filter</button>
            </div>
        </div>
    </form>

    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                <tr>
                    <th>Judul</th>
                    <th>Pemilik</th>
                    <th>Kategori</th>
                    <th>Prioritas</th>
                    <th>Status</th>
                    <th>Tenggat</th>
                </tr>
                </thead>
                <tbody>
                @forelse ($tasks as $task)
                    <tr>
                        <td><a href="{{ route('tasks.show', $task) }}">{{ $task->title }}</a></td>
                        <td>{{ $task->user->name }}</td>
                        <td class="text-muted">{{ $task->category?->name ?? '—' }}</td>
                        <td><span class="badge bg-{{ $task->priorityColor() }}">{{ ucfirst($task->priority) }}</span></td>
                        <td><span class="badge bg-{{ $task->statusColor() }}">{{ ucfirst($task->status) }}</span></td>
                        <td>{{ $task->due_date?->format('d M Y') ?? '—' }}</td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center text-muted py-4">Tidak ada data.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">{{ $tasks->links() }}</div>
@endsection
