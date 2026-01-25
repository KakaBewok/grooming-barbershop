<?php

namespace App\Filament\Widgets;

use App\Enums\OrderStatus;
use App\Models\Order;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class DashboardStatsWidget extends StatsOverviewWidget
{
    protected function getStats(): array
    {
          $today = now()->startOfDay();
        $thisMonth = now()->startOfMonth();

        // Today's stats
        $todayRevenue = Order::whereDate('order_date', $today)
            ->whereIn('status', [OrderStatus::PAID, OrderStatus::COMPLETED])
            ->sum('total_amount');

        $todayOrders = Order::whereDate('order_date', $today)->count();

        $todayPaidOrders = Order::whereDate('order_date', $today)
            ->whereIn('status', [OrderStatus::PAID, OrderStatus::COMPLETED])
            ->count();

        $todayPendingOrders = Order::whereDate('order_date', $today)
            ->where('status', OrderStatus::PENDING)
            ->count();

        // Month stats
        $monthRevenue = Order::whereDate('order_date', '>=', $thisMonth)
            ->whereIn('status', [OrderStatus::PAID, OrderStatus::COMPLETED])
            ->sum('total_amount');

        $monthOrders = Order::whereDate('order_date', '>=', $thisMonth)->count();

        // Yesterday's revenue for comparison
        $yesterday = now()->subDay()->startOfDay();
        $yesterdayRevenue = Order::whereDate('order_date', $yesterday)
            ->whereIn('status', [OrderStatus::PAID, OrderStatus::COMPLETED])
            ->sum('total_amount');

        // Calculate percentage change
        $revenueChange = 0;
        if ($yesterdayRevenue > 0) {
            $revenueChange = (($todayRevenue - $yesterdayRevenue) / $yesterdayRevenue) * 100;
        }

        return [
            Stat::make('Today\'s Revenue', 'Rp ' . number_format($todayRevenue, 0, ',', '.'))
                ->description($revenueChange > 0 ? '+' . number_format($revenueChange, 1) . '% from yesterday' : number_format($revenueChange, 1) . '% from yesterday')
                ->descriptionIcon($revenueChange >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->color($revenueChange >= 0 ? 'success' : 'danger')
                ->chart([7, 4, 8, 5, 10, 7, 9]),

            Stat::make('Today\'s Orders', $todayOrders)
                ->description("{$todayPaidOrders} paid, {$todayPendingOrders} pending")
                ->descriptionIcon('heroicon-o-shopping-cart')
                ->color('info')
                ->chart([3, 5, 4, 7, 5, 8, 6]),

            Stat::make('Monthly Revenue', 'Rp ' . number_format($monthRevenue, 0, ',', '.'))
                ->description("{$monthOrders} orders this month")
                ->descriptionIcon('heroicon-o-currency-dollar')
                ->color('success')
                ->chart([15, 20, 18, 25, 22, 30, 28]),
        ];
    }
}
