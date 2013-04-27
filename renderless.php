<?php
require 'lessc.inc.php';

// Define the output file and the input directory
// $input_dir: A relative path to your css/less files. The path should be relative to where the renderless.php file is located.
// $output_file: If this variable is defined renderless will output a compiled css file. Again, this is relative to where renderless.php is located.
// $pointer_file: You can specify a single file for renderless to render, the file can include @import statements and act as an organizer.
$input_dir = 'css/';
$output_file = '../style.css';
$pointer_file = '';

// min is useful for debugging and seeing the code unminified but compiled.
// Simply append a min query with a falsy value like so: renderless.php?min=0
$min = isset( $_REQUEST['min'] ) ? $_REQUEST['min'] : true;

// Custom header
$header = '/* This file was rendered using renderless.php v0.1 */';

// Minifies css code
function compress( $string ) {
    // comments
    $string = preg_replace('!/\*.*?\*/!s','', $string);
    $string = preg_replace('/\n\s*\n/',"\n", $string);

    // space
    $string = preg_replace('/[\n\r \t]/',' ', $string);
    $string = preg_replace('/ +/',' ', $string);
    $string = preg_replace('/ ?([,:;{}]) ?/','$1',$string);
    
    $string = str_replace(array('( ',' (',') ',' )'),array('(','(',')',')'),$string);

    // trailing;
    $string = preg_replace('/;}/','}',$string);
    
    return $string;
}

function file_type( $file_name ) {
  return substr( strrchr( $file_name, '.' ), 1 );
}

// Get one file containing @import statements or get all files in the input_dir
$files = $pointer_file != '' ? array( $pointer_file ) : glob( $input_dir . '{*.css,*.less}', GLOB_BRACE);

$css = "";

// Minify and add to string
foreach( $files as $file ) {
    
    if( file_type( $file ) == 'css' ) {

        $css .= file_get_contents( $file );
        
    } else {
    
        $less = new lessc( $file );
        $css .= $less->parse();
        
    }
    
    $output = $min ? compress( $css ) : $css;
    
}

// concat the two css files
$style = $header . $output;

// dump the contents into style.css
if ( $output_file ){
    file_put_contents( $output_file, $style );
}

// Show generated code
header("Content-Type: text/css");
header("X-Content-Type-Options: nosniff");
header("Cache-Control: no-cache, must-revalidate"); //HTTP 1.1
echo $style;
?>