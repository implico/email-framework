{strip}
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		
		{* charset *}
		<meta http-equiv="Content-Type" content="text/html; charset={#encoding#}" />
		
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
				{td width=#lWidth#}
					
				{/td}
			{/tr}
			
		{/table}
	</body>
</html>
{/strip}