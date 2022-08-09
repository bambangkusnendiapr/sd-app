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

class PsikologData extends Component
{
    public $studentId;
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

    public function mount($id)
    {
        $this->search = request()->query('search', $this->search);
        $student = Student::find($id);
        if($student == null) {
            Alert::error('Failed', 'Data Tidak Ditemukan');
            return redirect()->route('student');
        } 
        $this->studentId = $id;
    }

    public function render()
    {
        return view('livewire.psikolog-data', [
            'psychologist' => Psychologist::where('student_id', $this->studentId)->where('is_deleted', false)->paginate($this->paginate),
            'student' => Student::find($this->studentId)
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
            'iq' => 'required|max:255',
            'kemandirian' => 'required',
            'kemampuanBekerja' => 'required',
            'penyesuaianDiri' => 'required',
        ])->validate();

        DB::beginTransaction();

        try {
            $data = new Psychologist;
            $data->tanggal = $this->state['tanggal'];
            $data->student_id = $this->studentId;
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
            return redirect()->route('psikolog.data', $this->studentId);
        }
    }

    public function edit($id)
    {
        $this->form = 'edit';
        $this->idEdit = $id;
        $data = Psychologist::find($this->idEdit);
        $this->state['tanggal'] = $data->tanggal;
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
            'iq' => 'required|max:255',
            'kemandirian' => 'required',
            'kemampuanBekerja' => 'required',
            'penyesuaianDiri' => 'required',
        ])->validate();

        
        DB::beginTransaction();
        
        try {
            $data = Psychologist::find($this->idEdit);
            $data->tanggal = $this->state['tanggal'];
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
            return redirect()->route('psikolog.data', $this->studentId);
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
            return redirect()->route('psikolog.data', $this->studentId);
        }
        
    }

    private function resetInput()
    {
        $this->state = null;
    }
}
