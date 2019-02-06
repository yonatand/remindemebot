<?php

$bot_token="571928463:AAFnXzaO-xGjjC4IbxqD2l5ASX0fvci2XBs";
$bot_website="https://api.telegram.org/bot".$bot_token;

$reminders=json_decode(file_get_contents('arr.json'), true);
for($i=0; $i<count($reminders); $i++){

$text = $reminders[$i]["msg"];
$mesid = $reminders[$i]["message_id"];
$chat_id = $reminders[$i]["chat_id"];
$time = $reminders[$i]["time"];

if($time>0){
$reminders[$i]["time"]=$time-1;
}

if($time==0){
file_get_contents($bot_website."/sendmessage?chat_id=".$chat_id."&text=reminder: ".$text."&reply_to_message_id=".$mesid);
$reminders[$i]["time"]=-1;
unset($reminders[$i]);
}

if($time<0){
unset($reminders[$i]);
}

}
file_put_contents("arr.json",json_encode($reminders));

print_r(json_decode(file_get_contents('arr.json'), true));

?>