<?php

namespace App\Console\Commands;

use App\Mail\ChatEmail;
use App\Models\ChatMessage;
use App\Models\Offer;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Services\EmailService;

class CheckUnrepliedChatMessages extends Command
{
    protected $signature = 'app:check-unreplied-chat-messages 
                          {--hours=24 : Number of hours to check for unreplied messages}
                          {--dry-run : Run without sending emails}
                          {--debug : Show debug information}';

    protected $description = 'Check for chat messages that have not recieved a reply within the specified time period and notify users';

    public function handle()
    {
        $hours = $this->option('hours');
        $isDryRun = $this->option('dry-run');
        $debug = $this->option('debug');

        $this->info("Checking for messages without replies in the last {$hours} hours...");

        try {
            // First, let's get all messages for debugging
            if ($debug) {
                $this->info("\n=== All Messages (for debugging) ===");
                $allMessages = ChatMessage::with(['sender', 'reciever', 'notificationLog'])
                    ->orderBy('created_at')
                    ->get();
                
                foreach ($allMessages as $msg) {
                    $this->info(sprintf(
                        "ID: %d | From: %s (ID: %d) | To: %s (ID: %d) | Offer: %d | Time: %s | Notified: %s | Content: %s",
                        $msg->id,
                        $msg->sender->name ?? 'Unknown',
                        $msg->sender_id,
                        $msg->reciever->name ?? 'Unknown',
                        $msg->reciever_id,
                        $msg->offer_id,
                        $msg->created_at,
                        $msg->hasBeenNotified() ? 'Yes' : 'No',
                        $msg->content
                    ));
                }
            }

            // Get unreplied messages that haven't been notified yet
            $unrepliedMessages = ChatMessage::with(['sender', 'reciever'])
                ->unrepliedWithinHours($hours)
                ->whereDoesntHave('notificationLog')
                ->get();

            $this->info("\n=== Last Messages Without Replies (Not Yet Notified) ===");
            foreach ($unrepliedMessages as $message) {
                $this->info(sprintf(
                    "\nMessage ID: %d",
                    $message->id
                ));
                $this->info(sprintf(
                    "From: %s (ID: %d) | To: %s (ID: %d) | Offer ID: %d",
                    $message->sender->name ?? 'Unknown',
                    $message->sender_id,
                    $message->reciever->name ?? 'Unknown',
                    $message->reciever_id,
                    $message->offer_id
                ));
                $this->info(sprintf(
                    "Sent at: %s",
                    $message->created_at
                ));
                $this->info(sprintf(
                    "Content: %s",
                    $message->content
                ));

                // Check for any messages between these users for this offer
                if ($debug) {
                    $relatedMessages = ChatMessage::where(function($query) use ($message) {
                        $query->where(function($q) use ($message) {
                            $q->where('sender_id', $message->sender_id)
                              ->where('reciever_id', $message->reciever_id);
                        })->orWhere(function($q) use ($message) {
                            $q->where('sender_id', $message->reciever_id)
                              ->where('reciever_id', $message->sender_id);
                        });
                    })
                    ->where('offer_id', $message->offer_id)
                    ->orderBy('created_at', 'desc')
                    ->get();

                    if ($relatedMessages->count() > 0) {
                        $this->info("\nAll messages between these users for Offer ID {$message->offer_id}:");
                        foreach ($relatedMessages as $related) {
                            $this->info(sprintf(
                                "ID: %d | From: %d | To: %d | Time: %s | Notified: %s | Content: %s",
                                $related->id,
                                $related->sender_id,
                                $related->reciever_id,
                                $related->created_at,
                                $related->hasBeenNotified() ? 'Yes' : 'No',
                                $related->content
                            ));
                        }
                    }
                }
            }

            $count = $unrepliedMessages->count();
            $this->info("\nFound {$count} unreplied messages that need notification.");

            if ($count === 0) {
                return 0;
            }

            if (!$isDryRun) {
                $bar = $this->output->createProgressBar($count);
                $bar->start();

                foreach ($unrepliedMessages as $message) {
                    if (!$message->reciever || !$message->sender) {
                        Log::warning("Missing user data for message ID: {$message->id}");
                        continue;
                    }

                    $data = [
                        'sender' => $message->sender,
                        'reciever' => $message->reciever,
                        'content' => $message->content,
                        'sent_at' => $message->created_at->format('Y-m-d H:i:s'),
                        'offer_id' => $message->offer_id
                    ];

                    // if (!Offer::find($message->offer_id)) {
                    //     $chat = ChatMessage::where('offer_id',$message->offer_id);
                    //     $chat->delete();
                    // }
                  
                    try {
                        $emailService = app(EmailService::class);
                        $emailService->send(
                            $message->reciever->email, 
                            (new ChatEmail($data))->forUser($message->reciever), 
                            'chat.notification', 
                            $message->reciever
                        );
                        
                        // Log the notification
                        $message->logNotification();
                        
                        $this->info("\nEmail sent to {$message->reciever->email} for unread message in Offer #{$message->offer_id}");
                    } catch (\Exception $e) {
                        Log::error("Failed to send email for message ID: {$message->id}", [
                            'error' => $e->getMessage(),
                            'reciever_email' => $message->reciever->email,
                            'offer_id' => $message->offer_id
                        ]);
                        $this->error("\nFailed to send email to {$message->reciever->email}");
                    }

                    $bar->advance();
                }

                $bar->finish();
                $this->newLine();
            }
            
            return 0;
        } catch (\Exception $e) {
            Log::error('Error in CheckUnrepliedChatMessages command', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            $this->error('An error occurred while processing unreplied messages: ' . $e->getMessage());
            return 1;
        }
    }
}
