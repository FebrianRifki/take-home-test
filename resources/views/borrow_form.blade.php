@extends('layouts.app')

@section('title', 'Tambah Peminjaman')

@section('content')
<div class="page-header">
    <h2>Tambah Peminjaman</h2>
    <a href="{{ route('borrow.index') }}" class="btn-add" style="background: #64748b; box-shadow: none;">
        <i class='bx bx-arrow-back'></i> Kembali
    </a>
</div>

<div class="glass" style="padding: 2rem; max-width: 800px; margin: 0 auto;">
    @if ($errors->any())
        <div class="alert-danger">
            <ul style="margin-left: 1.5rem;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('borrow.store') }}" method="POST" id="borrowForm">
        @csrf

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
            <div class="form-group" style="margin-bottom: 0;">
                <label class="form-label" for="member_id">Pilih Anggota</label>
                <select name="member_id" id="member_id" class="app-input" required>
                    <option value="">-- Pilih Anggota --</option>
                    @foreach($members as $member)
                        <option value="{{ $member->id }}" data-limit="{{ $member->stock }}" {{ old('member_id') == $member->id ? 'selected' : '' }}>
                            {{ $member->member_number }} - {{ $member->name }} (Limit: {{ $member->stock }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group" style="margin-bottom: 0;">
                <label class="form-label" for="borrow_date">Tanggal Peminjaman</label>
                <input type="date" name="borrow_date" id="borrow_date" class="app-input" value="{{ old('borrow_date', date('Y-m-d')) }}" required>
            </div>
        </div>

        <div class="form-group">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                <label class="form-label" style="margin: 0; font-size: 1.1rem; color: var(--dark);">Daftar Buku yang Dipinjam</label>
                <button type="button" class="btn-primary" id="addBookBtn" style="width: auto; padding: 0.5rem 1rem; font-size: 0.875rem;">
                    <i class='bx bx-plus'></i> Tambah Buku
                </button>
            </div>
            
            <div id="bookList">
                <!-- Book Items will be appended here -->
            </div>
        </div>

        <div style="margin-top: 2rem; text-align: right;">
            <button type="submit" class="btn-primary" style="width: auto; padding: 0.75rem 2rem;">
                <i class='bx bx-save'></i> Simpan Peminjaman
            </button>
        </div>
    </form>
</div>

<!-- Template for a single book row -->
<template id="bookRowTemplate">
    <div class="book-row" style="display: flex; gap: 1rem; align-items: center; margin-bottom: 1rem; background: rgba(0,0,0,0.02); padding: 1rem; border-radius: 10px; border: 1px solid rgba(0,0,0,0.05);">
        <div style="flex: 1;">
            <label class="form-label">Buku</label>
            <select class="app-input book-select" required>
                <option value="">-- Pilih Buku --</option>
                @foreach($books as $book)
                    <option value="{{ $book->id }}" data-stock="{{ $book->stock }}">
                        {{ $book->title }} (Stok: {{ $book->stock }})
                    </option>
                @endforeach
            </select>
        </div>
        <div style="width: 100px;">
            <label class="form-label">Kuantitas</label>
            <input type="number" class="app-input book-quantity" min="1" value="1" required>
        </div>
        <div style="padding-top: 1.5rem;">
            <button type="button" class="action-btn btn-delete remove-book-btn" title="Hapus"><i class='bx bx-trash'></i></button>
        </div>
    </div>
</template>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const bookList = document.getElementById('bookList');
        const addBookBtn = document.getElementById('addBookBtn');
        const template = document.getElementById('bookRowTemplate');
        let bookIndex = 0;

        function addBookRow() {
            const clone = template.content.cloneNode(true);
            const row = clone.querySelector('.book-row');
            
            const select = clone.querySelector('.book-select');
            select.name = `books[${bookIndex}][id]`;
            
            const quantity = clone.querySelector('.book-quantity');
            quantity.name = `books[${bookIndex}][quantity]`;

            // Setup remove button
            const removeBtn = clone.querySelector('.remove-book-btn');
            removeBtn.addEventListener('click', function() {
                row.remove();
            });

            // Prevent selecting more quantity than available stock
            select.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                const stock = selectedOption.getAttribute('data-stock');
                if(stock) {
                    quantity.max = stock;
                    if(parseInt(quantity.value) > parseInt(stock)) {
                        quantity.value = stock;
                    }
                }
            });

            quantity.addEventListener('input', function() {
                const selectedOption = select.options[select.selectedIndex];
                if(selectedOption.value) {
                    const stock = parseInt(selectedOption.getAttribute('data-stock'));
                    if(parseInt(this.value) > stock) {
                        alert('Kuantitas melebihi stok yang tersedia (' + stock + ')');
                        this.value = stock;
                    }
                }
            });

            bookList.appendChild(clone);
            bookIndex++;
        }

        // Add one initial row
        addBookRow();

        // Handle add button click
        addBookBtn.addEventListener('click', function() {
            addBookRow();
        });

        // Form submit validation for Member Limit
        document.getElementById('borrowForm').addEventListener('submit', function(e) {
            const memberSelect = document.getElementById('member_id');
            if(!memberSelect.value) return;

            const selectedMember = memberSelect.options[memberSelect.selectedIndex];
            const limit = parseInt(selectedMember.getAttribute('data-limit'));
            
            let totalQty = 0;
            document.querySelectorAll('.book-quantity').forEach(input => {
                totalQty += parseInt(input.value || 0);
            });

            if(totalQty > limit) {
                e.preventDefault();
                alert(`Gagal! Total buku yang dipinjam (${totalQty}) melebihi limit stok anggota (${limit}).`);
            }
        });
    });
</script>
@endsection
