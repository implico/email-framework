{extends file="./core.internal.tpl"}{**
	Implico Email Framework
	
	@package Core functions
	@author Bartosz Sak <info@implico.pl>
	
*}{block core}{strip}


{* table *}
{function table cellpadding=0 cellspacing=0 bgColor="" border="0" borderColor="" width="" align="" style="" id="" class="" attrs="" e=false}
	
	{if !$e}
	
		{$cssWidth = $width}
		{if $width}
			{if strpos($width, '%') === false}
				{$cssWidth = "{$width}px"}
			{/if}
		{/if}
		
		<table cellpadding="{$cellpadding}" cellspacing="{$cellspacing}" border="{$border}"{if $bgColor} bgcolor="{$bgColor}"{/if} {if $borderColor}bordercolor="{$borderColor}" {/if}{if $align}align="{$align}" {/if}style="padding:0;margin:0{if $align == 'center'} auto{/if};{if $width}width:{$cssWidth};{/if}{if $bgColor}background:{$bgColor};{/if}{if $border}border:{$border}px solid {if $borderColor}{$borderColor}{else}#000{/if};{/if}{if !#mPacked#}border-collapse:collapse;mso-table-lspace:0pt;mso-table-rspace:0pt;{/if}{if $style} {$style}{/if}"{if $width} width="{$width}"{/if}{attrs id=$id class=$class attrs=$attrs}>
		
	{else}
	
		</table>
		
	{/if}
	
{/function}


{* td *}
{function td width="" height="" colspan=1 align="" valign="top" padding=0 bgColor="" lineHeight="" style="" fontFamily="" fontSize="" fontColor="" noFont="" id="" class="" attrs="" e=false}

	{if !$e}
		{if $width === ""}
			{$width = #mMiddleWidth#}
		{/if}
		
		{if $align === ""}
			{$align = #mTdAlign#}
		{/if}
		
		{if !$lineHeight}
			{if #mTdLineHeight#}
				{$lineHeight = #mTdLineHeight#}
			{/if}
		{/if}
		
		{if ($noFont === '') && #mPacked#}
			{$noFont = true}
		{/if}

		{if !$noFont}		
			{if $fontFamily === ""}
				{$fontFamily = #mFontFamily#}
			{/if}
			
			{if $fontSize === ""}
				{$fontSize = #mFontSize#}
			{/if}
			
			{if $fontColor === ""}
				{$fontColor = #mFontColor#}
			{/if}
		{/if}
		
		{$cssWidth = $width}
		{if $width}
			{if strpos($width, '%') === false}
				{$cssWidth = "{$width}px"}
			{/if}
		{/if}
		
	
		<td {if $colspan > 1}colspan="{$colspan}" {/if}valign="{$valign}" align="{$align}"{if $bgColor} bgcolor="{$bgColor}"{/if}{if $width} width="{$width}"{/if}{if $height} height="{$height}"{/if} style="{if $width}width:{$cssWidth};{/if}{if $height}height:{$height}px;{/if}vertical-align:{$valign};{if !#mPacked#}overflow:hidden;padding:{$padding};margin:0;text-align:{$align};{/if}{if $bgColor}background:{$bgColor};{/if}{if $lineHeight}line-height:{$lineHeight};{if !#mPacked#}mso-line-height-rule:exactly;{/if}{/if}{if $fontFamily}font-family:{$fontFamily};{/if}{if $fontSize}font-size:{$fontSize}px;{/if}{if $fontColor}color:{$fontColor};{/if}{if $style}{$style}{/if}"{attrs id=$id class=$class attrs=$attrs}>
		
	{else}
		</td>
	{/if}
{/function}


{* font function *}
{function font color="" size="" weight="normal" style="normal" cssStyle="" decoration="" family="" forceSetDefaults=false content="" lineHeight="" e=false}
	{$isBold = $weight == "bold"}
	{$isItalic = $style == "italic"}
	{$isUnderlined = $decoration == "underline"}
	
	{$isDefault = ($color === '') && ($size === '') && ($weight == 'normal') && ($style == 'normal') && ($decoration == 'none')}

	{$familyStyle = 'font-family: '|cat:$family|cat:';'}
	{if $family === ""}
		{$family = #mFontFamily#}
		{if !$forceSetDefaults}
			{$familyStyle = ''}
		{/if}
	{/if}
	
	{$sizeStyle = 'font-size:'|cat:$size|cat:'px;'}
	{if $size === ""}
		{$size = #mFontSize#}
		{if !$forceSetDefaults}
			{$sizeStyle = ''}
		{/if}
	{/if}
	
	{$colorStyle = 'color:'|cat:$color|cat:';'}
	{if $color === ""}
		{$color = #mFontColor#}
		{if !$forceSetDefaults}
			{$colorStyle = ''}
		{/if}
	{/if}
		
	{$weightStyle = 'font-weight:'|cat:$weight|cat:';'}
	{if ($weight == "normal") && !$forceSetDefaults}
		{$weightStyle = ''}
	{/if}
		
	{$styleStyle = 'font-style: '|cat:$style|cat:';'}
	{if ($style == "normal") && !$forceSetDefaults}
		{$styleStyle = ''}
	{/if}
		
	{$decorationStyle = ''}
	{if ($decoration !== "")}
		{$decorationStyle = 'text-decoration:'|cat:$decoration|cat:' !important;'}
	{/if}
	
	{*if $lineHeight === ''}
		{$lineHeight = $size|cat:"px"}
	{/if*}
		
	{if !$e}	
		{if #useSpanTagFont# && (!$isDefault || $forceSetDefaults)}<span style="{$colorStyle}{$sizeStyle}{$weightStyle}{$styleStyle}{$decorationStyle}{$familyStyle}{if $cssStyle};{$cssStyle}{/if}">{/if}
			{if $isBold}<b>{elseif $isItalic}<i>{elseif $isUnderlined}<u>{/if}
				{if #mUseFontTag#}<font color="{$color}" size="{convertFontSize size=$size}" face="{$family}" style="font-size:{$size}px;{if $lineHeight}line-height:{$lineHeight};{/if}{if $cssStyle};{$cssStyle}{/if}">{/if}
					{$content}
	{/if}
	
	{if $e || $content}					
				{if #mUseFontTag#}</font>{/if}
			{if $isBold}</b>{elseif $isItalic}</i>{elseif $isUnderlined}</u>{/if}
		{if #useSpanTagFont# && (!$isDefault || $forceSetDefaults)}</span>{/if}
	{/if}	
{/function}


{* helper - margin as a row *}
{function trMargin height=30 width=0 colspan=1 bgColor="" style="" class=""}
	{if $width === ''}
		{$width = #mMiddleWidth#}
	{/if}
	
	<tr>
		{td height=$height width=$width colspan=$colspan bgColor=$bgColor fontSize=1 style=$style class="tr-margin{if $class} {$class}{/if}"}{if $height >= 18}{font size=1}&nbsp;{font size=1 e=true}{/if}{td e=true}
	</tr>
{/function}


{* helper - margin as a font (text) *}
{function fontMargin height=10 addBr=true}
	{font size=$height}&nbsp;{if $addBr}<br />{/if}{font size=$height e=true}
{/function}


{* a (link) *}
{function a href="" textDecoration="" style="" id="" class="" attrs="" target="_blank" e=false}

	{if $textDecoration === ""}
		{$textDecoration = #mATextDecoration#}
	{/if}
	
	{if !$e}	
		<a href="{$href}"{if $textDecoration || $style} style="{if $textDecoration}text-decoration:{$textDecoration};text-decoration:{$textDecoration} !important;{/if}{if $style}{$style}{/if}"{/if}{attrs id=$id class=$class attrs=$attrs}{if $target} target="{$target}"{/if}>
	{else}
		</a>					
	{/if}	
{/function}


{* img *}
{function img src="" srcPrepend="" width="" height="" alt="" padding="0" margin="0" marginVertical="0" marginHorizontal="0" align="top" displayBlock="" id="" class="" attrs="" center=false border="0" borderColor="" cssStyle=""}
	{if $displayBlock === ''}
		{$displayBlock = true}
		
		{if ($center) && ($margin === "0")}
			{$margin = "0 auto"}
		{/if}
	{/if}
	
	{if !$margin}
		{if $marginVertical && !$marginHorizontal}
			{$margin = $marginVertical|cat:"px 0px"}
		{elseif !$marginVertical && $marginHorizontal}
			{$margin = "0px "|cat:$marginHorizontal|cat:"px"}
		{elseif $marginVertical && $marginHorizontal}
			{$margin = $marginVertical|cat:"px"|cat:$marginHorizontal|cat:"px"}
		{/if}
	{/if}
	
	{if !$srcPrepend}
		{$srcPrepend = #mImgSrcPrepend#}
	{/if}
	
	{$cssWidth = $width}
	{if $width}
		{if strpos($width, '%') === false}
			{$cssWidth = "{$width}px"}
		{/if}
	{/if}
		
			
	<img src="{$srcPrepend}{$src}" alt="{$alt}" {if $align} align="{$align}"{/if} border="{$border}" {if $borderColor}bordercolor="{$borderColor}" {/if}style="{if $displayBlock}display:block;{/if}padding:{$padding};margin:{$margin};{if $width} width:{$cssWidth};{/if}{if $height}height:{$height}px;{/if}{if $border}border:{$border}px solid {if $borderColor}{$borderColor}{else}#000{/if};{else}border:none;{/if}outline:none;text-decoration:none;-ms-interpolation-mode:bicubic;"{if $width} width="{$width}"{/if}{if $height} height="{$height}"{/if} hspace="{$marginHorizontal}" vspace="{$marginVertical}"{attrs id=$id class=$class attrs=$attrs} />
{/function}


{* ul > li *}
{function li symbol="&bull;" symbolWidth=40 symbolSize="" symbolAlign="center" symbolStyle="" addContentTd=true content="" contentWidth="" margin=0 addBr=true e=false}

	{if $symbolSize === ''}
		{$symbolSize = #mFontSize#}
	{/if}
	
	{if $contentWidth === ''}
		{math equation="mMiddleWidth - symbolWidth" mMiddleWidth=#mMiddleWidth# symbolWidth=$symbolWidth assign=contentWidth}
	{/if}

	{if !$e}
		{td width=$symbolWidth align=$symbolAlign style=$symbolStyle}
			{if $symbolSize}{font size=$symbolSize cssStyle=$symbolStyle}{/if}{$symbol}{if $symbolSize}{font size=$symbolSize e=true}{/if}
		{td e=true}
		
		{if $addContentTd}
			{td width=$contentWidth align="left"}
				{if $content}
					{font}{$content}{font e=true}
				{/if}
		{/if}
	{/if}
	
	{if $e || $content}
		{if $margin}
			{if $addBr}<br />{/if}{fontMargin height=$margin addBr=false}
		{/if} 
		{td e=true}
	{/if}
{/function} 


{* button function *}
{function button width="" height=50 buttonAlign="center" borderRadius=5 borderWidth="0" borderColor="" marginTop=0 marginBottom=0 bgColor="" align="center" color="" href="" content="" fontFamily="" fontSize="" fontWeight="" id="" class="" attrs=""}

	{if $bgColor === ""}
		{$bgColor = #mButtonBgColor#}
	{/if}
	
	{if $color === ""}
		{$color = #mButtonColor#}
	{/if}
	
	{if $fontFamily === ""}
		{$fontFamily = #mFontFamily#}
	{/if}
	
	{if $fontSize === ""}
		{$fontSize = #mFontSize#}
	{/if}
	
	{table align=$buttonAlign bgcolorborder=$borderWidth borderColor=$borderColor id=$id class=$class attrs=$attrs}
	
		{if $marginTop}
			{trMargin width=$width height=$marginTop}
		{/if}
		
		<tr>
			<td valign="middle" align="{$align}"{if $width} width="{$width}"{/if} height="{$height}" style="{if $width}width:{$width}px;{/if}height:{$height}px;padding:0;margin:0;background:{$bgColor};{if $borderRadius}-webkit-border-radius:{$borderRadius}px;-moz-border-radius:{$borderRadius}px;border-radius:{$borderRadius}px;{/if}" bgcolor="{$bgColor}">
				{if $align == 'center'}
					<center>
				{/if}
				{a href="{$href}" textDecoration="none" style="mso-line-height-rule:exactly;height:{$height}px;line-height:{$height}px;vertical-align:middle;width:100%;white-space:nowrap;overflow:hidden;display:inline-block"}
					{font color=$color size=$fontSize weight=$fontWeight family=$fontFamily content=$content}
				{a e=true}
				{if $align == 'center'}
					</center>
				{/if}
			</td>
		</tr>
		
		{if $marginBottom}
			{trMargin width=$width height=$marginBottom}
		{/if}
		
	{table e=true}
{/function}



{block layout}{/block}{/strip}{/block}