@extends('layouts.app')

@section('title', 'Master Anggota')

@section('content')
<div class="page-header">
    <h2>Data Anggota</h2>
    <a href="{{ route('member.create') }}" class="btn-add">
        <i class='bx bx-plus'></i> Tambah Anggota
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
                <th>Nomor Anggota</th>
                <th>Nama</th>
                <th>Tanggal Lahir</th>
                <th>Stock Limit</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($members ?? [] as $index => $member)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $member->member_number }}</td>
                <td>{{ $member->name }}</td>
                <td>{{ \Carbon\Carbon::parse($member->tanggal_lahir)->format('d/m/Y') }}</td>
                <td>{{ $member->stock }}</td>
                <td style="display: flex; gap: 0.25rem;">
                    <a href="{{ route('member.edit', $member->id) }}" class="action-btn btn-edit" title="Edit"><i class='bx bx-edit-alt'></i></a>
                    <form action="{{ route('member.destroy', $member->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus anggota ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="action-btn btn-delete" title="Hapus"><i class='bx bx-trash'></i></button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align: center; color: #64748b;">Belum ada data anggota</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
