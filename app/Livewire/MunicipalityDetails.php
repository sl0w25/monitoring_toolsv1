<?php

namespace App\Http\Livewire;

use App\Models\FamilyHead;
use App\Models\Municipality;
use Livewire\Component;
use Livewire\WithPagination;

class MunicipalityDetails extends Component
{
    use WithPagination;

    public $province;

    protected $paginationTheme = 'tailwind';

    public function mount($province)
    {
        $this->province = $province;
    }

    public function render()
    {
        return view('livewire.municipality-details', [
            'municipalities' => FamilyHead::where('province', $this->province)->paginate(5),
        ]);
    }
}
