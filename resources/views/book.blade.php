@extends('layouts.app')

@section('title', 'Master Buku')

@section('content')
<div class="page-header">
    <h2>Data Buku</h2>
    <a href="{{ route('book.create') }}" class="btn-add">
        <i class='bx bx-plus'></i> Tambah Buku
    </a>
</div>

@if(session('success'))
<div class="alert-success">
    {{ session('success') }}
</div>
@endif

<div class="glass table-container">
    <table class="data-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Judul</th>
                <th>Penerbit</th>
                <th>dimension</th>
                <th>Stok</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($books ?? [] as $index => $book)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $book->title }}</td>
                <td>{{ $book->publisher }}</td>
                <td>{{ $book->dimension }}</td>
                <td>{{ $book->stock }}</td>
                <td style="display: flex; gap: 0.25rem;">
                    <a href="{{ route('book.edit', $book->id) }}" class="action-btn btn-edit" title="Edit"><i class='bx bx-edit-alt'></i></a>
                    <form action="{{ route('book.destroy', $book->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus buku ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="action-btn btn-delete" title="Hapus"><i class='bx bx-trash'></i></button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align: center; color: #64748b;">Belum ada data buku</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection