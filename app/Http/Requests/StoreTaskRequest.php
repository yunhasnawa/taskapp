<?php

namespace App\Http\Requests;

use App\Models\Task;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title'       => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'priority'    => ['required', Rule::in(Task::PRIORITIES)],
            'status'      => ['required', Rule::in(Task::STATUSES)],
            'due_date'    => ['nullable', 'date'],
            'category_id' => ['nullable', 'exists:categories,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required'     => 'Judul tugas wajib diisi.',
            'title.max'          => 'Judul tugas maksimal 255 karakter.',
            'priority.required'  => 'Prioritas wajib dipilih.',
            'priority.in'        => 'Prioritas yang dipilih tidak valid.',
            'status.required'    => 'Status wajib dipilih.',
            'status.in'          => 'Status yang dipilih tidak valid.',
            'due_date.date'      => 'Tanggal tenggat harus berupa tanggal yang valid.',
            'category_id.exists' => 'Kategori yang dipilih tidak tersedia.',
        ];
    }
}
