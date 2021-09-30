<?php 
include("Telegram.php");
// Set the TOKEN
$bot_id = getenv('TOKEN');
// Instances the class
$telegram = new Telegram($bot_id);


// Take text and chat_id from the message
$text 			  = $telegram->Text();
$chat_id 		  = $telegram->ChatID();


$update= json_decode(file_get_contents('php://input'));
$message = $update->message;


	$msgType = $telegram->getUpdateType();

	if ($text == '/start') {
	        $content = ['chat_id' =>$chat_id, 'action' => 'typing'];
	        $telegram->sendChatAction($content);
			$content = array('chat_id' => $chat_id,'text' =>'ویس خود را ارسال کنید.');
			$telegram->sendMessage($content);

			
			
}	elseif ($text == '/link') {
	             $content = ['chat_id' =>$chat_id, 'action' => 'typing'];
	             $telegram->sendChatAction($content);
                 
	    
	             $content = array('chat_id' => $chat_id  ,'text' => 'لینک سایت : https://voice-dict.herokuapp.com/ ' );
	             $telegram->sendMessage($content);
	
	
			
}   elseif ($msgType == 'voice') {
  
$file_id = $telegram->voiceFileID();
    	
	
$file = $telegram->getFile($file_id);
$file_path = $file['result']['file_path'];
$file_name = (string)$file_id;
$full_path ='https://api.telegram.org/file/bot'.$bot_id.'/'.$file_path;
file_put_contents('files/'.$file_name.'voice.ogg',file_get_contents($full_path));
  
$id=$message->from->username;


  $content = ['chat_id' =>$chat_id, 'action' => 'typing'];
  $telegram->sendChatAction($content);
 
  
  $content = array('chat_id' => $chat_id,'text' => 'فایل با موفقیت ذخیره شد.');
  $telegram->sendMessage($content);
  
} else {
 $content = ['chat_id' =>$chat_id, 'action' => 'typing'];
	        $telegram->sendChatAction($content);
 $content = array('chat_id' => $chat_id, 'text' => 'فایل را به صورت ویس ارسال کنید.');
			$telegram->sendMessage($content);
}

?>
