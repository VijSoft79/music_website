<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\Post;
use App\Traits\ModelImageTrait;

use Carbon\Carbon;

class PostController extends Controller
{
    use ModelImageTrait;

    public function index()
    {
        $posts = Post::all();
        $data = [];
        foreach ($posts as $post) {
            $btnHidden = 'hidden';
            $btnEdit = '<a href="' . route('admin.blog.edit', $post) . '" class="btn btn-xs btn-default text-primary mx-1 shadow" title="Edit">
                <i class="fa fa-lg fa-fw fa-pen"></i>
            </a>';
            $btnDelete = '<a href="' . route('admin.blog.delete', $post) . '" onclick="confirmDelete(event, \'' . route('admin.blog.delete', $post) . '\')" class="btn btn-xs btn-default text-danger mx-1 shadow" title="Delete">
            <i class="fa fa-lg fa-fw fa-trash"></i>
            </a>';

            $rowData = [
                $post->id,
                $post->title,
                $post->status,
                $post->reminder,
                $post->created_at,
                '<nobr>' . $btnEdit . $btnDelete . '</nobr>',
            ];
            $data[] = $rowData;
        }

        return view('admin.blogs.index', compact(['posts', 'data']));
    }

    public function show(Post $post)
    {
        return view('admin.blogs.show', [
            'post' => $post
        ]);
    }

    public function create()
    {
        return view('admin.blogs.create');
    }

    public function save(Request $request)
    {
        
        $validated = $request->validate([
            'title' => 'required|unique:posts|max:500',
            'cat' => 'required',
            'content' => 'required',
            'status' => 'required',
        ]);

        $blog = new Post;

        $content = $request->input('content');

        // Extract image URLs from the content
        $dom = new \DOMDocument();
        $dom->loadHTML('<?xml encoding="utf-8" ?>' . $content);
        $images = $dom->getElementsByTagName('img');

        foreach ($images as $image) {
            $imageUrl = $image->getAttribute('src');
            $uploadedImageUrl = $this->uploadImage($imageUrl);
            $image->setAttribute('src', $uploadedImageUrl);
        }

        $reminderDate = Carbon::createFromFormat('m/d/Y', $request->reminder_date)->format('Y-m-d');
        
        $blog->user_id = Auth::user()->id;
        $blog->title = $validated['title'];
        $blog->status = $validated['status'];
        $blog->reminder = $reminderDate;
        $blog->content = $dom->saveHTML();
        $blog->save();

        // feature image 
        if ($request->hasFile('image')) {
            $photo = $request->file('image');
            $photoPath = $this->getImage($photo, $blog);
            $blog->featured_image = $photoPath;
            $blog->save();
        }

        $blog->category()->sync($validated['cat']);

        return redirect()->route('admin.blog.index')->with(
            ['message' =>'Blog post has been added']
        );
    }

    public function edit(Post $post)
    {
        $baseImage = basename($post->featured_image);
        
        return view('admin.blogs.edit', [
            'post' => $post,
            'image' => $baseImage,
        ]);
    }

    public function update(Post $post, Request $request)
    {
        
        $validated = $request->validate([
            'title' => 'required|max:255',
            'cat' => 'required',
            'content' => 'required',
            'status' => 'required',
            'reminder_date' => 'date',
        ]);

        $blog = $post;
        $content = $request->input('content');

        if (strpos($content, '<?xml encoding="utf-8" ?>') === false) {
            // If not, create a new DOMDocument and process the content
            $dom = new \DOMDocument();
            @$dom->loadHTML('<?xml encoding="utf-8" ?>' . $content); // Add XML declaration
            $images = $dom->getElementsByTagName('img');
    
            foreach ($images as $image) {
                $imageUrl = $image->getAttribute('src');
                $uploadedImageUrl = $this->uploadImage($imageUrl);
                $image->setAttribute('src', $uploadedImageUrl);
            }
    
            // Save processed content back to variable
            $content = $dom->saveHTML();
        }

        // foreach ($images as $image) {
        //     $imageUrl = $image->getAttribute('src');
        //     $uploadedImageUrl = $this->uploadImage($imageUrl);
        //     $image->setAttribute('src', $uploadedImageUrl);
        // }

        $date = Carbon::parse($validated['reminder_date'])->format('Y-m-d');
        $blog->title = $validated['title'];
        $blog->content = $content;
        $blog->status = $validated['status'];
        $blog->reminder = $date;
        $blog->save();

        if ($request->hasFile('image')) {
            $photo = $request->file('image');
            $photoPath = $this->getImage($photo, $blog);
            $blog->featured_image = $photoPath;
            $blog->save();
        }

        $blog->category()->sync($validated['cat']);
        return redirect()->route('admin.blog.index')->with(
            ['message' =>'Blog post has been updated']
        );
    }

    public function delete(Post $post)
    {
        $post->delete();
        return redirect()->route('admin.blog.index')->with('message', 'Blog Post has been deleted');
    }

    private function uploadImage($imageUrl)
    {
        if (Str::startsWith($imageUrl, url('public/posts/'))) {
            return $imageUrl;
        }

        $imageContents = file_get_contents($imageUrl);

        // Extract the file extension from the URL
        $path = parse_url($imageUrl, PHP_URL_PATH);
        $extension = pathinfo($path, PATHINFO_EXTENSION);

        // Default to 'jpg' if the extension is not recognized
        if (empty($extension)) {
            $extension = 'jpg';
        }

        $fileName = Str::random(20) . $extension;
        $publicPath = public_path('public/posts/' . $fileName);

        if (!file_exists(dirname($publicPath))) {
            mkdir(dirname($publicPath), 0755, true);
        }

        file_put_contents($publicPath, $imageContents);
        return url('public/posts/' . $fileName);
    }
}
