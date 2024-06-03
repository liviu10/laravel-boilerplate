<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Content;
use Illuminate\Database\Eloquent\Collection;
use App\Jobs\UpdateContentVisibility;
use App\Mail\EmailUpdateContentVisibility;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Console\Command;
use Exception;

class UpdateContent extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-content';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update the content visibility based on today\'s date and send an email notification to the user that created the content';

    protected $content;

    public function __construct()
    {
        parent::__construct();
        $this->content = new Content();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            $today = Carbon::today()->toDateString();
            $contents = $this->content->fetchAllRecords(['scheduled_on' => $today]);

            if ($contents instanceof Collection && $contents->isNotEmpty()) {
                $jobUpdate = UpdateContentVisibility::dispatch($contents);
                Log::info(
                    'Successfully dispatched the job to update the content visibility',
                    [
                        'command' => get_class($this),
                        'payload' => $contents->toArray(),
                        'job' => Str::beforeLast(UpdateContentVisibility::class, '\\') . class_basename(UpdateContentVisibility::class),
                    ]
                );

                if ($jobUpdate) {
                    Mail::to($contents->toArray()[0]['user']['email'])->send(new EmailUpdateContentVisibility($contents->toArray()));
                    Log::info(
                        'Successfully sent the email',
                        [
                            'command' => get_class($this),
                            'payload' => $contents->toArray(),
                        ]
                    );
                } else {
                    Log::warning(
                        'The job was successfully dispatched but the content was not updated',
                        [
                            'command' => get_class($this),
                            'payload' => $contents,
                        ]
                    );
                }
            } else {
                Log::warning(
                    'The job was not dispatched because there are no record to match the criteria',
                    [
                        'command' => get_class($this),
                        'payload' => $contents,
                    ]
                );
            }
        } catch (Exception $exception) {
            Log::error(
                'Failed to dispatch the job to update the content visibility',
                [
                    'command' => get_class($this),
                    'payload' => $contents,
                    'exception' => $exception,
                ]
            );
        }
    }
}
