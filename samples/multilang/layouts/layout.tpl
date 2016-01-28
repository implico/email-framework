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
			<style type="text/css">
				{include file="[styles]layout.css" assign=styles}
				{SmartyUtils::removeCssComments($styles)|strip}
			</style>
		*}

	</head>

	<body>
		{table width=#lWidth#}
			{tr}
				{td valign="top" align="left" width=#lWidth#}
					
					{block script}{/block}
					
				{/td}
			{/tr}
			
		{/table}
	</body>
</html>
{/strip}{/block}