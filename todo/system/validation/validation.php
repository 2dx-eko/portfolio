<?php
class validation{
   public static function errorCheck($content){
      if(!$content){
         return false;
      }
      return true;
   }
}
?>