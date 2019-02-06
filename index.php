<?php


$bot_token="571928463:AAFnXzaO-xGjjC4IbxqD2l5ASX0fvci2XBs";
$bot_website="https://api.telegram.org/bot".$bot_token;

$update=file_get_contents('php://input');
$update_array = json_decode($update, TRUE);

$text = $update_array["message"]["text"];
$mesid = $update_array["message"]["message_id"];
$chat_id = $update_array["message"]["chat"]["id"];

$data=array();
$r="";
$mid=0;

switch ($text) {
	case "/start":
        $r="hello there, I am RemindMeBot. to learn how to use me please write /commands.";
        break;
    case "/ping":
        $r="pong";
        break;
	case "/commands":
        $r=urlencode("commands:\n/commands - shows this list.\n/ping - tests the internet connection.\n!remindme <time in minutes> <message> - sets a reminder.");
        break;
    case "!hi":
        $r="hey there";
        break;
	case stristr($text,'!remindme'):
		$ex=explode(' ', $text, 3);
		if(strcmp($ex[0],"!remindme")!=0){$r="";}
		elseif(strcmp($ex[0],"!remindme")==0 && !is_numeric($ex[1])){$r="To use the command you type: !remindme <time in minutes> <message>."; $mid=$mesid;}
		elseif(strcmp($ex[0],"!remindme")==0 && is_numeric($ex[1])){
		$r="Setted a reminder in ".$ex[1].' minutes, with the message: "'.$ex[2].'".';
		$mid=$mesid;
		remind($chat_id, $mesid, $ex[1], $ex[2]);}
        break;
    default:
        $r="";
}

file_get_contents($bot_website."/sendmessage?chat_id=".$chat_id."&text=".$r."&reply_to_message_id=".$mid);

function remind($chat_id, $mesid, $time, $msg){
$data = json_decode(file_get_contents('arr.json'), true);
array_push($data, array('chat_id'=>$chat_id,'time'=>($time),'message_id'=>$mesid,'msg'=>$msg));
file_put_contents("arr.json",json_encode($data));
}
?>