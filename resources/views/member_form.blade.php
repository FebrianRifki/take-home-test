@extends('layouts.app')

@section('title', isset($member) ? 'Edit Anggota' : 'Tambah Anggota')

@section('content')
<div class="page-header">
    <h2>{{ isset($member) ? 'Edit Anggota' : 'Tambah Anggota' }}</h2>
    <a href="{{ route('member.index') }}" class="btn-add" style="background: #64748b; box-shadow: none;">
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

    <form action="{{ isset($member) ? route('member.update', $member->id) : route('member.store') }}" method="POST">
        @csrf
        @if(isset($member))
            @method('PUT')
        @endif

        <div class="form-group">
            <label class="form-label" for="member_number">Nomor Anggota</label>
            <input type="text" name="member_number" id="member_number" class="app-input" value="{{ old('member_number', $member->member_number ?? '') }}" required>
        </div>

        <div class="form-group">
            <label class="form-label" for="name">Nama</label>
            <input type="text" name="name" id="name" class="app-input" value="{{ old('name', $member->name ?? '') }}" required>
        </div>

        <div class="form-group">
            <label class="form-label" for="tanggal_lahir">Tanggal Lahir</label>
            <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="app-input" value="{{ old('tanggal_lahir', $member->tanggal_lahir ?? '') }}" required>
        </div>

        <div class="form-group">
            <label class="form-label" for="stock">Stock Limit</label>
            <input type="number" name="stock" id="stock" class="app-input" min="0" value="{{ old('stock', $member->stock ?? 0) }}" required>
        </div>

        <div style="margin-top: 2rem;">
            <button type="submit" class="btn-primary" style="width: auto; padding: 0.75rem 2rem;">
                <i class='bx bx-save'></i> Simpan Data
            </button>
        </div>
    </form>
</div>
@endsection
