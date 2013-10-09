<?php

namespace Acme\marketBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{

  protected $upload_dir = '/../../../../web/bundles/acmemarket/tmp/';
  protected $filename = "setData.csv";

  public function indexAction()
  {
      return $this->render('AcmemarketBundle:Default:index.html.twig');
  }
  
  public function setDataAction(){
    $this->upload_dir = __DIR__.$this->upload_dir.$this->filename;
    $file = fopen( $this->upload_dir , 'r' );
    while (($line = fgetcsv($file, 89 , "," )) !== FALSE) {
      foreach($line as $value){
        echo sizeof( split( ",", $value) );
          //list($cliente_id,$imss, $curp,  $rfc, $telefono_trabajo, $celular) =split( ",", $value);          
          
      }
      echo "<pre>";print_r( $line );echo "</pre>";
      die();
    }
    fclose($file);
    
   
    die();

  }

  public function uploadFileAction()
  {
    #return new Response('<html><body>Hello !</body></html>');
    $response = array();
    if(!empty($_FILES['file']['error'])){
      switch($_FILES['file']['error']){
        case '1':
          $error = 'The uploaded file exceeds the upload_max_filesize directive in php.ini';
          break;
        case '2':
          $error = 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form';
          break;
        case '3':
          $error = 'The uploaded file was only partially uploaded';
          break;
        case '4':
          $error = 'No file was uploaded.';
          break;

        case '6':
          $error = 'Missing a temporary folder';
          break;
        case '7':
          $error = 'Failed to write file to disk';
          break;
        case '8':
          $error = 'File upload stopped by extension';
          break;
        case '999':
        default:
          $error = 'No error code avaiable';
          break;
    }
    $response ['message']= $error;
    $response['status'] = 'Failure';
    $response['cls'] = 'alert-error';
    }
    elseif(empty($_FILES['file']['tmp_name']) || $_FILES['file']['tmp_name'] == 'none'){
      $response ['message'] = 'No file was uploaded..';
      $response['status'] = 'Failure';
    }
    else{
      if (isset($_FILES['file'])){
        if ($_FILES['file']['error'] == UPLOAD_ERR_OK){
          $this->upload_dir = __DIR__.$this->upload_dir.$this->filename;
          move_uploaded_file($_FILES['file']['tmp_name'], $this->upload_dir);  
          chmod( $this->upload_dir, 0777 );        
          $response ['FileName'] = $this->filename ;
          $response ['FilePath'] = $this->upload_dir;
          $response ['FileSize'] = $_FILES['file']['size'];
          #$this->setData();
        }
      }
      $response ['message']= 'El Archivo se subio correctamente.';
      $response['status'] = 'Success';
      $response['cls'] = 'alert-success';
    }
    return new JsonResponse( $response );  
  }
}
