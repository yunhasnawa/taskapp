@extends('layouts.app')

@section('title', 'Edit Tugas')

@section('content')
    <h1 class="h4 mb-3">Edit Tugas</h1>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('tasks.update', $task) }}">
                @csrf
                @method('PUT')
                @include('tasks._form')

                <button class="btn btn-primary">Perbarui</button>
                <a href="{{ route('tasks.show', $task) }}" class="btn btn-link">Batal</a>
            </form>
        </div>
    </div>
@endsection
