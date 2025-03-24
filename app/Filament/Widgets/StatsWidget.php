<?php

namespace App\Filament\Widgets;

use App\Models\Attendance;
use App\Models\Beneficiary;
use Filament\Forms\Components\Select;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Database\Eloquent\Builder;

class StatsWidget extends BaseWidget
{
    use InteractsWithPageFilters;

    protected function getFilters(): array
    {
        return [
            Select::make('province')
                ->label('Filter by Province')
                ->options(
                    Beneficiary::query()
                        ->whereNotNull('province')
                        ->distinct()
                        ->pluck('province', 'province') // 🔥 Fetch dynamic province list
                )
                ->searchable()
                ->preload()
                ->default(null)
                ->live(),
        ];
    }

    protected function getStats(): array
    {

        $province = $this->filters['province'] ?? null;

        $totalEmployee = Beneficiary::query()
            ->when($province, fn (Builder $query) => $query->where('province', $province))
            ->count();

        $totalTransaction = Attendance::where('is_hired', "hired")
            ->when($province, fn (Builder $query) => $query->whereHas('beneficiary', fn ($q) => $q->where('province', $province)))
            ->count();

        $totalWaitListed = Attendance::where('w_listed', "yes")
            ->when($province, fn (Builder $query) => $query->whereHas('beneficiary', fn ($q) => $q->where('province', $province)))
            ->count();

        $totalAttendee = Attendance::query()
            ->when($province, fn (Builder $query) => $query->whereHas('beneficiary', fn ($q) => $q->where('province', $province)))
            ->count();

        $percentage = $totalAttendee > 0 ? ($totalTransaction / $totalAttendee) * 100 : 0;
        $formattedAverage = number_format($percentage, 2);

        return [

            // Stat::make('Beneficiaries', number_format($totalEmployee))
            //     ->description('Total beneficiaries')
            //     ->color('success')
            //     ->icon('heroicon-o-users'),

            Stat::make('Attendees', number_format($totalAttendee). ' out of '.number_format($totalEmployee))
                ->description('Total registered beneficiaries')
                ->color('success')
                ->icon('heroicon-o-users'),

            Stat::make('Hired Beneficiaries', number_format($totalTransaction))
          //  Stat::make('Hired Beneficiaries', sprintf('%s or %s%%', number_format($totalTransaction), $formattedAverage))
                ->description('Total hired beneficiaries')
                ->color('success')
                ->icon('heroicon-o-users'),

            Stat::make('Wait Listed', number_format($totalWaitListed))
                ->description('Total wait listed beneficiaries')
                ->color('success')
                ->icon('heroicon-o-users'),
        ];
    }
}
