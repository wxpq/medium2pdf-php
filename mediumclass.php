<?php

require 'vendor/autoload.php';
use Dompdf\Dompdf;
use Dompdf\Options;

class medium{
    private $reqid;
    private $storylink;
    public function __construct()
    {
        array_map('unlink', glob("tmp_fsd54g66sg5/*"));
        array_map('unlink', glob("pdf/*"));
        array_map('unlink', glob("mirror/*"));
        $this->reqid = md5(strval(time())."secretrandomstring");
        
    }


    public function req($url, $method, $headers, $postpayload)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($ch, CURLOPT_COOKIESESSION, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, TRUE);


        if ($method == 'post') {
            curl_setopt($ch, CURLOPT_POST, TRUE);
        } elseif ($method == 'get') {
            curl_setopt($ch, CURLOPT_HTTPGET, TRUE);
        }


        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        curl_setopt($ch, CURLOPT_URL, $url);

        $this->storylink = $url;


        if ($postpayload != '') {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postpayload);
        }

        $combined = curl_exec($ch);
        $headersize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        curl_close($ch);
        return array(
            "res" => utf8_decode($combined),
            "header_size" => $headersize
        );
    }

    public function req2($url, $method, $headers, $postpayload)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($ch, CURLOPT_COOKIESESSION, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, TRUE);


        if ($method == 'post') {
            curl_setopt($ch, CURLOPT_POST, TRUE);
        } elseif ($method == 'get') {
            curl_setopt($ch, CURLOPT_HTTPGET, TRUE);
        }


        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        curl_setopt($ch, CURLOPT_URL, $url);



        if ($postpayload != '') {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postpayload);
        }

        $combined = curl_exec($ch);
        $headersize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        curl_close($ch);
        return array(
            "res" => $combined,
            "header_size" => $headersize
        );
    }


    public function get_html_data($mediumlink){


        $get_html_data_res = $this->req(
            $mediumlink,
            'get',
            array(
                // 'Host: medium.com',
                'Cache-Control: max-age=0',
                'Connection:keep-alive',
                'User-Agent: Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:79.0) Gecko/20100101 Firefox/79.0',
                'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
                'Upgrade-Insecure-Requests: 1'
            ),
            ''
        );
        $get_html_data_body = substr($get_html_data_res["res"], $get_html_data_res["header_size"]);
        return $get_html_data_body;

    }

    public function get_html_data2($mediumlink){


        $get_html_data_res = $this->req2(
            $mediumlink,
            'get',
            array(
                'Cache-Control: max-age=0',
                'Connection:keep-alive',
                'User-Agent: Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:79.0) Gecko/20100101 Firefox/79.0',
                'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
                'Upgrade-Insecure-Requests: 1'
            ),
            ''
        );
        $get_html_data_body = substr($get_html_data_res["res"], $get_html_data_res["header_size"]);
        return $get_html_data_body;

    }


    public function get_article_html($html){
        $html_dom = new DOMDocument();
        @ $html_dom->loadHTML($html);
        
        $article = $html_dom->getElementsByTagName('article');
        $article_html = $html_dom->saveHTML($article[0]);

        $fixed_html_dom = new DOMDocument();
        @ $fixed_html_dom->loadHTML($article_html);

        $xpath = new DOMXpath($fixed_html_dom);
        $div_result = $xpath->query("//body/article/div[1]");
        foreach( $div_result as $elem ) {
            $article_html = $fixed_html_dom->saveHTML($elem);
        }
        
        

        $fixed2_html_dom = new DOMDocument();
        @ $fixed2_html_dom->loadHTML($article_html);
        $button = $fixed2_html_dom->getElementsByTagName('button');

        foreach($button as $btn){
            $btn->parentNode->removeChild($btn);
        }
        foreach($button as $btn){
            $btn->parentNode->removeChild($btn);
        }
        foreach($button as $btn){
            $btn->parentNode->removeChild($btn);
        }
        $svg = $fixed2_html_dom->getElementsByTagName('svg');
        foreach($svg as $elem){
            $elem->parentNode->removeChild($elem);
        }


        $noscript = $fixed2_html_dom->getElementsByTagName('noscript');
        foreach($noscript as $scrt){
            $scrt->parentNode->removeChild($scrt);
        }
        foreach($noscript as $scrt){
            $scrt->parentNode->removeChild($scrt);
        }
        foreach($noscript as $scrt){
            $scrt->parentNode->removeChild($scrt);
        }
        foreach($noscript as $scrt){
            $scrt->parentNode->removeChild($scrt);
        }
        foreach($noscript as $scrt){
            $scrt->parentNode->removeChild($scrt);
        }
        
        $iframes = $fixed2_html_dom->getElementsByTagName('iframe');
        foreach($iframes as $ifr){
            $ifr->parentNode->removeChild($ifr);
        }
        foreach($iframes as $ifr){
            $ifr->parentNode->removeChild($ifr);
        }
        foreach($iframes as $ifr){
            $ifr->parentNode->removeChild($ifr);
        }
        foreach($iframes as $ifr){
            $ifr->parentNode->removeChild($ifr);
        }
        foreach($iframes as $ifr){
            $ifr->parentNode->removeChild($ifr);
        }



        return $fixed2_html_dom->saveHTML();
    }

    public function get_tags($html){
        $html_dom = new DOMDocument();
        @ $html_dom->loadHTML($html);
        
        $atags = $html_dom->getElementsByTagName('a');
        $post_tags = array();
        foreach($atags as $tag){
            if(preg_match('/^\/tag\//',$tag->getAttribute('href'))){
                $post_tags[] = "#".str_replace(" ","_",$tag->textContent);
            }
            elseif(preg_match('/\/tagged\//',$tag->getAttribute('href'))){
                $post_tags[] = "#".str_replace(" ","_",$tag->textContent);
            }
        }

        return $post_tags;

    }
    
    public function get_article_html2($html){

        $fixed2_html_dom = new DOMDocument();
        @ $fixed2_html_dom->loadHTML($html);
        $script = $fixed2_html_dom->getElementsByTagName('script');

        foreach($script as $scr){
            $scr->parentNode->removeChild($scr);
        }
        foreach($script as $scr){
            $scr->parentNode->removeChild($scr);
        }
        foreach($script as $scr){
            $scr->parentNode->removeChild($scr);
        }
        foreach($script as $scr){
            $scr->parentNode->removeChild($scr);
        }
        foreach($script as $scr){
            $scr->parentNode->removeChild($scr);
        }



        $noscript = $fixed2_html_dom->getElementsByTagName('noscript');
        foreach($noscript as $scrt){
            $scrt->parentNode->removeChild($scrt);
        }
        foreach($noscript as $scrt){
            $scrt->parentNode->removeChild($scrt);
        }
        foreach($noscript as $scrt){
            $scrt->parentNode->removeChild($scrt);
        }
        foreach($noscript as $scrt){
            $scrt->parentNode->removeChild($scrt);
        }
        foreach($noscript as $scrt){
            $scrt->parentNode->removeChild($scrt);
        }
        

        return $fixed2_html_dom->saveHTML();
    }


    public function replace_good_images($article){
        $article_dom = new DOMDocument();
        @ $article_dom->loadHTML($article);

        $images = $article_dom->getElementsByTagName('img');
        foreach( $images as $image ) {
            if(preg_match('/^https:\/\/miro.medium.com\/max/',$image->getAttribute('src'))){

                $image->setAttribute('width', '');
                $image->setAttribute('height', '');

                $urlparsed = explode('/',$image->getAttribute('src'));
                $remove = explode('?',$urlparsed[5]);
                $image->setAttribute('src', 'https://miro.medium.com/max/650/'.$remove[0]);
                    
                    

            }
            elseif(preg_match('/^https:\/\/miro.medium.com\/freeze/',$image->getAttribute('src'))){
            if(preg_match('/.gif/',$image->getAttribute('src'))){
                $image->parentNode->removeChild($image);
            }
            }}
        return $article_dom->saveHTML();
    }

    
    public function replace_good_images_css_js($article){

        $article_dom = new DOMDocument();
        @ $article_dom->loadHTML($article);

        $images = $article_dom->getElementsByTagName('img');
        foreach( $images as $image ) {
            if(preg_match('/^https:\/\/miro.medium.com\/max/',$image->getAttribute('src'))){

                    $urlparsed = explode('/',$image->getAttribute('src'));
                    $remove = explode('?',$urlparsed[5]);
                    

                    $data = file_get_contents('https://miro.medium.com/max/900/'.$remove[0]);
                    $base64 = 'data:image/jpeg;base64,' . base64_encode($data);

                    $image->setAttribute('src', $base64);
                    $image->setAttribute('style', 'filter:none !important;transform: none;cursor: none;');

                    $image->parentNode->setAttribute('class', '');
                    
                    

            }
            elseif(preg_match('/^https:\/\/miro.medium.com\/freeze/',$image->getAttribute('src'))){
            if(preg_match('/.gif/',$image->getAttribute('src'))){
                $urlparsed = explode('/',$image->getAttribute('src'));
                $remove = explode('?',$urlparsed[6]);
                

                $data = file_get_contents('https://miro.medium.com/max/850/'.$remove[0]);
                $base64 = 'data:image/gif;base64,' . base64_encode($data);

                $image->setAttribute('src', $base64);
                $image->setAttribute('style', 'filter:none !important;transform: none;');

                $image->parentNode->setAttribute('class', '');
            }
            }}

            $css = $article_dom->getElementById('glyph_link');
            $css->parentNode->removeChild($css);


        return array("html"=>$article_dom->saveHTML(),
                     "linkname"=>sha1(time())
        );
    }

    public function create_pdf($html,$tags){
        
        $htmlstart = '<!DOCTYPE html><html lang="en"><head><style>@font-face {src: url(DejaVuSans.ttf) format("truetype");font-family: "dejavudiego";}body { font-family:"dejavudiego", "Times New Roman", Times, serif;}</style></head><body>';
        $htmlend = '</body></html>';
        
        $html =  str_replace("?","",$html);
        $html_dom = new DOMDocument();
        @ $html_dom->loadHTML($html);
        $h1 = $html_dom->getElementsByTagName('h1');

        $options = new Options();
        $options->set('tempDir', __DIR__ . '/tmp_fsd54g66sg5');

        $options->set('isRemoteEnabled', TRUE);
        $options->set('debugKeepTemp', TRUE);
        $options->set('defaultFont', 'DejaVu Sans');
        $dompdf = new Dompdf($options);
        $dompdf->set_option('isHtml5ParserEnabled', true);
        $dompdf->loadHtml($htmlstart.$html.$htmlend);
        $dompdf->setPaper('A4', 'portrait');
        
        $pdfname = str_replace(" ","",$h1[0]->textContent);
        $pdfname = str_replace("(","",$pdfname);
        $pdfname = str_replace(")","",$pdfname);
        $pdfname = str_replace("!","",$pdfname);
        $pdfname = str_replace("@","",$pdfname);
        $pdfname = str_replace("-","_",$pdfname);
        $pdfname = str_replace("#","",$pdfname);
        $pdfname = str_replace("$","",$pdfname);
        $pdfname = str_replace("%","",$pdfname);
        $pdfname = str_replace("^","",$pdfname);
        $pdfname = str_replace("&","",$pdfname);
        $pdfname = str_replace("*","",$pdfname);
        $pdfname = str_replace("/","_",$pdfname);
        $pdfname = str_replace("|","",$pdfname);
        $pdfname = str_replace("\\","",$pdfname);
        $pdfname = str_replace("=","",$pdfname);
        $pdfname = str_replace(">","",$pdfname);
        $pdfname = str_replace("<","",$pdfname);
        $pdfname = str_replace("?","",$pdfname);
        $pdfname = str_replace("+","",$pdfname);
        $pdfname = str_replace(":","",$pdfname);
        $pdfname = str_replace(",","",$pdfname);


        $pdfdata = array(
            "pdfpath" => 'pdf/'.$pdfname.".pdf",
            "pdfdes" => $h1[0]->textContent,
            "mainurl" => $this->storylink,
            "tags" => $tags
        );
        $dompdf->render();
        $output = $dompdf->output();
        file_put_contents('pdf/'.$pdfname.'.pdf', $output);
        // $dompdf->stream($pdfname.'.pdf',array('compress' =>0,'Attachment' => 1));
        header('Content-Type: application/json');
        echo json_encode($pdfdata);


    }

}
