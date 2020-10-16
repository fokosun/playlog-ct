<?php

namespace Playlog\Services;

class FeedService
{
	protected array $defaults = [
		'order_by' => 'created_at',
		'order' => 'asc'
	];

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
		$collection = $resource::with($relations)
			->orderBy(
				(isset($options['order_by']) ? $options['order_by'] : $this->defaults['order_by']),
				(isset($options['order']) ? $options['order'] : $this->defaults['order'])
			);

		return (isset($options['paginate'])) ? $collection->paginate($options['paginate']) : $collection->get();
	}
}
