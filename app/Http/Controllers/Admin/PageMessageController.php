<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PageMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class PageMessageController extends Controller
{
    public function index()
    {
        $messages = PageMessage::all();

        $data = [];


        foreach ($messages as $message) {

            $btnEdit = '<a href="'. route('page.messages.edit', $message->id) .'" class="btn btn-xs btn-default text-primary mx-1 shadow" title="Edit">
                <i class="fa fa-lg fa-fw fa-pen"></i>
            </a>';

            $rowData = [
                $message->id,
                $message->name,
                Str::limit($message->content, 10),
                $message->page,
                '<nobr>' . $btnEdit . '</nobr>',
            ];

            $data[] = $rowData;
        }

        return view('admin.page-messages.index', compact('data'));
    }

    public function save(Request $request)
    {
        $pageMessage = new PageMessage;
        $pageMessage->name = $request->name;
        $pageMessage->page = $request->page;
        $pageMessage->content = $request->content;
        $pageMessage->save();

        return response()->json(['message' => 'message saved']);
    }

    public function edit(PageMessage $pageMessage)
    {
        return view('admin.page-messages.edit', compact('pageMessage'));
    }

    public function update(PageMessage $pageMessage, Request $request)
    {  
        $pageMessage->name = $request->name;
        $pageMessage->page = $request->page;
        $pageMessage->content = $request->content;
        $pageMessage->save();

        return redirect()->route('page.messages.index');
    }



}
