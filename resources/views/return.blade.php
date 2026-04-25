@extends('layouts.app')

@section('title', 'Pengembalian')

@section('content')
<div class="page-header">
    <h2>Data Pengembalian</h2>
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
                <th>ID Peminjaman</th>
                <th>Anggota</th>
                <th>Tanggal Pinjam</th>
                <th>Tanggal Kembali</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($returns ?? [] as $index => $return)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>#{{ str_pad($return->borrowing_id, 4, '0', STR_PAD_LEFT) }}</td>
                <td>{{ $return->borrowing->member->name ?? '-' }}</td>
                <td>{{ $return->borrowing->borrow_date ?? '-' }}</td>
                <td>{{ $return->return_date }}</td>
                <td>
                    <a href="{{ route('borrow.show', $return->borrowing_id) }}" class="action-btn btn-edit" title="Detail"><i class='bx bx-info-circle'></i></a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align: center; color: #64748b;">Belum ada data pengembalian</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection