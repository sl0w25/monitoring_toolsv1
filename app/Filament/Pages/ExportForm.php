<?php

namespace App\Filament\Pages;

use App\Models\Beneficiary;
use Filament\Actions\Concerns\HasAction;
use Filament\Facades\Filament;
use Filament\Pages\Page;
use Filament\Tables\Actions\Action;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ExportForm extends Page
{

    use HasAction; // This enables Livewire actions

    protected static ?string $navigationIcon = 'heroicon-o-table-cells';

    protected static string $view = 'filament.pages.export-form';

    protected static ?string $navigationGroup = 'Database Management';

    protected static ?string $navigationLabel = 'Export Beneficiaries';

    protected static ?int $navigationSort = 5;

    public static function canAccess(): bool
    {
        if(!Filament::auth()->user()->is_admin){
            return false;
        }

        else{

        return true;
         }
    }


        public function downloadTemplate()
        {
            $filePath = 'csvfiles/template.csv'; // Update the filename if needed

            if (!Storage::exists($filePath)) {
                abort(404, 'Template file not found.');
            }

            return Storage::download($filePath);
        }


}
