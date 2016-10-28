<?php

/**
 * Implico Email Framework
 * 
 * @package Command\Send - Console Command object (controller) for sending test emails
 * @author Bartosz Sak <info@implico.pl>
 * 
*/

namespace Implico\Email\Commands;


use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class Send extends Command
{
	protected $config;
	
	protected $logContent, $logSent, $logLeft;
	
	
	/**
	 * Configure parameters
	 */
	protected function configure()
	{
		$this
			->setName('send')
			->setDescription('Sends a test email or from mailing list')
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
				'dir',
				'd',
				InputOption::VALUE_REQUIRED,
				'Projects dir relative to root'
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
				'm',
				InputOption::VALUE_NONE,
				'Use minified version vs. expanded'
			)
			->addOption(
				'log',
				'l',
				InputOption::VALUE_NONE,
				'Log sent/failed addresses'
			)
			->addOption(
				'interval',
				'i',
				InputOption::VALUE_REQUIRED,
				'Interval in ms between each email sending',
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


	/**
	 * Execute send command
	*/
	protected function execute(InputInterface $input, OutputInterface $output)
	{
		
		//get project name & set source/output dirs
		$project = $input->getArgument('project');
		$this->config = new \Implico\Email\Config($project, $input->getOption('dir'));
		
		if ($error = $this->config->getErrors()) {
			switch ($error) {
				case 'projectNotFound':
					$output->writeln('<fg=red>ERROR: project directory not found</fg=red>');
					exit(1);
					break;
			}
		}
		
		$this->logContent = '';
		$this->logSent = false;
		$this->logLeft = false;
		if ($input->getOption('log')) {
			$this->logSent = $this->config['senderDir'] . 'log-done.txt';
			$this->logLeft = $this->config['senderDir'] . 'log-fail.txt';
		}
		
		
		if (file_exists($this->logSent))
			unlink($this->logSent);
		
		if (file_exists($this->logLeft))
			unlink($this->logLeft);
		
		$script = $input->getOption('script');
		
		
		$sender = new \Implico\Email\Sender(
			$this->config, $script, $input->getOption('toaddress'), $input->getOption('toaddressfn') ? ($this->config['senderDir'] . $input->getOption('toaddressfn')) : '', 
			$input->getOption('fromname'), 
			$input->getOption('fromaddress'), $input->getOption('subject'), $input->getOption('minified'),
			$input->getOption('interval'), $input->getOption('errorstop')
		);
		
		$_this = $this;
		$result = $sender->run(
			function($mailer) use ($_this, $output) {
				$output->writeln("Using host: {$mailer->Host}, username: {$mailer->Username}, port: {$mailer->Port}");
			},
			function($addressTo, $count, $message) use ($_this, $output) {
				if ($message) {
					$output->writeln($message);
				}
				else {
					$output->writeln("$count: $addressTo");
				}
				$_this->addLog($addressTo);
			}
		);
			
		if ($result['error']) {
			$output->writeln('<fg=red>'.$result['message'].'</fg=red>');
			if ($this->logLeft) {
				file_put_contents($this->logLeft, implode(PHP_EOL, $result['left']));
			}
		}
		else {
			$output->writeln('-------------------------------');
			$output->writeln('Completed. Emails sent: ' . $result['count']);
		}
	}
	
	/**
	 * Appends an address to the log
	 * 
	 * @param string $address 	Address to append
	*/
	protected function addLog($address)
	{
		if ($this->logSent) {
			$this->logContent .= $address . PHP_EOL;
			file_put_contents($this->logSent, $this->logContent);
		}
	}
}
