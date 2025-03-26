<?php

namespace App\Filament\Pages;

use App\Models\Beneficiary;
use Filament\Actions\Action;
use Filament\Pages\Page;

class QrGenerator extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.qr-generator';

    protected static ?string $navigationGroup = 'QR Code Management';

      public static function canAccess(): bool
    {
        return false; //Auth::user()?->isAdmin(); // Adjust as needed
    }

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }



}
