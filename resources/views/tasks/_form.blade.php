<div class="mb-3">
    <label for="title" class="form-label">Judul <span class="text-danger">*</span></label>
    <input id="title" type="text" name="title" value="{{ old('title', $task->title) }}"
           class="form-control @error('title') is-invalid @enderror">
    @error('title')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="description" class="form-label">Deskripsi</label>
    <textarea id="description" name="description" rows="4"
              class="form-control @error('description') is-invalid @enderror">{{ old('description', $task->description) }}</textarea>
    @error('description')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="row">
    <div class="col-md-4 mb-3">
        <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
        <select id="status" name="status" class="form-select @error('status') is-invalid @enderror">
            @foreach (\App\Models\Task::STATUSES as $status)
                <option value="{{ $status }}" @selected(old('status', $task->status) === $status)>
                    {{ ucfirst($status) }}
                </option>
            @endforeach
        </select>
        @error('status')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4 mb-3">
        <label for="priority" class="form-label">Prioritas <span class="text-danger">*</span></label>
        <select id="priority" name="priority" class="form-select @error('priority') is-invalid @enderror">
            @foreach (\App\Models\Task::PRIORITIES as $priority)
                <option value="{{ $priority }}" @selected(old('priority', $task->priority) === $priority)>
                    {{ ucfirst($priority) }}
                </option>
            @endforeach
        </select>
        @error('priority')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4 mb-3">
        <label for="due_date" class="form-label">Tenggat</label>
        <input id="due_date" type="date" name="due_date"
               value="{{ old('due_date', $task->due_date?->format('Y-m-d')) }}"
               class="form-control @error('due_date') is-invalid @enderror">
        @error('due_date')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="mb-3">
    <label for="category_id" class="form-label">Kategori</label>
    <select id="category_id" name="category_id" class="form-select @error('category_id') is-invalid @enderror">
        <option value="">— Tanpa kategori —</option>
        @foreach ($categories as $category)
            <option value="{{ $category->id }}" @selected((int) old('category_id', $task->category_id) === $category->id)>
                {{ $category->name }}
            </option>
        @endforeach
    </select>
    @error('category_id')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
