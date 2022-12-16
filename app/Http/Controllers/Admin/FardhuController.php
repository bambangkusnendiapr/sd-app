<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Fardhu;
use Illuminate\Support\Facades\DB;
use Exception;
use RealRashid\SweetAlert\Facades\Alert;

class FardhuController extends Controller
{
    public function create()
    {
        $kelas = Student::get('kelas')->unique('kelas');
        return view('admin.fardhu.create', [
            'kelas' => $kelas,
            'students' => Student::all()
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'tanggal' => ['required'],
            'sholat' => ['required'],
        ]);

        $fardhu = Fardhu::where('tanggal', $request->tanggal)->where('sholat', $request->sholat)->first();
        if($fardhu) {
            Alert::error('Failed', 'Tanggal dan Sholat sudah ada, silahkan pilih yang lain');
            return redirect()->route('fardhu.create');
        }

        if(!$request->siswa) {
            Alert::error('Failed', 'Silahkan Ceklis Data Siswa');
            return redirect()->route('fardhu.create');
        }

        DB::beginTransaction();

        try {
            $fardhu = Fardhu::create([
                'tanggal' => $request->tanggal,
                'sholat' => $request->sholat,
                'ket' => $request->ket,
            ]);

            $fardhu->students()->attach($request->siswa);

            $studentNotSalat = Student::whereNotIn('id', $request->siswa)->get('id');
            $fardhu->students()->attach($studentNotSalat, ['salat' => false]);

            DB::commit();
            
            Alert::success('Sukses', 'Data Sholat Fardhu Siswa Berhasil Disimpan');
            return redirect()->route('fardhu');
        } catch (Exception $e) {
            DB::rollBack();
            Alert::error('Failed', $e);
            return redirect()->route('fardhu.create');
        }
    }

    public function edit($id)
    {
        $fardhu = fardhu::find($id);
        if(!$fardhu) {
            Alert::error('Failed', 'Data Tidak Ditemukan');
            return redirect()->route('fardhu');
        }

        // $salat = DB::table('fardhu_student')->where('fardhu_id', $id)->get(['student_id', 'salat']);
        // dd($salat->where('student_id', 3));

        $kelas = Student::get('kelas')->unique('kelas');
        return view('admin.fardhu.edit', [
            'kelas' => $kelas,
            'students' => Student::all(),
            'fardhu' => $fardhu,
            'fardhuStudents' => $fardhu->students()->get()->pluck('id')->toArray(),
            'salat' => DB::table('fardhu_student')->where('fardhu_id', $id)->get(['student_id', 'salat'])
        ]);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'tanggal' => ['required'],
        ]);

        $fardhu = Fardhu::find($id);

        if($request->tanggal != $fardhu->tanggal || $request->sholat != $fardhu->sholat) {
            $fardhuCek = Fardhu::where('tanggal', $request->tanggal)->where('sholat', $request->sholat)->first();
            if($fardhuCek) {
                Alert::error('Failed', 'Tanggal dan Sholat sudah ada, silahkan pilih yang lain');
                return redirect()->route('fardhu.edit', $id);
            }
        }

        if(!$request->siswa) {
            Alert::error('Failed', 'Silahkan Ceklis Data Siswa');
            return redirect()->route('fardhu.edit', $id);
        }

        DB::beginTransaction();

        try {
            
            $fardhu->tanggal = $request->tanggal;
            $fardhu->sholat = $request->sholat;
            $fardhu->ket = $request->ket;
            $fardhu->save();

            // $fardhu->students()->sync($request->siswa);
            $fardhu->students()->detach();

            $fardhu->students()->attach($request->siswa);

            $studentNotSalat = Student::whereNotIn('id', $request->siswa)->get('id');
            $fardhu->students()->attach($studentNotSalat, ['salat' => false]);

            DB::commit();
    
            Alert::success('Sukses', 'Data Sholat Fardhu Siswa Berhasil Diedit');
            return redirect()->route('fardhu');
        } catch (Exception $e) {
            DB::rollBack();
            Alert::error('Failed', $e);
            return redirect()->route('fardhu.edit', $id);
        }
    }
}
