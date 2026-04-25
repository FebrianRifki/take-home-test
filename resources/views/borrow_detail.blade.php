@extends('layouts.app')

@section('title', 'Detail Peminjaman')

@section('content')
<div class="page-header">
    <h2>Detail Peminjaman #{{ str_pad($borrowing->id, 4, '0', STR_PAD_LEFT) }}</h2>
    <a href="{{ route('borrow.index') }}" class="btn-add" style="background: #64748b; box-shadow: none;">
        <i class='bx bx-arrow-back'></i> Kembali
    </a>
</div>

<div class="dashboard-cards" style="grid-template-columns: 1fr 1fr; margin-bottom: 2rem;">
    <!-- Info Anggota -->
    <div class="glass" style="padding: 2rem;">
        <h3 style="font-size: 1.1rem; color: #64748b; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.5rem;">
            <i class='bx bx-user' style="font-size: 1.5rem; color: var(--primary);"></i> Informasi Anggota
        </h3>

        <div style="display: grid; grid-template-columns: 150px 1fr; gap: 1rem; margin-bottom: 0.5rem;">
            <span style="color: #64748b; font-weight: 500;">No. Anggota</span>
            <span style="color: var(--dark); font-weight: 600;">{{ $borrowing->member->member_number ?? '-' }}</span>
        </div>
        <div style="display: grid; grid-template-columns: 150px 1fr; gap: 1rem; margin-bottom: 0.5rem;">
            <span style="color: #64748b; font-weight: 500;">Nama Lengkap</span>
            <span style="color: var(--dark); font-weight: 600;">{{ $borrowing->member->name ?? '-' }}</span>
        </div>
        <div style="display: grid; grid-template-columns: 150px 1fr; gap: 1rem; margin-bottom: 0.5rem;">
            <span style="color: #64748b; font-weight: 500;">Tanggal Lahir</span>
            <span style="color: var(--dark); font-weight: 600;">{{ $borrowing->member->tanggal_lahir ? \Carbon\Carbon::parse($borrowing->member->tanggal_lahir)->format('d F Y') : '-' }}</span>
        </div>
    </div>

    <!-- Info Transaksi -->
    <div class="glass" style="padding: 2rem;">
        <h3 style="font-size: 1.1rem; color: #64748b; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.5rem;">
            <i class='bx bx-transfer' style="font-size: 1.5rem; color: var(--secondary);"></i> Status Peminjaman
        </h3>

        <div style="display: grid; grid-template-columns: 150px 1fr; gap: 1rem; margin-bottom: 0.5rem;">
            <span style="color: #64748b; font-weight: 500;">Tanggal Pinjam</span>
            <span style="color: var(--dark); font-weight: 600;">{{ \Carbon\Carbon::parse($borrowing->borrow_date)->format('d F Y') }}</span>
        </div>
        <div style="display: grid; grid-template-columns: 150px 1fr; gap: 1rem; margin-bottom: 0.5rem;">
            <span style="color: #64748b; font-weight: 500;">Status</span>
            <span>
                @if($borrowing->bookReturn)
                <span style="background: rgba(16,185,129,0.1); color: #10b981; padding: 4px 12px; border-radius: 20px; font-weight: 600; font-size: 0.85rem;">Dikembalikan</span>
                @else
                <span style="background: rgba(239,68,68,0.1); color: #ef4444; padding: 4px 12px; border-radius: 20px; font-weight: 600; font-size: 0.85rem;">Dipinjam</span>
                @endif
            </span>
        </div>
        @if($borrowing->bookReturn)
        <div style="display: grid; grid-template-columns: 150px 1fr; gap: 1rem; margin-bottom: 0.5rem;">
            <span style="color: #64748b; font-weight: 500;">Tanggal Kembali</span>
            <span style="color: var(--dark); font-weight: 600;">{{ \Carbon\Carbon::parse($borrowing->bookReturn->return_date)->format('d F Y H:i') }}</span>
        </div>
        @endif
    </div>
</div>

<!-- Daftar Buku -->
<div class="glass table-container">
    <h3 style="font-size: 1.1rem; color: #64748b; margin-bottom: 1rem; padding: 0 1rem;">Daftar Buku yang Dipinjam</h3>
    <table class="data-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Judul Buku</th>
                <th>Penerbit</th>
                <th>dimension</th>
                <th style="text-align: center;">Kuantitas</th>
            </tr>
        </thead>
        <tbody>
            @php $totalQty = 0; @endphp
            @forelse($borrowing->books as $index => $book)
            @php $totalQty += $book->pivot->quantity; @endphp
            <tr>
                <td>{{ $index + 1 }}</td>
                <td style="font-weight: 600; color: var(--dark);">{{ $book->title }}</td>
                <td>{{ $book->publisher }}</td>
                <td>{{ $book->dimension }}</td>
                <td style="text-align: center;">
                    <span style="background: rgba(99,102,241,0.1); color: #6366f1; padding: 4px 12px; border-radius: 12px; font-weight: 600;">
                        {{ $book->pivot->quantity }}
                    </span>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align: center; color: #64748b;">Tidak ada buku</td>
            </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr style="background: rgba(0,0,0,0.02);">
                <td colspan="4" style="text-align: right; font-weight: 600; color: #64748b;">Total Buku:</td>
                <td style="text-align: center; font-weight: bold; color: var(--dark); font-size: 1.1rem;">{{ $totalQty }}</td>
            </tr>
        </tfoot>
    </table>
</div>

@if(!$borrowing->bookReturn)
<div style="margin-top: 2rem; text-align: right;">
    <form action="{{ route('return.store') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin mengembalikan buku ini sekarang? Stok buku akan dikembalikan otomatis.');">
        @csrf
        <input type="hidden" name="borrowing_id" value="{{ $borrowing->id }}">
        <button type="submit" class="btn-primary" style="background: #10b981; box-shadow: 0 4px 15px rgba(16,185,129,0.3); width: auto; padding: 1rem 2rem;">
            <i class='bx bx-check-circle'></i> Proses Pengembalian
        </button>
    </form>
</div>
@endif

@endsection