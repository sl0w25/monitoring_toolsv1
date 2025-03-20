<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\Beneficiary;
use App\Models\User;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationGroup = 'User Management';

    protected static ?int $navigationSort = 4;


    // public static function getNavigationBadge(): ?string
    // {
    //     return static::getModel()::query()->when(
    //         !Filament::auth()->user()?->is_admin,
    //         fn ($query) => $query
    //             ->where('province', Filament::auth()->user()->province)
    //             ->where('municipality', Filament::auth()->user()->municipality)
    //             ->where('is_lgu', Filament::auth()->user()?->is_lgu ? false : true)
    //             ->where('is_approved', Filament::auth()->user()?->is_approved ? false : true)
    //             )
    //             ->when(
    //                 Filament::auth()->user()?->is_admin,
    //                 fn ($query) => $query
    //                     ->where('province', Filament::auth()->user()->province)
    //                     ->where('municipality', Filament::auth()->user()->municipality)
    //                     ->where('is_lgu', Filament::auth()->user()?->is_lgu ? false : true)
    //                     ->where('is_approved', false)
    //             )
    //             ->count();
    // }

    // public static function getNavigationBadgeColor(): ?string
    // {
    //     return static::getModel()::query()->when(
    //         !Filament::auth()->user()?->is_admin,
    //         fn ($query) => $query
    //             ->where('province', Filament::auth()->user()->province)
    //             ->where('municipality', Filament::auth()->user()->municipality)
    //             ->where('is_lgu', Filament::auth()->user()?->is_lgu ? false : true)
    //             ->where('is_approved', Filament::auth()->user()?->is_approved ? false : true)
    //     )->count() > 0 ? 'warning' : 'primary';
    // }


    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            TextInput::make('name')->required(),
            TextInput::make('email')->required()->email(),
            Toggle::make('is_approved')->label('Approve User')
            ->helperText('Enable to grant user access.'),
            Toggle::make('swad_admin')
            ->label('Swad Admin')
            ->visible(fn (): bool => Auth::check() && Auth::user()->isAdmin())
            ->helperText('Enable to grant admin privileges.'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table

        ->query(
            User::when(
                !Filament::auth()->user()?->is_admin,
                fn ($query) => $query
                    ->where('province', Filament::auth()->user()->province)
                    ->where('municipality', Filament::auth()->user()->municipality)
                    ->where('is_lgu', Filament::auth()->user()?->is_lgu ? false : true)
            )
        )
            ->columns([
                TextColumn::make('name')->sortable(),
                TextColumn::make('location')
                    ->label('Location')
                    ->getStateUsing(fn ($record) => "{$record->province}, {$record->municipality}, {$record->barangay}")
                    ->sortable()
                    ->wrap(),
                // TextColumn::make('contact'),
                TextColumn::make('email')->sortable(),
                TextColumn::make('validated_count')
                ->label('Validated Count')
                ->getStateUsing(fn ($record) => Beneficiary::where('validated_by', $record->id)->count())
                ->searchable(),


                BooleanColumn::make('is_approved')->label('Approved'),

                BooleanColumn::make('is_lgu')->label('Swad Admin')
                ->visible(fn (): bool => Auth::check() && Auth::user()->isAdmin()),
            ])
            ->defaultPaginationPageOption(10) // Show more records per page
            ->striped() // Adds zebra-striping for better readability

            ->filters([
                SelectFilter::make('is_approved')
                    ->options([
                        '1' => 'Approved',
                        '0' => 'Pending',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkAction::make('Approve Selected')
                    ->action(fn (array $records) => User::whereIn('id', $records)->update(['is_approved' => true])),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
