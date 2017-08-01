<?php


if (!function_exists('old')){
function old($field_name){
  
  return isset($_REQUEST[$field_name]) ? $_REQUEST[$field_name] : '';
}
}
