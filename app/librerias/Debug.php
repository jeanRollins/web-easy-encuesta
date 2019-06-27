<?php

class Debug {


  public static function pr( $datos , $title = NULL  ){
    echo '<h2>  **********  ' . $title  . '  ********** </h2>' ;
    echo'<pre>' ;
    var_dump( $datos ) ;
    echo'</pre>' ;
  }

}
