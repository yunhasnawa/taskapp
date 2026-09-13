@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h4 mb-0">Dashboard</h1>
        <a href="{{ route('tasks.create') }}" class="btn btn-primary">+ Tugas Baru</a>
    </div>

    <div class="row g-3 mb-4">
        @foreach ([
            ['label' => 'Total Tugas', 'value' => $total, 'color' => 'primary'],
            ['label' => 'Belum Dimulai', 'value' => $belum, 'color' => 'secondary'],
            ['label' => 'Dikerjakan', 'value' => $dikerjakan, 'color' => 'warning'],
            ['label' => 'Selesai', 'value' => $selesai, 'color' => 'success'],
            ['label' => 'Lewat Tenggat', 'value' => $terlambat, 'color' => 'danger'],
        ] as $kartu)
            <div class="col-6 col-md">
                <div class="card border-{{ $kartu['color'] }} h-100">
                    <div class="card-body text-center">
                        <div class="text-muted small">{{ $kartu['label'] }}</div>
                        <div class="fs-3 fw-bold text-{{ $kartu['color'] }}">{{ $kartu['value'] }}</div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="card">
        <div class="card-header">Tugas Terdekat Tenggatnya</div>
        <ul class="list-group list-group-flush">
            @forelse ($segeraTenggat as $task)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span>
                        <a href="{{ route('tasks.show', $task) }}">{{ $task->title }}</a>
                        @if ($task->isOverdue())
                            <span class="badge bg-danger ms-1">Lewat tenggat</span>
                        @endif
                    </span>
                    <span class="text-muted small">{{ $task->due_date->format('d M Y') }}</span>
                </li>
            @empty
                <li class="list-group-item text-muted">Belum ada tugas dengan tenggat waktu.</li>
            @endforelse
        </ul>
    </div>
@endsection
