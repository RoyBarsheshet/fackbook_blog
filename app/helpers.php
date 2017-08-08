<?php


if (!function_exists('old')){
function old($field_name){
  
  return isset($_REQUEST[$field_name]) ? $_REQUEST[$field_name] : '';
}
}
if(!function_exists('csrf_token') ){
function csrf_token(){
  
  $token = sha1(rand(1, 1000) . 'Roy_fakebook_blog' .date('Y.m.d.H.i.s'));
  $_SESSION['token'] = $token;
  return $token;
}
}
