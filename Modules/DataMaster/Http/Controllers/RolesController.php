<?php

namespace Modules\DataMaster\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\DataMaster\Entities\RoleModel;
use Yajra\DataTables\Facades\DataTables;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            // Murni Eloquent dengan Eager Loading
            $data = RoleModel::get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('nama_role', function ($row) {
                    return $row->nama_role ?? '-';
                })
                ->make(true);
        }
        return view('datamaster::pages.role.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_role' => 'required',
        ]);

        $role = RoleModel::updateOrCreate(
            ['id_role' => $request->id_role],
            [
                'nama_role'  => $request->nama_role,
            ]
        );

        return response()->json(['success' => 'Data Berhasil Disimpan'], 201);
    }

    public function delete(Request $request)
    {
        $role = RoleModel::find($request->id);
        if ($role) {
            $role->delete();
            return response()->json(['success' => 'Data Berhasil Dihapus']);
        }
        return;
    }
}
