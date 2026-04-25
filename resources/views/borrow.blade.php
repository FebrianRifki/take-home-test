@extends('layouts.app')

@section('title', 'Peminjaman')

@section('content')
<div class="page-header">
    <h2>Data Peminjaman</h2>
    <a href="{{ route('borrow.create') }}" class="btn-add">
        <i class='bx bx-plus'></i> Tambah Peminjaman
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
                <th>Anggota</th>
                <th>Buku</th>
                <th>Tanggal Pinjam</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($borrowings ?? [] as $index => $borrowing)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $borrowing->member->name ?? '-' }}</td>
                <td>
                    @if(isset($borrowing->books))
                        @foreach($borrowing->books as $book)
                            <span class="badge" style="background: rgba(99,102,241,0.1); color: #6366f1; padding: 2px 8px; border-radius: 12px; font-size: 0.75rem; display: inline-block; margin-bottom: 2px;">{{ $book->title }} ({{ $book->pivot->quantity }})</span><br>
                        @endforeach
                    @endif
                </td>
                <td>{{ $borrowing->borrow_date }}</td>
                <td>
                    @if($borrowing->bookReturn)
                        <span style="color: #10b981; font-weight: 600;">Dikembalikan</span>
                    @else
                        <span style="color: #ef4444; font-weight: 600;">Dipinjam</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('borrow.show', $borrowing->id) }}" class="action-btn btn-edit" title="Detail"><i class='bx bx-info-circle'></i></a>
                    @if(!$borrowing->bookReturn)
                        <form action="{{ route('return.store') }}" method="POST" style="display:inline;" onsubmit="return confirm('Apakah Anda yakin ingin menyelesaikan peminjaman ini? Stok buku akan otomatis dikembalikan.');">
                            @csrf
                            <input type="hidden" name="borrowing_id" value="{{ $borrowing->id }}">
                            <button type="submit" class="action-btn btn-return" title="Kembalikan"><i class='bx bx-check-circle'></i></button>
                        </form>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align: center; color: #64748b;">Belum ada data peminjaman</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
