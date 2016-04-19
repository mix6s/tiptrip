<?php

namespace App\Main\Components;

use Phalcon\Mvc\User\Component;

/**
 * Class PopupManager
 * @package App\Main\Components
 */
class PopupManager extends Component
{
	private $_popups = [];

	/**
	 * @param $name
	 */
	public function addPopupToOutput($name, $params = [])
	{
		if (!in_array($name, $this->_popups)) {
			$this->_popups[] = ['name' => $name, 'params' => $params];
		}
	}

	/**
	 * @return string
	 */
	public function output()
	{
		$html = '';
		foreach ($this->_popups as $popup) {
			$html .= $this->getDI()->tag->popup($popup['name'], $popup['params']) . PHP_EOL;
		}
		return $html;
	}

	/**
	 * @return DI
	 */
	public function getDI()
	{
		return parent::getDI();
	}
}