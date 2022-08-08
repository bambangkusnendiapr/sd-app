<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Psychologist;
use App\Models\Student;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Exception;
use RealRashid\SweetAlert\Facades\Alert;

class PsychologistData extends Component
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
        $student = Student::where('nama', 'like', '%'.$this->search.'%')->get('id');

        return view('livewire.psychologist-data', [
            'psychologist' => Psychologist::whereIn('student_id', $student)->where('is_deleted', false)->paginate($this->paginate),
            'students' => Student::all()
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
            'tanggal' => 'required',
            'nama' => 'required',
            'iq' => 'required|max:255',
            'kemandirian' => 'required',
            'kemampuanBekerja' => 'required',
            'penyesuaianDiri' => 'required',
        ])->validate();

        DB::beginTransaction();

        try {
            $data = new Psychologist;
            $data->tanggal = $this->state['tanggal'];
            $data->student_id = $this->state['nama'];
            $data->iq = $this->state['iq'];
            $data->kemandirian = $this->state['kemandirian'];
            $data->kemampuan_bekerja = $this->state['kemampuanBekerja'];
            $data->penyesuaian_diri = $this->state['penyesuaianDiri'];
            $data->save();

            DB::commit();

            $this->resetInput();

            $this->dispatchBrowserEvent('hide-form');
        } catch (Exception $e) {
            DB::rollBack();
            Alert::error('Failed', $e);
            return redirect()->route('psikolog');
        }
    }

    public function edit($id)
    {
        $this->form = 'edit';
        $this->idEdit = $id;
        $data = Psychologist::find($this->idEdit);
        $this->state['tanggal'] = $data->tanggal;
        $this->state['nama'] = $data->student_id;
        $this->state['iq'] = $data->iq;
        $this->state['kemandirian'] = $data->kemandirian;
        $this->state['kemampuanBekerja'] = $data->kemampuan_bekerja;
        $this->state['penyesuaianDiri'] = $data->penyesuaian_diri;

        $this->dispatchBrowserEvent('show-form');
    }

    public function updateData()
    {
        Validator::make($this->state, [
            'tanggal' => 'required',
            'nama' => 'required',
            'iq' => 'required|max:255',
            'kemandirian' => 'required',
            'kemampuanBekerja' => 'required',
            'penyesuaianDiri' => 'required',
        ])->validate();

        
        DB::beginTransaction();
        
        try {
            $data = Psychologist::find($this->idEdit);
            $data->tanggal = $this->state['tanggal'];
            $data->student_id = $this->state['nama'];
            $data->iq = $this->state['iq'];
            $data->kemandirian = $this->state['kemandirian'];
            $data->kemampuan_bekerja = $this->state['kemampuanBekerja'];
            $data->penyesuaian_diri = $this->state['penyesuaianDiri'];
            $data->save();

            DB::commit();

            $this->resetInput();

            $this->dispatchBrowserEvent('hide-form-edit');
        } catch (Exception $e) {
            DB::rollBack();
            Alert::error('Failed', $e);
            return redirect()->route('psikolog');
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
            $data = Psychologist::findOrFail($this->idHapus);

            $data->delete();

            DB::commit();

            $this->dispatchBrowserEvent('hide-form-delete');
        } catch (Exception $e) {
            DB::rollBack();
            Alert::error('Failed', $e);
            return redirect()->route('menus');
        }
        
    }

    private function resetInput()
    {
        $this->state = null;
    }
}
