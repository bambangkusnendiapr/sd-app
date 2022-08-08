<?php

namespace App\Http\Livewire\Master;

use Livewire\Component;
use App\Models\User;
use App\Models\Role;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Exception;
use RealRashid\SweetAlert\Facades\Alert;

class DataUsers extends Component
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
        return view('livewire.master.data-users', [
            'users' => User::where('name', 'like', '%'.$this->search.'%')->paginate($this->paginate),
            'roles' => Role::all()
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
            'role' => ['required'],
            'name' => ['required', 'string', 'max:255'],
            'username' => 'required|max:50|unique:users,username|alpha_dash',
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ])->validate();

        DB::beginTransaction();

        try {

            $user = User::create([
                'name' => $this->state['name'],
                'username' => strtolower($this->state['username']),
                'email' => $this->state['email'],
                'password' => bcrypt($this->state['password']),
            ]);

            $role = Role::find($this->state['role']);

            $user->attachRole($role->name);

            DB::commit();

            $this->resetInput();

            $this->dispatchBrowserEvent('hide-form');
        } catch (Exception $e) {
            DB::rollBack();
            Alert::error('Failed', $e);
            return redirect()->route('users');
        }
    }

    public function edit($id)
    {
        $this->form = 'edit';
        $this->idEdit = $id;
        $data = User::find($this->idEdit);
        $roleData;
        foreach($data->roles as $role) {
            $roleData = $role->id;
        }
        $this->state['role'] = $roleData;
        $this->state['name'] = $data->name;
        $this->state['username'] = $data->username;
        $this->state['email'] = $data->email;
        $this->state['password'] = null;

        $this->dispatchBrowserEvent('show-form');
    }

    public function updateData()
    {
        Validator::make($this->state, [
            'role' => ['required'],
            'name' => ['required', 'string', 'max:255'],
            'username' => 'required|max:50|alpha_dash',
            'email' => ['required', 'string', 'email', 'max:255'],
        ])->validate();

        $data = User::find($this->idEdit);

        if($data->username != $this->state['username']) {
            Validator::make($this->state, [
                'username' => 'unique:users,username',
            ])->validate();
        }

        if($data->email != $this->state['email']) {
            Validator::make($this->state, [
                'email' => ['unique:users'],
            ])->validate();
        }

        if($this->state['password'] != null) {
            Validator::make($this->state, [
                'password' => ['required', 'string', 'min:8', 'confirmed'],
            ])->validate();

            $data->password = bcrypt($this->state['password']);
        }

        DB::beginTransaction();

        try {
            $data->name = $this->state['name'];
            $data->username = $this->state['username'];
            $data->email = $this->state['email'];
            $data->save();

            $role = Role::find($this->state['role']);

            $data->syncRoles([$role->id]);

            DB::commit();

            $this->resetInput();

            $this->dispatchBrowserEvent('hide-form-edit');
        } catch (Exception $e) {
            DB::rollBack();
            Alert::error('Failed', $e);
            return redirect()->route('users');
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
            $data = User::findOrFail($this->idHapus);

            foreach ($data->roles as $role) {
                $data->detachRole($role->name);
            }

            $data->delete();

            DB::commit();

            $this->dispatchBrowserEvent('hide-form-delete');
        } catch (Exception $e) {
            DB::rollBack();
            Alert::error('Failed', $e);
            return redirect()->route('users');
        }
        
    }

    private function resetInput()
    {
        $this->state = null;
    }
}
