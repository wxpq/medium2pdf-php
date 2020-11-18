<?php
require_once './mediumclass.php';
if(isset($_GET)){
    if($_GET['url']!=''){

        $medium3 = new medium();
        $htmlpdf = $medium3->get_html_data($_GET['url']);
        $tags = $medium3->get_tags($htmlpdf);
        $articlepdf = $medium3->get_article_html($htmlpdf);
        $articlepdf = $medium3->replace_good_images($articlepdf);
        $medium3->create_pdf($articlepdf,$tags);
        
    }
}
?>
