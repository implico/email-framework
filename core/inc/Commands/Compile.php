<?php

/**
 * Implico Email Framework
 * 
 * @package Command\Compile - Console Command object (controller) for compilation
 * @author Bartosz Sak <info@implico.pl>
 * 	
*/

namespace ImplicoEmail\Commands;

use ImplicoEmail\Utils\Smarty as SmartyUtils;


use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class Compile extends Command
{
	protected $config;
	
	
	/**
	 * Configure parameters
	 */
	protected function configure()
	{
		$this
			->setName('compile')
			->setDescription('Compile project')
			->addArgument(
				'project',
				InputArgument::REQUIRED,
				'Project name'
			)
			->addOption(
				'script',
				's',
				InputOption::VALUE_IS_ARRAY | InputOption::VALUE_REQUIRED,
				'Script name(s) (if extension not set, uses .tpl); if not provided, all scripts are compiled'
			)
			->addOption(
				'watch',
				'w',
				InputOption::VALUE_NONE,
				'Watch for changes'
			)
			->addOption(
				'dir',
				'd',
				InputOption::VALUE_REQUIRED,
				'Projects dir relative to root'
			)
			->addOption(
				'output',
				'o',
				InputOption::VALUE_IS_ARRAY | InputOption::VALUE_REQUIRED,
				'Output mode(s): m-minified, f-formatted',
				array('m', 'f')
			)
		;
	}


	/**
	 * Execute compile command
	*/
	protected function execute(InputInterface $input, OutputInterface $output)
	{
		//get project name & set source/output dirs
		$project = $input->getArgument('project');
		$this->config = new \ImplicoEmail\Config($project, $input->getOption('dir'));
		
		if ($error = $this->config->getErrors()) {
			switch ($error) {
				case 'projectNotFound':
					$output->writeln('<fg=red>ERROR: project directory not found</fg=red>');
					exit();
					break;
			}
		}

		SmartyUtils::init($this->config);
		
		
		//get script name(s)
		$scripts = $input->getOption('script');
		
		//if script name(s) not passed, set all scripts (exclude dirs)
		if (!$scripts)
			$scripts = array_filter(array_diff(scandir($this->config['scriptsDir']), array('.', '..')), function($script) {
				return !is_dir($this->config['scriptsDir'] . $script);
			})
		;
		
		//add ".tpl" extension when applicable
		foreach ($scripts as $i => $script) {
			if (strpos($script, '.') === false)
				$scripts[$i] = $script . '.tpl';
		}
		
		//get watch option
		$watch = $input->getOption('watch');
		
		//get output option
		$outputMode = $input->getOption('output');
		
		
		//create & configure Smarty object
		$smarty = new \Smarty();
		
		$smarty->setCompileDir(IE_SMARTY_COMPILE_DIR);
		$smarty->addPluginsDir(IE_SMARTY_PLUGINS_DIR);
		$smarty->addPluginsDir(IE_SMARTY_CUSTOM_PLUGINS_DIR);

		$smarty->compile_check = false;
		$smarty->force_compile = true;
		$smarty->error_reporting = E_ALL;
		
		//set directories
		$smarty->setTemplateDir(array(
			0 => $this->config['dir'],
			'core' => IE_CORE_DIR,
			'layouts' => $this->config['layoutsDir'],
			'scripts' => $this->config['scriptsDir'],
			'styles' => $this->config['stylesDir']
		));
		
		//master config file
		$smarty->configLoad(IE_CORE_DIR.'config.conf');
			

		//optional master custom config file
		$customConf = IE_CUSTOM_DIR.'config.conf';
		if (file_exists($customConf))
			$smarty->configLoad($customConf);
		
		//console message for watching
		if ($watch)
			$output->writeln('Watching for changes...');
		

		//main loop - watch for changes (or execute once if not watching)
		$compileNo = 1;
		$compileDirStamp = '';
		
		//dirs to inspect file change
		$checkDirs = array($this->config['configsDir'], $this->config['configsScriptsDir'], $this->config['layoutsDir'], $this->config['scriptsDir'], $this->config['stylesDir']);
		
		//set output mode variables
		$outputMinified = in_array('m', $outputMode);
		$outputFormatted = in_array('f', $outputMode);
		
		//formatter object
		$formatter = null;

		while (true) {

			//compile only if not watching or the dirs filestamp changes
			if (!$watch || ($compileDirStamp != $this->getDirStamp($checkDirs))) {
				
				//clear compiled templates
				$smarty->clearCompiledTemplate();
				
				
				//Smarty assign project-specific config file path
				$configFile = $this->config['configsDir'] . 'config.conf';
				$loadConfigFile = file_exists($configFile);
				
				
				//set random complile_id (forces Smarty to compile)
				$smarty->compile_id = uniqid();
				
				//list of compiled scripts
				$compiledScripts = $scripts;
				
				//fetch & save templates
				foreach ($scripts as $i => $script) {
					//script name without extension
					$scriptName = substr($script, 0, strrpos($script, '.'));

					$smarty->clearConfig();
					if ($loadConfigFile) {
						$smarty->configLoad($configFile);
					}
					
					//set script-specific config file path if exists
					$configFileScript = $this->config['configsScriptsDir'] . $scriptName . '.conf';
					if (file_exists($configFileScript)) {
						$smarty->configLoad($configFileScript);
					}

					//lazy create indenter
					if ($outputFormatted && !$formatter) {
						$formatter = new \Gajus\Dindent\Indenter(array('indentation_character' => $smarty->getConfigVars('indentChar')));
					}
				
					//set encoding
					$outputEncoding = $smarty->getConfigVars('encoding');
					if (!$outputEncoding)
						$outputEncoding = 'utf-8';
					$outputEncodingUtf8 = strtoupper($outputEncoding) == 'UTF-8';

					try {
						
						//get the html
						$html = $smarty->fetch($this->config['scriptsDir'] . $script);
						
						//save minified
						if ($outputMinified) {
							
							$htmlSave = $html;
							if (!$outputEncodingUtf8)
								$htmlSave = mb_convert_encoding($htmlSave, $outputEncoding, 'utf-8');
							
							//max line width = 900 chars
							$maxPerLine = 750;
							$endLine = false;
							$newHtml = '';
							for ($i = 0; $i < mb_strlen($htmlSave, $outputEncoding); $i++) {
								if (($i % $maxPerLine == 0) && ($i > 0))
									$endLine = true;
								
								$curChar = mb_substr($htmlSave, $i, 1, $outputEncoding);
								$newHtml .= $curChar;
								if ($endLine) {
									if ($curChar == '>') {
										$newHtml .= PHP_EOL;
										$endLine = false;
									}
								}
							}
							
							$htmlSave = $newHtml;
							
							$this->saveOutput($this->config['outputsDir'] . $scriptName . '.min.html', $htmlSave);
						}
						
						//save formatted
						if ($outputFormatted) {
							$htmlSave = $formatter->indent($html);
							if (!$outputEncodingUtf8)
								$htmlSave = mb_convert_encoding($htmlSave, $outputEncoding, 'utf-8');
							
							$this->saveOutput($this->config['outputsDir'] . $scriptName . '.html', $htmlSave, true);
						}
					}
					catch (\Exception $e) {
						$output->writeln('<fg=red>' . $e->getMessage() . '</fg=red>');
						$compiledScripts[$i] .= ' <fg=red>(ERROR)</fg=red>';
					}
				}
				
				//console info message
				$output->writeln(($watch ? ('#' . ($compileNo++) . ' ') : '') . 'Compiled ' . date('d-m-Y H:i:s') . ' ' . implode(', ', $compiledScripts));
			}
			
			//break if not watching
			if (!$watch)
				break;
			
			//calculate dirs filestamp to compare
			$compileDirStamp = $this->getDirStamp($checkDirs);
			
			//pause
			usleep(500000);
		}
	}
	
	/**
	 * Calculate direcotry(ies) filestamp
	 * 
	 * @param array $dirs 	Directories to process
	 * @return string		Concatenated filemtime of each file in the dirs
	 */
	protected function getDirStamp(array $dirs)
	{
		$ret = '';
		
		clearstatcache();
		foreach ($dirs as $dir) {
			$ret = array_reduce(array_diff(scandir($dir), array('.', '..')), function($c, $i) use ($dir) {
				return $c . filemtime($dir . $i);
			}, $ret);
		}
		
		return $ret;
	}
	
	
	/**
	 * Saves output to file, including directives
	 * 
	 * @param unknown_type $filename
	 * @param unknown_type $content
	 * @param unknown_type $isFormatted
	 */
	protected function saveOutput($filename, $content, $isFormatted = false)
	{
		//force strip
		$d = 'strip';
		$r = preg_match_all('/\#\('.$d.'\)(.*?)\#\(\/'.$d.'\)/ims', $content, $fsFound);
		if ($r && array_key_exists(1, $fsFound)) {
			foreach ($fsFound[1] as $f) {
				$content = str_replace('#('.$d.')' . $f . '#(/'.$d.')', str_replace(array("\n", "\n\r", "\r\n", "\t"), '', $f), $content);
			}
		}

		file_put_contents($filename, $content);
	}
		
}