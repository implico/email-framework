/**
 * Implico Email Framework - gulp configuration file
 * 
 * @author Bartosz Sak <info@implico.pl>
 * 
*/

'use strict';

var bs = require('browser-sync').create(),
    chalk = require('chalk'),
    exec = require('child_process').exec,
    gulp = require('gulp'),
    keypress = require('keypress'),
    minimist = require('minimist');


// ---------- PARSE CLI PARS & CONFIG ----------

var cliOptsConfig = {
  string: ['project', 'script', 'params'],
  boolean: ['resume'],
  alias: {
    project: 'p',
    script: 's',
    params: 'a',
    resume: 'r'
  },
  default: {
    script: 'index',
    params: '',
    resume: false
  }
}
var cliOpts = minimist(process.argv.slice(2), cliOptsConfig);

var options = {
  rootDir: __dirname + '/',
  project: cliOpts.project,
  script: cliOpts.script,
  params: cliOpts.params,
  resume: cliOpts.resume
}
options.projectDir = options.rootDir + options.project + '/';
options.projectOutputsDir = options.projectDir + 'outputs/';


// ---------- TITLE ----------
(() => {
  let title = 'Implico Email Framework: gulp builder';
  console.log(`${chalk.blue(title)}`);
  console.log(`${chalk.blue(Array(title.length + 1).join('*'))}`);
  console.log('Press Ctrl+C to exit');
  console.log('');
})();


// ---------- LAUNCHER ----------

var childrenProc = [];

function spawnCompiler(command, callback) {
  var child = exec('iemail ' + command, { cwd: __dirname }).on('error', function() {
    console.error('Email-framework gulp: error while executing "iemail". Check if you have implico-email-framework installed.')
    process.exit(1);
  });
  childrenProc.push(child);

  function handleOutput(data) {
    data = (new String(data)).trim();
    if (data.length) {
      process.stdout.write(data + '\n');
    }
  }
  child.stdout.on('data', handleOutput);
  child.stderr.on('data', handleOutput);

  child.on('close', function(exitCode) {
    callback && callback(exitCode);
  });
}

//kills all processes
function killProcesses() {
  childrenProc.forEach(function(child) {
    child.stdin.on('error', function() {}).write('_FRS_CLOSE_');
    child.kill('SIGTERM');
  });
}

//kill all processes on exit
process.on('exit', function() {
  killProcesses();
});


// ---------- KEYS SETUP ----------
keypress(process.stdin);

process.stdin.on('keypress', function(ch, key) {

  if (key && key.ctrl) {
    switch (key.name) {
      case 'c':
        process.exit();
        break;
    }
  }
});

if (process.stdin.setRawMode) {
  process.stdin.setRawMode(true);
}
process.stdin.resume();



// ---------- TASK SETUP ----------

var blockCompile = false,
    runAdditionalCompile = false;

function compile() {
  if (blockCompile) {
    runAdditionalCompile = true;
    return Promise.resolve();
  }
  blockCompile = true;
  return new Promise(function(resolve, reject) {
    spawnCompiler(
      'compile ' + options.project + (options.script ? ' -s ' + options.script : '') + (options.params ? ' ' + options.params : ''),
      (exitCode) => {
        if ((exitCode == 0) && (bs.active)) {
          bs.reload();
        }
        if ((exitCode != 0) && (!bs.active)) {
          process.exit(1);
        }
        blockCompile = false;
        if (runAdditionalCompile) {
          runAdditionalCompile = false;
          compile().then(resolve, reject);
        }
        else {
          resolve();
        }
      }
    );
  });
}

function browserSync() {
  bs.init({
    host: 'localhost',
    open: options.resume ? false : 'local',
    //port: 8081,
    reloadOnRestart: true,
    server: {
      baseDir: options.projectOutputsDir,
      index: options.script ? options.script + '.html' : false,
      directory: !options.script
    }
  });

  return Promise.resolve();
}

function watch() {
  return gulp.watch([options.projectDir + '**/*', '!' + options.projectOutputsDir + '**/*.html'], compile);
}


gulp.task('compile', compile);
gulp.task('watch', watch);

gulp.task('default', gulp.series(compile, browserSync, watch));
