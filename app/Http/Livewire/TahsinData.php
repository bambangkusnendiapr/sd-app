<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Tahsin;
use App\Models\Student;
use App\Models\Surat;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Exception;
use RealRashid\SweetAlert\Facades\Alert;

class TahsinData extends Component
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
        return view('livewire.tahsin-data', [
            'tahsin' => Tahsin::where('student_id', $this->studentId)->where('is_deleted', false)->paginate($this->paginate),
            'student' => Student::find($this->studentId),
            'surat' => Surat::all()
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
            'jilid' => 'required|max:255',
            'halaman' => 'required|max:255',
            'murajaah' => 'required|max:255',
            'ziyadah' => 'required|max:255',
            'nilai' => 'required|max:255',
            'ket' => 'required|max:255',
        ])->validate();

        DB::beginTransaction();

        try {
            $data = new Tahsin;
            $data->tanggal = $this->state['tanggal'];
            $data->student_id = $this->studentId;
            $data->jilid = $this->state['jilid'];
            $data->halaman = $this->state['halaman'];
            $data->murajaah = $this->state['murajaah'];
            $data->ziyadah = $this->state['ziyadah'];
            $data->nilai = $this->state['nilai'];
            $data->ket = $this->state['ket'];
            $data->save();

            DB::commit();

            $this->resetInput();

            $this->dispatchBrowserEvent('hide-form');
        } catch (Exception $e) {
            DB::rollBack();
            Alert::error('Failed', $e);
            return redirect()->route('tahsin', $this->studentId);
        }
    }

    public function edit($id)
    {
        $this->form = 'edit';
        $this->idEdit = $id;
        $data = Tahsin::find($this->idEdit);
        $this->state['tanggal'] = $data->tanggal;
        $this->state['jilid'] = $data->jilid;
        $this->state['halaman'] = $data->halaman;
        $this->state['murajaah'] = $data->murajaah;
        $this->state['ziyadah'] = $data->ziyadah;
        $this->state['nilai'] = $data->nilai;
        $this->state['ket'] = $data->ket;

        $this->dispatchBrowserEvent('show-form');
    }

    public function updateData()
    {
        Validator::make($this->state, [
            'tanggal' => 'required',
            'jilid' => 'required|max:255',
            'halaman' => 'required|max:255',
            'murajaah' => 'required|max:255',
            'ziyadah' => 'required|max:255',
            'nilai' => 'required|max:255',
            'ket' => 'required|max:255',
        ])->validate();

        
        DB::beginTransaction();
        
        try {
            $data = Tahsin::find($this->idEdit);
            $data->tanggal = $this->state['tanggal'];
            $data->jilid = $this->state['jilid'];
            $data->halaman = $this->state['halaman'];
            $data->murajaah = $this->state['murajaah'];
            $data->ziyadah = $this->state['ziyadah'];
            $data->nilai = $this->state['nilai'];
            $data->ket = $this->state['ket'];
            $data->save();

            DB::commit();

            $this->resetInput();

            $this->dispatchBrowserEvent('hide-form-edit');
        } catch (Exception $e) {
            DB::rollBack();
            Alert::error('Failed', $e);
            return redirect()->route('tahsin', $this->studentId);
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
            $data = Tahsin::findOrFail($this->idHapus);
            $data->is_deleted = true;
            $data->save();

            DB::commit();

            $this->dispatchBrowserEvent('hide-form-delete');
        } catch (Exception $e) {
            DB::rollBack();
            Alert::error('Failed', $e);
            return redirect()->route('tahsin', $this->studentId);
        }
        
    }

    private function resetInput()
    {
        $this->state = null;
    }
}
