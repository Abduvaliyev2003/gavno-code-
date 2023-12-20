<?php
require './FuncPage.php';

class Controller {
    protected $telegram;
    protected $chat_id;
    protected $callback_query;
    public $messageId = null;
    public function __construct($telegram , $chat_id, $callback_query = null)
    {
        $this->telegram = $telegram;
        $this->chat_id = $chat_id;
        $this->callback_query = $callback_query;
    }


    public function register()
    {
        setHomePage($this->chat_id, 'register');
        $options = [
            [$this->telegram->buildKeyboardButton("📞 Telefon raqam", true)],
        ];

        $text = "Telefon raqamingizni quyidagi formatda yuboring yoki kiriting: +998** *** ** **";

        $keyb = $this->telegram->buildKeyBoard($options, $onetime = true, $resize = true,);
        $content = [
            'chat_id' => $this->chat_id,
            'text' => $text,
            'reply_markup' => $keyb
        ];
        $this->telegram->sendMessage($content);
    }
    
    public function register_second()
    {
        setHomePage($this->chat_id, 'register_second');
        $text = "Ism va familyani kirgazing";

        $this->sendMessage($text);
    }

    public function menu()
    {
        setHomePage($this->chat_id, 'menu');
        $buttons =[
            '🗂 Mahsulotlar',
            '🛍 Mening buyurtmalarim',
            "✍️ Fikr bildirish",
            "⚙️ Sozlamalar"
        ];

        $text = "Bo‘limni tanlang:";

        $this->sendTextWithKeyboard($buttons, $text);
    }
    
    public function categories()
    {
        setHomePage($this->chat_id, 'categories');
        $buttons =[
            "🔙 Orqaga",
            'Category 1',
            'Category 2',
            'Category 3',
            'Category 4',
        ];

        $text = "Sizni ko‘rganimizdan xursandmiz, Bugun nima buyurtma qilasiz?";
        $this->sendTextWithKeyboard($buttons, $text);
        // $this->telegram->sendPhoto([
        //     'chat_id' => $this->chat_id,
        //     'photo' => 'https://kartinki.pics/uploads/posts/2022-03/1647389533_3-kartinkin-net-p-stroitelnie-materiali-kartinki-3.jpg',
        //    ]);
        
    }

    
    public function setting()
    {
        setHomePage($this->chat_id, 'setting');
        
        $buttons = ['📞 Telefon nomerni o`zgartrish', '👤 Ism-familyani tahrirlash' , '🔙 Orqaga'];
        $textToSend = "Shu tugmalarni bosing";
        $this->sendTextWithKeyboard($buttons, $textToSend);
    }

    public function comment ()
    {
        setHomePage($this->chat_id, 'comment');
        $buttons = [
            '🔙 Orqaga'
        ];
        $textToSend = "Fikringizni yuboring";
        $this->sendTextWithKeyboard($buttons, $textToSend);
    }

    public function myUserByProduct()
    {
        $text  = '🚀 Manzil: Баренцево море'. PHP_EOL;
        $text .= '📦 Mahsulot:'. PHP_EOL;
        $text .= '✔️ Mahsulot 5'.PHP_EOL;
        $text .= '✔️ Mahsulot 5'.PHP_EOL;
        $text .= '✔️ Mahsulot 5'.PHP_EOL;
        $text .= '💵 Ummumiy suma:'. number_format(120000) . 'sum' .PHP_EOL;
         
        $this->telegram->sendMessage([
           'chat_id' => $this->chat_id,
           'text' => $text
        ]);
    }

    public function category_products($text)
    {
        setHomePage($this->chat_id, 'category_products');
        $data = ['Salom', 'qaleysan', 'Nima'];
        $keyb  = $this->inlineKeyboard($data);
        $buttons = [
            '🔙 Orqaga',
            '📥 Savat'
        ];
        $textToSend = "Mahsulot tanlang";
        $this->sendTextWithKeyboard($buttons, $textToSend);
        $this->telegram->sendPhoto([
            'chat_id' => $this->chat_id,
            'photo' => 'https://kartinki.pics/uploads/posts/2022-03/1647389533_3-kartinkin-net-p-stroitelnie-materiali-kartinki-3.jpg',
            'caption' => $text,
            'reply_markup' => $keyb
        ]);
    }
    
    public function category_inline($text)
    {
        setHomePage($this->chat_id, 'product_page');
        $this->telegram->deleteMessage([
            'chat_id' => $this->chat_id,
            'message_id' => $this->callback_query['message']['message_id']
        ]);
        $buttons = [
            '🔙 Orqaga'
        ];
        $textToSend = "Sonini tanlang:";
        $this->sendTextWithKeyboard($buttons, $textToSend);
        $text = $text . PHP_EOL;

        $text .= 'f type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.';
         
        $options = array( 
            [      
                $this->telegram->buildInlineKeyboardButton('-', '', 'minus'. 1), 
                $this->telegram->buildInlineKeyboardButton('1', '', 'clicks'),
                $this->telegram->buildInlineKeyboardButton('+', '', 'plus'. 1)
            ],
            [$this->telegram->buildInlineKeyboardButton('📥 Savatga qo`shish', '', 'karzina'. 1)],    
            );
            $keyb = $this->telegram->buildInlineKeyBoard($options);
            $caption = 'narxi:' . number_format(200000) ;

        $this->telegram->sendPhoto([
            'chat_id' => $this->chat_id,
            'photo' => 'https://kartinki.pics/uploads/posts/2022-03/1647389533_3-kartinkin-net-p-stroitelnie-materiali-kartinki-3.jpg',
            'caption' => $caption,
            'reply_markup' => $keyb
        ]);
        
    }
  
    
    public function addKarzina()
    {
        $this->telegram->deleteMessage([
            'chat_id' => $this->chat_id,
            'message_id' => $this->callback_query['message']['message_id']
        ]);
        $text = 'sasdas l mahsuloti savatga muvaffaqiyatli qo‘shildi 📥 Yana biror nima buyurtma qilamizmi?';

        $this->sendMessage($text);
        $this->category_products('Mahsulot');
    }

    public function karzina()
    {
        setHomePage($this->chat_id, 'karzina_page');
        
        $options = array(
            [$this->telegram->buildInlineKeyboardButton('✏️ O`zgarish kiritish', '', 'edit' . 1)],
        );
        $keyb = $this->telegram->buildInlineKeyBoard($options);
        $text = 'Mahsulot 1';
        
        $response = $this->telegram->sendMessage([
            'chat_id' => $this->chat_id,
            'text' => $text,
            'reply_markup' => $keyb
        ]);
        
        
        $buttons = [
            '🔙 Orqaga',
            '➡️ Davom etish',
            '🔄 Tozalash'
        ];
        $textToSend = "Umumiy narx: 10 000 so‘m";
        $this->sendTextWithKeyboard($buttons, $textToSend);

    }


    public function location()
    {
        setHomePage($this->chat_id, 'location');
        $option = array(
            array($this->telegram->buildKeyboardButton("🗺 Mening manzillarim ")),
            array($this->telegram->buildKeyboardButton("📍  Geolokatsiyani yuboring", false, true),  $this->telegram->buildKeyboardButton("⬅️ Orqaga")),
        );
        $keyb = $this->telegram->buildKeyBoard($option, $onetime = false, $resize = true);
        $content = array('chat_id' => $this->chat_id, 'reply_markup' => $keyb, 'text' => "📍 Geolokatsiyani yuboring yoki Oldingi  manzilini tanlang");
        $this->telegram->sendMessage($content); 
    }
    

    public function storeLocation($long, $lat)
    {
        $api_key = '49167188-2e49-4d62-a9f2-a27752083ce6';
        $url = "https://geocode-maps.yandex.ru/1.x/?apikey={$api_key}&format=json&geocode={$long},{$lat}";
        $response = file_get_contents($url);
        $data = json_decode($response, true);
        
        $address = '';
        if (!empty($data['response']['GeoObjectCollection']['featureMember'])) {
            $address = $data['response']['GeoObjectCollection']['featureMember'][0]['GeoObject']['metaDataProperty']['GeocoderMetaData']['text'];
        }
        $this->telegram->sendMessage([
            'chat_id' => '-991150848',
            'text' => $address
         ]);
        $this->last($address);
    }
    
    public function alluserLocation()
    {
        setHomePage($this->chat_id, 'allLocation');
        $buttons = [
            'Узбекистан, Ташкент, улица Чувалачи',
            
        ];
        $textToSend = "Manzilardan bittasini tanlang";
        $this->sendTextWithKeyboard($buttons, $textToSend);
    }

    public function last($address)
    {
        setHomePage($this->chat_id, 'last');
        $text = '🛍 Bugungi tanlagan mahsulotingiz' .PHP_EOL;
        $text .= '🗺 '. $address . PHP_EOL;
        $text .= '✔️ Mahsulot 5'.PHP_EOL;
        $text .= '✔️ Mahsulot 5'.PHP_EOL;
        $text .= '✔️ Mahsulot 5'.PHP_EOL;
        $text .= '💵 Ummumiy suma:'. number_format(120000) . 'sum' .PHP_EOL;
        $buttons = [
            "❌ Bekor qilish",
            '✅ Tasdiqlash'
        ];
        $this->sendTextWithKeyboard($buttons, $text);
    }


    public function end()
    {
        setHomePage($this->chat_id, 'end');
        $buttons = [
            'Home'
        ];
        $this->sendTextWithKeyboard($buttons, 'Zakazingiz qabul qilindi tez orada hadimlarmiz siz bilan boglanishadi 🙃. Bosh menuga qaytish: /menu');
        $text = '🆕  Yangi Zakaz:'. PHP_EOL;
        $text .= "👤 Ismi - Familyasi: Asadbek Abduvaliyev". PHP_EOL;
        $text .= '📞 Telefon nomeri: +998998784803'. PHP_EOL;
        $text .= '🚀 Manzil: Баренцево море'. PHP_EOL;
        $text .= "📦 Mahsulot:". PHP_EOL;
        $text .= '✔️ Mahsulot 5'.PHP_EOL;
        $text .= '✔️ Mahsulot 5'.PHP_EOL;
        $text .= '✔️ Mahsulot 5'.PHP_EOL;
        $text .= '💵 Ummumiy suma:'. number_format(120000) . 'sum' .PHP_EOL;
         
        $this->telegram->sendMessage([
           'chat_id' => '-991150848',
           'text' => $text
        ]);
    }



      
    public function counter($callback_data)
    {
        $operation = '';
        $modifier = '';
        
        if (strpos($callback_data, 'plus') === 0) {
            $operation = 'plus';
            $orderId = (int) str_replace("plus", "", $callback_data);
        } elseif (strpos($callback_data, 'minus') === 0) {
            $operation = 'minus';
            $orderId = (int) str_replace("minus", "", $callback_data);
        }

        if ($operation !== '') {

            if ($operation === 'plus') {
                $number = $orderId + 1;
                $content = ['callback_query_id' => $this->telegram->Callback_ID(), 'text' =>'+1 mahsulot' , 'show_alert' => false];
                $this->telegram->answerCallbackQuery($content);

            } elseif ($operation === 'minus') {
                
                $number = max(1, $orderId - 1);
                $content = ['callback_query_id' => $this->telegram->Callback_ID(), 'text' =>'-1 mahsulot' , 'show_alert' => false];
                $this->telegram->answerCallbackQuery($content);
            }
            $options = array(
                [
                    $this->telegram->buildInlineKeyboardButton('-', '', 'minus' . $number),
                    $this->telegram->buildInlineKeyboardButton($number, '', 'clickss'),
                    $this->telegram->buildInlineKeyboardButton('+', '', 'plus' . $number)
                ],
                [$this->telegram->buildInlineKeyboardButton('📥 Savat', '', 'karzina' . $orderId)],
            );
            $keyb = $this->telegram->buildInlineKeyBoard($options);

            $this->telegram->editMessageCaption([
                'chat_id' => $this->chat_id,
                'message_id' => $this->callback_query['message']['message_id'],
                'caption' => 'sasdas',
                'reply_markup' => $keyb
            ]);
        }
    }


    public function edit_product($callback_data)
    {
        $operation = '';
        $number = 1;
    
        if($callback_data !== 'delete'){
            if (strpos($callback_data, 'edit') === 0) {
               
            } elseif (strpos($callback_data, 'plus') === 0) {
                $operation = 'plus';
                $orderId = (int) str_replace("plus", "", $callback_data);
            } elseif (strpos($callback_data, 'minus') === 0) {
                $operation = 'minus';
                $orderId = (int) str_replace("minus", "", $callback_data);
            }
    
            if ($operation === 'plus') {
                $number = $orderId + 1;
                $content = ['callback_query_id' => $this->telegram->Callback_ID(), 'text' =>'+1 mahsulot' , 'show_alert' => false];
                $this->telegram->answerCallbackQuery($content);

            } elseif ($operation === 'minus') {
                $number = max(1, $orderId - 1);
                $content = ['callback_query_id' => $this->telegram->Callback_ID(), 'text' =>'-1 mahsulot' , 'show_alert' => false];
                $this->telegram->answerCallbackQuery($content);
            }
    
            $options = array(
                [
                $number == 1 ? $this->telegram->buildInlineKeyboardButton('❌', '', 'delete') : $this->telegram->buildInlineKeyboardButton('-', '', 'minus' . $number),
                $this->telegram->buildInlineKeyboardButton($number, '', 'click'),
                $this->telegram->buildInlineKeyboardButton('+', '', 'plus' . $number)
                ]
            );
            $keyb = $this->telegram->buildInlineKeyBoard($options);
            $text = 'Mahsulot ' . $number;
    
            $this->telegram->editMessageText([
                'chat_id' => $this->chat_id,
                'message_id' => $this->callback_query['message']['message_id'],
                'text' => $text,
                'reply_markup' => $keyb
            ]);
        } else {
            // Handle the 'delete' case
            $this->telegram->deleteMessage([
                'chat_id' => $this->chat_id,
                'message_id' => $this->callback_query['message']['message_id']
            ]);
        }
    }
    


    protected function sendMessage ($text)
    {
        $this->telegram->sendMessage([
            'chat_id'=> $this->chat_id,
            'parse_mode' => "HTML",
            'text' => $text
        ]);
    }

    protected function sendTextWithKeyboard($buttons, $text, $backBtn = false)
    {
        
        $option = [];
        if (count($buttons) % 2 == 0) {
            for ($i = 0; $i < count($buttons); $i += 2) {
                $option[] = array($this->telegram->buildKeyboardButton($buttons[$i]), $this->telegram->buildKeyboardButton($buttons[$i + 1]));
            }
        } else {
            for ($i = 0; $i < count($buttons) - 1; $i += 2) {
                $option[] = array($this->telegram->buildKeyboardButton($buttons[$i]), $this->telegram->buildKeyboardButton($buttons[$i + 1]));
            }
            $option[] = array($this->telegram->buildKeyboardButton(end($buttons)));
        }
        if ($backBtn) {
            $option[] = [$this->telegram->buildKeyboardButton('⬅️ Orqaga')];
        }
        $keyboard = $this->telegram->buildKeyBoard($option, $onetime = false, $resize = true);
        $content = array('chat_id' => $this->chat_id, 'reply_markup' => $keyboard, 'text' => $text, 'parse_mode' => "HTML");
        $this->telegram->sendMessage($content);
    }

    protected function inlineKeyboard($buttons)
    {
        $option = [];
        if (count($buttons) % 2 == 0) {
            for ($i = 0; $i < count($buttons); $i += 2) {
                $option[] = array($this->telegram->buildInlineKeyboardButton($buttons[$i],  '', strtolower($buttons[$i])  ), $this->telegram->buildInlineKeyboardButton($buttons[$i + 1], '', strtolower($buttons[$i + 1])));
            }
        } else {
            for ($i = 0; $i < count($buttons) - 1; $i += 2) {
                $option[] = array($this->telegram->buildInlineKeyboardButton($buttons[$i], '', strtolower($buttons[$i])), $this->telegram->buildInlineKeyboardButton($buttons[$i + 1], '', strtolower($buttons[$i + 1])));
            }
            $option[] = array($this->telegram->buildInlineKeyboardButton(end($buttons) , '' ,strtolower(end($buttons))));
        }
        return  $keyboard = $this->telegram->buildInlineKeyBoard($option);
    }
}



?>