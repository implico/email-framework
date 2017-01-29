{strip}
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    
    {* charset *}
    <meta http-equiv="Content-Type" content="text/html; charset={#encoding#}" />
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    
    <style type="text/css">
      {include file="[styles]layout.tpl" assign=styles}
      {SmartyUtils::removeCssComments($styles)|strip}
    </style>

  </head>

  <body>

    {* responsive: Outlook max-width hack / BEGIN *}
    <!--[if (gte mso 9)|(IE)]>
    {table width=#lWidth#}
        {tr}
            {td align=left width=#lWidth#}
                <![endif]-->


    {table style="max-width:"|cat:#lWidth#|cat:"px" id="main-table" class="main-table"}


      {tr}
        {td valign="top" align="left"}
          {a href=""}{img src="logo.jpg" alt="Logo" width="100%" id="logo"}{/a}
        {/td}
      {/tr}
      
      {margin height=19}
      
      {tr}
        {td height=6}
          {img src="dot.gif" width="100%" height="1" alt=""}
        {/td}
      {/tr}
      {tr}
        {td align="left"}
        
          {table}
            {tr}
              {$h = 20}
              {td width="5%" height=$h}
                &nbsp;
              {/td}
              {td width="15%" height=$h bgcolor="#6b202b" valign=middle lineHeight="17px" style="white-space:nowrap;word-break:keep-all;"}
                {a href=""}{font size=16 color="#ffffff"}NEWS{/font}{/a}
              {/td}
              {td width="13%" height=$h}
                &nbsp;
              {/td}
              {td width="16%" height=$h valign=middle lineHeight="17px" style="white-space:nowrap;word-break:keep-all;"}
                {a href=""}{font size=16 color="#6b202b"}TRENDS{/font}{/a}
              {/td}
              {td width="16%" height=$h}
                &nbsp;
              {/td}
              {td width="5%" height=$h valign=middle lineHeight="17px" style="white-space:nowrap;word-break:keep-all;"}
                {a href=""}{font size=16 color="#6b202b"}SHOES{/font}{/a}
              {/td}
              {td width="15%" height=$h}
                &nbsp;
              {/td}
              {td width="10%" height=$h valign=middle lineHeight="17px" style="white-space:nowrap;word-break:keep-all;"}
                {a href=""}{font size=16 color="#6b202b"}CLOTHES{/font}{/a}
              {/td}
              {td width="5%" height=$h}
                &nbsp;
              {/td}
            {/tr}
          {/table}
        {/td}
      {/tr}
      
      {tr}
        {td height=6 valign=bottom}
          {img src="dot.gif" width="100%" height="1" alt=""}
        {/td}
      {/tr}
      
      {margin height=18}
      
      {tr}
        {td}
          {a href=""}{img src="banner.jpg" alt="Banner" width="100%"}{/a}
        {/td}
      {/tr}
        
      {margin height=35}
      
      {tr}
        {td align="left"}
        
          {table}
          
            {block script}{/block}
            
          {/table}
          
        {/td}
        
      {/tr}
      
      {margin height=20}
      
      {tr}
        {$h = 20}
        {td}
          {table}
            {tr}
              {td width="2%" height=$h}&nbsp;{/td}
              {td width="96%" height=$h}
                {img src="dot.gif" width="100%" height="1" alt=""}
              {/td}
              {td width="2%" height=$h}&nbsp;{/td}
            {/tr}
          {/table}
        {/td}
      {/tr}
      
      {tr}
        {td}
          {table bgcolor="#3c618e"}
            {$h = 40}
            {tr}
              {td width="43%" valign=middle height=$h align=right lineHeight="12px"}
                {a href=""}
                  {font size=12 bold=1 color="#ffffff"}
                    Over&nbsp;1000&nbsp;fans
                  {/font}
                {/a}
              {/td}
              {td width="1%" valign=middle height=$h align=right lineHeight="14px"}
                &nbsp;
              {/td}
              {td width="5%" valign=middle height=$h align=left}
                {a href=""}
                  {img src="facebook.jpg" alt="FB" width=32 height=30 displayBlock=false style="vertical-align: middle;"}
                {/a}
              {/td}
              {td width="1%" valign=middle height=$h align=right lineHeight="14px"}
                &nbsp;
              {/td}
              {td width="50%" valign=middle height=$h align=left lineHeight="12px"}
                {a href=""}
                  {font size=12 bold=1 color="#ffffff"}
                    VISIT&nbsp;OUR&nbsp;FACEBOOK&nbsp;&gt;&gt;
                  {/font}
                {/a}
              {/td}
            {/tr}
          {/table}
        {/td}
      {/tr}
      
      {margin height=17}
      
      {tr}
        {td lineHeight="12px"}
          {font size=9 color="#7d7d7d"}
            Lorem ipsum dolor sit amet sapien tristique senectus et turpis. Nullam eros egestas dignissim.  <br />
            e-mail:{/font}{a href="mailto:mail@mail.com"}#(strip){font size=9 color="#3000f0" underlined=1}mail@mail.com{/font}{/a}{font size=8 color="#7d7d7d"},#(/strip) tel.: +00 00 11 22 33 444
          {/font}
        {/td}
      {/tr}
      
      {margin height=2}
      
      {tr}
        {td height=3 valign=top}
          {img src="dot.gif" width="100%" height="1" alt=""}
        {/td}
      {/tr}
      
      {tr}
        {td}
          {table}
            {tr}
              {td width="2%"}&nbsp;{/td}
              {td width="96%" valign=top lineHeight="12px"}
                {font size=9 color="#7d7d7d"}
                  Lorem ipsum dolor sit amet sapien tristique senectus et turpis. <br />
                  Nullam eros egestas dignissim, sapien auctor congue eu, iaculis leo, in augue. Maecenas gravida, #(strip)
                  {/font}{a href=""}{font size=9 color="#3000f0" underlined=1}unsubscribe link{/font}{/a}{font size=8 color="#7d7d7d"}#(/strip).
                {/font}
              {/td}
              {td width="2%"}&nbsp;{/td}
            {/tr}
          {/table}
        {/td}
      {/tr}
      
      {margin height=30}

    {/table}


    {* responsive: Outlook max-width hack / END *}
    <!--[if (gte mso 9)|(IE)]>
            {/td}
        {/tr}
    {/table}
    <![endif]-->


  </body>
</html>
{/strip}