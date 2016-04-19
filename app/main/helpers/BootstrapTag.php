<?php
namespace App\Main\Helpers;

use App\Main\Components\DI;
use Phalcon\Forms\Form;
use Phalcon\Tag;

class BootstrapTag extends Tag
{
	static public function renderFromElement(Form $form, $element, $attributes = [])
	{
		$form->get($element)->setAttribute('class', $form->get($element)->getAttribute('class', 'form-control'));
		return $form->render($element, $attributes);
	}

	static public function rub($amount)
	{
		return sprintf('%s<i class="icon-rub-bold"></i>', number_format($amount, 0, ',', ' '));
	}

	static public function timeCounter(\DateTime $endTime, \DateTime $startTime = null)
	{
		if (null === $startTime) {
			$startTime = new \DateTime('now');
		}
		$interval = $endTime->diff($startTime);
		$textData = [];
		if ($interval->d) {
			$textData[] = $interval->d . ' д.';
		}
		if ($interval->h) {
			$textData[] = $interval->h . ' ч.';
		}
		if ($interval->i) {
			$textData[] = $interval->i . ' м.';
		}
		return sprintf(
			'<span data-time="%s">%s</span>',
			$endTime->getTimestamp() - $startTime->getTimestamp(),
			implode(' ', $textData)
		);
	}

	static public function popup($name)
	{
		/** @var DI $di */
		$di = self::getDI();
		return $di->view->partial('shared/popup/' . $name);
	}

	static public function popupLink($text, $popupName, array $attributes = [])
	{
		return self::popupTag('a', $text, $popupName, $attributes, [
			'class' => [],
			'href' => '#',
			'data-toggle' => 'modal',
			'data-target' => '#popup_' . $popupName
		]);
	}

	static public function popupButton($text, $popupName, array $attributes = [])
	{
		return self::popupTag('button', $text, $popupName, $attributes, [
			'class' => [],
			'data-toggle' => 'modal',
			'data-target' => '#popup_' . $popupName
		]);
	}

	static private function popupTag($tag, $text, $popupName, array $attributes = [], array $defs = [])
	{
		if (array_key_exists('class', $attributes) && is_string($attributes['class'])) {
			$attributes['class'] = explode(' ', $attributes['class']);
		}
		$attributes = array_merge_recursive($defs, $attributes);
		if (array_key_exists('class', $attributes) && is_array($attributes['class'])) {
			$attributes['class'] = implode(' ', $attributes['class']);
		}
		/** @var DI $di */
		$di = self::getDI();
		$di->popupManager->addPopupToOutput($popupName);
		return self::tagHtml($tag, $attributes, false, true) . $text . self::tagHtmlClose($tag);
	}
}