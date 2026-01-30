<?php

namespace App\Filament\Pages;

use App\Models\Attendance;
use Filament\Facades\Filament;
use Filament\Pages\Page;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;

class AttendanceForm extends Page implements HasTable
{
    use InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-check-badge';

    protected static string $view = 'filament.pages.attendance-form';

    protected static ?string $navigationLabel ='Paid Beneficiary List';

    public function getTitle(): string
    {
        return 'List of Paid Beneficiaries';
    }

        public function getTitle(): string
    {
        return 'List of Attendee';
    }

    public function table(Table $table): Table
    {
        return $table
        ->query(
            Attendance::query()
                ->with('beneficiary')
                ->when(
                    !Filament::auth()->user()->is_admin && !Filament::auth()->user()->is_lgu,
                    fn($query) => $query->where('ml_user', Filament::auth()->id()) // Filament::auth()->id())
                )
                ->selectRaw('ROW_NUMBER() OVER (ORDER BY id) as row_number, attendances.*')
        )



        ->columns([
            TextColumn::make('row_number')->label('No.'),
            TextColumn::make('first_name')->label('First Name')->searchable(),
            TextColumn::make('middle_name')->label('Middle Name')->searchable(),
            TextColumn::make('last_name')->label('Last Name')->searchable(),
            TextColumn::make('status')
            ->label('Status')
            ->getStateUsing(fn ($record) => match (true) {
                $record->is_hired === 'hired' => 'Hired',
                $record->w_listed === 'yes' => 'Waitlisted',
                default => 'On Queue',
            })
            ->color(fn ($state) => match ($state) {
                'Hired' => 'success',
                'Waitlisted' => 'warning',
                'On Queue' => 'danger',
            })
            ->tooltip(fn ($record) => match (true) {
                $record->is_hired === 'hired' => 'This beneficiary is officially hired.',
                $record->w_listed === 'yes' => 'This beneficiary is on the waiting list.',
                default => 'This beneficiary is on queue.',
            })
            ->searchable(),
            ImageColumn::make('image')
            ->label('Image')
            ->getStateUsing(fn ($record) => asset("storage/{$record->image}"))
            ->width(150)
            ->height(100)

        ]);
    }
}
