<?php

/**
 * Implico Email Framework
 * 
 * @package Command\Create - Console Command object (controller) for project directory initialization
 * @author Bartosz Sak <info@implico.pl>
 * 
*/

namespace Implico\Email\Commands;


use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

use Implico\Email\Utils\FileSystem;

class Create extends Command
{
  
  /**
   * Configure parameters
   */
  protected function configure()
  {
    $this
      ->setName('create')
      ->setDescription('Initializes projects directory')
      ->addArgument(
        'directory_name',
        InputArgument::REQUIRED,
        'Projects directory name'
      )
    ;
  }


  /**
   * Execute init command
  */
  protected function execute(InputInterface $input, OutputInterface $output)
  {
    //get projects dir name
    $dirName = $input->getArgument('directory_name');
    $dir = IE_PROJECTS_DIR . $dirName . DIRECTORY_SEPARATOR;

    //validate projects dir name
    $pattern = '/^[a-zA-Z0-9\-\_]+$/';
    $allowedChars = 'a-z, A-Z, 0-9, -, _';
    if (!preg_match($pattern, $dirName)) {
      $output->writeln('<fg=red>ERROR: wrong projects directory name "' . $dirName . '". Allowed characters: ' . $allowedChars .'</fg=red>');
      exit(1);
    }

    //check if projects dir exists
    if (file_exists($dir)) {
      $output->writeln('<fg=red>ERROR: projects directory  "' . $dirName . '" already exists</fg=red>');
      exit(1);
    }

    if (!@mkdir($dir)) {
      $output->writeln('<fg=red>ERROR: failed to create directory "' . $dirName . '" (exists/permissions?)</fg=red>');
      exit(1);
    }

    //custom directory init
    if (!FileSystem::copy(IE_SAMPLES_DIR . IE_CUSTOM_DIR_NAME, $dir . IE_CUSTOM_DIR_NAME/*, ['.gitkeep']*/)) {
      $output->writeln('<fg=red>ERROR: custom config directory initialization failed</fg=red>');
      exit(1);
    }
    if (!@copy(IE_CORE_DIR . 'config.conf', $dir . IE_CUSTOM_DIR_NAME . DIRECTORY_SEPARATOR . 'config.conf')) {
      $output->writeln('<fg=red>ERROR: failed to copy master config file to custom config directory</fg=red>');
      exit(1);
    }
    $output->writeln('Projects directory "' . $dirName . '" created successfully!');
  }
}