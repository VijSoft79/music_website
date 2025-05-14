<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Genre;

class GenreController extends Controller
{
    public function index()
    {
        $Genres = Genre::all();

        $otherGenre = $Genres->firstWhere('name', 'Other Genre');
        $otherGenreId = $otherGenre ? $otherGenre->id : null;

        $parentGenres = Genre::where('parent_id', null)->get();

        $data = [];
       
        foreach ($Genres as $Genre) {
            $parentName='';
            if($Genre->parent_id !== null){
                $parentGenre = Genre::find($Genre->parent_id);
                if($parentGenre){
                    $parentName = $parentGenre->name;
                }else{
                    $parentName = $Genre->parent_id;
                }
                
            }else{
                $parentName = $Genre->parent_id;
            }
         
            $btnEdit = '<button class="btn btn-xs btn-default text-primary mx-1 shadow" id="editBtn" title="Edit" data-target="#modalMin" data-toggle="modal" data-genre-id="' . $Genre->id . '"  data-genre-name="' . $Genre->name . '" data-genre-parent="' . $parentName . '" data-genre-parentId="' . $Genre->parent_id . '">
                <i class="fa fa-lg fa-fw fa-pen"></i>
                </button>';
            $btnDelete = '<button id="btnDelete" title="Delete" class="btn btn-xs btn-default text-danger mx-1 shadow" data-target="#mdlDelete" data-toggle="modal" data-genre-id="' . $Genre->id . '" data-genre-name="' . $Genre->name . '" data-genre-parent="' . $parentName . '" data-genre-parentId="' . $Genre->parent_id . '" >
            <i class="fa fa-lg fa-fw fa-trash"></i>
                </button>';
            $rowData = [
                $Genre->id,
                $Genre->name,
                $parentName,
                $Genre->created_at,
                '<nobr>' . $btnEdit . $btnDelete . '</nobr>',
            ];
            $data[] = $rowData;

        }
        return view('admin.genre.index', compact('Genres', 'data', 'parentGenres'));
    }

    public function create(Request $request)
    {
        
        $validatedGenre = $request->validate([
            'name' => 'required',
        ]);
        
        $additionalGenre = [];
        foreach ($request->all() as $key => $value) {

            if (strpos($key, 'addition') === 0) {
                
                $existingGenreadd = Genre::where('name',$value)->first();    
                if ($existingGenreadd) {
                    return redirect()->back()->withErrors(['name' => 'A genre with the same name already exists.'])->withInput();
                }else {
                    $additionalGenre[] = $value;
                }
            }
        }
        
        //auto create Other Genre if no exist
        $OtherGenreId = Genre::where('name', "Other Genre")->first();
        if ($OtherGenreId == null) {
            
            $createotherGen = new Genre();
            $createotherGen->name = "Other Genre";
            $createotherGen->parent_id = null;
            $createotherGen->save();
            
            $OtherGenreId = $createotherGen; 
        }

        // genType condition selection
        $parentId = null;
        switch ($request->genreType) {
            case "Other Genre":
                $parentId = $OtherGenreId->id;
                break;
            case "parent":
                $parentId = null;
                break;
            default:
                $parentId = $request->parent_id;
                break;
        }

                
        $existingGenre = Genre::where('name', $validatedGenre['name'])->first();
        
        if ($existingGenre) {
            return redirect()->back()->withErrors(['name' =>'A genre with the same name already exists.'])->withInput();
        }else{
            foreach ($additionalGenre as $additionalValue) {
                $newGenre = new Genre(); 
                $newGenre->parent_id = $request->parent_id;
                $newGenre->name = $additionalValue;
                $newGenre->save();
            }

            $genre = new Genre();
            $genre->parent_id = $parentId;
            $genre->name = $validatedGenre['name'];
            $genre->save();
        }
        return back()->with('message', 'Genre added successfully.');
    }

    public function update(Request $request)
    {
        $request->validate([
            'editGenreName' => 'required', 
            'editGenreId' => 'required',
        ]);
       

        $genre = Genre::findOrFail($request->editGenreId);
        $genre->name = $request->editGenreName;
        $genre->parent_id = $request->edit_parent;
        $genre->save();

        return back()->with('success', 'Genre Updated successfully.');
    }

    public function destroy(Request $request)
    {   

        // dd($request->all());
        
        $genres = Genre::all();
        $parentId = $request->parent;
        $GenreId = $request->Genre;


        $genreid = Genre::findOrFail($GenreId);
        if(!$genreid){
            return back()->with('message', 'genre does not exist');
        }else {
            if ($parentId === null) {
                foreach ($genres as $genre) {
    
                    if ($genre->parent_id === $GenreId) {
                        $genre->delete();
                    }
                    
                }
            }
        }
        
        $genreid->delete();

        return back()->with('message', 'Successfully Deleted');
    }
    public function retrieve(Request $request){
        $genres = Genre::all();

        // $parentGen = [];
        // foreach ($genres as $selectedGen ) {


        //     if ($genres->parent_id === ) {
                
        //     }
        // }

        // $duplicateParentIds = Genre::select('parent_id')
        //     ->groupBy('parent_id')
        //     ->havingRaw('COUNT(*) > 1')
        //     ->pluck('parent_id');

        // $duplicateGenres = Genre::whereIn('parent_id', $duplicateParentIds)->get();
    }

}
