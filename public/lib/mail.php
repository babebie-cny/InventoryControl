<?php 
/*************************************** 
** Title.........: HTML Mime Mail class 
** Version.......: 2.0.1 
** Author........: Richard Heyes <richard@phpguru.org> 
** Filename......: class.html.mime.mail.class 
** Last changed..: 11 October 2001 
** License.......: Free to use. If you find it useful 
**                 though, feel free to buy me something 
**                 from my wishlist :) 
**                 http://www.amazon.co.uk/exec/obidos/wishlist/S8H2UOGMPZK6 
***************************************/ 

class html_mime_mail{ 

    var $html; 
    var $text; 
    var $output; 
    var $html_text; 
    var $html_images; 
    var $image_types; 
    var $build_params; 
    var $attachments; 
    var $headers; 

	/*************************************** 
	** Constructor function. Sets the headers 
	** if supplied. 
	***************************************/ 

    function html_mime_mail($headers = array()){ 

        /*************************************** 
        ** Make sure this is defined. This should 
        ** be \r\n, but due to many people having 
        ** trouble with that, it is by default \n 
        ** If you leave it as is, you will be breaking 
        ** quite a few standards. 
        ***************************************/ 

        if(!defined('CRLF')) 
            define('CRLF', "\n", TRUE); 

        /*************************************** 
        ** Initialise some variables. 
        ***************************************/ 

        $this->html_images    = array(); 
        $this->headers        = array(); 

        /*************************************** 
        ** If you want the auto load functionality 
        ** to find other image/file types, add the 
        ** extension and content type here. 
        ***************************************/ 

        $this->image_types = array( 
                                    'gif'    => 'image/gif', 
                                    'jpg'    => 'image/jpeg', 
                                    'jpeg'    => 'image/jpeg', 
                                    'jpe'    => 'image/jpeg', 
                                    'bmp'    => 'image/bmp', 
                                    'png'    => 'image/png', 
                                    'tif'    => 'image/tiff', 
                                    'tiff'    => 'image/tiff', 
                                    'swf'    => 'application/x-shockwave-flash' 
                                  ); 

        /*************************************** 
        ** Set these up 
        ***************************************/ 

        $this->build_params['html_encoding']    = 'quoted-printable'; 
        $this->build_params['text_encoding']    = '7bit'; 
        $this->build_params['html_charset']        = 'iso-8859-1'; 
        $this->build_params['text_charset']        = 'iso-8859-1'; 
        $this->build_params['text_wrap']        = 998; 

        /*************************************** 
        ** Make sure the MIME version header is first. 
        ***************************************/ 

        $this->headers[] = 'MIME-Version: 1.0'; 

        foreach($headers as $value){ 
            if(!empty($value)) 
                $this->headers[] = $value; 
        } 
    } 

	/*************************************** 
	** This function will read a file in 
	** from a supplied filename and return 
	** it. This can then be given as the first 
	** argument of the the functions 
	** add_html_image() or add_attachment(). 
	***************************************/ 
    function get_file($filename){ 

        if($fp = fopen($filename, 'rb')){ 
            $return = fread($fp, filesize($filename)); 
            fclose($fp); 
            return $return; 

        }else 
            return FALSE; 
    } 

	/*************************************** 
	** Function for extracting images from 
	** html source. This function will look 
	** through the html code supplied by add_html() 
	** and find any file that ends in one of the 
	** extensions defined in $obj->image_types. 
	** If the file exists it will read it in and 
	** embed it, (not an attachment). 
	** 
	** Function contributed by Dan Allen 
	***************************************/ 
    function find_html_images($images_dir) { 

        // Build the list of image extensions 
        while(list($key,) = each($this->image_types)) 
            $extensions[] = $key; 

        preg_match_all('/"([^"]+\.('.implode('|', $extensions).'))"/Ui', $this->html, $images); 

        for($i=0; $i<count($images[1]); $i++){ 
            if(file_exists($images_dir.$images[1][$i])){ 
                $html_images[] = $images[1][$i]; 
                $this->html = str_replace($images[1][$i], basename($images[1][$i]), $this->html); 
            } 
        } 

        if(!empty($html_images)){ 

            // If duplicate images are embedded, they may show up as attachments, so remove them. 
            $html_images = array_unique($html_images); 
            sort($html_images); 
     
            for($i=0; $i<count($html_images); $i++){ 
                if($image = $this->get_file($images_dir.$html_images[$i])){ 
                    $content_type = $this->image_types[substr($html_images[$i], strrpos($html_images[$i], '.') + 1)]; 
                    $this->add_html_image($image, basename($html_images[$i]), $content_type); 
                } 
            } 
        } 
    } 

	/*************************************** 
	** Adds plain text. Use this function 
	** when NOT sending html email 
	***************************************/ 
    function add_text($text = ''){ 
        $this->text = $text; 
    } 

	/*************************************** 
	** Adds a html part to the mail. 
	** Also replaces image names with 
	** content-id's. 
	***************************************/ 
    function add_html($html, $text, $images_dir = NULL){ 

        $this->do_html        = 1; 
        $this->html            = $html; 
        $this->html_text    = $text; 

        if(isset($images_dir)) 
            $this->find_html_images($images_dir); 
    } 

	/*************************************** 
	** Adds an image to the list of embedded 
	** images. 
	***************************************/ 
    function add_html_image($file, $name = '', $c_type='application/octet-stream'){ 
        $this->html_images[] = array( 
                                        'body'   => $file, 
                                        'name'   => $name, 
                                        'c_type' => $c_type, 
                                        'cid'    => md5(uniqid(time())) 
                                    ); 
    } 


	/*************************************** 
	** Adds a file to the list of attachments. 
	***************************************/ 
    function add_attachment($file, $name = '', $c_type='application/octet-stream', $encoding = 'base64'){ 
        $this->attachments[] = array( 
                                    'body'        => $file, 
                                    'name'        => $name, 
                                    'c_type'    => $c_type, 
                                    'encoding'    => $encoding 
                                  ); 
    } 

	/*************************************** 
	** Adds a text subpart to a mime_part object 
	***************************************/ 
    function &add_text_part(&$obj, $text){ 

        $params['content_type'] = 'text/plain'; 
        $params['encoding']     = $this->build_params['text_encoding']; 
        $params['charset']      = $this->build_params['text_charset']; 
        if(is_object($obj)){ 
            return $obj->add_subpart($text, $params); 
        }else{ 
            return new mime_part($text, $params); 
        } 
    } 

	/*************************************** 
	** Adds a html subpart to a mime_part object 
	***************************************/ 
    function &add_html_part(&$obj){ 

        $params['content_type'] = 'text/html'; 
        $params['encoding']     = $this->build_params['html_encoding']; 
        $params['charset']      = $this->build_params['html_charset']; 
        if(is_object($obj)){ 
            return $obj->add_subpart($this->html, $params); 
        }else{ 
            return new mime_part($this->html, $params); 
        } 
    } 

	/*************************************** 
	** Starts a message with a mixed part 
	***************************************/ 
    function &add_mixed_part(){ 

        $params['content_type'] = 'multipart/mixed'; 
        return new mime_part('', $params); 
    } 

	/*************************************** 
	** Adds an alternative part to a mime_part object 
	***************************************/ 
    function &add_alternative_part(&$obj){ 

        $params['content_type'] = 'multipart/alternative'; 
        if(is_object($obj)){ 
            return $obj->add_subpart('', $params); 
        }else{ 
            return new mime_part('', $params); 
        } 
    } 

	/*************************************** 
	** Adds a html subpart to a mime_part object 
	***************************************/ 
    function &add_related_part(&$obj){ 

        $params['content_type'] = 'multipart/related'; 
        if(is_object($obj)){ 
            return $obj->add_subpart('', $params); 
        }else{ 
            return new mime_part('', $params); 
        } 
    } 

	/*************************************** 
	** Adds an html image subpart to a mime_part object 
	***************************************/ 
    function &add_html_image_part(&$obj, $value){ 

        $params['content_type'] = $value['c_type']; 
        $params['encoding']     = 'base64'; 
        $params['disposition']  = 'inline'; 
        $params['dfilename']    = $value['name']; 
        $params['cid']          = $value['cid']; 
        $obj->add_subpart($value['body'], $params); 
    } 

	/*************************************** 
	** Adds an attachment subpart to a mime_part object 
	***************************************/ 
    function &add_attachment_part(&$obj, $value){ 

        $params['content_type'] = $value['c_type']; 
        $params['encoding']     = $value['encoding']; 
        $params['disposition']  = 'attachment'; 
        $params['dfilename']    = $value['name']; 
        $obj->add_subpart($value['body'], $params); 
    } 

	/*************************************** 
	** Builds the multipart message from the 
	** list ($this->_parts). $params is an 
	** array of parameters that shape the building 
	** of the message. Currently supported are: 
	** 
	** $params['html_encoding'] - The type of encoding to use on html. Valid options are 
	**                            "7bit", "quoted-printable" or "base64" (all without quotes). 
	**                            7bit is EXPRESSLY NOT RECOMMENDED. Default is quoted-printable 
	** $params['text_encoding'] - The type of encoding to use on plain text Valid options are 
	**                            "7bit", "quoted-printable" or "base64" (all without quotes). 
	**                            Default is 7bit 
	** $params['text_wrap']     - The character count at which to wrap 7bit encoded data. 
	**                            Default this is 998. 
	** $params['html_charset']  - The character set to use for a html section. 
	**                            Default is iso-8859-1 
	** $params['text_charset']  - The character set to use for a text section. 
	**                          - Default is iso-8859-1 
	***************************************/ 
    function build_message($params = array()){ 

        if(count($params) > 0) 
            while(list($key, $value) = each($params)) 
                $this->build_params[$key] = $value; 

        if(!empty($this->html_images)) 
            foreach($this->html_images as $value) 
                $this->html = str_replace($value['name'], 'cid:'.$value['cid'], $this->html); 

        $null        = NULL; 
        $attachments = !empty($this->attachments) ? TRUE : FALSE; 
        $html_images = !empty($this->html_images) ? TRUE : FALSE; 
        $html        = !empty($this->html)        ? TRUE : FALSE; 
        $text        = !empty($this->text)        ? TRUE : FALSE; 

        switch(TRUE){ 
            case $text AND !$attachments: 
                $message =& $this->add_text_part($null, $this->text); 
                break; 

            case $text AND $attachments: 
                $message =& $this->add_mixed_part(); 
                $this->add_text_part($message, $this->text); 

                for($i=0; $i<count($this->attachments); $i++) 
                    $this->add_attachment_part($message, $this->attachments[$i]); 
                break; 

            case $html AND !$attachments AND !$html_images: 
                if(!is_null($this->html_text)){ 
                    $message =& $this->add_alternative_part($null); 
                    $this->add_text_part($message, $this->html_text); 
                    $this->add_html_part($message); 
                }else{ 
                    $message =& $this->add_html_part($null); 
                } 
                break; 

            case $html AND !$attachments AND $html_images: 
                if(!is_null($this->html_text)){ 
                    $message =& $this->add_alternative_part($null); 
                    $this->add_text_part($message, $this->html_text); 
                    $related =& $this->add_related_part($message); 
                }else{ 
                    $related =& $this->add_related_part($null); 
                } 
                $this->add_html_part($related); 
                for($i=0; $i<count($this->html_images); $i++) 
                    $this->add_html_image_part($related, $this->html_images[$i]); 
                break; 

            case $html AND $attachments AND !$html_images: 
                $message =& $this->add_mixed_part(); 
                if(!is_null($this->html_text)){ 
                    $alt =& $this->add_alternative_part($message); 
                    $this->add_text_part($alt, $this->html_text); 
                    $this->add_html_part($alt); 
                }else{ 
                    $this->add_html_part($message); 
                } 
                for($i=0; $i<count($this->attachments); $i++) 
                    $this->add_attachment_part($message, $this->attachments[$i]); 
                break; 

            case $html AND $attachments AND $html_images: 
                $message =& $this->add_mixed_part(); 
                if(!is_null($this->html_text)){ 
                    $alt =& $this->add_alternative_part($message); 
                    $this->add_text_part($alt, $this->html_text); 
                    $rel =& $this->add_related_part($alt); 
                }else{ 
                    $rel =& $this->add_related_part($message); 
                } 
                $this->add_html_part($rel); 
                for($i=0; $i<count($this->html_images); $i++) 
                    $this->add_html_image_part($rel, $this->html_images[$i]); 
                for($i=0; $i<count($this->attachments); $i++) 
                    $this->add_attachment_part($message, $this->attachments[$i]); 
                break; 

        } 

        if(isset($message)){ 
            $output = $message->encode(); 
            $this->output = $output['body']; 
            $this->headers = array_merge($this->headers, $output['headers']); 
            return TRUE; 

        }else 
            return FALSE; 
    } 

	/*************************************** 
	** Sends the mail. 
	***************************************/ 
    function send($to_name, $to_addr, $from_name, $from_addr, $subject = '', $headers = ''){ 

        $to        = ($to_name != '')   ? '"'.$to_name.'" <'.$to_addr.'>' : $to_addr; 
        $from    = ($from_name != '') ? '"'.$from_name.'" <'.$from_addr.'>' : $from_addr; 

        if(is_string($headers)) 
            $headers = explode(CRLF, trim($headers)); 

        for($i=0; $i<count($headers); $i++){ 
            if(is_array($headers[$i])) 
                for($j=0; $j<count($headers[$i]); $j++) 
                    if($headers[$i][$j] != '') 
                        $xtra_headers[] = $headers[$i][$j]; 

            if($headers[$i] != '') 
                $xtra_headers[] = $headers[$i]; 
        } 
        if(!isset($xtra_headers)) 
            $xtra_headers = array(); 

        return mail($to, $subject, $this->output, 'From: '.$from.CRLF.implode(CRLF, $this->headers).CRLF.implode(CRLF, $xtra_headers)); 
    } 

	/*************************************** 
	** Use this method to deliver using direct 
	** smtp connection. Relies upon the smtp 
	** class available from http://www.heyes-computing.net 
	** You probably downloaded it with this class though. 
	** 
	** bool smtp_send( 
	**                object The smtp object, 
	**                array  Parameters to pass to the smtp object 
	**                       See example.1.php for details. 
	**               ) 
	***************************************/ 
    function smtp_send(&$smtp, $params = array()){ 

        foreach($params as $key => $value){ 
            switch($key){ 
                case 'headers': 
                    $headers = $value; 
                    break; 

                case 'from': 
                    $send_params['from'] = $value; 
                    break; 

                case 'recipients': 
                    $send_params['recipients'] = $value; 
                    break; 
            } 
        } 

        $send_params['body']    = $this->output; 
        $send_params['headers']    = array_merge($this->headers, $headers); 

        return $smtp->send($send_params); 
    } 

	/*************************************** 
	** Use this method to return the email 
	** in message/rfc822 format. Useful for 
	** adding an email to another email as 
	** an attachment. there's a commented 
	** out example in example.php. 
	** 
	** string get_rfc822(string To name, 
	**           string To email, 
	**           string From name, 
	**           string From email, 
	**           [string Subject, 
	**            string Extra headers]) 
	***************************************/ 
    function get_rfc822($to_name, $to_addr, $from_name, $from_addr, $subject = '', $headers = ''){ 

        // Make up the date header as according to RFC822 
        $date = 'Date: '.date('D, d M y H:i:s'); 

        $to   = ($to_name   != '') ? 'To: "'.$to_name.'" <'.$to_addr.'>' : 'To: '.$to_addr; 
        $from = ($from_name != '') ? 'From: "'.$from_name.'" <'.$from_addr.'>' : 'From: '.$from_addr; 

        if(is_string($subject)) 
            $subject = 'Subject: '.$subject; 

        if(is_string($headers)) 
            $headers = explode(CRLF, trim($headers)); 

        for($i=0; $i<count($headers); $i++){ 
            if(is_array($headers[$i])) 
                for($j=0; $j<count($headers[$i]); $j++) 
                    if($headers[$i][$j] != '') 
                        $xtra_headers[] = $headers[$i][$j]; 

            if($headers[$i] != '') 
                $xtra_headers[] = $headers[$i]; 
        } 

        if(!isset($xtra_headers)) 
            $xtra_headers = array(); 

        $headers = array_merge($this->headers, $xtra_headers); 

        return $date.CRLF.$from.CRLF.$to.CRLF.$subject.CRLF.implode(CRLF, $headers).CRLF.CRLF.$this->output; 
    } 


} // End of class. 


/*************************************** 
** The mime part class which handles the 
** build of the email 
***************************************/ 
    class mime_part{ 

        var $encoding; 
        var $subparts; 
        var $encoded; 
        var $headers; 
        var $params; 
        var $body; 

        /*************************************** 
        ** Constructor function. Arguments: 
        ** $body   - The body 
        ** $params - Various parameters for the part: 
        **   content-type - Content type 
        **   encoding     - Encoding type to use 
        **   cid          - Content ID if any 
        **   disposition  - Disposition (inline or attachment) 
        **   dfilename    - Filename parameter of disposition 
        **   description  - Content Description 
        ***************************************/ 
        function mime_part($body, $params = array()){ 

            if(!defined('CRLF')) 
                define('CRLF', "\r\n", TRUE); 

            foreach($params as $key => $value){ 
                switch($key){ 
                    case 'content_type': 
                        $headers['Content-Type'] = $value.(isset($charset) ? '; charset="'.$charset.'"' : ''); 
                        break; 

                    case 'encoding': 
                        $this->encoding = $value; 
                        $headers['Content-Transfer-Encoding'] = $value; 
                        break; 

                    case 'cid': 
                        $headers['Content-ID'] = '<'.$value.'>'; 
                        break; 

                    case 'disposition': 
                        $headers['Content-Disposition'] = $value.(isset($dfilename) ? '; filename="'.$dfilename.'"' : ''); 
                        break; 

                    case 'dfilename': 
                        if(isset($headers['Content-Disposition'])){ 
                            $headers['Content-Disposition'] .= '; filename="'.$value.'"'; 
                        }else{ 
                            $dfilename = $value; 
                        } 
                        break; 

                    case 'description': 
                        $headers['Content-Description'] = $value; 
                        break; 

                    case 'charset': 
                        if(isset($headers['Content-Type'])){ 
                            $headers['Content-Type'] .= '; charset="'.$value.'"'; 
                        }else{ 
                            $charset = $value; 
                        } 
                        break; 
                } 
            } 

            // Default content-type 
            if(!isset($headers['Content-Type'])) 
                $headers['Content-Type'] = 'text/plain'; 

            // Assign stuff to member variables 
            $this->encoded  =  array(); 
            $this->headers  =& $headers; 
            $this->body     =  $body; 
        } 

        /*************************************** 
        ** Encodes and returns the email. Also 
        ** stores it in the encoded member variable 
        ***************************************/ 
        function encode(){ 

            $encoded =& $this->encoded; 

            if(!empty($this->subparts)){ 
                srand((double)microtime()*1000000); 
                $boundary = '=_'.md5(uniqid(rand()).microtime()); 
                $this->headers['Content-Type'] .= ';'.CRLF.chr(9).'boundary="'.$boundary.'"'; 

                // Add body parts to $subparts 
                for($i=0; $i<count($this->subparts); $i++){ 
                    $tmp = $this->subparts[$i]->encode(); 
                    $subparts[] = implode(CRLF, $tmp['headers']).CRLF.CRLF.$tmp['body']; 
                } 

                $encoded['body'] = '--'.$boundary . CRLF . 
                            implode('--'.$boundary.CRLF, $subparts) . 
                            '--'.$boundary.'--'.CRLF; 

            }else{ 
                $encoded['body'] = $this->get_encoded_data($this->body, $this->encoding).CRLF; 
            } 

            // Add headers to $encoded 
            foreach($this->headers as $key => $value){ 
                $encoded['headers'][] = $key.': '.$value; 
            } 

            return $encoded; 
        } 

        /*************************************** 
        ** Adds a subpart 
        ***************************************/ 
        function &add_subpart($body, $params){ 
            $this->subparts[] = new mime_part($body, $params); 
            return $this->subparts[count($this->subparts) - 1]; 
        } 

        /*************************************** 
        ** Returns encoded data 
        ***************************************/ 
        function get_encoded_data($data, $encoding){ 

            switch($encoding){ 
                case '7bit': 
                    return $data; 
                    break; 

                case 'quoted-printable': 
                    return $this->quoted_printable_encode($data); 
                    break; 

                case 'base64': 
                    return rtrim(chunk_split(base64_encode($data), 76, CRLF)); 
                    break; 
            } 
        } 

        /*************************************** 
        ** Encodes text to quoted printable standard. 
        ** 
        ** Function contributed by Allan Hansen 
        ***************************************/ 
        function quoted_printable_encode($input , $line_max = 76){ 
         
            $lines    = preg_split("/\r\n|\r|\n/", $input); 
            $eol    = CRLF; 
            $escape    = '='; 
            $output    = ''; 
             
            while(list(, $line) = each($lines)){ 
     
                $linlen     = strlen($line); 
                $newline = ''; 
     
                for($i = 0; $i < $linlen; $i++){ 
                    $char = substr($line, $i, 1); 
                    $dec  = ord($char); 
     
                    if(($dec == 32) AND ($i == ($linlen - 1)))    // convert space at eol only 
                        $char = '=20'; 
     
                    elseif($dec == 9) 
                        ; // Do nothing if a tab. 
     
                    elseif(($dec == 61) OR ($dec < 32 ) OR ($dec > 126)) 
                        $char = $escape.strtoupper(sprintf('%02s', dechex($dec))); 
         
                    if((strlen($newline) + strlen($char)) >= $line_max){    // CRLF is not counted 
                        $output  .= $newline.$escape.$eol;                    // soft line break; " =\r\n" is okay 
                        $newline  = ''; 
                    } 
                    $newline .= $char; 
                } // end of for 
                $output .= $newline.$eol; 
            } 
            $output = substr($output, 0, -1*strlen($eol)); // Don't want last crlf 
            return $output; 
        } 

    } // End of class 
?>