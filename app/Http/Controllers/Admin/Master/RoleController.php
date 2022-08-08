<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Role;
use Illuminate\Support\Facades\DB;
use Exception;
use RealRashid\SweetAlert\Facades\Alert;

class RoleController extends Controller
{
    public function create()
    {
        return view('admin.master.role.create', [
            'menus' => Menu::all()
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => ['required', 'string', 'max:255', 'unique:roles'],
            'display' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:255'],
        ]);

        DB::beginTransaction();

        try {
            $role = Role::create([
                'name' => strtolower($request->name),
                'display_name' => $request->display,
                'description' => $request->description,
            ]);

            $role->attachPermissions($request->permissions);

            DB::commit();

            Alert::success('Success', 'Data Berhasil Disimpan');
            return redirect()->route('roles');

        } catch (Exception $e) {
            DB::rollBack();
            Alert::error('Failed', $e);
            return redirect()->route('roles');
        }

    }

    public function edit($id)
    {
        try {
            $role = Role::findOrFail($id);
            return view('admin.master.role.edit', [
                'menus' => Menu::all(),
                'role' => $role,
                'rolePermissions' => $role->permissions()->get()->pluck('id')->toArray()
            ]);
        } catch (Exception $e) {
            Alert::error('Failed', 'Data Not Found!');
            return redirect()->route('roles');
        }
    }

    public function update(Request $request, $id)
    {
        // dd($request->permissions);
        $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'display' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:255'],
        ]);

        $role = Role::find($id);

        if($role->id != $request->name) {
            $this->validate($request, [
                'name' => ['unique:roles']
            ]);
        }

        DB::beginTransaction();

        try {
            $role->update([
                'name' => $request->name,
                'display_name' => $request->display,
                'description' => $request->description,
            ]);

            $role->syncPermissions($request->permissions);

            $role->save();

            DB::commit();

            Alert::success('Success', 'Data Berhasil Diupdate');
            return redirect()->route('roles');

        } catch (Exception $e) {
            DB::rollBack();
            Alert::error('Failed', $e);
            return redirect()->route('roles');
        }

    }
}
