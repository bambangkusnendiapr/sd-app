<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Student;
use App\Models\User;
use App\Models\Kelas;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Exception;
use RealRashid\SweetAlert\Facades\Alert;
use File;

class StudentData extends Component
{
    public $nama;
    public $nis;
    public $tempat;
    public $tgl;
    public $jk;
    public $agama;
    public $sekolah;
    public $alamat;
    public $namaAyah;
    public $namaIbu;
    public $kerjaAyah;
    public $kerjaIbu;
    public $jalanOrtu;
    public $kel;
    public $kec;
    public $kota;
    public $prov;
    public $namaWali;
    public $kerjaWali;
    public $alamatWali;
    public $gambar;

    public $state = [];
    public $idHapus = null;

    public $kelas = 'Semua';
    public $kelasTipe = 'Semua';

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
        $students;
        if($this->kelas == 'Semua' && $this->kelasTipe == 'Semua') {
            $students = Student::where('nama', 'like', '%'.$this->search.'%')->where('is_deleted', false)->paginate($this->paginate);
        } else if($this->kelas != 'Semua' && $this->kelasTipe == 'Semua') {
            $students = Student::where('nama', 'like', '%'.$this->search.'%')->where('kelas', $this->kelas)->where('is_deleted', false)->paginate($this->paginate);
        } else if($this->kelas == 'Semua' && $this->kelasTipe != 'Semua') {
            $students = Student::where('nama', 'like', '%'.$this->search.'%')->where('kelas_id', $this->kelasTipe)->where('is_deleted', false)->paginate($this->paginate);
        } else {
            $students = Student::where('nama', 'like', '%'.$this->search.'%')->where('kelas', $this->kelas)->where('kelas_id', $this->kelasTipe)->where('is_deleted', false)->paginate($this->paginate);
        }
        return view('livewire.student-data', [
            'students' => $students,
            'kelasData' => Kelas::where('is_deleted', false)->get()
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

    public function detail($id)
    {
        $data = Student::find($id);
        $this->nama = $data->nama;
        $this->nis = $data->nis;
        $this->tempat = $data->tempat_lahir;
        $this->tgl = $data->tgl_lahir;
        $this->jk = $data->jk;
        $this->agama = $data->agama;
        $this->sekolah  = $data->sekolah_asal;
        $this->alamat = $data->alamat;
        $this->namaAyah = $data->nama_ayah;
        $this->namaIbu = $data->nama_ibu;
        $this->kerjaAyah = $data->kerja_ayah;
        $this->kerjaIbu = $data->kerja_ibu;
        $this->jalanOrtu = $data->jalan_ortu;
        $this->kel = $data->kel_ortu;
        $this->kec = $data->kec_ortu;
        $this->kota  = $data->kota_ortu;
        $this->prov = $data->prov_ortu;
        $this->namaWali = $data->namaWali;
        $this->kerjaWali = $data->kerjaWali;
        $this->alamatWali = $data->alamatWali;
        $this->gambar = $data->gambar;

        $this->dispatchBrowserEvent('show-detail');
    }

    private function resetInput()
    {
        $this->state = null;
    }
}
