<?php

namespace App\Transformers;

use App\Like;

class LikeTransformer extends \League\Fractal\TransformerAbstract
{
	protected $availableIncludes = ['user'];
	
	public function transform(Like $like)
	{
		return [
			'id' => $like->id,
		];
	}
	
	
	public function includeUser(Like $like)
	{
		return $this->item($like->user, new UserTransformer);
	}
}