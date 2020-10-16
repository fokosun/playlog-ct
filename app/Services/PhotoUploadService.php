<?php

namespace Playlog\Services;

use Illuminate\Http\Request;
use Playlog\Jobs\PhotoUploadJob;
use Illuminate\Database\Eloquent\Model;

class PhotoUploadService
{
	/**
	 * Upload image to disk
	 *
	 * @param Model $resource
	 * @param Request $request
	 */
	public function upload(Model $resource, Request $request)
	{
		if ($photo = $request->file('photo')) {
			PhotoUploadJob::dispatchNow($resource, $request);
		}
	}
}