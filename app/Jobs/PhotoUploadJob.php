<?php

namespace Playlog\Jobs;

use Illuminate\Http\Request;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class PhotoUploadJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected Model $resource;
    protected Request $request;
    public array $options;

	/**
	 * Create a new job instance.
	 *
	 * @param Model $resource
	 * @param Request $request
	 * @param array $options
	 */
    public function __construct(Model $resource, Request $request, $options = [])
    {
        $this->resource = $resource;
        $this->request = $request;
        $this->options = $options;
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

		Log::info('Image upload completed.');

		if ($this->options["resource_photo_path"]) {
			$this->resource->update([$this->options["resource_photo_path"] => $photo->getFilename() . '.' . $ext]);
		}
    }
}
