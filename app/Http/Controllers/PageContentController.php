<?php

namespace App\Http\Controllers;

use App\Mail\ContactHelp;
use Illuminate\Http\Request;
use App\Models\Music;

use App\Models\PageContent;


use Illuminate\Support\Facades\Mail;
use App\Mail\ContactUsMail;
use App\Mail\ReportMusic;
use Illuminate\Support\Facades\Auth;
use Spatie\FlareClient\Truncation\ReportTrimmer;
use App\Services\EmailService;

class PageContentController extends Controller
{
    protected $emailService;

    public function __construct()
    {
        $this->emailService = app(EmailService::class);
    }

    public function show($pageName)
    { 
        // Check if page content exists
        $pageContent = PageContent::where('title', $pageName)->first();
        
        // Check if view exists
        if (!view()->exists('pages.' . $pageName)) {
            abort(404);
        }

        // If we need content and it doesn't exist, show 404
        if (!$pageContent) {
            abort(404);
        }

        return view('pages.' . $pageName , compact('pageContent'));
    }
    
    public function contact()
    {
        return view('pages.contact');
    }

    public function faqs()
    {
        return view('pages.faqs');
    }

    public function send(Request $request)
    {
        $name =  $request->name;
        $email = $request->email;
        $content = $request->content;
        
        $this->emailService->send('admin@youhearus.com', new ContactUsMail($name, $email, $content), 'contact.us', null);
        return redirect()->route('page.contact')->with('message', 'Your Message Has been Sent to The admin');
    }

    public function helpQuestion()
    {
        return view('help.index');
    }

    public function sendHelpQuestion(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'question' => 'required',
        ]);

        $name = $validated['name'];
        $email = Auth::user()->email;
        $question = $validated['question'];

        // 'admin@youhearus.com'
        $this->emailService->send('admin@youhearus.com', new ContactUsMail($name, $email, $question), 'contact.help', null);

        if(Auth::user()->hasRole('curator')){
            return redirect()->route('curator.help')->with('message', 'Your Meesage Has been Sent to The admin');
        }else{
            return redirect()->route('musician.help')->with('message', 'Your Meesage Has been Sent to The admin');
        }
        
    }

    public function sendProbelm(Request $request){
    
        $validated = $request->validate([
            'email' => 'required|email',
            'subject' => 'required',
            'message' => 'required',
        ]);
        $userRole = Auth::user()->roles->first()->name;
        
        $email = $validated['email'];
        $subject =  $validated['subject'];
        $content =  $validated['message'];

        $this->emailService->send('admin@youhearus.com', new ContactHelp($email, $subject, $content, $userRole), 'contact.problem', null);

        return back()->with('message', 'Email message submitted');
    }

    public function reportMusic(Request $request){
        $userRole = Auth::user()->roles->first()->name;
        $music = Music::find($request->musicId);
        $content = $request->concern;
        $userEmail = Auth::user()->email;
        
        if ($music) {
            $musicTitle = $music->title;
            
        }else {
            return back()->with('message', 'No music found');
        }

        $this->emailService->send('bongaitan.jc23@gmail.com', new ReportMusic($userRole, $musicTitle, $content, $userEmail), 'report.music', null);

        return back()->with('message', 'music reported successfully');
    }

    
}
