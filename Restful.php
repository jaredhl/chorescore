<?php
require_once('model.php');
require_once "bootstrap.php";
require_once 'Roommate.php';
require_once 'Chore.php';
require_once 'Completed.php';
        
        
//$resource_components = explode('/', $_SERVER['PATH_INFO']);
//$resource_components = array("","getAllRoommates");
//$currentDate = date("Y-m-d");
$resource_components = array("","updateChore","Trash");


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
    $roommate = $entityManager->getRepository('Roommate')->findOneBy(array('name' => $resource_components[2]));
    header('Content-type: application/json');
    print(json_encode($roommate));
}
if($resource_type == 'updateRoommate') {
    $roommate = $entityManager->getRepository('Roommate')->findOneBy(array('name' => $resource_components[2]));
    $roommate->setScore($resource_components[3]);
    //$entityManager->persist($newMember);
    $entityManager->flush();
}
if($resource_type == 'deleteRoommate') {
    $roommate = $entityManager->getRepository('Roommate')->findOneBy(array('name' => $resource_components[2]));
    $entityManager->remove($roommate);
    $entityManager->flush();
}

if($resource_type == 'getAllRoommates') {
    $roommates = $entityManager->getRepository('Roommate')->findAll();
    $roommateArray;
    foreach ($roommates as $roommate) {
        $roommateArray[] = json_encode($roommate);
    }
    header('Content-type: application/json');
    print(json_encode($roommateArray));
}
if($resource_type == 'addChore') {
    $newChore = new Chore;
    $newChore->setName($resource_components[2]);
    $newChore->setBaseValue($resource_components[3]);
    $newChore->setRefreshRate($resource_components[4]);
    $date = new DateTime("now");
    $newChore->setLastCompleted($date);
    $entityManager->persist($newChore);
    $entityManager->flush();
}
if($resource_type == 'performChore') { 
    $newCompleted = new Completed();
    $chore = $entityManager->getRepository('Chores')->findOneBy(array('name' => $resource_components[2]));
    $completedValue = $chore->getBaseValue();
    $roommate = $entityManager->getRepository('Roommate')->findOneBy(array('name' => $resource_components[3]));
    $completedRid = $roommate->getRid();
    $newCompleted->setRid($completedRid);
    //$datetime = new DateTime::createFromFormat('Y-m-d', $resource_components[4]);
}
if($resource_type == 'updateChore') {
    $chore = $entityManager->getRepository('Chore')->findOneBy(array('cid' => "3"));
    $date = new DateTime("now");
    $chore->setLastCompleted($date);
    $entityManager->flush();
}
if($resource_type == 'getAllChores') {
    $chores = $entityManager->getRepository('Chore')->findAll();
    $choreArray;
    foreach ($chores as $chore) {
        $choreArray[] = json_encode($chore);
    }
    header('Content-type: application/json');
    print(json_encode($choreArray));
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

