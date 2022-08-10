<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Dhuha;
use App\Models\DhuhaDetail;
use Illuminate\Support\Facades\DB;
use Exception;
use RealRashid\SweetAlert\Facades\Alert;

class DhuhaController extends Controller
{
    public function create()
    {
        $kelas = Student::get('kelas')->unique('kelas');
        return view('admin.dhuha.create', [
            'kelas' => $kelas,
            'students' => Student::all()
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'tanggal' => ['required'],
        ]);

        if(!$request->siswa) {
            Alert::error('Failed', 'Silahkan Ceklis Data Siswa');
            return redirect()->route('dhuha.create');
        }

        DB::beginTransaction();

        try {
            $dhuha = Dhuha::create([
                'tanggal' => $request->tanggal,
                'ket' => $request->ket,
            ]);

            $dhuha->students()->sync($request->siswa);

            DB::commit();
    
            Alert::success('Sukses', 'Data Dhuha Siswa Berhasil Disimpan');
            return redirect()->route('dhuha');
        } catch (Exception $e) {
            DB::rollBack();
            Alert::error('Failed', $e);
            return redirect()->route('dhuha.create');
        }
    }

    public function edit($id)
    {
        $dhuha = Dhuha::find($id);
        if(!$dhuha) {
            Alert::error('Failed', 'Data Tidak Ditemukan');
            return redirect()->route('dhuha');
        }

        $kelas = Student::get('kelas')->unique('kelas');
        return view('admin.dhuha.edit', [
            'kelas' => $kelas,
            'students' => Student::all(),
            'dhuha' => $dhuha,
            'dhuhaStudents' => $dhuha->students()->get()->pluck('id')->toArray()
        ]);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'tanggal' => ['required'],
        ]);

        if(!$request->siswa) {
            Alert::error('Failed', 'Silahkan Ceklis Data Siswa');
            return redirect()->route('dhuha.create');
        }

        DB::beginTransaction();

        try {
            $dhuha = Dhuha::find($id);
            $dhuha->tanggal = $request->tanggal;
            $dhuha->ket = $request->ket;
            $dhuha->save();

            $dhuha->students()->sync($request->siswa);

            DB::commit();
    
            Alert::success('Sukses', 'Data Dhuha Siswa Berhasil Diedit');
            return redirect()->route('dhuha');
        } catch (Exception $e) {
            DB::rollBack();
            Alert::error('Failed', $e);
            return redirect()->route('dhuha.edit', $id);
        }
    }
}
