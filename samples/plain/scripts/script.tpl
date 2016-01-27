{extends "[layouts]layout.tpl"}{block script}

{table}
  {tr}
    {td colspan=2}
      {font size=20}Title{/font}
    {/td}
  {/tr}

  {margin height=50 colspan=2}

  {tr}
    {$leftWidth = 400}
    {$rightWidth = 200}
    {td width=$leftWidth}
      {a href=""}{img src="image.jpg"}{/a}
    {/td}
    {td width=$rightWidth padding="0 0 0 10px"}
      {font weight=bold}Bold font with default family and size{/font}
    {/td}
  {/tr}
{/table}


{/block}