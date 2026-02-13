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

    protected static ?string $navigationIcon = 'heroicon-o-arrow-right-end-on-rectangle';

    protected static string $view = 'filament.pages.attendance-form';

    protected static ?string $navigationLabel ='Attendance List';


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
            TextColumn::make('full_name')
                ->label('Full Name')
                ->getStateUsing(function ($record) {
                    $middle = $record->middle_name ? ' ' . $record->middle_name : '';
                    return "{$record->first_name}{$middle} {$record->last_name}";
                })
                ->searchable(['first_name', 'middle_name', 'last_name']),
            TextColumn::make('division')->label('Division')->searchable(),
            TextColumn::make('race_category')->label('Category'),
            TextColumn::make('time_in')->label('Time In'),
            ImageColumn::make('image')
            ->label('MOVs')
            ->getStateUsing(fn ($record) => $record->image ? asset("storage/{$record->image}") : null)
            ->width(150)
            ->height(100)
        ]);
    }
}





















            // TextColumn::make('status')
            // ->label('Status')
            // ->getStateUsing(fn ($record) => match (true) {
            //     $record->is_hired === 'hired' => 'Hired',
            //     $record->w_listed === 'yes' => 'Waitlisted',
            //     default => 'On Queue',
            // })
            // ->color(fn ($state) => match ($state) {
            //     'Hired' => 'success',
            //     'Waitlisted' => 'warning',
            //     'On Queue' => 'danger',
            // })
            // ->tooltip(fn ($record) => match (true) {
            //     $record->is_hired === 'hired' => 'This beneficiary is officially hired.',
            //     $record->w_listed === 'yes' => 'This beneficiary is on the waiting list.',
            //     default => 'This beneficiary is on queue.',
            // })
            // ->searchable(),
