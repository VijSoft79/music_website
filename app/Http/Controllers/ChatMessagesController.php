<?php

namespace App\Http\Controllers;

use App\Mail\ChatEmail;
use App\Models\ChatNotificationLog;
use App\Models\Offer;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Models\ChatMessage;
use App\Models\User;
use Mail;
use Spatie\Permission\Traits\HasRoles;
use App\Services\EmailService;

class ChatMessagesController extends Controller
{
    protected $emailService;

    public function __construct()
    {
        $this->emailService = app(EmailService::class);
    }

    public function savemessage(Request $request)
    {
        $sender = $request->sender;
        $receiver = $request->receiver;
        $content = $request->content;
        $offer = $request->offer;

        $data = [];

        $message = ChatMessage::create([
            'sender_id' => $sender,
            'reciever_id' => $receiver,
            'content' => $content,
            'offer_id' => $offer,
        ]);

        $sender = User::find($sender);
        $receiver = User::find($receiver);

        // Check if this is sender's second message to this receiver for this offer
        $messageCount = ChatMessage::where('sender_id', $sender->id)
            ->where('reciever_id', $receiver->id)
            ->where('offer_id', $offer)
            ->count();

        // Check if this is first reply from receiver to sender for this offer
        $previousMessages = ChatMessage::where('offer_id', $offer)
            ->where(function ($query) use ($sender, $receiver) {
                $query->where('sender_id', $sender->id)
                    ->where('reciever_id', $receiver->id);
            })
            ->orWhere(function ($query) use ($sender, $receiver) {
                $query->where('sender_id', $receiver->id)
                    ->where('reciever_id', $sender->id);
            })
            ->orderBy('created_at', 'asc')
            ->get();

        $isFirstReply = false;
        if (count($previousMessages) > 1) {
            $firstMessage = $previousMessages->first();
            $isFirstReply = $firstMessage->sender_id != $sender->id &&
                !ChatMessage::where('sender_id', $sender->id)
                    ->where('reciever_id', $receiver->id)
                    ->where('offer_id', $offer)
                    ->where('created_at', '<', $message->created_at)
                    ->exists();
        }

        // Send email notification if it's second message or first reply
        if ($messageCount === 2 || $isFirstReply) {
            $emailData = [
                'sender' => $sender,
                'reciever' => $receiver,
                'offer_id' => $offer
            ];

            $this->emailService->send($receiver->email, (new ChatEmail($emailData))->forUser($receiver), 'chat.notification', $receiver);

            // Log the notification
            ChatNotificationLog::create([
                'chat_message_id' => $message->id,
                'notified_at' => now()
            ]);
        }

        $data['sender'] = $sender;
        $data['reciever'] = $receiver;
        $data['content'] = $content;
        $data['offer_id'] = $offer;

        return response()->json($data);
    }

    public function getChatDropdown(Request $request)
    {
        $userId = auth()->id();

        // Group unread messages by offer_id for current user
        $unreadOffers = ChatMessage::where('receiver', $userId)
            ->where('status', 'unread')
            ->select('offer_id')
            ->distinct()
            ->pluck('offer_id')
            ->toArray();

        $dropdownHtml = '';
        $messages = ChatMessage::where('receiver', $userId)
            ->where('status', 'unread')
            ->latest()
            ->take(5)
            ->get();

        foreach ($messages as $msg) {
            $sender = \App\Models\User::find($msg->sender);
            $icon = "<i class='mr-2 fa-regular fa-comments text-primary'></i>";
            $text = "{$sender->name}: " . \Str::limit($msg->content, 30);
            $time = "<span class='float-right text-muted text-sm'>{$msg->created_at->diffForHumans()}</span>";

            $dropdownHtml .= "<a href='#' class='dropdown-item'>{$icon}{$text}{$time}</a>";
            $dropdownHtml .= "<div class='dropdown-divider'></div>";
        }

        // Format dropdown_flabel
        if (count($unreadOffers) > 0) {
            $offerLabels = collect($unreadOffers)->map(function ($offerId) {
                return "You have unread chat in Offer #{$offerId}";
            })->implode(', ');
        } else {
            $offerLabels = 'Open chat';
        }

        return [
            'label' => count($messages),
            'label_color' => 'danger',
            'icon_color' => 'primary',
            'dropdown' => $dropdownHtml,
            'dropdown_flabel' => $offerLabels, // 👈 this will override the config
        ];
    }
    public function index(){
        return view('chats.index');
    }

    public function show(Offer $offer){

        return view('chats.show', ['offer' => $offer]);
    }


}
