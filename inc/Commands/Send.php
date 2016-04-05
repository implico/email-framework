<?php

/**
	Implico Email Framework

	@package Command\Compile - Console Command object (controller) for compilation
	@author Bartosz Sak <info@implico.pl>
	
*/

namespace ImplicoEmail\Commands;


use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class Send extends Command
{
	protected $config;
	
	protected $logContent, $logSent, $logLeft;
	
	
	protected function configure()
	{
		$this
			->setName('send')
			->setDescription('Send a test email or from mailing list')
			->addArgument(
				'project',
				InputArgument::REQUIRED,
				'Project name'
			)
			->addOption(
				'script',
				's',
				InputOption::VALUE_REQUIRED,
				'Script name (\'script\' by default)'
			)
			->addOption(
				'toaddress',
				't',
				InputOption::VALUE_REQUIRED | InputOption::VALUE_IS_ARRAY,
				'Target addresses (array, default value set in configuration)'
			)
			->addOption(
				'toaddressfn',
				'f',
				InputOption::VALUE_REQUIRED,
				'Name of the text file in Sender dir with target addresses'
			)
			->addOption(
				'fromname',
				null,
				InputOption::VALUE_REQUIRED,
				'Sender name'
			)
			->addOption(
				'fromaddress',
				null,
				InputOption::VALUE_REQUIRED,
				'Sender address'
			)
			->addOption(
				'subject',
				'u',
				InputOption::VALUE_REQUIRED,
				'Email subject'
			)
			->addOption(
				'minified',
				null,
				InputOption::VALUE_NONE,
				'Use minified version vs. expanded'
			)
			/*->addOption(
				'sequence',
				null,
				InputOption::VALUE_REQUIRED,
				'Number of messages per sequence',
				1
			)*/
			->addOption(
				'interval',
				'i',
				InputOption::VALUE_REQUIRED,
				'Interval in ms between sequences',
				1000
			)
			->addOption(
				'errorstop',
				null,
				InputOption::VALUE_NONE,
				'Stop sending on error'
			)
		;
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		
		//get project name & set source/output dirs
		$project = $input->getArgument('project');
		$this->config = new \ImplicoEmail\Config($project);
		
		if ($error = $this->config->getErrors()) {
			switch ($error) {
				case 'projectNotFound':
					$output->writeln('<fg=red>ERROR: project directory not found</fg=red>');
					exit();
					break;
			}
		}
		
		$this->logContent = '';
		$this->logSent = $this->config['senderDir'] . 'log-sent.txt';
		$this->logLeft = $this->config['senderDir'] . 'log-left.txt';
		
		
		if (file_exists($this->logSent))
			unlink($this->logSent);
		
		if (file_exists($this->logLeft))
			unlink($this->logLeft);
		
		$script = $input->getOption('script');
		
		
		$sender = new \ImplicoEmail\Sender(
			$this->config, $script, $input->getOption('toaddress'), $input->getOption('toaddressfn') ? ($this->config['senderDir'] . $input->getOption('toaddressfn')) : '', 
			$input->getOption('fromname'), 
			$input->getOption('fromaddress'), $input->getOption('subject'), $input->getOption('minified'),
			$input->getOption('interval'), $input->getOption('errorstop')
		);
		
		$_this = $this;
		$result = $sender->run(function($addressTo, $count, $message) use ($_this, $output) {
			if ($message) {
				$output->writeln($message);
			}
			else {
				$output->writeln("$count: $addressTo");
			}
			$_this->addLog($addressTo);
		});
		
		if ($result['error']) {
			$output->writeln('<fg=red>'.$result['message'].'</fg=red>');
			file_put_contents($this->logLeft, implode(PHP_EOL, $result['left']));
		}
		else {
			$output->writeln('-------------------------------');
			$output->writeln('Completed. Emails sent: ' . $result['count']);
		}
	}
	
	protected function addLog($address)
	{
		$this->logContent .= $address . PHP_EOL;
		file_put_contents($this->logSent, $this->logContent);
	}
}