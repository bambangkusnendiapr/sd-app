<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Exception;
use Illuminate\Support\Facades\DB;
use Alert;
use App\Models\user;

class ProfileData extends Component
{
    public $state = [];
    public $nama;
    public $guruId;
    public $siswaId;
    public $ortuId;
    public $nis;
    public $kode;
    public $kelas;
    public $jurusan;

    public function render()
    {
        $user = User::find(Auth::user()->id);
        $this->nama = $user->name;
        $this->state["nama"] = $user->name;
        $this->state["email"] = $user->email;
        $this->state["username"] = $user->username;

        return view('livewire.profile-data');
    }

    public function updateProfile()
    {
        $user = User::find(Auth::user()->id);

        if($this->state['email'] != $user->email) {
            Validator::make($this->state, [
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            ])->validate();

            $user->email = $this->state['email'];
        }

        if($this->state['username'] != $user->username) {
            Validator::make($this->state, [
                'username' => ['required', 'string', 'max:255', 'unique:users', 'alpha_dash'],
            ])->validate();

            $user->username = $this->state['username'];
        }

        Validator::make($this->state, [
            'nama' => 'required|max:100',
        ])->validate();

        DB::beginTransaction();

        try {

            $user->name = $this->state['nama'];
            $user->save();

            DB::commit();
            $this->dispatchBrowserEvent('update-profile');
        } catch (Exception $e) {
            DB::rollBack();
            Alert::error('Error', $e->getMessage());
            return redirect()->route('profile');
        }
    }

    public function formPassword()
    {
        $this->state['password'] = null;
        $this->state['password_confirmation'] = null;
        $this->dispatchBrowserEvent('show-form');
    }

    public function updatePassword()
    {
        Validator::make($this->state, [
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ])->validate();

        DB::beginTransaction();

        try {
            $user = User::find(Auth::user()->id);
            $user->password = bcrypt($this->state['password']);
            $user->save();
            DB::commit();
            $this->dispatchBrowserEvent('update-password');
        } catch (Exception $e) {
            DB::rollBack();
            Alert::error('Error', $e->getMessage());
            return redirect()->route('profile');
        }
    }
}
