<?php

namespace App\Http\Livewire\Kedisiplinan;

use Livewire\Component;
use App\Models\Fardhu;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Exception;
use RealRashid\SweetAlert\Facades\Alert;

class FardhuData extends Component
{
    public $idHapus = null;

    public $tanggal = null;

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
        $fardhu;
        if($this->tanggal != null) {
            $fardhu = Fardhu::where('sholat', 'like', '%'.$this->search.'%')->where('tanggal', $this->tanggal)->paginate($this->paginate);
        } else {
            $fardhu = Fardhu::where('sholat', 'like', '%'.$this->search.'%')->paginate($this->paginate);
        }
        return view('livewire.kedisiplinan.fardhu-data', [
            'fardhu' => $fardhu
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
            $fardhu = Fardhu::findOrFail($this->idHapus);
            $fardhu->students()->detach();
            $fardhu->delete();

            DB::commit();

            $this->dispatchBrowserEvent('hide-form-delete');
        } catch (Exception $e) {
            DB::rollBack();
            Alert::error('Failed', $e);
            return redirect()->route('fardhu');
        }
        
    }
}
