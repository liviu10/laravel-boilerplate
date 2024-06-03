<?php

namespace App\Jobs;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Exception;

class UpdateContentVisibility implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $content;

    /**
     * Create a new job instance.
     */
    public function __construct(Collection $payload)
    {
        $this->content = $payload;
    }

    /**
     * Execute the job to update the content visibility to published.
     */
    public function handle(): bool
    {
        try {
            foreach($this->content as $item) {
                $item->partialUpdateRecord([
                    'scheduled_on' => null,
                    'content_visibility_id' => 1,
                ], $item->id);
            }
            Log::info(
                'Successfully updated the content visibility',
                [
                    'command' => get_class($this),
                    'payload' => $this->content->toArray(),
                ]
            );

            return true;
        } catch (Exception $exception) {
            Log::error(
                'Failed to update the content visibility',
                [
                    'command' => get_class($this),
                    'payload' => $this->content,
                    'exception' => $exception,
                ]
            );

            return false;
        }
    }
}
