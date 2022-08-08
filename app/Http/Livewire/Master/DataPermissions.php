<?php

namespace App\Http\Livewire\Master;

use Livewire\Component;
use App\Models\Permission;
use App\Models\Menu;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Exception;
use RealRashid\SweetAlert\Facades\Alert;

class DataPermissions extends Component
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
        return view('livewire.master.data-permissions', [
            'permissions' => Permission::where('display_name', 'like', '%'.$this->search.'%')->paginate($this->paginate),
            'menus' => Menu::all()
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
            'menu' => 'required',
            'name' => 'required|max:50|unique:roles,name|alpha_dash',
            'display' => 'required|max:50',
            'desc' => 'required|max:255',
        ])->validate();

        DB::beginTransaction();

        try {
            $permission = Permission::create([
                'name' => strtolower($this->state['name']),
                'display_name' => $this->state['display'],
                'description' => $this->state['desc'],
            ]);

            $permission->menus()->attach($this->state['menu']);

            DB::commit();

            $this->resetInput();

            $this->dispatchBrowserEvent('hide-form');
        } catch (Exception $e) {
            DB::rollBack();
            Alert::error('Failed', $e);
            return redirect()->route('permissions');
        }
    }

    public function edit($id)
    {
        $this->form = 'edit';
        $this->idEdit = $id;
        $data = Permission::find($this->idEdit);
        foreach ($data->menus as $menu) {
            $this->state['menu'] = $menu->id;
        }
        $this->state['name'] = $data->name;
        $this->state['display'] = $data->display_name;
        $this->state['desc'] = $data->description;

        $this->dispatchBrowserEvent('show-form');
    }

    public function updateData()
    {
        Validator::make($this->state, [
            'menu' => 'required',
            'name' => 'required|max:50|alpha_dash',
            'display' => 'required|max:50',
            'desc' => 'required|max:255',
        ])->validate();

        $data = Permission::find($this->idEdit);

        if($data->name != $this->state['name']) {
            Validator::make($this->state, [
                'name' => 'unique:roles,name',
            ])->validate();
        }

        DB::beginTransaction();

        try {
            $data->name = strtolower($this->state['name']);
            $data->display_name = $this->state['display'];
            $data->description = $this->state['desc'];

            $data->menus()->sync([$this->state['menu']]);

            $data->save();

            DB::commit();

            $this->resetInput();

            $this->dispatchBrowserEvent('hide-form-edit');
        } catch (Exception $e) {
            DB::rollBack();
            Alert::error('Failed', $e);
            return redirect()->route('permissions');
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
            $data = Permission::findOrFail($this->idHapus);

            foreach ($data->menus as $menu) {
                $data->menus()->detach($menu->id);
            }

            $data->delete();

            DB::commit();

            $this->dispatchBrowserEvent('hide-form-delete');
        } catch (Exception $e) {
            DB::rollBack();
            Alert::error('Failed', $e);
            return redirect()->route('permissions');
        }
        
    }

    private function resetInput()
    {
        $this->state = null;
    }
}
