<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\PageContent;
use App\Model\HelpQuestions;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Traits\ModelImageTrait;

class PageContentController extends Controller
{
    use ModelImageTrait;


    public function index()
    {
        $contents = PageContent::all();

        $data = [];

        foreach ($contents as $content) {
            $btnEdit = '<a href="' . route('admin.page.content.show', $content) . '" class="btn btn-xs btn-default text-primary mx-1 shadow" title="Edit">
                <i class="fa fa-lg fa-fw fa-pen"></i>
            </a>';
            $btnDetails = '<button class="btn btn-xs btn-default text-teal mx-1 shadow" title="Details">
                    <i class="fa fa-lg fa-fw fa-eye"></i>
                </button>';

            $rowData = [
                $content->id,
                $content->title,
                '<nobr>' . $btnEdit . $btnDetails . '</nobr>',
            ];

            $data[] = $rowData;

        }
        return view('admin.page-contents.index', compact('data'));
    }

    public function show(PageContent $pageContent)
    {
        return view('admin.page-contents.show', compact('pageContent'));
    }

    public function create()
    {
        return view('admin.page-contents.create');
    }

    public function save(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required'
        ]);

        $pagecontent = PageContent::create([
            'title' => $validated['title'],
            'content' => $validated['content']
        ]);

        $content = $validated['content'];

        // Extract image URLs from the content
        $dom = new \DOMDocument();
        $dom->loadHTML($content);
        $images = $dom->getElementsByTagName('img');

        foreach ($images as $image) {

            $imageUrl = $image->getAttribute('src');

            // Upload each image and replace the URL
            $uploadedImageUrl = $this->uploadImage($imageUrl);
            $image->setAttribute('src', $uploadedImageUrl);
        }

        $pagecontent->content = $dom->saveHTML();
        $pagecontent->save();

        return redirect()->back();
    }

    public function update(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required'
        ]);

        // Find the page by ID
        $page = PageContent::where('title', $validated['title'])->first();
        if (!$page) {
            return redirect()->back()->with('error', 'Page Content not found');
        }

        // Extract image URLs from the content
        $dom = new \DOMDocument();
        libxml_use_internal_errors(true); // Suppress HTML5 warnings
        $dom->loadHTML($request->content, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        libxml_clear_errors();
        $images = $dom->getElementsByTagName('img');

        foreach ($images as $image) {
            $imageUrl = $image->getAttribute('src');
            // Upload each image and replace the URL
            $uploadedImageUrl = $this->uploadImage($imageUrl);
            $image->setAttribute('src', $uploadedImageUrl);
        }

        $page->title = $validated['title'];
        $page->content = $dom->saveHTML();
        $page->save();

        return redirect()->back()->with('success', 'Page Content Successfully updated');
    }


    private function uploadImage($imageUrl)
    {
        // Check if the image URL is already an uploaded URL
        if (Str::startsWith($imageUrl, url('page-content/'))) {
            return $imageUrl;
        }

        // Download the image from the URL
        $imageContents = file_get_contents($imageUrl);

        // Extract the file extension from the URL
        $path = parse_url($imageUrl, PHP_URL_PATH);
        $extension = pathinfo($path, PATHINFO_EXTENSION);

        // Default to 'jpg' if the extension is not recognized
        if (empty($extension)) {
            $extension = 'jpg';
        }

        // Generate a unique file name with the correct extension
        $fileName = Str::random(20) . '.' . $extension;

        // Define the path to save the image in the public folder
        $publicPath = public_path('page-content/' . $fileName);

        // Ensure the directory exists
        if (!file_exists(dirname($publicPath))) {
            mkdir(dirname($publicPath), 0755, true);
        }

        // Save the image in the public folder
        file_put_contents($publicPath, $imageContents);

        // Return the URL of the uploaded image
        return url('page-content/' . $fileName);
    }



}

