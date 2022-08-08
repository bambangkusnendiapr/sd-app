<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Student;
use App\Models\User;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Exception;
use RealRashid\SweetAlert\Facades\Alert;
use File;

class StudentData extends Component
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
        return view('livewire.student-data', [
            'students' => Student::where('nama', 'like', '%'.$this->search.'%')->where('is_deleted', false)->paginate($this->paginate)
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
            $data = Student::findOrFail($this->idHapus);

            $local_gambar = "images/siswa/".$data->gambar;
            if(File::exists($local_gambar))
            {
                File::delete($local_gambar);
            }

            $user = User::find($data->user_id);

            $user->detachRole('siswa');

            $user->delete();

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
