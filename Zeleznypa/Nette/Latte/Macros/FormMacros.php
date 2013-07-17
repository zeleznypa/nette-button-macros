<?php

namespace Zeleznypa\Nette\Latte\Macros;

use Nette\Latte;

/**
 * Some new nette form latte macros
 * @author Pavel Železný <info@pavelzelezny.cz>
 */
class FormMacros extends \Nette\Latte\Macros\MacroSet
{

	/**
	 * Register latte macros
	 * @author Pavel Železný <info@pavelzelezny.cz>
	 * @return void
	 */
	public static function install(Latte\Compiler $compiler)
	{
		parent::install($compiler);
		$me = new static($compiler);
		$me->addMacro('button', array($me, 'macroButton'), array($me, 'macroButtonEnd'));
		$me->addMacro('caption', array($me, 'macroCaption'));
	}

	/**
	 * Renders button beggining tag
	 * @author Pavel Železný <info@pavelzelezny.cz>
	 * @param \Nette\Latte\MacroNode $node
	 * @param \Nette\Latte\PhpWriter $writer
	 * @return void
	 */
	public function macroButton(\Nette\Latte\MacroNode $node, \Nette\Latte\PhpWriter $writer)
	{
		$code = '$_input = (is_object(%node.word) ? %node.word : $_form[%node.word]);';
		$code .= '$_attributes[$_input->getName()] = %node.array;';
		$code .= '$_buttonAttrs = $_input->getControl()->attrs;';
		$code .= '$_buttonCaption = isset($_buttonAttrs[\'value\']) === TRUE ? $_buttonAttrs[\'value\'] : NULL;';
		$code .= 'unset($_buttonAttrs[\'type\'], $_buttonAttrs[\'value\']);';
		$code .= '$_buttonAttrs[\'type\'] = \'submit\';'; // Prevent button type="image"
		$code .= '$_buttonControl = \Nette\Utils\Html::el(\'button\')->addAttributes(array_merge((array) $_buttonAttrs,$_attributes[$_input->getName()]));';
		$code .= 'echo $_buttonControl->startTag();';
		return $writer->write($code);
	}

	/**
	 * Renders button end tag
	 * @author Pavel Železný <info@pavelzelezny.cz>
	 * @param \Nette\Latte\MacroNode $node
	 * @param \Nette\Latte\PhpWriter $writer
	 * @return void
	 */
	public function macroButtonEnd(\Nette\Latte\MacroNode $node, \Nette\Latte\PhpWriter $writer)
	{
		$code = 'echo $_buttonControl->endTag();';
		$code .= 'unset($_buttonControl);';
		$code .= 'unset($_buttonCaption);';
		$code .= 'unset($_buttonAttrs);';
		$code .= 'unset($_attributes);';
		$code .= 'unset($_input);';
		return $writer->write($code);
	}

	/**
	 * Render button caption
	 * @author Pavel Železný <info@pavelzelezny.cz>
	 * @param \Nette\Latte\MacroNode $node
	 * @param \Nette\Latte\PhpWriter $writer
	 * @return void
	 */
	public function macroCaption(\Nette\Latte\MacroNode $node, \Nette\Latte\PhpWriter $writer)
	{
		if ($node->args !== '')
		{
			$code = '$_input = (is_object(%node.word) ? %node.word : $_form[%node.word]);';
			$code .= 'echo isset($_input->getControl()->attrs[\'value\']) === TRUE ? $_input->getControl()->attrs[\'value\'] : NULL;';
			$code .= 'unset($_input);';
		}
		else
		{
			$code = 'echo isset($_buttonCaption) ? $_buttonCaption : NULL;';
		}
		return $writer->write($code);
	}

}