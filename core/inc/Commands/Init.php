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

class Init extends Command
{
  
  /**
   * Configure parameters
   */
  protected function configure()
  {
    $this
      ->setName('init')
      ->setDescription('Initialize new project')
      ->addArgument(
        'project_dest',
        InputArgument::REQUIRED,
        'New project name'
      )
      ->addArgument(
        'project_src',
        InputArgument::OPTIONAL,
        'Base project name (defaults to plain)'
      )
      ->addOption(
        'custom',
        'c',
        InputOption::VALUE_NONE,
        'Initializes also the custom config directory ("' . IE_CUSTOM_DIR_NAME . '"). Use for the very first run'
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
    if (!strlen($projectSrc)) {
      $projectSrc = 'plain';
    }

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

    //custom directory init
    if ($input->getOption('custom')) {
      if (file_exists(IE_CUSTOM_DIR)) {
        $output->writeln('<fg=red>WARNING: custom config directory ("' . IE_CUSTOM_DIR_NAME . '") exists, skipping</fg=red>');
      }
      else {
        if (!$this->copy(IE_SAMPLES_DIR . IE_CUSTOM_DIR_NAME, IE_PROJECTS_DIR . IE_CUSTOM_DIR_NAME/*, ['.gitkeep']*/)) {
          $output->writeln('<fg=red>ERROR: custom config directory initialization failed</fg=red>');
          exit(1);
        }
        if (!copy(IE_CORE_DIR . 'config.conf', IE_PROJECTS_DIR . IE_CUSTOM_DIR_NAME . DIRECTORY_SEPARATOR . 'config.conf')) {
          $output->writeln('<fg=red>ERROR: failed to copy master config file to custom config directory</fg=red>');
          exit(1);
        }
        $output->writeln('Custom config directory created successfully!');
      }
    }

    //start copying
    if (!$this->copy($projectSrcDir, $projectDestDir)) {
      $output->writeln('<fg=red>ERROR: failed to copy source project to destination</fg=red>');
    }
    else {
      $output->writeln('Project "' . $projectDest . '" initialized successfully!');
    }
  }
  
  /**
   * Copies directory recursively
   * 
   * @param string $src   Source path
   * @param string $src   Source path
   *
   * @return bool         True on success, false on failure
  */
  function copy($src, $dst, $skip = null) { 
    
    $ret = true;

    $dir = opendir($src); 
    if (!@mkdir($dst))
      return false;

    while(false !== ( $file = readdir($dir)) ) { 
        if (( $file != '.' ) && ( $file != '..' ) && (!$skip || !in_array($file, $skip))) { 
            if ( is_dir($src . '/' . $file) ) { 
                if (!($ret = $this->copy($src . '/' . $file,$dst . '/' . $file, $skip)))
                  break;
            } 
            else { 
                if (!($ret = copy($src . '/' . $file,$dst . '/' . $file)))
                  break;
            } 
        } 
    } 
    closedir($dir);

    return $ret;
  }
}