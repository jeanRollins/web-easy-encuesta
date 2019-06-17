<?php 

class Api{
	private function curl_url_get( $url )
    {
        $curl = curl_init();

        curl_setopt_array($curl, 
            [
                CURLOPT_RETURNTRANSFER  =>  1,
                CURLOPT_URL             =>  $url,
                CURLOPT_USERAGENT       =>  ''
             ]
        );
        $response = curl_exec( $curl );
        
        curl_close( $curl );

        return $response ; 
    }

    public function test(){
    	$url = "https://jsonplaceholder.typicode.com/todos/";

    	$response =$this->curl_url_get($url);
    	var_dump($response);
    }
}

 ?>