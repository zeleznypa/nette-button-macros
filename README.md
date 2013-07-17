#nette-button-macros (cc)#
Pavel Železný (2bfree), 2013 ([pavelzelezny.cz](http://pavelzelezny.cz))

## Requirements ##

[Nette Framework 2.0.7](http://nette.org) or higher. PHP 5.3 edition

## Documentation ##

Add support of pair latte macro "button" for render form control SubmitButton as <button>. It can be useful for Twitter bootstrap design.

## Instalation ##

Prefered way to intall is by [Composer](http://getcomposer.org)

	{
		"require":{
			"zeleznypa/nette-button-macros": "dev-master"
		}
	}

## Setup ##

Add following code into neon.conf

	common:
		factories:
			nette.latte:
				class:  \Nette\Latte\Engine
				setup:
					- \Zeleznypa\Nette\Latte\Macros\FormMacros::install(::$service->getCompiler())


## Usage ##

In latte template you can use following code

	{form formName}
		{button controlName class=>"btn"}
			<i class="icon icon-ok"></i>
			{caption}
		{/button}
	{/form}

Also you can use object instead the control name

	{form formName}
		{button $_form['controlName'] class=>"btn"}
			<i class="icon icon-ok"></i>
			{caption}
		{/button}
	{/form}