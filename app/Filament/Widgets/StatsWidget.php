<?php

namespace App\Filament\Widgets;

use App\Models\Attendance;
use App\Models\Beneficiary;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Database\Eloquent\Builder;

class StatsWidget extends BaseWidget
{

    protected function getStats(): array
    {
        $startDate = $this->filters['startDate'] ?? null;
        $endDate = $this->filters['endDate'] ?? null;
        $status = $this->filters['status'] ?? null;


        $totalEmployee = Beneficiary::query()
            ->when($startDate, fn (Builder $query) => $query->whereDate('created_at', '>=', $startDate))
            ->when($endDate, fn (Builder $query) => $query->whereDate('created_at', '<=', $endDate))
            ->count();


        $totalTransaction = Attendance::where('is_hired', "hired")
            ->when($startDate, fn (Builder $query) => $query->whereDate('created_at', '>=', $startDate))
            ->when($endDate, fn (Builder $query) => $query->whereDate('created_at', '<=', $endDate))
            ->count();

            $totalAttendee = Attendance::query()
            ->when($startDate, fn (Builder $query) => $query->whereDate('created_at', '>=', $startDate))
            ->when($endDate, fn (Builder $query) => $query->whereDate('created_at', '<=', $endDate))
            ->count();

        $percentage = $totalTransaction / $totalAttendee * 100;

        $formattedAverage = number_format($percentage, 2);


        return [


            Stat::make(
                label: 'Total Attendee',
                value: $totalAttendee
            ),



            Stat::make(
                label: 'Total Hired',
                value: $formattedAverage.'%'
            ),

            // Stat::make(
            //     label: 'On-Time Submitted Bids (%)',
            //     value: $onTimePercentage . '%'
            // ),
        ];
    }
}
