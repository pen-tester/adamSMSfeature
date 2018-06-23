<?php
//X1-ZWz1g5umo647ij_7ew1d  ::Zillow ZWSID
	//This gets the result from zillow api(search) and return the first url to display
	class Zillow_Wrapper{
		public static $zwsid = "X1-ZWz1g5umo647ij_7ew1d";
		public static $host = "http://www.zillow.com/webservice/GetDeepSearchResults.htm?";
		public static $param = "zws-id=%s&address=%s&citystatezip=%s";
		public static $detail_host= "http://www.zillow.com/webservice/GetUpdatedPropertyDetails.htm?zws-id=%s&zpid=%s";


		public static function get_allresult($addr,$zip){
			$call_url = self::$host.sprintf(self::$param, self::$zwsid, urlencode($addr), urlencode($zip));
			$content = self::get_web_page($call_url)['content'];
			$result = simplexml_load_string($content);
			if($result->message->code == '0'){
				return $result->response->results->result[0];
			}
			else{return array();}
		}

		public static function get_detailed_info($zpid){
			$call_url = sprintf(self::$detail_host,self::$zwsid , $zpid);
			$content = self::get_web_page($call_url)["content"];
			$result = simplexml_load_string($content);
			return $result;
		}

		/**
		 * Get a web file (HTML, XHTML, XML, image, etc.) from a URL.  Return an
		 * array containing the HTTP server response header fields and content.
		 */
		static function get_web_page( $url )
		{
		    $options = array(
		        CURLOPT_RETURNTRANSFER => true,     // return web page
		        CURLOPT_HEADER         => false,    // don't return headers
		        CURLOPT_FOLLOWLOCATION => true,     // follow redirects
		        CURLOPT_ENCODING       => "",       // handle all encodings
		        CURLOPT_USERAGENT      => "spider", // who am i
		        CURLOPT_AUTOREFERER    => true,     // set referer on redirect
		        CURLOPT_CONNECTTIMEOUT => 120,      // timeout on connect
		        CURLOPT_TIMEOUT        => 120,      // timeout on response
		        CURLOPT_MAXREDIRS      => 10,       // stop after 10 redirects
		        CURLOPT_SSL_VERIFYPEER => false     // Disabled SSL Cert checks
		    );

		    $ch      = curl_init( $url );
		    curl_setopt_array( $ch, $options );
		    $content = curl_exec( $ch );
		    $err     = curl_errno( $ch );
		    $errmsg  = curl_error( $ch );
		    $header  = curl_getinfo( $ch );
		    curl_close( $ch );

		    $header['errno']   = $err;
		    $header['errmsg']  = $errmsg;
		    $header['content'] = $content;
		    $header['url'] = $url;
		    return $header;
		}
	}
?>