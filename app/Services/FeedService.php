<?php

namespace Playlog\Services;

class FeedService
{
	/**
	 * Eagerload a given resource along with its relationships
	 *
	 * @param string $resource
	 * @param array $relations
	 * @param array $options
	 *
	 * @return mixed
	 */
	public function index(string $resource, $relations = [], $options = [])
	{
		return $resource::with($relations)
			->orderBy(($options['order_by'] ? $options['order_by'] : 'created_at') , ($options['order'] ? $options['order'] : 'asc'))
			->paginate($options['paginate']);
	}
}
