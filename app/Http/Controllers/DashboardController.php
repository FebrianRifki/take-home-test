<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Borrowing;
use App\Models\Book;
use App\Models\Member;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $totalMembers = Member::count();
        $totalBooks = Book::count();
        $totalBorrowings = Borrowing::count();

        // Rekap peminjaman perminggu untuk 4 minggu terakhir
        $borrowingData = [];
        $labels = [];

        for ($i = 3; $i >= 0; $i--) {
            $startOfWeek = Carbon::now()->subWeeks($i)->startOfWeek()->format('Y-m-d');
            $endOfWeek = Carbon::now()->subWeeks($i)->endOfWeek()->format('Y-m-d');
            
            $count = Borrowing::whereBetween('borrow_date', [$startOfWeek, $endOfWeek])->count();
            
            $labels[] = "Week " . Carbon::now()->subWeeks($i)->weekOfYear;
            $borrowingData[] = $count;
        }

        return view('dashboard', compact('totalMembers', 'totalBooks', 'totalBorrowings', 'labels', 'borrowingData'));
    }
}
