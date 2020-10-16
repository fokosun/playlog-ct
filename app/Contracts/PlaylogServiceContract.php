<?php

namespace Playlog\Contracts;

use Illuminate\Http\Request;

interface PlaylogServiceContract
{
	/**
	 * Creates new resource
	 *
	 * @param Request $request
	 * @return mixed
	 */
	public function store(Request $request);

	/**
	 * Deletes a resource
	 *
	 * @param array $resources
	 *
	 * @return mixed
	 */
	public function delete(array $resources);
}
