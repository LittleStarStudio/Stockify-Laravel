<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use App\Models\StockTransaction;
use App\Models\Category;
use App\Models\StockOpname;

use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        return match (auth()->user()->role) {
            'admin'           => redirect()->route('dashboard.admin'),
            'manajer_gudang'  => redirect()->route('dashboard.manager'),
            'staff_gudang'    => redirect()->route('dashboard.staff'),
            default           => abort(403),
        };
    }

    public function admin()
    {
        // Total produk
        $totalProducts = Product::count();

        // Total user aktif
        $totalUsers = User::where('approval_status','active')->count();

        // Stok real per produk
        $stocks = StockTransaction::select(
            'product_id',
            DB::raw("SUM(CASE WHEN type='IN' THEN quantity ELSE -quantity END) as stock")
        )->groupBy('product_id');

        // Produk stok menipis
        $lowStock = Product::leftJoinSub($stocks,'s','products.id','=','s.product_id')
            ->whereRaw('COALESCE(s.stock,0) <= products.minimum_stock')
            ->count();

        // Transaksi bulan ini
        $transactionsThisMonth = StockTransaction::whereMonth('date', now()->month)->count();

        // Produk per kategori
        $stockByCategory = Category::withCount('products')
            ->orderByDesc('products_count')
            ->take(8) 
            ->get();

        // Aktivitas terakhir
        $latestActivities = StockTransaction::with('user','product')
            ->latest()
            ->limit(5)
            ->get();

        // Status transaksi (untuk donut chart)
        $transactionStatus = StockTransaction::select(
                'status',
                DB::raw('COUNT(*) as total')
            )
            ->groupBy('status')
            ->get();

        return view('dashboard.admin', compact(
            'totalProducts',
            'totalUsers',
            'lowStock',
            'transactionsThisMonth',
            'stockByCategory',
            'latestActivities',
            'transactionStatus' // INI YANG TADI KURANG
        ));
    }

    public function manager()
    {
        // Stok real per produk
        $stocks = StockTransaction::select(
            'product_id',
            DB::raw("SUM(CASE WHEN type='IN' THEN quantity ELSE -quantity END) as stock")
        )->groupBy('product_id');

        // Produk stok menipis
        $lowStockProducts = Product::leftJoinSub($stocks,'s','products.id','=','s.product_id')
            ->whereRaw('COALESCE(s.stock,0) <= products.minimum_stock')
            ->select('products.*','s.stock')
            ->limit(5)
            ->get();

        // Barang masuk hari ini
        $incomingToday = StockTransaction::whereDate('date', now())
            ->where('type','IN')
            ->count();

        // Barang keluar hari ini
        $outgoingToday = StockTransaction::whereDate('date', now())
            ->where('type','OUT')
            ->count();

        // Pending approval
        $pendingRequests = StockTransaction::where('status','PENDING')->count();

        // Aktivitas terakhir
        $latestActivities = StockTransaction::with('product','user')
            ->latest()
            ->limit(8)
            ->get();

        return view('dashboard.manager', compact(
            'lowStockProducts',
            'incomingToday',
            'outgoingToday',
            'pendingRequests',
            'latestActivities'
        ));
    }
    public function staff()
    {
        $userId = auth()->id();

        // Barang masuk pending
        $incomingTasks = StockTransaction::with('product')
            ->where('type','IN')
            ->where('status','PENDING')
            ->limit(5)
            ->get();

        // Barang keluar pending
        $outgoingTasks = StockTransaction::with('product')
            ->where('type','OUT')
            ->where('status','PENDING')
            ->limit(5)
            ->get();

        // Opname belum submit
        $pendingOpnames = StockOpname::where('staff_id',$userId)
            ->where('status','SUBMITTED')
            ->count();

        // Aktivitas staff sendiri
        $myActivities = StockTransaction::with('product')
            ->where('user_id',$userId)
            ->latest()
            ->limit(8)
            ->get();

        return view('dashboard.staff', compact(
            'incomingTasks',
            'outgoingTasks',
            'pendingOpnames',
            'myActivities'
        ));
    }

}
