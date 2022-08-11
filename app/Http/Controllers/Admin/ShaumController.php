<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Shaum;
use Illuminate\Support\Facades\DB;
use Exception;
use RealRashid\SweetAlert\Facades\Alert;

class ShaumController extends Controller
{
    public function create()
    {
        $kelas = Student::get('kelas')->unique('kelas');
        return view('admin.shaum.create', [
            'kelas' => $kelas,
            'students' => Student::all()
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'tanggal' => ['required'],
            'nama' => ['required'],
        ]);

        $shaum = shaum::where('tanggal', $request->tanggal)->where('nama', $request->nama)->first();
        if($shaum) {
            Alert::error('Failed', 'Tanggal dan Shaum sudah ada, silahkan pilih yang lain');
            return redirect()->route('shaum.create');
        }

        if(!$request->siswa) {
            Alert::error('Failed', 'Silahkan Ceklis Data Siswa');
            return redirect()->route('shaum.create');
        }

        DB::beginTransaction();

        try {
            $shaum = shaum::create([
                'tanggal' => $request->tanggal,
                'nama' => $request->nama,
                'ket' => $request->ket,
            ]);

            $shaum->students()->sync($request->siswa);

            DB::commit();
    
            Alert::success('Sukses', 'Data Shaum Siswa Berhasil Disimpan');
            return redirect()->route('shaum');
        } catch (Exception $e) {
            DB::rollBack();
            Alert::error('Failed', $e);
            return redirect()->route('shaum.create');
        }
    }

    public function edit($id)
    {
        $shaum = shaum::find($id);
        if(!$shaum) {
            Alert::error('Failed', 'Data Tidak Ditemukan');
            return redirect()->route('shaum');
        }

        $kelas = Student::get('kelas')->unique('kelas');
        return view('admin.shaum.edit', [
            'kelas' => $kelas,
            'students' => Student::all(),
            'shaum' => $shaum,
            'shaumStudents' => $shaum->students()->get()->pluck('id')->toArray()
        ]);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'tanggal' => ['required'],
        ]);

        $shaum = shaum::find($id);

        if($request->tanggal != $shaum->tanggal || $request->nama != $shaum->nama) {
            $shaumCek = shaum::where('tanggal', $request->tanggal)->where('nama', $request->nama)->first();
            if($shaumCek) {
                Alert::error('Failed', 'Tanggal dan Nama sudah ada, silahkan pilih yang lain');
                return redirect()->route('shaum.edit', $id);
            }
        }

        if(!$request->siswa) {
            Alert::error('Failed', 'Silahkan Ceklis Data Siswa');
            return redirect()->route('shaum.edit', $id);
        }

        DB::beginTransaction();

        try {
            
            $shaum->tanggal = $request->tanggal;
            $shaum->nama = $request->nama;
            $shaum->ket = $request->ket;
            $shaum->save();

            $shaum->students()->sync($request->siswa);

            DB::commit();
    
            Alert::success('Sukses', 'Data Shaum Siswa Berhasil Diedit');
            return redirect()->route('shaum');
        } catch (Exception $e) {
            DB::rollBack();
            Alert::error('Failed', $e);
            return redirect()->route('shaum.edit', $id);
        }
    }
}
