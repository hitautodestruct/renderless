renderless
==========

Small PHP script for rendering lesscss on the fly.

##What?
Renderless is a small script for generating and concatenating minified [less](http://lesscss.org/) and css files either on the fly or to a single file using PHP.
Renderless uses the [lessphp](http://leafo.net/lessphp/) library to generate less files.

##How?

###Setup
Simply download both files (`lessc.inc.php` and `renderless.php`) and place them in one of your directories in your project:

`myproject\renderless.php`
`myproject\lessc.inc.php`

Open up `renderless.php` in an editor and configure your settings:

`$input_dir`: A relative path to your css/less files. The path should be relative to where the renderless.php file is located.

`$output_file`: If this variable is defined renderless will output a compiled css file. Again, this is relative to where renderless.php is located.

`$pointer_file`: You can specify a single file for renderless to render, the file can include @import statements and act as an organizer.

###Manually generate a css file
Once this is done you can manually render the css/less file by accessing it in your browser.
Just type in the path to the file i.e. `http://localhost/myproject/renderless.php`.
If you've set up the `$output_file` option renderless will create a compiled css file according to what you wrote.

###Render the code on the fly
If you want renderless to act as an immediate interpreter you can point your style declaration to the renderless.php file in your html like so:

**WARNING**: This script has no caching method so it is advised to not use it in a production environment. Use the manual option instead.
```html
<link href="renderless.php" rel="stylesheet" type="text/css">
```

Fore debugging your css you can also use the `min` query string and renderless will not minify your code:
```html
<link href="renderless.php?min=0" ... >
```