<?php
require_once('model.php');
require_once "bootstrap.php";
require_once 'Roommate.php';

/*$newMember = new Roommate();
$newMember->setName("Jared");
$newMember->setScore(0);
$newMember->setHid(null);
$entityManager->persist($newMember);
$entityManager->flush();






$roommate = $entityManager->find('Roommate', "Jared");
$roommate->getName();*/

        
        
        
        
        
        
//$resource_components = explode('/', $_SERVER['PATH_INFO']);
$resource_components = array("addRoommate","Jared");

/*if (count($resource_components) < 2) {
  header("HTTP/1.1 400 Bad Request");
  print("No resource specified.");
  exit();
}*/

$resource_type = $resource_components[1];
//echo $resource_components[2];

/*if ($resource_type != "addRoommate") {
  header("HTTP/1.1 400 Bad Request");
  print("Unknown resource: " . $resource_type);
  exit();
}*/
if($resource_type == "addRoommate") {
    $newMember = new Roommate();
    $newMember->setName($resource_components[2]);
    $newMember->setScore(0);
    $entityManager->persist($newMember);
    $entityManager->flush();
    
}
if($resource_type == 'getRoommate') {
    $roommate = $entityManager->find('Roommate', "Jared");
    $roommate->getName();
    $userArray = array('rid' => $roommate->getRid(), 
        'name' => $roommate->getName(),
        'score' => $roommate->getScore()
            
            );
    
    header('Content-type: application/json');
    print(json_encode($userArray));
}
/*if (count($resource_components) == 2) {
  $mlist = array();

  foreach (getMessageList() as $idx => $message) {
    $mlist[] = array('id' => $message['id'],
		     'from' => $message['from'],
		     'subject' => $message['subject']);
  }

  header('Content-type: application/json');
  print(json_encode($mlist));
  exit();
} 


if (count($resource_components) == 3) {

  $resource_id_components = explode(".", $resource_components[2]);

  if (count($resource_id_components) > 2) {
    header("HTTP/1.1 400 Bad Request");
    print("Resource id badly formed: " . $resource_components[2]);
    exit();
  }
  
  $resource_id = intval($resource_id_components[0]);

  if (count($resource_id_components) == 2) {
    $representation_type = $resource_id_components[1];
  } else {
    $representation_type = 'json';
  }

  $message = getMessage($resource_id);*/

  /*if (is_null($message)) {
    header("HTTP/1.1 404 Not Found");
    print("No message with id = " . $resource_id);
    exit();
  } */


  

?>

