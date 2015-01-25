<?php
namespace udokmeci\yii2closestrelation;

Trait ClosestRelationTrait {

    function getRelationName($class){ 
    	$itsNS = substr($class, 0, strrpos( $class, '\\'));
    	$itsCN = substr($class,  strrpos( $class, '\\'));
		$myClass=get_called_class();
		$myNS = substr($myClass, 0, strrpos( $myClass, '\\'));
		$myCN = substr($myClass,  strrpos( $myClass, '\\'));
		$lookingFor=$myNS.$itsCN;
    	
		$parentCN=get_parent_class($myClass);
		if(class_exists($lookingFor)){
			return $lookingFor;
		}
		$parent= new $parentCN;
		
		try{
			return $parent->getRelationName($class);
		}
		catch (\Exception $e){
			return $class;
		}
		return $class;		
			

    }
}