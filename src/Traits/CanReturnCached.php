<?php

namespace Ajtarragona\Vialer\Traits;


use Cache;

trait CanReturnCached{

    protected $cache_time= 360;

	protected function getHash($function, $parameters=[]){
        
		return get_class($this)."\\".$function."\\".md5(serialize($parameters));
	}

	protected function returnCached($hash, $callable){
        if(is_callable($callable)){
			return Cache::remember($hash, $this->cache_time, function () use ($callable) {
				return $callable();
			});
		}
		return $callable;
	}
	
}
   
