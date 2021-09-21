<?php 
try{
	$connection = new PDO("mysql:host=ec2-34-228-154-153.compute-1.amazonaws.com;dbname=
	d9uhuugvncjmvg","
	yhpgwjrdhfcobl","8b5aa7e994d61210f6a7f62dbe92e39a0d224e94ebe41dbf2930aad5b193579b");
	echo "DB connected :D"
}catch(PDOException $e){
	//error text info
	echo $e.getMessage();
	//error array
	print_r($e.errorInfo());
	}
include("Telegram.php");
// Set the bot TOKEN
$bot_id = "1821998766:AAFC33-G_KDLtoHvvm5tBBWjMvzsGY0925o";
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
