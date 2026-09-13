@extends('layouts.app')

@section('title', 'Detail Tugas')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h4 mb-0">Detail Tugas</h1>
        <a href="{{ route('tasks.index') }}" class="btn btn-link">&larr; Kembali</a>
    </div>

    <div class="card">
        <div class="card-body">
            <h2 class="h5">{{ $task->title }}</h2>
            <p class="text-muted">{{ $task->description ?: 'Tidak ada deskripsi.' }}</p>

            <dl class="row mb-0">
                <dt class="col-sm-3">Status</dt>
                <dd class="col-sm-9"><span class="badge bg-{{ $task->statusColor() }}">{{ ucfirst($task->status) }}</span></dd>

                <dt class="col-sm-3">Prioritas</dt>
                <dd class="col-sm-9"><span class="badge bg-{{ $task->priorityColor() }}">{{ ucfirst($task->priority) }}</span></dd>

                <dt class="col-sm-3">Kategori</dt>
                <dd class="col-sm-9">{{ $task->category?->name ?? '—' }}</dd>

                <dt class="col-sm-3">Tenggat</dt>
                <dd class="col-sm-9">
                    {{ $task->due_date?->format('d M Y') ?? '—' }}
                    @if ($task->isOverdue())
                        <span class="badge bg-danger">Lewat tenggat</span>
                    @endif
                </dd>

                <dt class="col-sm-3">Pemilik</dt>
                <dd class="col-sm-9">{{ $task->user->name }}</dd>

                <dt class="col-sm-3">Dibuat</dt>
                <dd class="col-sm-9">{{ $task->created_at->format('d M Y H:i') }}</dd>
            </dl>
        </div>
        <div class="card-footer d-flex gap-2">
            <a href="{{ route('tasks.edit', $task) }}" class="btn btn-primary btn-sm">Edit</a>
            <form method="POST" action="{{ route('tasks.destroy', $task) }}"
                  onsubmit="return confirm('Yakin ingin menghapus tugas ini?')">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger btn-sm">Hapus</button>
            </form>
        </div>
    </div>
@endsection
