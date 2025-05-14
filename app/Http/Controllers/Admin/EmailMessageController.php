<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\EmailMessage;

class EmailMessageController extends Controller
{
    public function index()
    {
        $emails = EmailMessage::all();

        $data = [];
        foreach ($emails as $email) {
            $btnEdit = '<a href="' .  route('admin.email.edit', $email->id). '" class="btn btn-xs btn-default text-primary mx-1 shadow" title="Edit">
                <i class="fa fa-lg fa-fw fa-pen"></i>
            </a>';
            $btnDelete = '<button class="btn btn-xs btn-default text-danger mx-1 shadow" title="Delete">
                    <i class="fa fa-lg fa-fw fa-trash"></i>
                </button>';

            $rowData = [
                $email->id,
                $email->title,
                $email->email_type,
                $email->email_to,
                '<nobr>' . $btnEdit . $btnDelete . '</nobr>',
            ];
            $data[] = $rowData;
        }
        return view('admin.emails.index', compact('data') );
    }

    public function create()
    {
        return view('admin.emails.create');
    }

    public function save(Request $request)
    {   
        $validated = $request->validate([
            'title' => 'required|max:255',
            'email_type' => 'required',
            'email_to' => 'required',
            'content' => 'required',
        ]);

        if(EmailMessage::where('email_type',$validated['email_type'])->exists()){
            return redirect()->route('admin.email.create')->with('message', 'email of that type is already exist');
        }

        $request = EmailMessage::create([
            'title' => $validated['title'],
            'email_type' => $validated['email_type'],
            'email_to' => $validated['email_to'],
            'content' => $validated['content']
        ]);

        return redirect()->route('admin.email.index');
    }

    public function edit(EmailMessage $emailMessage)
    {
        return view('admin.emails.edit', compact('emailMessage'));
    }

    public function update(Request $request,  $EmailMessage)
    {
        $email = EmailMessage::find($EmailMessage);
        $email->title = $request->title;
        $email->content = $request->content;
        $email->email_to = $request->email_to;
        $email->save();

        return redirect()->route('admin.email.index');

    }

    public function destroy(EmailMessage $emailMessage){
        $emailMessage->delete();
        
        return redirect()->route('admin.email.index')->with('message', 'Email Deleted Successfully');
    }


}
