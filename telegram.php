<?php
    $update = file_get_contents("php://input");   //get incoming data
 
    $update_array = json_decode($update, true); 
 
    $bot_url = "https://api.telegram.org/bot" . "[telegram-bot-token]";
    $bot_dl_url = "https://api.telegram.org/file/bot"."[telegram-bot-token]";

    if( isset($update_array["message"]) ) {
        $text    = $update_array["message"]["text"];
        $chat_id = $update_array["message"]["chat"]["id"];

        if( isset($update_array["message"]["document"])){

            save_txt();			//I know it's vulnerable ,hacker can upload webshells ,you can fix it,i don't have time
            
        }else{
            if(preg_match('/https:\/\//',$text)){       //I know it's vulnerable to spamming
                $url = $bot_url . "/sendMessage";
                $post_params = [ 'chat_id' =>  $GLOBALS['chat_id'] , 'text' => "لطفا کمی صبر کنید ... \nنتایج برای کانال اصلی هم ارسال میشود \n https://t.me/cybersecarticles" ];
                send_reply($url, $post_params);

				               
                $dlurl = "[your-domain.com]/mediumtopdf/download.php?url=".$text;    //I know it's vulnerable,maybe RFI , you can fix it,i don't have time
        
                $ch2 = curl_init();
                curl_setopt($ch2, CURLOPT_RETURNTRANSFER, TRUE);
                curl_setopt($ch2, CURLOPT_FOLLOWLOCATION, TRUE);
                curl_setopt($ch2, CURLOPT_COOKIESESSION, TRUE);
                curl_setopt($ch2, CURLOPT_URL, $dlurl);
                $combined = curl_exec($ch2);
        
                curl_close($ch2);
        
                $filedata = json_decode($combined, true);
        
        
                $url = $bot_url . "/sendDocument";
                $post_params = [ 
                    'chat_id'  => '@cybersecarticles' , 
                    'document' => new CURLFILE(realpath($filedata["pdfpath"])),  
                    'caption'  => $filedata["pdfdes"]."\n".$filedata["mainurl"]."\n\n".implode(" ",$filedata["tags"])."\n\n"."@cybersecarticles"
                ];
                send_reply($url, $post_params);
                
                $post_params = [ 
                    'chat_id'  => $GLOBALS['chat_id'] , 
                    'document' => new CURLFILE(realpath($filedata["pdfpath"])),  
                    'caption'  => $filedata["pdfdes"]."\n".$filedata["mainurl"]."\n\n".implode(" ",$filedata["tags"])."\n\n"."@cybersecarticles"
                ];
                send_reply($url, $post_params);
        
            }elseif($text == "/dump"){        // return your medium links from your uploaded text file
                $fn = fopen("txts/input.txt","r");

                $url = $bot_url . "/sendMessage";
                $post_params = [ 'chat_id' =>  $GLOBALS['chat_id'] , 'text' => "لطفا کمی صبر کنید ... \nجهت گسترش دانش نتایج برای کانال اصلی هم ارسال میشود \n https://t.me/cybersecarticles" ];
                send_reply($url, $post_params);

                while(!feof($fn))  {
                  $result = fgets($fn);

                  $url = $bot_url . "/sendMessage";
                  $post_params = [ 'chat_id' =>  $GLOBALS['chat_id'] , 'text' => $result ];
                  send_reply($url, $post_params);


                }
              
                fclose($fn);
            }
            elseif($text == "/start"){
                $url = $bot_url . "/sendMessage";
                $post_params = [ 'chat_id' =>  $GLOBALS['chat_id'] , 'text' => "سلام به ربات من خوش اومدی میتونی برام لینک مدیوم بفرستی(یا هر سایتی که با سیستم مدیوم کار میکنه) من هم بدون محدودیت برات هم پی دی اف ش میکنم و هم میرورش میکنم که بدون محدودیت بتونی بخونیش!\nمثل این لینک برای من بفرست\n\nhttps://medium.com/@MicroPyramid/generic-functional-based-and-class-based-views-in-django-rest-framework-f45fd6ae158" ];
                send_reply($url, $post_params);
            }
            else{
                $url = $bot_url . "/sendMessage";
                $post_params = [ 'chat_id' =>  $GLOBALS['chat_id'] , 'text' => "لینک یا دستور نا معتبر!" ];
                send_reply($url, $post_params);
            }
        }
    }
 

 


    function save_txt() {
 
        $update_array = $GLOBALS['update_array'];
 
        $file_id   = $update_array["message"]["document"]["file_id"];
        $file_type = $update_array["message"]["document"]["mime_type"];
 
        if($file_type == "text/plain") {
 
            $url = $GLOBALS['bot_url'] . "/getFile";
            $post_params = [ 'file_id' => $file_id ];
            $result = send_reply($url, $post_params);
 
            $result_array = json_decode($result, true);
            $file_path    = $result_array["result"]["file_path"];
 
            $url = $GLOBALS['bot_dl_url'] . "/$file_path";
            $file_data = file_get_contents($url);
 
            $file_path = "txts/input.txt";
            $my_file   = fopen($file_path, 'w');
            fwrite($my_file, $file_data);
            fclose($my_file);
 
            $reply = "فایل متنی آپلود شد ...";
            $url = $GLOBALS['bot_url'] . "/sendMessage";
            $post_params = [ 'chat_id' => $GLOBALS['chat_id'] , 'text' => $reply ];
            send_reply($url, $post_params);
        }
        else {
 
            $reply = "لطفا لینک های مدیوم را در قالب یک فایل متنی ارسال کنید";
            $url = $GLOBALS['bot_url'] . "/sendMessage";
            $post_params = [ 'chat_id' => $GLOBALS['chat_id'] , 'text' => $reply ];
            send_reply($url, $post_params);
        }
    }



    function send_reply($url, $post_params) {
 
        $cu = curl_init();
        curl_setopt($cu, CURLOPT_URL, $url);
        curl_setopt($cu, CURLOPT_POSTFIELDS, $post_params);
        curl_setopt($cu, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($cu);
        curl_close($cu);
        return $result;
    }
 
?>
