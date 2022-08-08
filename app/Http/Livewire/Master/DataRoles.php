<?php

namespace App\Http\Livewire\Master;

use Livewire\Component;
use App\Models\Role;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Exception;
use RealRashid\SweetAlert\Facades\Alert;

class DataRoles extends Component
{
    public $state = [];
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
        return view('livewire.master.data-roles', [
            'roles' => Role::where('display_name', 'like', '%'.$this->search.'%')->paginate($this->paginate)
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
            $data = Role::findOrFail($this->idHapus);

            foreach($data->permissions as $permission) {
                $data->detachPermission($permission->name);
            }

            $data->delete();

            DB::commit();

            $this->dispatchBrowserEvent('hide-form-delete');
        } catch (Exception $e) {
            DB::rollBack();
            Alert::error('Failed', $e);
            return redirect()->route('roles');
        }
        
    }

    private function resetInput()
    {
        $this->state = null;
    }
}
