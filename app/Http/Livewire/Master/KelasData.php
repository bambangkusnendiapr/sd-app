<?php

namespace App\Http\Livewire\Master;

use Livewire\Component;
use App\Models\Kelas;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Exception;
use RealRashid\SweetAlert\Facades\Alert;

class KelasData extends Component
{
    public $state = [];
    public $idHapus = null;
    public $idEdit = null;
    public $form = null;

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
        return view('livewire.master.kelas-data', [
            'kelas' => Kelas::where('nama', 'like', '%'.$this->search.'%')->where('is_deleted', false)->paginate($this->paginate)
        ]);
    }

    public function addNew()
    {
        $this->resetInput();
        $this->form = 'tambah';
        $this->dispatchBrowserEvent('show-form');
    }

    public function createData()
    {
        Validator::make($this->state, [
            'nama' => 'required|max:50|unique:kelas,nama|',
            'ket' => 'required|max:255',
        ])->validate();

        DB::beginTransaction();

        try {
            $data = new Kelas;
            $data->nama = $this->state['nama'];
            $data->ket = $this->state['ket'];
            $data->save();

            DB::commit();

            $this->resetInput();

            $this->dispatchBrowserEvent('hide-form');
        } catch (Exception $e) {
            DB::rollBack();
            Alert::error('Failed', $e);
            return redirect()->route('kelas');
        }
    }

    public function edit($id)
    {
        $this->form = 'edit';
        $this->idEdit = $id;
        $data = Kelas::find($this->idEdit);
        $this->state['nama'] = $data->nama;
        $this->state['ket'] = $data->ket;

        $this->dispatchBrowserEvent('show-form');
    }

    public function updateData()
    {
        Validator::make($this->state, [
            'nama' => 'required|max:50',
            'ket' => 'required|max:255',
        ])->validate();

        $data = Kelas::find($this->idEdit);

        if($data->nama != $this->state['nama']) {
            Validator::make($this->state, [
                'nama' => 'unique:kelas,nama',
            ])->validate();
        }

        DB::beginTransaction();

        try {
            $data->nama = $this->state['nama'];
            $data->ket = $this->state['ket'];
            $data->save();

            DB::commit();

            $this->resetInput();

            $this->dispatchBrowserEvent('hide-form-edit');
        } catch (Exception $e) {
            DB::rollBack();
            Alert::error('Failed', $e);
            return redirect()->route('kelas');
        }
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
            $data = Kelas::findOrFail($this->idHapus);

            $data->is_deleted = true;

            $data->save();

            DB::commit();

            $this->dispatchBrowserEvent('hide-form-delete');
        } catch (Exception $e) {
            DB::rollBack();
            Alert::error('Failed', $e);
            return redirect()->route('kelas');
        }
        
    }

    private function resetInput()
    {
        $this->state = null;
    }
}
