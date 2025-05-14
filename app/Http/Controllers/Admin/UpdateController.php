<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Update;

class UpdateController extends Controller
{
    public function index()
    {
        $updates = Update::all();
        $data = [];
        foreach ($updates as $update) {
            $btnEdit = '<a href="' .  route('admin.updates.edit', $update->id). '" class="btn btn-xs btn-default text-primary mx-1 shadow" title="Edit">
                <i class="fa fa-lg fa-fw fa-pen"></i>
            </a>';
            $btnDelete = '<a href="'. route('admin.updates.delete', $update).'" class="btn btn-xs btn-default text-danger mx-1 shadow" title="Delete">
                <i class="fa fa-lg fa-fw fa-trash"></i>
            </a>';
            $btnDetails = '<button class="btn btn-xs btn-default text-teal mx-1 shadow" title="Details">
                    <i class="fa fa-lg fa-fw fa-eye"></i>
                </button>';

            $rowData = [
                $update->id,
                $update->title,
                $update->update_for,
                '<nobr>' . $btnEdit . $btnDelete . $btnDetails . '</nobr>',
            ];
            $data[] = $rowData;
        }
        return view('admin.updates.index', compact(['data']));
    }

    public function edit(Update $update)
    {
        return view('admin.updates.edit', [
            'update' =>  $update,
        ]);
    }

    public function create()
    {
        return view('admin.updates.create');
    }

    public function save(Request $request) 
    {
        $validated = $request->validate([
            'title' => 'required',
            'update_for' => 'required',
            'content' => 'required',
        ]);

        $update = Update::create([
            'title' => $validated['title'],
            'update_for' => $validated['update_for'],
            'content' => $validated['content'],
        ]);

        return redirect()->route('admin.updates.index')->with('message', 'Update Notice Has been Save');

    }

    public function destroy(Update $update)
    {
        $update->delete();
        return redirect()->route('admin.updates.index')->with('message', 'Update has been deleted');
    }
}
