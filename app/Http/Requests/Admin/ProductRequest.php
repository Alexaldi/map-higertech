<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'category_id' => [
                'required',
                Rule::exists('categories', 'id')->where('tipe', 'produk'),
            ],
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255'],
            'desc' => ['nullable', 'string'],
            'inaproc_link' => ['nullable', 'url', 'max:500'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'extensions:jpeg,png,jpg,webp', 'max:2048', 'dimensions:max_width=6000,max_height=6000'],
            'gallery_images' => ['sometimes', 'array', 'max:5'],
            'gallery_images.*' => ['required', 'image', 'mimes:jpeg,png,jpg,webp', 'extensions:jpeg,png,jpg,webp', 'max:2048', 'dimensions:max_width=6000,max_height=6000'],
            'remove_image' => ['sometimes', 'boolean'],
            'remove_gallery_images' => ['sometimes', 'array', 'max:5'],
            'remove_gallery_images.*' => ['required', 'string', 'distinct', Rule::in($this->route('product')?->gallery_images ?? [])],
            'brochure' => ['nullable', 'file', 'mimes:pdf', 'extensions:pdf', 'max:5120'],
            'remove_brochure' => ['sometimes', 'boolean'],
            'is_active' => ['sometimes', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'category_id.required' => 'Kategori wajib dipilih.',
            'category_id.exists' => 'Kategori tidak valid.',
            'title.required' => 'Judul produk wajib diisi.',
            'image.image' => 'File harus berupa gambar valid.',
            'image.mimes' => 'Format gambar yang diizinkan: JPG, JPEG, PNG, WEBP.',
            'image.extensions' => 'Ekstensi gambar harus JPG, JPEG, PNG, atau WEBP.',
            'image.max' => 'Ukuran gambar maksimal 2 MB.',
            'image.dimensions' => 'Dimensi gambar maksimal 6000 × 6000 piksel.',
            'gallery_images.max' => 'Maksimal 5 gambar per produk, termasuk gambar utama.',
            'gallery_images.*.image' => 'Setiap foto galeri harus berupa gambar valid.',
            'gallery_images.*.mimes' => 'Format foto galeri: JPG, JPEG, PNG, atau WEBP.',
            'gallery_images.*.extensions' => 'Ekstensi foto galeri: JPG, JPEG, PNG, atau WEBP.',
            'gallery_images.*.max' => 'Ukuran setiap foto galeri maksimal 2 MB.',
            'gallery_images.*.dimensions' => 'Dimensi setiap foto maksimal 6000 × 6000 piksel.',
            'remove_gallery_images.*.in' => 'Foto yang dihapus harus milik produk ini.',
            'brochure.mimes' => 'Brosur harus berupa PDF.',
            'brochure.extensions' => 'Ekstensi brosur harus PDF.',
            'brochure.max' => 'Ukuran brosur maksimal 5 MB.',
        ];
    }
}
