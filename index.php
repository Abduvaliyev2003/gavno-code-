<?php

session_start();


require_once './Telegram.php';
require_once './Controller/Controller.php';
require_once './FuncPage.php';
$telegram = new Telegram('6895971365:AAHrq3QsmWtjifrIUaKGXh6j-Cg-ifhRxvo');
$webhook = $telegram->setWebhook('https://b843-178-218-201-167.ngrok-free.app/index.php');

$chat_id = $telegram->ChatID();
$text = $telegram->Text();
$data = $telegram->getData();
$callback_query = $telegram?->Callback_Query();
$callback_data = $telegram?->Callback_Data();
$message = $data['message'];
$controller = new  Controller($telegram, $chat_id, $callback_query);
$productInfo = $_SESSION['karzina_page'];


if($callback_query !== null && $callback_query != '')
{
    
    switch(getHomePage($chat_id)) {
        case 'category_products':
            $controller->category_inline($callback_data);
            break;
        case 'product_page': 
            switch($callback_data){
                
                case strpos($callback_data, 'plus') !== false || strpos($callback_data, 'minus') !== false :
                    $controller->counter($callback_data);
                    break;
                case  strpos($callback_data, 'karzina') !== false:
                    $controller->addKarzina(); 
                    break;  
            }
            break;
        case 'karzina_page': 
            switch($callback_data){
                case strpos($callback_data, 'edit') !== false || strpos($callback_data, 'plus') !== false || strpos($callback_data, 'minus') !== false || strpos($callback_data, 'delete') !== false:
                    $controller->edit_product($callback_data);
                    break;   
              
            }
            break; 
    }
}
elseif('/start' == $text){
  $controller->register();
} elseif($text == '/menu')
{  
    
    $controller->menu();
} else {
   
  switch(getHomePage($chat_id)) {
    case 'register':
        if($message["contact"]["phone_number"]){
            $controller->register_second();
        } 
        elseif($text !== '')
        {
            $phone_number_validation_regex = "/^998([378]{2}|(9[013-57-9]))\d{7}$/";
            if (preg_match($phone_number_validation_regex,  str_replace('+','', preg_replace('/\s+/', '', $text)))) {
                $controller->register_second();
            } else {
                $content = ['chat_id' => $chat_id, 'text' => "Noto'g'ri formatda kiritdingiz"];
                $telegram->sendMessage($content);
            }
        }
        break;
    case 'register_second':
        if($text !==''){
            $controller->menu();
        }
        break;  
    case 'menu': 
        switch ($text){
            case '🗂 Mahsulotlar':
                $controller->categories();
                break;
            case '🛍 Mening buyurtmalarim':
                $controller->myUserByProduct();
                break;  
            case  '⚙️ Sozlamalar':
                $controller->setting();
                break; 
            case '✍️ Fikr bildirish': 
                $controller->comment();
                break;
        }
        break;


    case 'setting':
        switch ($text) {
            case '📞 Telefon nomerni o`zgartrish':
                $controller->menu();
                break; 
            case '👤 Ism-familyani tahrirlash':
                $controller->menu();
                break;  
            case '🔙 Orqaga':
                $controller->menu();
                break;        
        } 
        break; 
    case 'categories': 
        switch ($text) 
        {
            case '🔙 Orqaga':
                $controller->menu();
                break;
            case in_array($text , [ 'Category 1','Category 2','Category 3', 'Category 4',]):
                $controller->category_products($text);
                break;         
        }  
        break; 
    case 'comment': 
            switch ($text) 
            {
                case $text !== "🔙 Orqaga":
                    $controller->menu();
                    break; 
                case '🔙 Orqaga':
                    $controller->menu();
                    break;        
            }  
            break; 
    case 'category_products': 
        switch($text){
            case '🔙 Orqaga':
                $telegram->deleteMessage([
                    'chat_id' => $chat_id,
                    'message_id' => $message['message_id'] -1
                ]);
                $controller->categories();
                break;   
            case '📥 Savat':
                $telegram->deleteMessage([
                    'chat_id' => $chat_id,
                    'message_id' => $message['message_id'] - 3
                ]);
                $telegram->deleteMessage([
                    'chat_id' => $chat_id,
                    'message_id' => $message['message_id'] - 2
                ]);
                $telegram->deleteMessage([
                    'chat_id' => $chat_id,
                    'message_id' => $message['message_id'] - 1
                ]);
                $controller->karzina();
                break;   
        }  
        break;          
    case 'product_page':
        switch($text){
            case '🔙 Orqaga':
                $telegram->deleteMessage([
                    'chat_id' => $chat_id,
                    'message_id' => $message['message_id'] - 3 
                ]);
                $telegram->deleteMessage([
                    'chat_id' => $chat_id,
                    'message_id' => $message['message_id'] -1
                ]);
                $controller->categories();

                break;
        }    
        break; 
    case 'karzina_page': 
        switch ($text){
            case '🔙 Orqaga':
              
                $telegram->deleteMessage([
                    'chat_id' => $chat_id,
                    'message_id' => $message['message_id'] - 2
                ]);
                $telegram->deleteMessage([
                    'chat_id' => $chat_id,
                    'message_id' => $message['message_id'] - 1
                ]);
                
                $controller->category_products('sad');
                break;
            case '➡️ Davom etish':
                $telegram->deleteMessage([
                    'chat_id' => $chat_id,
                    'message_id' => $message['message_id'] - 2
                ]);
                $telegram->deleteMessage([
                    'chat_id' => $chat_id,
                    'message_id' => $message['message_id'] - 1
                ]);
                $controller->location();
                
                break;
            case '🔄 Tozalash':
                $telegram->deleteMessage([
                    'chat_id' => $chat_id,
                    'message_id' => $message['message_id'] - 2
                ]);
                $telegram->deleteMessage([
                    'chat_id' => $chat_id,
                    'message_id' => $message['message_id'] - 1
                ]);
                $controller->categories();
                break;        
        }    
        break;
    case 'location': 
    
        if( $message['location']['latitude'] != ''){
            $controller->storeLocation($message['location']['longitude'], $message['location']['latitude']);
        } elseif( $text ='🗺 Mening manzillarim'){
            $controller->alluserLocation();
        } elseif ($text == '🔙 Orqaga'){
            $controller->karzina();
        }
                    
        break;   
    case 'allLocation': 
        switch($text)
        {
            case 'Узбекистан, Ташкент, улица Чувалачи':
                $controller->last($text);
                break; 
        }
        break; 
    case 'last':
        if($text == '✅ Tasdiqlash'){
            $controller->end();
        }elseif($text == '❌ Bekor qilish'){
            $controller->categories();
        }else {
            
        }
        break;  
    case 'end':
        if($text == 'Home'){
            $controller->menu();
        } 
        break;      
  }
}







?>