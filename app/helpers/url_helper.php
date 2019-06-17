<?php

// redirecionar pcntl_async_signals
function redirect($pagina){
    header('location:'.RUTA_URL . $pagina);
}

?>
