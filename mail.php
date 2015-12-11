<?php
require_once('model.php');

$resource_components = explode('/', $_SERVER['PATH_INFO']);

if (count($resource_components) < 2) {
  header("HTTP/1.1 400 Bad Request");
  print("No resource specified.");
  exit();
}

$resource_type = $resource_components[1];

if ($resource_type != "messages") {
  header("HTTP/1.1 400 Bad Request");
  print("Unknown resource: " . $resource_type);
  exit();
}

if (count($resource_components) == 2) {
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

  $message = getMessage($resource_id);

  if (is_null($message)) {
    header("HTTP/1.1 404 Not Found");
    print("No message with id = " . $resource_id);
    exit();
  } 

  switch ($representation_type) {
    case 'txt':
       header("Content-type: text/plain");
       print("ID: " . $message['id'] . "\n");
       print("From: " . $message['from'] . "\n");
       print("Subject: " . $message['subject'] . "\n");
       print("Body: " . $message['body'] . "\n");
       break;

    case 'html':
?>
<html>
  <head>
    <title><?php print("Message: " . $message['id'])?></title>
  </head>
  <body>
    <h3>Subject: <?php print(htmlspecialchars($message['subject']))?></h3>
    <h3>From: <?php print(htmlspecialchars($message['from']))?></h3>
    <p>
    <?php print(str_replace("\n", "<br>", htmlspecialchars($message['body']))); ?>
    </p>
  </body>
</html>
<?php
       break;

    case 'json':
      header('Content-type: application/json');
      print(json_encode($message));
      break;

    default:
      header('HTTP/1.1 400 Bad Request');
      print("Unknown representationt type: " . $representation_type);
  }  
  exit();  
}
  

header("HTTP/1.1 400 Bad Request");
print("Did not understand URL");
?>

