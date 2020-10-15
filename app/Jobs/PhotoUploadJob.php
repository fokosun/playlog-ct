<?php

namespace Playlog\Jobs;

use Illuminate\Support\Facades\Log;
use Playlog\Comment;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class PhotoUploadJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $comment;
    protected $request;

	/**
	 * Create a new job instance.
	 *
	 * @param Comment $comment
	 * @param Request $request
	 */
    public function __construct(Comment $comment, Request $request)
    {
        $this->comment = $comment;
        $this->request = $request;
    }

	/**
	 * Execute the job.
	 *
	 * @return void
	 */
    public function handle()
    {
		Log::info('Uploading image ...');

    	$photo = $this->request->file('photo');
    	$ext = $photo->getClientOriginalExtension();
    	Storage::disk('public')->put($photo->getFilename() . '.' . $ext, File::get($photo));

		Log::info('Image upload complete.');

    	$this->comment->update(['photo_url' => $photo->getFilename() . '.' . $ext]);
    }
}
