<?php

namespace Playlog\Jobs;

use Illuminate\Http\Request;
use Illuminate\Bus\Queueable;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Symfony\Component\HttpKernel\Exception\UnsupportedMediaTypeHttpException;

class PhotoUploadJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public Model $resource;
    public Request $request;
    public UploadedFile $photo;
    public array $options;
	protected array $supported_extensions = ['jpg', 'png', 'jpeg'];

	/**
	 * Create a new job instance.
	 *
	 * @param Model $resource
	 * @param Request $request
	 */
    public function __construct(Model $resource, Request $request)
    {
        $this->resource = $resource;
        $this->request = $request;
        $this->photo = $this->request->file('photo');
    }

	/**
	 * Execute the job.
	 *
	 * @return void
	 */
    public function handle()
    {
		Log::info('Uploading image ...');

		try {
			$ext = $this->photo->getClientOriginalExtension();

			if (in_array($ext, $this->supported_extensions)) {
				Storage::disk('public')->put($this->photo->getFilename() . '.' . $ext, File::get($this->photo));

				Log::info('Image upload completed.');

				$photo_path = $this->request->get('resource_photo_path');

				if (isset($photo_path)) {
					$this->resource->update([$photo_path => $this->photo->getFilename() . '.' . $ext]);
				}
			} else {
				throw new UnsupportedMediaTypeHttpException('Image Extension not supported');
			}
		} catch (\Exception $e){
			Log::info('Upload failed', ['message' => $e->getMessage()]);
		}
    }
}
