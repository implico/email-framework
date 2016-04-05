{extends "[layouts]layout.tpl"}{block script}
	<tr>
		{td}
			{font size=32 weight=bold content=#mTitle#}
		{td e=true}
	</tr>
	
	{trMargin height=40}
	
	<tr>
		{td}
		
			{font size=14}
				Lorem ipsum dolor sit amet. Etiam ullamcorper:
			{font size=14 e=true}
		{td e=true}
	</tr>
	
	{trMargin height=25}
	
	<tr>
		{td}
			
			{table cellpadding="4" align="center"}
				
				<tr>
					{td width=100 align=left padding="4px"}
						{font size=12 content="Lorem:"}
					{td e=true}
					{td width=100 align=left padding="4px"}
						{font size=12}
							Ipsum dolor
						{font size=12 e=true}
					{td e=true}
					
				</tr>
				<tr>
					{td width=100 align=left padding="4px"}
						{font size=12 content="Curabitur:"}
					{td e=true}
					{td width=100 align=left padding="4px"}
						{font size=12}
							Suspendisse
						{font size=12 e=true}
					{td e=true}
					
				</tr>
				<tr>
					{td width=100 align=left padding="4px"}
						{font size=12 content="Nullam (%):"}
					{td e=true}
					{td width=100 align=left padding="4px"}
						{font size=12}
							40
						{font size=12 e=true}
					{td e=true}
					
				</tr>
				
			{table e=true}
			
		{td e=true}
	</tr>
	
	{trMargin height=60}
	
	<tr>
		{td}
			{font size=15 weight=bold}
				Cum sociis natoque penatibus et ultrices volutpat...
			{font size=15 weight=bold e=true}
		{td e=true}
	</tr>
	
	{trMargin height=30}
			
	<tr>
		{td}
			{table}
				<tr>
					{td width="240"}
				
						{button href="" width="170" containerWidth="240" marginTop=10 marginBottom=15 content="Lorem ipsum &raquo;"}
					
						{button href="" width="170" containerWidth="240" bgColor="#ff4040" content="Dolor amet &raquo;"}
						
					{td e=true}
					
					
					{td width="300" align="left" lineHeight="1.5"}
					
						{font}
							Lorem ipsum dolor sit amet enim. Etiam ullamcorper a pellentesque dui:<br />
						{font e=true}
						
						{fontMargin height=6}
						
						{table width="300"}
							<tr>
								{li symbolSize=12 symbolWidth=20 contentWidth=280}
									{font size=12 content="Aliquam sem. In hendrerit nulla quam nunc, accumsan congue."}
								{li e=true margin=10}
							</tr>
							<tr>
								{li symbolSize=12 symbolWidth=20 contentWidth=280}
									{font size=12 content="Lorem ipsum primis.<br />"}
								{li e=true margin=10 addBr=false}
							</tr>
							<tr>
								{li symbolSize=12 symbolWidth=20 contentWidth=280}
									{font size=12 weight="bold" content="Curabitur et ligula!<br />"}
								{li e=true}
							</tr>
						{table e=true}
						
					{td e=true}
				</tr>
			{table e=true}
			
		{td e=true}
	</tr>

{/block}