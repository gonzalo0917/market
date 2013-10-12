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
  
  public function readTownAction(){

    $response =  array();
    $town_repository = $this->getDoctrine()->getRepository('AcmemarketBundle:Town');
    $towns = $town_repository->findAll();
    foreach ($towns as $key => $value) {
      $response[] = array( 'IdTown' => $value->getIdtown(), 'town' => $value->getName()   );
    }
    return new JsonResponse( $response );

  }

  public function updateBrandAction(){

    $em = $this->getDoctrine()->getManager();
    $Brand = $this->getDoctrine()->getRepository('AcmemarketBundle:Brand')->find($_REQUEST['idbrand']);
    $Brand->setDescription( $_REQUEST['description'] );
    $Brand->setDateupdated( new \DateTime(date('Y-m-d H:i:s')) );
    $em->persist( $Brand );
    $em->flush();

    return new JsonResponse( array( 'status'=>'Success' ) );
  }

  public function readBrandAction(){

    $response = array();
    $repository = $this->getDoctrine()->getRepository('AcmemarketBundle:Brand');
    $Brand = $repository->findAll();
    foreach ($Brand as $key => $value) {
      $response[] = array(
        'idbrand'=> $value->getIdbrand(),
        'brand' => $value->getName(),
        'description' => $value->getDescription(),
        'dateUpdated' => $value->getDateupdated(),
        'dateCreated' => $value->getDatecreated()
      );
    }
    return new JsonResponse( $response );
  }

  public function measureByTownAction(){

    $response = array();
    $aux = array();
    $date = array();
    $brand = "";
    $brands = $this->getDoctrine()->getRepository('AcmemarketBundle:Brand')->findAll();
    $em = $this->getDoctrine()->getManager();
    foreach ($brands as $key => $value) {
      
      $query = $em->createQuery( 'SELECT m FROM AcmemarketBundle:Measure m
        WHERE m.towntown = :towntown and m.brandbrand =:brandbrand ORDER BY m.brandbrand ASC'
      )->setParameters(array(
        'towntown' => $_REQUEST['idTown'],
        'brandbrand'  => $value->getIdbrand(),
      ));
      $measures = $query->getResult();
      $aux = array();
      foreach ($measures as $key => $element) {

        $date[] = $element->getDatemeasure();
        $aux['name'] = $element->getBrandbrand()->getName();
        $aux['data'][] = $element->getValue();     
        $date = array_unique($date);

      }
      if(sizeof($aux)){
        $response['output']['measures'][] = $aux;
      } 

    }
    foreach ($date as $key => $value) {
      $response['output']['month'][] = $value;
    }
    
    return new JsonResponse( $response );

  }

  public function handlerData(){
    $data = array();
    $fileName = __DIR__.$this->upload_dir.$this->filename;
    $fp = fopen( $fileName , 'r' );
    $space = 0;
    
    $data_arr = array();
    $date_arr = array();
    $twon = "";
    $brand = "";
    while($csv_line = fgetcsv($fp,2084, ';')){

      $space = 0;
      $data_arr = array();
      foreach ($csv_line as $key => $value) {
        if($value){

          if($space==2 && $key >= 2){
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
          elseif( $space==0 && $key>=1 ){
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

  public function setData(){
    $dataset = $this->handlerData();
    
    $town_repository = $this->getDoctrine()->getRepository('AcmemarketBundle:Town');
    $brand_repository = $this->getDoctrine()->getRepository('AcmemarketBundle:Brand');
    
    foreach ($dataset as $key => $value) {



      $town = $town_repository->findOneByName( $value['town'] );
      if(!$town){
        $town = new Town();
        $town->setName( $value['town'] );
        $town->setDateupdated( new \DateTime(date('Y-m-d H:i:s')) );
        $town->setDatecreated( new \DateTime(date('Y-m-d H:i:s')) );
      }      

      $brand = $brand_repository->findOneByName( $value['brand'] );
      if(!$brand){
        $brand = new Brand();
        $brand->setName( $value['brand'] );
        $brand->setDescription( "  " );
        $brand->setDateupdated( new \DateTime(date('Y-m-d H:i:s')) );
        $brand->setDatecreated( new \DateTime(date('Y-m-d H:i:s')) );
      }  
      $measure = new Measure();
            

      $measure->setValue( $value['value'] );
      $measure->setDateupdated( new \DateTime(date('Y-m-d H:i:s')) );
      $measure->setDatecreated( new \DateTime(date('Y-m-d H:i:s')) );
      $measure->setDatemeasure( $value['date'] );
      $measure->setBrandbrand( $brand );
      $measure->setTowntown( $town );

      $em = $this->getDoctrine()->getManager();
      $em->persist( $measure );
      $em->persist( $measure->getBrandbrand() );
      $em->persist( $measure->getTowntown() );
      $em->flush();

    }
    return new Response('<html><body>Hello update !</body></html>');
  }

  public function readDataAction(){

    $response = array();
    $repository = $this->getDoctrine()->getRepository('AcmemarketBundle:Measure');
    $products = $repository->findAll();
    foreach ($products as $key => $value) {
      $response[] = array(
        'idmeasure'=> $value->getIdmeasure(),
        'datemeasure' => $value->getDatemeasure(),
        'value' => $value->getValue(),
        'brand' => $value->getBrandbrand()->getName(),
        'town' => $value->getTowntown()->getName()
      );
    }
    return new JsonResponse( $response );

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
          $fileName = __DIR__.$this->upload_dir.$this->filename;
          move_uploaded_file($_FILES['file']['tmp_name'], $fileName);  
          chmod( $fileName, 0777 );        
          $response ['FileName'] = $this->filename ;
          $response ['FilePath'] = $fileName;
          $response ['FileSize'] = $_FILES['file']['size'];
          $this->setData();
        }
      }
      $response ['message']= 'El Archivo se subio correctamente.';
      $response['status'] = 'Success';
      $response['cls'] = 'alert-success';
    }
    return new JsonResponse( $response );  
  }
}
