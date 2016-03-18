# implico-email-framework

[Smarty Template Engine][smarty] email coding framework. A kind of preprocessor that facilitates daily work with email templates.

## Concept & example

When developing an email template, you often face issues such as:
- setting the same (often prehistoric) attributes and css properties across the whole project like:

  ```html
  <table width="600" cellpadding="0" cellspacing="0" border="0">
    <tr>
      <td width="600" valign="top">
        <img src="image.jpg" width="400" height="300" alt="Image" border="0" style="display: block">
  ```
- using `font` tag unconveniently
- setting `img` sizes manually
- having multiple language versions (or other small differences between templates) for one layout
- using same values across whole project (widths etc.) - that could be accessed as variables (and in some cases could also take a default configuration value when not set, like font parameters)

Produced code is often hard to maintain.

The framework brings configured Smarty plugins and CLI interface, so you can develop project like this:

```smarty
{$marginHeight = 50}
{table}
  {tr}
    {td colspan=2}
      {font size=20}Title{/font}
    {/td}
  {/tr}

  {margin height=$marginHeight colspan=2}

  {tr}
    {td width=400}
      {a href="http://example.com/"}{img src="image.jpg"}{/a}
    {/td}
    {td width=200 align=left padding="0 0 0 10px"}
      {font bold=true}{#configVariable#}{/font}
    {/td}
  {/tr}
{/table}

<p>
  Of course, you can use your own markup or easily create custom Smarty plugins, like {literal}{h1}Header{/h1}{/literal}.
</p>
```

And run the watcher:
```
iemail compile [project_name] -w
```

<br>

The code is converted (may vary according to the actual settings) to:
```html
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style type="text/css"> #outlook a {padding:0;} body{width:100% !important; -webkit-text-size-adjust:100%; -ms-text-size-adjust:100%; margin:0; padding:0;} .ExternalClass {width:100%;} .ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div {line-height: 100%;} #backgroundTable {margin:0; padding:0; width:100% !important; line-height: 100% !important;} table td {border-collapse: collapse;} </style>
  </head>
  <body>
    <table cellpadding="0" cellspacing="0" border="0" align="center" width="600" style="border-collapse:collapse;mso-table-lspace:0pt;mso-table-rspace:0pt;">
      <tr>
        <td width="600" colspan="2" valign="top" align="center">
          <font color="#000000" size="5" face="Arial,Tahoma,sans-serif" style="font-size:20px;">Title</font>
        </td>
      </tr>
      <tr>
        <td height="50" colspan="2" style="font-size:1px;">&nbsp;</td>
      </tr>
      <tr>
        <td width="400" valign="top" align="center">
          <a href="http://example.com/" style="text-decoration:none;text-decoration:none !important;">
            <img src="image.jpg" width="400" height="200" alt="Click Show Images option to see the picture" vspace="0" hspace="0" border="0" style="display:block;margin:0;border:none;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic;" />
          </a>
        </td>
        <td width="200" valign="top" align="left" style="padding:0 0 0 10px;">
          <b>
            <font color="#000000" size="3" face="Arial,Tahoma,sans-serif" style="font-size:13px;">This content is set in the configuration file</font>
          </b>
        </td>
      </tr>
    </table>
    
    <p>
      Of course, you can use your own markup or easily create custom Smarty plugins, like {h1}Header{/h1}.
    </p>
        
  </body>
</html>
```


<br>
## Installation

To use the framework you need the following software:

- [PHP] >= 5.5 with **openssl and mbstring** extensions enabled
- Git, e.g. [Github desktop](https://desktop.github.com/)
- [Composer][composer] (for Windows, use the installer)

Clone this repo and **add to the PATH variable**.


### Example: PHP installation on Windows

- unpack the [downloaded PHP archive](http://windows.php.net/download/) (e.g. PHP 7.x Non Thread Safe Zip) into `c:\PHP`
- add `c:\PHP` to your PATH environment variable
- edit `c:\PHP\php.ini`, uncomment:
  - `extension_dir = "ext"`
  - `extension=php_mbstring.dll`
  - `extension=php_openssl.dll` 


### Initializing the app

Just run `composer install` in the directory you have cloned this repository into. Copy the `samples` directory into desired location and change its name to e.g. `email-projects`. This will be your bootstrap project dir (you can remove all example projects if you wish).



<br>
## CLI

The global executable is named `iemail`, just runs `php email.php` and passes all the parameters. Run it from your projects dir.

### Compile project
```
iemail compile project_name [-s script_name(s)] [-d projects_dir] [-w] [-o m|f]
```

Compiles project with specified `project_name`. Options:
- `-s` (`--script`): script name(s), if not set - all scripts are compiled
- `-d` (`--dir`): projects directory, defaults to current direcotry
- `-w` (`--watch`): watch mode - starts watching your project dir and compiles on any change
- `-o` (`--output`): output mode - minified (m) or formatted with indentation (f)


### Send test email(s)
```
iemail send project_name [-s script_name] [-d projects_dir] [-t address(es)] [-f filename] [--fromname name] [--fromaddress address] [-u subject] [--minified] [-i interval_ms] [--errorstop]
```

Sends test email(s) for the specified `project_name`. All images are converted and embedded as cids. SMTP and default options are set in the configuration file.

Options:
- `-s` (`--script`): script name, defaults to `script`
- `-d` (`--dir`): projects directory, defaults to `projects`
- `-t` (`--toaddress`): target address(es), defaults to configuration settings
- `-f` (`--toaddressfn`): name of a text file in the project's `sender` directory with target addresses (separate by newline)
- `--fromname`: from name, defaults to configuration settings
- `--fromaddress`: from address, defaults to configuration settings
- `-u` (`--subject`): email subject, defaults to configuration settings
- `-m` (`--minified`): uses minified script version instead of formatted
- `-l` (`--log`): logs addresses into the project's `sender` directory:
  - `log-done.txt`: addresses to which sending succeeded
  - `log-fail.txt`: (optionally) addresses to which sending failed
- `-i` (`--interval`): interval in ms between sending each email, defaults to 1000
- `--errorstop`: quits on error


<br>
## Directory structure

### Framework
The framework directory structure overview:

- `core`: PHP files, Smarty plugins and master config file
- `samples`: example projects, used also for bootstraping
- `vendor`: modules installed with [Composer][composer]


### Projects dir
The `_custom` subdirectory contains optional: custom master config file and your own Smarty plugins - place them in the `plugins` directory.

Other dirs contain per project files. Each of them has the following structure:

  - `configs`: configuration for the whole project and for particular scripts
  - `layouts`: layout templates
  - `outputs`: compiled project files (HTML)
  - `scripts`: script templates
  - `sender`: sender logs
  - `styles`: CSS styles (optionally included in your layout template)


<br>
## Plugin reference

Reference scheme:
```smarty
{plugin_name parameter1=0 parameter2=#config_value# parameter3=false}
```

Where:
- `parameter1` is set to `0`
- `parameter2` is set to configuration value `config_value`
- `parameter3` is not displayed

Attribute names which are equal to the HTML ones are not camelCase (like `cellpadding`, `bordercolor`), others like `lineHeight` are.

Standard parameters are:
- `style`: additional CSS style, like `border: 1px solid #000;`
- `id`: id attribute
- `class`: one or more classes separated by space
- `attrs`: additional HTML attributes, like `valign="middle" border="0"`

These won't be described in the reference below.

Function plugin has only the start tag, e.g. `{margin height=20}`, other (block) must have the ending tag, e.g. `{table}...{/table}`.

Specify width, height, font sizes without units.


### Table
```smarty
{table width=#tableWidth# cellpadding=0 cellspacing=0 bgcolor=false border=0 bordercolor=false align=#tableAlign# style=false id=false class=false attrs=false}
```

### Tr
```smarty
{tr id=false class=false attrs=false}
```

### Td
```smarty
{td width=#lContentWidth# height=false colspan=1 align=#tdAlign# valign=#tdValign# padding=0 overflow=#tdOverflow# bgcolor=false lineHeight=#tdLineHeight# borderRadius=false noFont=!#fontStyleTdTag# fontFamily=#fontFamily# fontSize=#fontSize# fontColor=#fontColor# style=false id=false class=false attrs=false}
```
Notes:
- `padding`: set as a CSS `padding` property value, e.g. `10px 20px`
- `noFont`: blocks applying font styles even if `fontStyleTdTag` config value is set to `true`
- `overflow`: set to `true` for `hidden` (shorthand)

### Vertical margin (function)
Creates a row with specified height.

```smarty
{margin height=false colspan=1 bgcolor=false style=false id=false class=false attrs=false}
```

### Font
```smarty
{font color=#fontColor# size=#fontSize# sizeForce=false family=#fontFamily# bold=false italic=false underlined=false centered=false style=false id=false class=false attrs=false}
```
Notes:
- `sizeForce`: adds `!important` to CSS `font-size` property value (useful when you don't want the font to be resized on e.g. mobile Gmail apps)
- `bold`, `italic`, `underlined`, `centered`: have aliases derived from the first letter; set any truthy value, like `{font b=1}`


### Link
```smarty
{a href="" target=#aTarget# textDecoration=#aTextDecoration# buttonHeight=false style=false id=false class=false attrs=false}
```
Notes:
- `buttonHeight`: if you want to "buttonize" the link, set its height; you should add `sizeForce=true` parameter to the `{font}` used inside this button to prevent font scaling on mobile Gmail apps; you would also probably need to set the button background color on wrapping `{td}`


### Image (function)
```smarty
{img src="" width=false height=false autoSize=#imgAutoSize# alt=#imgAlt# padding=false margin=0 marginV=0 marginH=0 align=false display=#imgDisplay# border=0 bordercolor=false style=false id=false class=false attrs=false}
```
Notes:
- `autoSize`: if true, when width and height is not specified, actual image dimensions are taken
- `marginV` and `marginH`: vertical and horizontal margin (setting vspace and hspace attributes + CSS margin)


### Force strip
To force white space strip (in the formatted version), use the following syntax:
`#(strip)[stripped_code]#(/strip)`


<br>
## Configuration
Default settings are defined in the master file `core/config.conf`. To change them, edit (if they do not exist - create) the following files:
- `[projects_dir]/_custom/config.conf`: your master custom config applied to all projects
- `[projects_dir]/[project_name]/configs/config.conf`: config applied to the project
- `[projects_dir]/[project_name]/configs/scripts/[script_name].conf`: per script config (name it as the script name)

All most recent options are described in the master file. You can change (among others):
- encoding, font defining mode (as a `font` tag, `span` and/or in a `td` cell tag)
- default table and cells attributes, font family/color/size, link and img styles
- sending test email options, such as default subject/target address or SMTP access


<br>
## Examples

### Starting a new project
Just copy a project from the `samples` to your projects directory and change its name. Usually, you will probably need the `plain` example. Run compiler in the watch mode:
```
iemail compile project_name -w
```
Open the script HTML file located in your project `outputs` directory. Refresh on every compilation to see the changes.

### Plain
This is a plain, bootstrap project. Includes only a layout with the main table defined.

### Grid
This shows how to build more complex projects, including lists and buttons.

### Responsive
Presents the way to build a responsive (in fact - fluid) project. Notes:
- config option `lContentWidth` is set to 100%
- layout template:
  - `<meta name="viewport">` is uncommented, mainly for Apple devices that support media queries (see the last media query that limits table width)
  - added Outlook max-width hack as a conditional comment (before and after the main table definition)
  - added max-width to the main table (for e.g. Gmail)
- all width units (tables, cells, images) are set in percentage

### Multilang
Multi-language project presents two ways of defining language-specific content for English and Polish. The concept is that `script.tpl` is extended by language scripts, in this case `en.tpl` and `pl.tpl`.

First way is to set script-specific config values in the `configs/scripts` directory, and then just use it like `{#title#}`.

Second way is to inject content by using blocks in language scripts.


<br>
## Integration
To use the framework in your own PHP scripts, install it in the standard way and then:
- update or create your [Composer][composer] config file (`composer.json`):
  ```json
  {
    "name": "...",
    "version": "...",
    
    "require": {
      "smarty/smarty": "3.*.*"
    },
    
    "autoload": {
      "psr-4": {
        "Implico\\Email\\": "path_to_core_inc_dir"
      }
    }
  }
  ```
  Require Smarty only if you don't already use it in your project.
  
  Replace `path_to_core_inc_dir` with the actual path relative to the file location, e.g. `views/email-framework/core/inc/`.

- to render an email, first create a Smarty object:
  ```php
  $smarty = new \Smarty();
  ```
- add plugins dir
  ```php
  $smarty->addPluginsDir(path_to_core_plugins_dir);
  ```
  Replace `path_to_core_plugins_dir` with the actual path, e.g. `__DIR__.'/views/email-framework/core/plugins/'`.

- load config file(s)
  ```php
  $smarty->configLoad(path_to_config_file1);
  $smarty->configLoad(path_to_config_file2);
  ```
- set directories the templates are referring to, like this:

  ```php
  $smarty->setTemplateDir(array(
    0 => path_to_project,
    'layouts' => path_to_project_layouts,
    'scripts' => path_to_project_scripts,
    'styles' => path_to_project_css
  ));
  ```
- execute the script and then send it using your favorite library (like [PHPMailer][phpmailer] or [Swift Mailer][swiftmailer])
  ```php
  $html = $smarty->fetch(path_to_script)

  //send the email
  //...
  ```

- to embed images as cids, you can use the following snippet (example for [PHPMailer][phpmailer])
  ```php
  $mail = new \PHPMailer();
  //...

  $cids = array();
  $i = 1;
  preg_match_all('/\<img.*?src="(.*?)".*?\/?\>/', $html, $imgs);
  foreach ($imgs[1] as $img)
  {
    $fname = path_to_images_dir.(substr($img, 0, 1) == '/' ? substr($img, 1) : $img);
    $pi = pathinfo($img);
    $name = $pi['basename'];
    $cid = 'cid-'.($i++);
    $cids[$fname] = array('fname' => $fname, 'cid' => $cid, 'name' => $name, 'replace' => $img);
  }
  
  foreach ($cids as $c)
  {
    $mail->AddEmbeddedImage($c['fname'], $c['cid'], $c['name']);
    $html = str_replace('src="'.$c['replace'].'"', 'src="cid:'.$c['cid'].'"', $html);
  }

  //send the email
  //...
  ```
  Replace `path_to_images_dir` with the actual path.



<br>
## Quick tips
- to create a vertical line (`<hr>`), you can use the following code:
```smarty
{margin height=1 bgcolor="#000000"}
```
- set line heights in pixels, rather than percentages or numbers
- to achieve precision, define cell paddings by nesting tables, instead of setting CSS `padding` property
- set a background color on tables, rather than on cells (causes gap lines on iPhones)



<br>
## TODO
Integration with [gulp] for:
- more optimized watch
- auto-refresh by [Browsersync](https://www.browsersync.io/)
- use one of other available tools (like CSS inliners)
- rewrite to [Node.js][nodejs] using [NSmarty][nsmarty]



<br>
## Alternatives
Take a look at other interesting tools and frameworks:
- [MJML][mjml]
- [Node Email Templates](https://github.com/niftylettuce/node-email-templates)
- some [nodeJS modules](https://www.npmjs.com/browse/keyword/premailer)



[composer]: https://getcomposer.org/
[gulp]: http://gulpjs.com/
[mjml]: https://mjml.io/
[nodejs]: https://nodejs.org/
[nsmarty]: https://github.com/stepofweb/nsmarty
[php]: http://www.php.net/
[phpmailer]: https://github.com/PHPMailer/PHPMailer
[smarty]: http://www.smarty.net/
[swiftmailer]: http://swiftmailer.org/
