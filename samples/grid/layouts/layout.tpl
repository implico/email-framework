{block layout}{strip}
<html>
	<head>
		
		{* Eclipse hack *}
		{"<"}meta http-equiv="Content-Type" content="text/html; charset={#encoding#}" />
		
		{if #title#}
			<title>{#title#|escape}</title>
		{/if}
		
		{* uncomment if responsive
			<meta name="viewport" content="width=device-width, initial-scale=1.0" />
    *}
    
		<style type="text/css">
			{include file="[styles]layout.css" assign=styles}
			{SmartyUtils::removeCssComments($styles)|strip}
		</style>

	</head>

	<body>
		{table width=#lWidth#}
			{tr}
				{td valign="top" align="left" colspan="3" width=#lWidth# lineHeight="1"}
					{a href=""}{img src="top.jpg" id="logo"}{/a}
				{/td}
			{/tr}
			{tr}
				{$leftWidth = 30}
				{td valign="top" align="left" width=$leftWidth bgcolor="#f4f2ef" lineHeight="1"}
					&nbsp;
				{/td}
				
				{td valign="top" align="left" width=#lWidth#}
				
					{table}
					
						{margin height=50}
						
						{block script}{/block}
						
						{margin height=30}
						
					{/table}
					
				{/td}
				
				{$rightWidth = 30}
				{td valign="top" align="left" width=$rightWidth bgcolor="#f4f2ef" lineHeight="1"}
					&nbsp;
				{/td}
			{/tr}
			
			{margin height=10 colspan=3 bgcolor="#f4f2ef"}
			
			{tr}
				{$height = 30}
				{td valign="middle" colspan="3" width=#lWidth# height=$height bgcolor="#f4f2ef"}
					{font color="#c3c1c1" size="11"}Aliquam sem. In hendrerit nulla quam nunc {/font}
					{a href="" textDecoration="none"}{font color="#c3c1c1" size="11"}sample.com{/font}{/a}{font color="#c3c1c1" size="11"}. {/font}
					{font color="#c3c1c1" size="11"}In hendrerit, {/font} 
					{a href="" textDecoration="underline"}{font color="#c3c1c1" size="11" decoration="underline"}lorem ipsum{/font}{/a}
				{/td}
			{/tr}
			
			{tr}
				{$height = 10}
				{td valign="top" align="left" colspan="3" width=#lWidth# height=$height bgcolor="#fff"}
					{img src="bottom.jpg" alt=false width=#lWidth# height=$height}
				{/td}
			{/tr}
			
		{/table}
	</body>
</html>
{/strip}{/block}