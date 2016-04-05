{extends file="[core]core.tpl"}{block layout}{strip}

<html>
	<head>
		
		{* Eclipse hack *}
		{"<"}meta http-equiv="Content-Type" content="text/html; charset={#mEncoding#}" />
		
		{if #mTitle#}
			<title>{#mTitle#|escape}</title>
		{/if}
		
		{* uncomment if responsive
			<meta name="viewport" content="width=device-width, initial-scale=1.0" />
			<style type="text/css">
				{include file="[styles]layout.css" assign=styles}
				{$styles|strip}
			</style>
		*}

	</head>

	<body>
		{table align="center" width=#mWidth#}
			<tr>
				{td valign="top" align="left" colspan="3" width=#mWidth# lineHeight="1"}
					{$height = 89}
					{a href=""}{img src="img/top.jpg" alt="" width=#mWidth# height=$height id="logo"}{a e=true}
				{td e=true}
			</tr>
			<tr>
				{if #mLeftWidth#}
					{td valign="top" align="left" width=#mLeftWidth# bgColor="#f4f2ef" lineHeight="1"}
						{* uncomment to use an image
							{$height = 490}
							{img src="mail/left.jpg" width=#mLeftWidth# height=$height}
						*}
						&nbsp;
					{td e=true}
				{/if}
				
				{td valign="top" align="left" width=#mMiddleWidth#}
				
					{table}
					
						{trMargin height=50}
						
						{block script}{/block}
						
						{trMargin height=30}
						
					{table e=true}
					
				{td e=true}
				
				{if #mRightWidth#}
					{td valign="top" align="left" width=#mRightWidth# bgColor="#f4f2ef" lineHeight="1"}
						{* uncomment to use an image
							{$height = 490}
							{img src="mail/right.jpg" width=#mRightWidth# height=$height}
						*}
						&nbsp;
					{td e=true}
				{/if}
			</tr>
			
			{trMargin height=10 width=#mWidth# colspan=3 bgColor="#f4f2ef"}
			
			<tr>
				{$height = 30}
				{td valign="middle" align="center" colspan="3" width=#mWidth# height=$height bgColor="#f4f2ef"}
					{font color="#c3c1c1" size="11"}Aliquam sem. In hendrerit nulla quam nunc {font color="#c3c1c1" size="11" e=true}
					{a href="" textDecoration="none"}{font color="#c3c1c1" size="11"}sample.com{font color="#c3c1c1" size="11" e=true}{a e=true}{font color="#c3c1c1" size="11" content=". "}
					{font color="#c3c1c1" size="11"}In hendrerit, {font color="#c3c1c1" size="11" e=true} 
					{a href="" textDecoration="underline"}{font color="#c3c1c1" size="11" decoration="underline"}lorem ipsum{font color="#c3c1c1" size="11" decoration="underline" e=true}{a e=true}
					
				{td e=true}
			</tr>
			
			<tr>
				{$height = 10}
				{td valign="top" align="left" colspan="3" width=#mWidth# height=$height bgColor="#fff"}
					{img src="img/bottom.jpg" alt="" width=#mWidth# height=$height}
				{td e=true}
			</tr>
			
		{table e=true}
	</body>
</html>
{/strip}{/block}