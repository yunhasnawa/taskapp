@extends('layouts.app')

@section('title', 'Tambah Tugas')

@section('content')
    <h1 class="h4 mb-3">Tambah Tugas</h1>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('tasks.store') }}">
                @csrf
                @include('tasks._form')

                <button class="btn btn-primary">Simpan</button>
                <a href="{{ route('tasks.index') }}" class="btn btn-link">Batal</a>
            </form>
        </div>
    </div>
@endsection
