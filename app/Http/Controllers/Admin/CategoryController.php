<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $data = [];
        foreach ($categories as $categorie) {
            $btnEdit = '<a href="' .  route('admin.templates.show', $categorie->id). '" class="btn btn-xs btn-default text-primary mx-1 shadow" title="Edit">
                <i class="fa fa-lg fa-fw fa-pen"></i>
            </a>';
            $btnDelete = '<button class="btn btn-xs btn-default text-danger mx-1 shadow" title="Delete">
                    <i class="fa fa-lg fa-fw fa-trash"></i>
                </button>';
            $btnDetails = '<button class="btn btn-xs btn-default text-teal mx-1 shadow" title="Details">
                    <i class="fa fa-lg fa-fw fa-eye"></i>
                </button>';

            if($categorie->status == 0){
                $status = "Pending Approve";
            }else{
                $status = "Approved";
            }

            $rowData = [
                $categorie->id,
                $categorie->name,
                $status,
                '<nobr>' . $btnEdit . $btnDelete . $btnDetails . '</nobr>',
            ];
            $data[] = $rowData;
        }
        return view('admin.categories.index', compact(['data']));
    }

    public function create(Request $request)
    {
        return view('admin.categories.create');
    }

    public function save(Request $request)
    {
        $cat = Category::create([
            'name' => $request->name,
        ]);

        return redirect()->back()->with('message','Category save successfully');
    }

    public function edit(Category $category)
    {
        $cat = Category::find('$category');
        
    }


}
