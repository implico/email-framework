{extends "[layouts]layout.tpl"}{block script}
	{tr}
		{td}
			{font size=32 weight=bold}{#title#}{/font}
		{/td}
	{/tr}
	
	{margin height=40}
	
	{tr}
		{td}
		
			{font size=14}
				Lorem ipsum dolor sit amet. Etiam ullamcorper:
			{/font}
		{/td}
	{/tr}
	
	{margin height=25}
	
	{tr}
		{td}
			
			{table cellpadding="4" width=false}
				
				{tr}
					{td width=100 align=left padding="4px"}
						{font size=12}Lorem:{/font}
					{/td}
					{td width=100 align=left padding="4px"}
						{font size=12}
							Ipsum dolor
						{/font}
					{/td}
					
				{/tr}
				{tr}
					{td width=100 align=left padding="4px"}
						{font size=12}Curabitur:{/font}
					{/td}
					{td width=100 align=left padding="4px"}
						{font size=12}
							Suspendisse
						{/font}
					{/td}
					
				{/tr}
				{tr}
					{td width=100 align=left padding="4px"}
						{font size=12}Nullam (%):{/font}
					{/td}
					{td width=100 align=left padding="4px"}
						{font size=12}
							40
						{/font}
					{/td}
					
				{/tr}
				
			{/table}
			
		{/td}
	{/tr}
	
	{margin height=60}
	
	{tr}
		{td}
			{font size=15 weight=bold}
				Cum sociis natoque penatibus et ultrices volutpat...
			{/font}
		{/td}
	{/tr}
	
	{margin height=30}
			
	{tr}
		{td}
			{table}
				{tr}
					{td width="240"}


						{* Buttons *}

						{table width=170 align=center}
							{margin height=10}
							{tr}
								{td width=170 bgcolor="#4040ff" height=50 borderRadius="5px"}
									{a href="" buttonHeight=50}
										{font color="#fff"}
											Lorem ipsum &raquo;
										{/font}
									{/a}
								{/td}
							{/tr}
							{margin height=15}
							{tr}
								{td width=170 bgcolor="#ff4040" height=50 borderRadius="5px"}
									{a href="" buttonHeight=50}
										{font color="#fff"}
											Dolor amet &raquo;
										{/font}
									{/a}
								{/td}
							{/tr}
						{/table}
						
					{/td}
					
					
					{td width="300" align="left" lineHeight="1.5"}
					
						{font}
							Lorem ipsum dolor sit amet enim. Etiam ullamcorper a pellentesque dui:<br />
						{/font}
						
						{font size=6}<br />{/font}
						

						{* List *}

						{table width="300"}

							{tr}
								{td width=20}
									{font size=12}&bull;{/font}
								{/td}
								{td width=280 align=left}
									{font size=12}Aliquam sem. In hendrerit nulla quam nunc, accumsan congue.{/font}
								{/td}
							{/tr}
							{margin height=10 colspan=2}
							{tr}
								{td width=20}
									{font size=12}&bull;{/font}
								{/td}
								{td width=280 align=left}
									{font size=12}Lorem ipsum primis.{/font}
								{/td}
							{/tr}
							{margin height=10 colspan=2}
							{tr}
								{td width=20}
									{font size=12}&bull;{/font}
								{/td}
								{td width=280 align=left}
									{font size=12 weight=bold}Curabitur et ligula!{/font}
								{/td}
							{/tr}
						{/table}
						
					{/td}
				{/tr}
			{/table}
			
		{/td}
	{/tr}

{/block}