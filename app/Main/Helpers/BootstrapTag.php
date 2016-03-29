<?php
namespace App\Main\Helpers;

use Phalcon\Forms\Form;
use Phalcon\Tag;

class BootstrapTag extends Tag
{
	static public function renderFromElement(Form $form, $element, $attributes = [])
	{
		$form->get($element)->setAttribute('class', $form->get($element)->getAttribute('class', 'form-control'));
		return $form->render($element, $attributes);
	}
}