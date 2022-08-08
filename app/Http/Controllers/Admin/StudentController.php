<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Student;
use Illuminate\Support\Facades\DB;
use Exception;
use RealRashid\SweetAlert\Facades\Alert;
use File;

class StudentController extends Controller
{
    public function create()
    {
        return view('admin.student.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'nama' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'noInduk' => ['required', 'string', 'max:50'],
            'tempatLahir' => ['required', 'string', 'max:50'],
            'tglLahir' => ['required'],
            'jk' => ['required'],
            'agama' => ['required'],
            'pendidikan' => ['required', 'string', 'max:200'],
            'alamat' => ['required', 'string', 'max:500'],
            'namaAyah' => ['required', 'string', 'max:50'],
            'namaIbu' => ['required', 'string', 'max:50'],
            'kerjaAyah' => ['required', 'string', 'max:50'],
            'kerjaIbu' => ['required', 'string', 'max:50'],
            'jalan' => ['required', 'string', 'max:200'],
            'kel' => ['required', 'string', 'max:200'],
            'kec' => ['required', 'string', 'max:200'],
            'kota' => ['required', 'string', 'max:200'],
            'prov' => ['required', 'string', 'max:200'],
            'filefoto' => 'mimes:jpg,png,jpeg,gif|max:2048', // max 2000kb/2mb
            'hafalan' => 'required|max:200',
            'kelas' => 'required|max:10'
        ]);

        DB::beginTransaction();

        try {
            $user = User::create([
                'name' => $request->nama,
                'username' => $request->username,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);

            $user->attachRole('siswa');

            $namafile;
            if($request->hasFile('filefoto') == true){
                $file = $request->file('filefoto');
                $namafile = time()."".$file->getClientOriginalName();
        
                $tujuan_upload = 'images/siswa/';
                $file->move($tujuan_upload,$namafile);
            }

            Student::create([
                'user_id' => $user->id,
                'nis' => $request->noInduk,
                'nama' => $request->nama,
                'tempat_lahir' => $request->tempatLahir,
                'tgl_lahir' => $request->tglLahir,
                'jk' => $request->jk,
                'agama' => $request->agama,
                'sekolah_asal' => $request->pendidikan,
                'alamat' => $request->alamat,
                'nama_ayah' => $request->namaAyah,
                'nama_ibu' => $request->namaIbu,
                'kerja_ayah' => $request->kerjaAyah,
                'kerja_ibu' => $request->kerjaIbu,
                'jalan_ortu' => $request->jalan,
                'kel_ortu' => $request->kel,
                'kec_ortu' => $request->kec,
                'kota_ortu' => $request->kota,
                'prov_ortu' => $request->prov,
                'nama_wali' => $request->namaWali,
                'kerja_wali' => $request->kerjaWali,
                'alamat_wali' => $request->alamatWali,
                'gambar' => $namafile,
                'surat_awal' => $request->hafalan,
                'kelas' => $request->kelas,
            ]);

            DB::commit();

            Alert::success('Success', 'Data Berhasil Disimpan');
            return redirect()->route('student');
        } catch (Exception $e) {
            DB::rollBack();
            Alert::error('Failed', $e);
            return redirect()->route('student');
        }
    }

    public function edit($id)
    {
        try {
            $siswa = Student::findOrFail($id);
            return view('admin.student.edit', [
                'siswa' => $siswa
            ]);
        } catch (Exception $e) {
            Alert::error('Failed', 'Data Not Found');
            return redirect()->route('student');
        }
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'nama' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'noInduk' => ['required', 'string', 'max:50'],
            'tempatLahir' => ['required', 'string', 'max:50'],
            'tglLahir' => ['required'],
            'jk' => ['required'],
            'agama' => ['required'],
            'pendidikan' => ['required', 'string', 'max:200'],
            'alamat' => ['required', 'string', 'max:500'],
            'namaAyah' => ['required', 'string', 'max:50'],
            'namaIbu' => ['required', 'string', 'max:50'],
            'kerjaAyah' => ['required', 'string', 'max:50'],
            'kerjaIbu' => ['required', 'string', 'max:50'],
            'jalan' => ['required', 'string', 'max:200'],
            'kel' => ['required', 'string', 'max:200'],
            'kec' => ['required', 'string', 'max:200'],
            'kota' => ['required', 'string', 'max:200'],
            'prov' => ['required', 'string', 'max:200'],
            'filefoto' => 'mimes:jpg,png,jpeg,gif|max:2048', // max 2000kb/2mb,
            'hafalan' => 'required|max:200',
            'kelas' => 'required|max:10'
        ]);

        $student = Student::find($id);
        $user = User::find($student->user_id);

        if($request->username != $student->user->username) {
            $this->validate($request, [
                'username' => ['required', 'string', 'max:255', 'unique:users'],
            ]);
        }

        if($request->email != $student->user->email) {
            $this->validate($request, [
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            ]);
        }

        if($request->password != null) {
            $this->validate($request, [
                'password' => ['string', 'min:8', 'confirmed'],
            ]);

            $user->password = bcrypt($request->password);
        }

        DB::beginTransaction();

        try {
            $user->name = $request->nama;
            $user->username = $request->username;
            $user->email = $request->email;
            $user->save();

            $gambar;
            if($request->hasFile('filefoto') == true)
            {
              $file = $request->file('filefoto');
              $filefoto = time()."".$file->getClientOriginalName();
              $file_ext  = $file->getClientOriginalExtension();
              
              $local_gambar = "images/siswa/".$student->gambar;
              if(File::exists($local_gambar))
              {
                  File::delete($local_gambar);
              }

              $tujuan_upload = 'images/siswa/';
              $file->move($tujuan_upload,$filefoto);
              $gambar = $filefoto;
            } else {
              $gambar = $student->gambar;
            }

            Student::where('id', $id)->update([
                'nis' => $request->noInduk,
                'nama' => $request->nama,
                'tempat_lahir' => $request->tempatLahir,
                'tgl_lahir' => $request->tglLahir,
                'jk' => $request->jk,
                'agama' => $request->agama,
                'sekolah_asal' => $request->pendidikan,
                'alamat' => $request->alamat,
                'nama_ayah' => $request->namaAyah,
                'nama_ibu' => $request->namaIbu,
                'kerja_ayah' => $request->kerjaAyah,
                'kerja_ibu' => $request->kerjaIbu,
                'jalan_ortu' => $request->jalan,
                'kel_ortu' => $request->kel,
                'kec_ortu' => $request->kec,
                'kota_ortu' => $request->kota,
                'prov_ortu' => $request->prov,
                'nama_wali' => $request->namaWali,
                'kerja_wali' => $request->kerjaWali,
                'alamat_wali' => $request->alamatWali,
                'gambar' => $gambar,
                'surat_awal' => $request->hafalan,
                'kelas' => $request->kelas,
            ]);

            DB::commit();

            Alert::success('Success', 'Data Berhasil Diedit');
            return redirect()->route('student');
        } catch (Exception $e) {
            DB::rollBack();
            Alert::error('Failed', $e);
            return redirect()->route('student');
        }
    }
}
