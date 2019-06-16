# vk_api
VERSION 1.2.0
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
  Also, do not forget to put the method $vk->sendOK(); Which is end of file before ?>
  Added new function isMethod($method); This function check $method in vk_api methods. Return true if this method be in vk_api, else false.
In version 1.2 was added Geo, VkPay, Vk Apps
For call use in button fourth element Type of action location, vkpay, open_app. Also for vkpay and open_app add fiveth element array. This is preferences of action. For vkpay add only Hash. For open_app AppID and not important (OwnerID, Hash)
For example
Location
[["command"=>"payload"],"-","-","location"];
VkPay
[["command"=>"payload"],"-","-","vkpay",["action=transfer-to-group&group_id=182951281&aid=10"]]
Vk Apps
[["command"=>"payload"],"Text","-","open_app",[6979558,false,"sendKeyboard"]]
If in element be a minus, this translate how not important, and if you write someone in this element, this will not read.
