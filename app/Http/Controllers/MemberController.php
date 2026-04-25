<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\Borrowing;

class MemberController extends Controller
{
    public function index()
    {
        $members = Member::orderBy('member_number', 'desc')->get();
        return view('member', compact('members'));
    }

    public function getMemberBorrowing($id)
    {
        $member = Member::findOrFail($id);

        $borrowings = Borrowing::where('member_id', $id)
            ->orderBy('borrow_date', 'desc')
            ->with('book:id,title,dimension')
            ->get();

        $data = $borrowings->map(function ($borrow) {
            return [
                'id' => $borrow->id,
                'borrow_number' => str_pad($borrow->id, 4, '0', STR_PAD_LEFT),
                'book_title' => $borrow->book->title ?? '-',
                'borrow_date' => $borrow->borrow_date,
                'due_date' => $borrow->due_date,
                'is_late' => $borrow->is_late,
                'returned' => $borrow->returned,
            ];
        });

        return response()->json([
            'member' => $member,
            'borrowings' => $data,
        ]);
    }
    public function create()
    {
        return view('member_form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'member_number' => 'required|unique:members',
            'name' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'stock' => 'required|integer|min:0',
        ]);

        Member::create($request->all());

        return redirect()->route('member.index')->with('success', 'Anggota berhasil ditambahkan.');
    }

    public function edit(Member $member)
    {
        return view('member_form', compact('member'));
    }

    public function update(Request $request, Member $member)
    {
        $request->validate([
            'member_number' => 'required|unique:members,member_number,' . $member->id,
            'name' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'stock' => 'required|integer|min:0',
        ]);

        $member->update($request->all());

        return redirect()->route('member.index')->with('success', 'Anggota berhasil diperbarui.');
    }

    public function destroy(Member $member)
    {
        $member->delete();
        return redirect()->route('member.index')->with('success', 'Anggota berhasil dihapus.');
    }
}
