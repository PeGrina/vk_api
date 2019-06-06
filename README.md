# vk_api
This vk api methods. Methods will be add in future, if you not see method, which your need, will write me in VK. @ap_prog(https://vk.com/ap_prog). Will answer all!
Description
Start
For start include vk_api 
  code:
  <pre>
  require "vk_api";
  $vk = new vk_api($token,$version,$token_user); // $token_user not important
  $vk->sendMessage(380925999,"Test");
  </pre>
Be a method sendButton()
code :
 <pre>
  $vk->sendButton(38025999,"Test",[[$btn1,$btn2],[$btn3,$btn4]]);
 </pre>
 Buttons build how array
 <pre>
  $btn1 = [["command"=>"btn1"],"BTN1","green"];
 </pre>
 First element this payload of button. Second element this text of button. Third element this color of button.
 Colors - 
 <pre>
   Green
   Red
   Blue
   White
 </pre>
