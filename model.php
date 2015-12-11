<?php

$message_list = array();

$message_list[] = array('id' => 123,
                        'subject' => 'Test message 1',
                        'from' => 'A friend',
                        'body' => 'This is test message one.');

$message_list[] = array('id' => 214,
                        'subject' => 'Greetings...',
                        'from' => 'An enemy',
                        'body' => 'I hate you.');

$message_list[] = array('id' => 167,
                        'subject' => 'Lunch on Friday?',
                        'from' => 'Christine',
                        'body' => "Want to have \n lunch on Friday?");

$message_list[] = array('id' => 312,
                        'subject' => 'Need help with bank account',
                        'from' => 'Nigerian Nick',
                        'body' => "Dear Sir:\nWe need your help transfering $8,000,000\n to a U.S. bank account. You will be compensated.\nPlease reply with account information. ");


function getMessageList() {
  global $message_list;
  return $message_list;
}

function getMessage($id) {
  global $message_list;

  foreach ($message_list as $idx => $message) {
    if ($message['id'] == $id) {
      return $message;
    }
  }
  return NULL;
}

?>
