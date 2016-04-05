{**
	Implico Email Framework
	
	@package Internal core functions and vars
	@author Bartosz Sak <info@implico.pl>
	
*}{strip}


{* helper - adds id, class or custom attrs *}
{function attrs id="" class="" attrs=""}

	{if $id || $class || $attrs}
		{if $id}
			{literal} {/literal}
			id="{$id}"
		{/if}
		{if $class}
			{literal} {/literal}
			class="{$class}"
		{/if}
		{if $attrs}
			{literal} {/literal}
			{$attrs}
		{/if}
	{/if}
	
{/function}

{* helper - converts size in px to font tag size *}
{function convertFontSize size="3"}
	{if $size < 11}
		1
	{elseif $size < 13}
		2
	{elseif $size < 15}
		3
	{elseif $size < 20}
		4
	{elseif $size < 26}
		5
	{elseif $size < 39}
		6
	{elseif $size >= 39}
		7
	{/if}
{/function}


{block core}{/block}


{/strip}