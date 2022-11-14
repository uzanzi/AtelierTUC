<?php
namespace iutnc\mf\utils;

class HttpRequest extends AbstractHttpRequest
{
  public function __construct()
  {

    $this->script_name = $_SERVER['SCRIPT_NAME'];

    if (isset($_SERVER['PATH_INFO'])) {
      $this->path_info = $_SERVER['PATH_INFO'];
    }

    $this->root = dirname($_SERVER['SCRIPT_NAME'], 1);

    $this->method = $_SERVER['REQUEST_METHOD'];

    if (isset($_GET)) {
      $this->get = $_GET;
    }
    
    if (isset($_POST)) {
      $this->post = $_POST;
    }

  }
}


?>