<?php

/**
 * Implico Email Framework
 * 
 * @package Command\Init - Console Command object (controller) for project initialization
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

class Init extends Command
{
  /**
   * Configure parameters
   */
  protected function configure()
  {
    $this
      ->setName('init')
      ->setDescription('Initializes new project')
      ->addArgument(
        'project_dest',
        InputArgument::REQUIRED,
        'New project name'
      )
      ->addArgument(
        'project_src',
        InputArgument::OPTIONAL,
        'Base project name',
        'plain'
      )
    ;
  }


  /**
   * Execute init command
  */
  protected function execute(InputInterface $input, OutputInterface $output)
  {
    //get project name
    $projectDest = $input->getArgument('project_dest');
    $projectSrc = $input->getArgument('project_src');

    //validate project name
    $pattern = '/^[a-zA-Z0-9\-\_]+$/';
    $allowedChars = 'a-z, A-Z, 0-9, -, _';
    if (!preg_match($pattern, $projectSrc)) {
      $output->writeln('<fg=red>ERROR: wrong base project name "' . $projectSrc . '". Allowed characters: ' . $allowedChars .'</fg=red>');
      exit(1);
    }
    if (!preg_match($pattern, $projectDest)) {
      $output->writeln('<fg=red>ERROR: wrong project name "' . $projectDest . '". Allowed characters: ' . $allowedChars .'</fg=red>');
      exit(1);
    }

    //set src dir
    $projectSrcDir = IE_PROJECTS_DIR . $projectSrc;
    if (!file_exists($projectSrcDir)) {
      $projectSrcDir = IE_SAMPLES_DIR . $projectSrc;
      if (!file_exists($projectSrcDir)) {
        $output->writeln('<fg=red>ERROR: base project "' . $projectSrc . '" not found</fg=red>');
        exit(1);
      }
    }

    //set dest dir
    $projectDestDir = IE_PROJECTS_DIR . $projectDest;
    if (file_exists($projectDestDir)) {
      $output->writeln('<fg=red>ERROR: new project directory "' . $projectDest . '" exists</fg=red>');
      exit(1);
    }

    //start copying
    if (!FileSystem::copy($projectSrcDir, $projectDestDir)) {
      $output->writeln('<fg=red>ERROR: failed to copy source project to destination</fg=red>');
    }
    else {
      $output->writeln('Project "' . $projectDest . '" initialized successfully!');
    }
  }  
}
