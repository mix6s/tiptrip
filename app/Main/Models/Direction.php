<?php

namespace App\Main\Models;

use App\Main\Components\Model;

/**
 * Class Direction
 * @package App\Main\Models
 * @property-read int $id
 * @property-read string $title
 */
class Direction extends Model
{
	/**
	 * @return int
	 */
	public function getId()
	{
		return $this->readAttribute('id');
	}

	/**
	 * @return int
	 */
	public function getTitle()
	{
		return $this->readAttribute('title');
	}
}