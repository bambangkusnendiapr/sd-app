<?php

namespace App\Http\Livewire\Master;

use Livewire\Component;
use App\Models\Menu;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Exception;
use RealRashid\SweetAlert\Facades\Alert;

class DataMenus extends Component
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
        return view('livewire.master.data-menus', [
            'menus' => Menu::where('name', 'like', '%'.$this->search.'%')->paginate($this->paginate)
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
            'name' => 'required|max:50|unique:menus,name|',
            'desc' => 'required|max:255',
        ])->validate();

        DB::beginTransaction();

        try {
            $data = new Menu;
            $data->name = $this->state['name'];
            $data->description = $this->state['desc'];
            $data->save();

            DB::commit();

            $this->resetInput();

            $this->dispatchBrowserEvent('hide-form');
        } catch (Exception $e) {
            DB::rollBack();
            Alert::error('Failed', $e);
            return redirect()->route('menus');
        }
    }

    public function edit($id)
    {
        $this->form = 'edit';
        $this->idEdit = $id;
        $data = Menu::find($this->idEdit);
        $this->state['name'] = $data->name;
        $this->state['desc'] = $data->description;

        $this->dispatchBrowserEvent('show-form');
    }

    public function updateData()
    {
        Validator::make($this->state, [
            'name' => 'required|max:50',
            'desc' => 'required|max:255',
        ])->validate();

        $data = Menu::find($this->idEdit);

        if($data->name != $this->state['name']) {
            Validator::make($this->state, [
                'name' => 'unique:menus,name',
            ])->validate();
        }

        DB::beginTransaction();

        try {
            $data->name = $this->state['name'];
            $data->description = $this->state['desc'];
            $data->save();

            DB::commit();

            $this->resetInput();

            $this->dispatchBrowserEvent('hide-form-edit');
        } catch (Exception $e) {
            DB::rollBack();
            Alert::error('Failed', $e);
            return redirect()->route('menus');
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
            $data = Menu::findOrFail($this->idHapus);

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
