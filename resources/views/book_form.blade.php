@extends('layouts.app')

@section('title', isset($book) ? 'Edit Buku' : 'Tambah Buku')

@section('content')
<div class="page-header">
    <h2>{{ isset($book) ? 'Edit Buku' : 'Tambah Buku' }}</h2>
    <a href="{{ route('book.index') }}" class="btn-add" style="background: #64748b; box-shadow: none;">
        <i class='bx bx-arrow-back'></i> Kembali
    </a>
</div>

<div class="glass" style="padding: 2rem; max-width: 600px; margin: 0 auto;">
    @if ($errors->any())
    <div class="alert-danger">
        <ul style="margin-left: 1.5rem;">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ isset($book) ? route('book.update', $book->id) : route('book.store') }}" method="POST">
        @csrf
        @if(isset($book))
        @method('PUT')
        @endif

        <div class="form-group">
            <label class="form-label" for="title">Judul Buku</label>
            <input type="text" name="title" id="title" class="app-input" value="{{ old('title', $book->title ?? '') }}" required>
        </div>

        <div class="form-group">
            <label class="form-label" for="publisher">Penerbit</label>
            <input type="text" name="publisher" id="publisher" class="app-input" value="{{ old('publisher', $book->publisher ?? '') }}" required>
        </div>

        <div class="form-group">
            <label class="form-label" for="dimension">dimension</label>
            <input type="text" name="dimension" id="dimension" class="app-input" value="{{ old('dimension', $book->dimension ?? '') }}" placeholder="Contoh: 14x21 cm" required>
        </div>

        <div class="form-group">
            <label class="form-label" for="stock">Stock</label>
            <input type="number" name="stock" id="stock" class="app-input" min="0" value="{{ old('stock', $book->stock ?? 0) }}" required>
        </div>

        <div style="margin-top: 2rem;">
            <button type="submit" class="btn-primary" style="width: auto; padding: 0.75rem 2rem;">
                <i class='bx bx-save'></i> Simpan Data
            </button>
        </div>
    </form>
</div>
@endsection