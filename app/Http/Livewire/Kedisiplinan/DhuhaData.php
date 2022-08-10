<?php

namespace App\Http\Livewire\Kedisiplinan;

use Livewire\Component;
use App\Models\Dhuha;
use App\Models\DhuhaDetail;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Exception;
use RealRashid\SweetAlert\Facades\Alert;

class DhuhaData extends Component
{
    public $idHapus = null;

    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $paginate = 10;
    public $foo;
    public $search = '';
    public $page = 1;

    protected $queryString = [
        'foo',
        'search' => ['except' => ''],
        'page' => ['except' => 1],
    ];

    public function mount()
    {
        $this->search = request()->query('search', $this->search);
    }

    public function render()
    {
        return view('livewire.kedisiplinan.dhuha-data', [
            'dhuha' => Dhuha::paginate($this->paginate)
        ]);
    }

    public function delete($id)
    {
        $this->idHapus = $id;

        $this->dispatchBrowserEvent('show-form-delete');
    }

    public function deleteData()
    {
        DB::beginTransaction();
        try {
            $dhuha = Dhuha::findOrFail($this->idHapus);
            $dhuha->delete();

            $dhuhaDetail = DhuhaDetail::where('dhuha_id', $this->idHapus)->delete();

            DB::commit();

            $this->dispatchBrowserEvent('hide-form-delete');
        } catch (Exception $e) {
            DB::rollBack();
            Alert::error('Failed', $e);
            return redirect()->route('dhuha');
        }
        
    }

    private function resetInput()
    {
        $this->state = null;
    }
}
