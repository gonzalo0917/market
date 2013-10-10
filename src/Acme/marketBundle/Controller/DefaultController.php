<?php

namespace Acme\marketBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Acme\marketBundle\Entity\Measure;
use Acme\marketBundle\Entity\Brand;
use Acme\marketBundle\Entity\Town;

class DefaultController extends Controller
{

  protected $upload_dir = '/../../../../web/bundles/acmemarket/tmp/';
  protected $filename = "analisis.csv";

  public function indexAction()
  {
      return $this->render('AcmemarketBundle:Default:index.html.twig');
  }
  
  public function handlerData(){
    $fileName = __DIR__.$this->upload_dir.$this->filename;
    $fp = fopen( $fileName , 'r' );
    $space = 0;
    $data = array();
    $data_arr = array();
    $date_arr = array();
    $twon = "";
    $brand = "";
    while($csv_line = fgetcsv($fp,2084,';')){
      $space = 0;
      foreach ($csv_line as $key => $value) {
        if($value){
          if($space==2 && $key >= 1){
            $date_arr[] = $value;

          }
          elseif( $space==1 && $key >= 1 ){
            if($key==1){
              $brand = $value;
            }
            else{
              $data_arr['value'] = $value;
              $data_arr['town'] = $town;
              $data_arr['brand'] = $brand;
              $data_arr['date'] = $date_arr[$key-2];
            }
          }
          elseif ( $space==0 && $key==0 ) {
            $town = $value;
          }
          else{
            
          }
        }
        else{
          $space++;
        }
        if(sizeof( $data_arr  )){
          $data[] = $data_arr;
        }
      }  
    }
    return $data;    
  }

  public function setDataAction(){
    $dataset = $this->handlerData();

    foreach ($dataset as $key => $value) {
      $measure = new Measure();
      
      $town = new Town();
      $town->setName( $value['town'] );
      $town->setDateupdated( new \DateTime(date('Y-m-d H:i:s')) );
      $town->setDatecreated( new \DateTime(date('Y-m-d H:i:s')) );

      $brand = new Brand();
      $brand->setName( $value['brand'] );
      $brand->setDescription( "  " );
      $brand->setDateupdated( new \DateTime(date('Y-m-d H:i:s')) );

      $measure->setValue( $value['value'] );
      $measure->setDateupdated( new \DateTime(date('Y-m-d H:i:s')) );
      $measure->setDatemeasure( $value['date'] );
      $measure->setBrandbrand( $brand );
      $measure->setTowntown( $town );

      $em = $this->getDoctrine()->getManager();
      $em->persist( $measure );
      $em->persist( $measure->getBrandbrand() );
      $em->persist( $measure->getTowntown() );
      $em->flush();
    }

  }

  public function readDataAction(){
    $repository = $this->getDoctrine()
    ->getRepository('AcmemarketBundle:Measure');
    $products = $repository->findAll();
    echo "<pre>";print_r( $products ); echo "</pre>";
    die();
    return new Response('<html><body>Hello read !</body></html>');

  }

  public function updateDataAction(){

    return new Response('<html><body>Hello update !</body></html>');

  }

  public function uploadFileAction()
  {

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
