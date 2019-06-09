<?php
class vk_api{
    /**
     * Токен
     * @var string
     */
    private $iscurl = true;
    private $headers = true;
    private $token = '';
    private $v = '';
    private $token_user = '';
    private $fields = 'nickname, screen_name, sex, bdate, city, country, timezone, photo_50, photo_100, photo_200_orig, has_mobile, contacts, education, online, counters, relation, last_seen, status, can_write_private_message, can_see_all_posts, can_post, universities';
    /**
     * @param string $token Токен
     */
    public function __construct($token, $v, $token_user = false){
        $this->token_user = $token_user==false?$token:$token_user;
        $this->token = $token;
        $this->v = $v;
    }
    /**
     * Посмотреть есть ли метод в API
     * @param string $method метод
     * @return true|false (1|0)
     */
    public function isMethod($method){
        return method_exists($this, $method)?1:0;
    }
    /**
     * Тогглит curl
     */
    public function curl_toggle(){
        $this->iscurl = !$this->iscurl;
    }
    /**
     * Тогглит curl
     */
    public function fixOK(){
        $this->headers = !$this->headers;
    }
    /**
     * Добавить пользователя в беседу
     * @param int $chat_id беседа
     * @param int $user_id пользователь
     * @return mixed|null
     */
    public function addUser($chat_id,$user_id){
        return $this->request('messages.addChatUser',array('chat_id'=>$chat_id,'user_id'=>$user_id),true);
    }
    /**
     * Ссылка для добавления пользователя в беседу
     * @param int $peer_id беседа
     * @return mixed|null
     */
    public function inviteLink($chat_id,$reset = 1){
            $request = $this->request('messages.getInviteLink',array('peer_id'=>$chat_id+2000000000,'reset'=>$reset));
            $request['chat_id'] = $chat_id;
            $request['reset'] = $reset;
            return $request;
    }
    /**
     * Отправить сообщение пользователю
     * @param int $sendID Идентификатор получателя
     * @param string $message Сообщение
     * @return mixed|null
     */
    public function sendDocMessage($sendID, $id_owner, $id_doc){
        if ($sendID != 0 and $sendID != '0') {
            return $this->request('messages.send',array('attachment'=>"doc". $id_owner . "_" . $id_doc,'user_id'=>$sendID));
        } else {
            return true;
        
        }
    }
    /**
     * Получить информацию об пользователя
     * @param string $response_type тип данных для получения
     * @param string $display Метод по получению токена
     * @param string|int $fields Данные для пользователя в токене (Автоматом стоят все данные)
     * @return string
     */
    public function getUser($user_id){
            return $this->request('users.get',array('user_id'=>$user_id,'fields'=>$this->fields));
    }
    /**
     * Получить ссылку на получения токена пользователя
     * @param string $response_type тип данных для получения
     * @param string $display Метод по получению токена
     * @param string|int $fields Данные для пользователя в токене (Автоматом стоят все данные)
     * @return string
     */
    public function tokenLink($response_type = "token",$display = "page",$fields = 140492255){
            return "https://oauth.vk.com/authorize?client_id=2685278&scope=140492255&redirect_uri=https://api.vk.com/blank.html&display=".$display."&response_type=".$response_type."&revoke=1";
    }
    /**
     * Получить сообщение по его идентефикатору
     * @param array $mess_ids идентефикатор(-ы) сообщения(-й)
     * @param int $user_id идентефикатор пользователя
     * @return mixed|null
     */
    public function getMessById($mess_ids=array(),$user_id,$preview_length=0,$extended=1){
        return $this->request('messages.getById',array("message_ids"=>$mess_ids,"user_id"=>$user_id,"preview_length"=>$preview_length,"extended"=>$extended));
    }
    /**
     * Получить сообщение по его идентефикатору (для юзеров и сообщений сообщества)
     * @param array $mess_ids идентефикатор(-ы) сообщения(-й)
     * @param int $group_id идентефикатор сообщества
     * @return mixed|null
     */
    public function getMessByIdGroup($mess_ids=array(),$group_id,$preview_length=0,$extended=1){
        return $this->request('messages.getById',array("message_ids"=>$mess_ids,"group_id"=>$group_id,"preview_length"=>$preview_length,"extended"=>$extended),true);
    }
    /**
     * Поставить онлайн пользователю
     * @param int $voip Звонки пользователю
     * @return mixed|null
     */
    public function setOnline($voip = 0){
        return $this->request('account.setOnline',array('voip'=>$voip),true);
    }
    /**
     * Изменить название чата
     * @param int $chat_id Идентефикатор сообщества (без 2000000000)
     * @param string $title Новое название
     * @return mixed|null
     */
    public function editChat($chat_id,$title){
        return $this->request('messages.editChat',array('chat_id'=>$chat_id,'title'=>$title));
    }
    /**
     * Получить чат
     * @param int $chat_id Идентефикатор сообщества (без 2000000000)
     * @param string $name_case Падеж для имен и фамилий пользователей
     * @return mixed|null
     */
    public function getChat($chat_id,$name_case='Nom'){
        return $this->request('messages.getChat',array('chat_id'=>$chat_id,'fields'=>$this->fields,'name_case'=>$name_case));
    }
    /**
     * Поставить оффлайн пользователю
     * @return mixed|null
     */
    public function setOffline(){
        return $this->request('account.setOffline',array(),true);
    }
    /**
     * Исключить пользователя из беседы
     * @param int $chat_id Идентефикатор беседы
     * @param int $user_id Идентефикатор исключаемого пользователя
     * @return mixed|null
     */
    public function removeUser($chat_id,$user_id){
        return $this->request('messages.removeChatUser',array('chat_id'=>$chat_id,'user_id'=>$user_id),true);
    }
    /**
     * Создать чат
     * @param string $title Название чата
     * @param string $user_ids Пользователи чата
     * @return mixed|null
     */
    public function createChat($title, $user_ids=''){
        return $this->request('messages.createChat',array('title'=>$title,'user_ids'=>$user_ids),true);
    }
    public function sendMessage($sendID,$message){
        if ($sendID != 0 and $sendID != '0') {
            return $this->request('messages.send',array('message'=>$message, 'peer_id'=>$sendID));
        } else {
            return true;
        }
    }

    public function sendOK(){
        echo 'ok';
        if($this->headers){
        $response_length = ob_get_length();
        // check if fastcgi_finish_request is callable
        if (is_callable('fastcgi_finish_request')) {
            /*
             * This works in Nginx but the next approach not
             */
            session_write_close();
            fastcgi_finish_request();

            return;
        }

        ignore_user_abort(true);

        ob_start();
        $serverProtocole = filter_input(INPUT_SERVER, 'SERVER_PROTOCOL', FILTER_SANITIZE_STRING);
        header($serverProtocole.' 200 OK');
        header('Content-Encoding: none');
        header('Content-Length: '. $response_length);
        header('Connection: close');

        ob_end_flush();
        ob_flush();
        flush();
        }
    }

    public function sendButton($sendID, $message, $gl_massiv = [], $one_time = False) {
        $buttons = [];
        $i = 0;
        foreach ($gl_massiv as $button_str) {
            $j = 0;
            foreach ($button_str as $button) {
                $color = $this->replaceColor($button[2]);
                $buttons[$i][$j]["action"]["type"] = "text";
                if ($button[0] != null)
                    $buttons[$i][$j]["action"]["payload"] = json_encode($button[0], JSON_UNESCAPED_UNICODE);
                $buttons[$i][$j]["action"]["label"] = $button[1];
                $buttons[$i][$j]["color"] = $color;
                $j++;
            }
            $i++;
        }
        $message = trim($message)==""?"*Is empty message*":$message;
        $buttons = array(
            "one_time" => $one_time,
            "buttons" => $buttons);
        $buttons = json_encode($buttons, JSON_UNESCAPED_UNICODE);
        //echo $buttons;
        return $this->request('messages.send',array('message'=>$message, 'peer_id'=>$sendID, 'keyboard'=>$buttons));
    }

    public function sendDocuments($sendID, $selector = 'doc'){
        if ($selector == 'doc')
            return $this->request('docs.getMessagesUploadServer',array('type'=>'doc','peer_id'=>$sendID));
        else
            return $this->request('photos.getMessagesUploadServer',array('peer_id'=>$sendID));
    }

    public function saveDocuments($file, $titile){
        return $this->request('docs.save',array('file'=>$file, 'title'=>$titile));
    }

    public function savePhoto($photo, $server, $hash){
        return $this->request('photos.saveMessagesPhoto',array('photo'=>$photo, 'server'=>$server, 'hash' => $hash));
    }

    /**
     * Запрос к VK
     * @param string $method Метод
     * @param array $params Параметры
     * @return mixed|null
     */
    private function request($method,$params=array(),$is_user_token = false){
        $url = 'https://api.vk.com/method/'.$method;
        $params['access_token'] = $is_user_token==false?$this->token:$this->token_user;
        $params['v']=$this->v;
        if (function_exists('curl_init') && $this->iscurl==true) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                "Content-Type:multipart/form-data"
            ));
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
            $result = json_decode(curl_exec($ch), True);
            curl_close($ch);
        } else {
            $result = json_decode(file_get_contents($url, true, stream_context_create(array(
                'http' => array(
                    'method'  => 'POST',
                    'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                    'content' => http_build_query($params)
                )
            ))), true);
        }
        if (isset($result['response']))
            return $result['response'];
        else
            return $result;
    }

    private function replaceColor($color) {
        switch ($color) {
            case 'red':
                $color = 'negative';
                break;
            case 'green':
                $color = 'positive';
                break;
            case 'white':
                $color = 'default';
                break;
            case 'blue':
                $color = 'primary';
                break;

            default:
                # code...
                break;
        }
        return $color;
    }

    private function sendFiles($url, $local_file_path, $type = 'file') {
        $post_fields = array(
            $type => new CURLFile(realpath($local_file_path))
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Content-Type:multipart/form-data"
        ));
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);
        $output = curl_exec($ch);
        return $output;
    }

    public function sendImage($id, $local_file_path)
    {
        $upload_url = $this->sendDocuments($id, 'photo')['upload_url'];

        $answer_vk = json_decode($this->sendFiles($upload_url, $local_file_path, 'photo'), true);

        $upload_file = $this->savePhoto($answer_vk['photo'], $answer_vk['server'], $answer_vk['hash']);

        $this->request('messages.send', array('attachment' => "photo" . $upload_file[0]['owner_id'] . "_" . $upload_file[0]['id'], 'peer_id' => $id));

        return 1;
    }
}
