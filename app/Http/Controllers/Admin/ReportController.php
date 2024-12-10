<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use Illuminate\Support\Facades\DB; 
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReportController extends Controller
{

    
    public function index()
    {

        // Doanh thu theo phương thức thanh toán
        $revenueByPaymentMethod = DB::table('orders')
        ->select('payment_method', DB::raw('SUM(total_amount) as total_revenue'))
        ->where('status', 'delivered') // Giữ trạng thái hoặc thay đổi theo yêu cầu
        ->groupBy('payment_method') // Nhóm theo phương thức thanh toán
        ->get();
        
        // Thống kê tổng doanh thu theo danh mục
        $categoryRevenue = DB::table('order_items')
            ->select('products.category_id', DB::raw('SUM(order_items.price * order_items.quantity) as total_amount'))
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.status', 'delivered')
            ->groupBy('products.category_id')
            ->get();

        // Tổng số đơn hàng
        $totalOrders = Order::count();

        // Tổng số khách hàng
        $totalCustomers = DB::table('users')->where('role', 'user')->count();

        // Doanh thu theo ngày
        $revenueByDate = DB::table('order_items')
            ->select(DB::raw('DATE(orders.created_at) as date, SUM(order_items.price * order_items.quantity) as total_amount'))
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.status', 'delivered')
            ->groupBy('date')
            ->get();

        // Doanh thu theo tháng
        $revenueByMonth = DB::table('order_items')
            ->select(DB::raw('MONTH(orders.created_at) as month, SUM(order_items.price * order_items.quantity) as total_amount'))
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.status', 'delivered')
            ->groupBy('month')
            ->get();

        // Doanh thu theo năm
        $revenueByYear = DB::table('order_items')
            ->select(DB::raw('YEAR(orders.created_at) as year, SUM(order_items.price * order_items.quantity) as total_amount'))
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.status', 'delivered')
            ->groupBy('year')
            ->get();

            return view('admin.reports.index', compact('categoryRevenue', 'totalOrders', 'totalCustomers', 'revenueByDate', 'revenueByMonth', 'revenueByYear', 'revenueByPaymentMethod'));

    }
}
