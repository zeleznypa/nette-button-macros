<?php

namespace Zeleznypa\Nette\Latte\Macros;

use Latte\CompileException;
use Latte\Compiler;
use Latte\MacroNode;
use Latte\Macros\MacroSet;
use Latte\PhpWriter;

/**
 * Some new nette form latte macros
 * @author Pavel Železný <info@pavelzelezny.cz>
 */
class FormMacros extends MacroSet
{

	/**
	 * Register latte macros
	 * @author Pavel Železný <info@pavelzelezny.cz>
	 * @param Compiler $compiler
	 */
	public static function install(Compiler $compiler)
	{
		$me = new static($compiler);
		$me->addMacro('button', array($me, 'macroButton'), array($me, 'macroButtonEnd'));
		$me->addMacro('caption', array($me, 'macroCaption'));
	}

	/**
	 * Renders button beginning tag
	 * @author Pavel Železný <info@pavelzelezny.cz>
	 * @param MacroNode $node
	 * @param PhpWriter $writer
	 * @return void
	 */
	public function macroButton(MacroNode $node, PhpWriter $writer)
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
	 * @param MacroNode $node
	 * @param PhpWriter $writer
	 * @return void
	 */
	public function macroButtonEnd(MacroNode $node, PhpWriter $writer)
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
	 * @param MacroNode $node
	 * @param PhpWriter $writer
	 * @return void
	 */
	public function macroCaption(MacroNode $node, PhpWriter $writer)
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
