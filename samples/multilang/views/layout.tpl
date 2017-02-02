{strip}
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    
    {* charset *}
    <meta http-equiv="Content-Type" content="text/html; charset={#encoding#}" />
    
    {* uncomment to test RWD
      <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    *}
    
    <style type="text/css">
      {include file="[styles]layout.tpl" assign=styles}
      {SmartyUtils::removeCssComments($styles)|strip}
    </style>

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
{/strip}