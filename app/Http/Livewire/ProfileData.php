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
        if(Auth::user()->hasRole('wali_kelas') || Auth::user()->hasRole('guru')) {
            $guru = Guru::where('user_id', auth()->user()->id)->first();
            $this->guruId = $guru->id;
            $this->kode = $guru->kode;
            $this->state["nip"] = $guru->nip;
            $this->state["statusPegawai"] = $guru->status_pegawai;
            $this->state["tempatLahir"] = $guru->tempat_lahir;
            $this->state["tglLahir"] = $guru->tgl_lahir;
            $this->state["jk"] = $guru->jk;
            $this->state["statusKawin"] = $guru->status_kawin;
            $this->state["agama"] = $guru->agama;
            $this->state["warganegara"] = $guru->warganegara;
            $this->state["hp"] = $guru->hp;
            $this->state["alamat"] = $guru->alamat;
        }

        if(Auth::user()->hasRole('siswa')) {
            $siswa = Siswa::where('user_id', auth()->user()->id)->first();
            $this->siswaId = $siswa->id;
            $this->nis = $siswa->nis;
            $this->jurusan = $siswa->jurusan->nama;
            $this->kelas = $siswa->kelas;
            $this->state['jurusan'] = $siswa->jurusan->nama;
            $this->state['tempatLahir'] = $siswa->tempat_lahir;
            $this->state['tglLahir'] = $siswa->tgl_lahir;
            $this->state['agama'] = $siswa->agama;
            $this->state['jk'] = $siswa->jk;
            $this->state['anakKe'] = $siswa->anak_ke;
            $this->state['alamat'] = $siswa->alamat;
            $this->state['hp'] = $siswa->hp;
            $this->state['sekolahAsal'] = $siswa->sekolah_asal;
            $this->state['tglDiterima'] = $siswa->tgl_diterima;
            $this->state['ayah'] = $siswa->ayah;
            $this->state['ibu'] = $siswa->ibu;
            $this->state['alamatOrtu'] = $siswa->alamat_ortu;
            $this->state['hpOrtu'] = $siswa->hp_ortu;
            $this->state['kerjaAyah'] = $siswa->kerja_ayah;
            $this->state['kerjaIbu'] = $siswa->kerja_ibu;
            $this->state['namaWali'] = $siswa->nama_wali;
            $this->state['alamatWali'] = $siswa->alamat_wali;
            $this->state['hpWali'] = $siswa->hp_wali;
            $this->state['kerjaWali'] = $siswa->kerja_wali;
        }

        $data = null;
        if(Auth::user()->hasRole('wali_siswa')) {
            $data = Ortu::where('user_id', Auth::user()->id)->first();
        }

        return view('livewire.profile-data', [
            'data' => $data
        ]);
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

        if(Auth::user()->hasRole('wali_kelas') || Auth::user()->hasRole('guru')) {
            Validator::make($this->state, [
                'nip' => 'max:20',
                'kode' => 'max:20',
                'statusPegawai' => 'max:50',
                'tempatLahir' => 'max:50',
                'jk' => 'required',
                'statusKawin' => 'max:50',
                'agama' => 'required',
                'warganegara' => 'max:50',
                'hp' => 'required|max:20',
                'alamat' => 'required|max:1000',
            ])->validate();
        }

        if(Auth::user()->hasRole('siswa')) {
            Validator::make($this->state, [
                'tempatLahir' => 'required|max:100',
                'tglLahir' => 'required',
                'agama' => 'required',
                'jk' => 'required',
                'anakKe' => 'required|max:10',
                'alamat' => 'required|max:1000',
                'hp' => 'required|max:20',
                'sekolahAsal' => 'required|max:100',
                'tglDiterima' => 'required',
            ])->validate();
        }

        Validator::make($this->state, [
            'nama' => 'required|max:100',
        ])->validate();

        DB::beginTransaction();

        try {
            $data;
            if(Auth::user()->hasRole('wali_kelas') || Auth::user()->hasRole('guru')) {
                $data = Guru::find($this->guruId);
                $data->nip = $this->state['nip'];
                $data->status_pegawai = $this->state['statusPegawai'];
                $data->tempat_lahir = $this->state['tempatLahir'];
                $data->tgl_lahir = $this->state['tglLahir'];
                $data->jk = $this->state['jk'];
                $data->status_kawin = $this->state['statusKawin'];
                $data->agama = $this->state['agama'];
                $data->hp = $this->state['hp'];
                $data->warganegara = $this->state['warganegara'];
                $data->alamat = $this->state['alamat'];
                $data->save();
            }

            if(Auth::user()->hasRole('siswa')) {
                $data = Siswa::find($this->siswaId);
                $data->tempat_lahir = $this->state['tempatLahir'];
                $data->tgl_lahir = $this->state['tglLahir'];
                $data->agama = $this->state['agama'];
                $data->jk = $this->state['jk'];
                $data->alamat = $this->state['alamat'];
                $data->hp = $this->state['hp'];
                $data->anak_ke = $this->state['anakKe'];
                $data->sekolah_asal = $this->state['sekolahAsal'];
                $data->tgl_diterima = $this->state['tglDiterima'];
                $data->save();
            }

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

    public function updateProfileOrtu()
    {
        Validator::make($this->state, [
            'ayah' => 'required|max:100',
            'ibu' => 'required|max:100',
            'alamatOrtu' => 'required|max:100',
            'hpOrtu' => 'required|max:20',
            'kerjaAyah' => 'required|max:20',
            'kerjaIbu' => 'required|max:20',
            'namaWali' => 'max:100',
            'alamatWali' => 'max:100',
            'hpWali' => 'max:100',
            'kerjaWali' => 'max:100',
        ])->validate();

        DB::beginTransaction();

        try {
            $data = Siswa::find($this->siswaId);
            $data->ayah = $this->state['ayah'];
            $data->ibu = $this->state['ibu'];
            $data->alamat_ortu = $this->state['alamatOrtu'];
            $data->hp_ortu = $this->state['hpOrtu'];
            $data->kerja_ayah = $this->state['kerjaAyah'];
            $data->kerja_ibu = $this->state['kerjaIbu'];
            $data->nama_wali = $this->state['namaWali'];
            $data->alamat_wali = $this->state['alamatWali'];
            $data->hp_wali = $this->state['hpWali'];
            $data->kerja_wali = $this->state['kerjaWali'];
            $data->save();
            
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
