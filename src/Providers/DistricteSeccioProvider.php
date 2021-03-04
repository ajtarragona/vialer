<?php

namespace Ajtarragona\Vialer\Providers;

use Ajtarragona\Vialer\Traits\CanReturnCached;

use Illuminate\Support\Str;

use Illuminate\Support\Facades\Log;
use Exception;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\ClientException;

class DistricteSeccioProvider{
    
    use CanReturnCached;
    
    protected $ds_url;

    public function __construct($args = null)
    {
       
       $config=config('vialer');
       $this->ds_url = $config["dist_sec_api_url"];

       $this->srs = $config["srs"];
       //cojo solo el código si tiene dos puntos
       if(Str::contains($this->srs,":")){
           $tmp=explode(":",$this->srs);
           $this->srs=$tmp[1];
       }


       
    } 
    

    public function getDistricteISeccio($lat,$lng){
        
        $hash=md5("dissec_".$lat.",".$lng);

		return $this->returnCached($hash, function() use ($lat,$lng){
            try{
                // dd($this->ds_url);
                $this->client = new Client([
                    'base_uri' => $this->ds_url,
                    'verify' =>false
                ]);
                // dd($this->client);
                $args=[
                    "geometry" => $lng.",".$lat,
                    "geometryType" => "esriGeometryPoint",
                    "inSR" => $this->srs,
                    "outFields" => "SEC,DIST_AUT,DISTRICTE_GOVERN",
                    "returnGeometry"=>false,
                    "f"=>"pjson"
                ];
                // dump($args);
                
                $response = $this->client->request("get", "query", [
                    'query' => $args,
                    'timeout' => 5,
                    'headers' => [
                        'Accept'     => 'application/json'
                    ]
                ]);
                // dd($response);

                // dump($response);
                // dump("STATUS:".$response->getStatusCode());
                // Log::debug("BODY:");
                $body = json_decode($response->getBody());
                // dump($body);
                $ret = (isset($body->features) && is_array($body->features) && $body->features )  ? $body->features[0]->attributes : null;

                if($ret){
                    return to_object([
                        "districte"  => $ret->DIST_AUT,
                        "seccio"  => $ret->SEC,
                        "districte_administratiu"  => $ret->DISTRICTE_GOVERN
                    ]);
                
                }
                return null;
            }catch(Exception $e){
                // dd($e);
                Log::debug("Error recuperant districte i seccio:". $e->getMessage());
                return null;
            }
        });
        
        
        
    }
}
