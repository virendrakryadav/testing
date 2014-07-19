<?php
class SearchUrlRule extends CBaseUrlRule{
   public function createUrl($manager,$route,$params,$ampersand){
      //print_r($manager);
      //print_r($params);
      //print_r($route);
      //print_r($ampersand);
      //exit();
      return false;
   }
   
   public function parseUrl($manager,$request,$pathInfo,$rawPathInfo){
      /*//print_r($request);
      echo '<br/><br/><br/><br/>';
      print_r($request->requestUri);
      //print_r($pathInfo);pathInfo
      //print_r($rawPathInfo);
      //print_r($manager);
      //exit();
      if (preg_match('%^(restaurant-delivery)+$%', $request->requestUri, $matches))
      {
            // check $matches[1] and $matches[3] to see
            // if they match a manufacturer and a model in the database
            // If so, set $_GET['manufacturer'] and/or $_GET['model']
            // and return 'car/index'
            exit('test');
      }*/
      return false;
   }
}