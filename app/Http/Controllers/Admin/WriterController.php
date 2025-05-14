<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;

class WriterController extends Controller
{
    public function index()
    {
        $writers = User::role('writer')->get();
        $data = [];
        foreach ($writers as $writer) {
            $btnEdit = '<a href="' . route('admin.curators.edit', $writer) . '" class="btn btn-xs btn-default text-primary mx-1 shadow" title="Edit">
                <i class="fa fa-lg fa-fw fa-pen"></i>
            </a>';
            $btnDelete = '<a href="' . route('admin.curators.delete', $writer) . '" class="btn btn-xs btn-default text-danger mx-1 shadow" title="Delete" onclick="confirm_delete(event)">
                    <i class="fa fa-lg fa-fw fa-trash"></i>
                </a>';
            $btnDetails = '<a href="' . route('admin.curators.show', $writer) . '" class="btn btn-xs btn-default text-teal mx-1 shadow" title="Details" >
                    <i class="fa fa-lg fa-fw fa-eye"></i>
                </a>';

            $rowData = [
                $writer->id,
                $writer->name,
                $writer->email,
                $writer->phone_number,
                $writer->is_approve == 0 ? '<span class="badge bg-success">Approve</span>':'<span class="badge bg-danger">Pending</span>',
                '<nobr>' . $btnEdit . $btnDelete . $btnDetails . '</nobr>',
            ];
            $data[] = $rowData;
        }

        return view('admin.writers.index', compact('data')); 
    }

    public function create(){
        return view('admin.writers.create');
    }
}
