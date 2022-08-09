<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Surat;
use App\Models\Student;
use Illuminate\Support\Facades\DB;
use Exception;
use RealRashid\SweetAlert\Facades\Alert;

class SuratController extends Controller
{
    public function surat(Request $request)
    {
        $this->validate($request, [
            'studentId' => ['required'],
            'surat' => ['required'],
            'suratAkhir' => ['required'],
        ]);

        DB::beginTransaction();

        try {
            $data = Student::find($request->studentId);
            $data->surat_id = $request->suratAkhir;
            $data->save();
            $data->surats()->sync($request->surat);

            DB::commit();
    
            Alert::success('Sukses', 'Hafalan Surat Berhasil Disimpan');
            return redirect()->route('tahsin', $request->studentId);
        } catch (Exception $e) {
            DB::rollBack();
            Alert::error('Failed', $e);
            return redirect()->route('tahsin', $request->studentId);
        }

    }
}
