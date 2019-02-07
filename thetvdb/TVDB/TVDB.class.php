<?php
	/**
	 * Base TVDB library class, provides universal functions and variables
	 *
	 * @package PHP::TVDB
	 * @author Ryan Doherty <ryan@ryandoherty.com>
	 **/
	 
    /**
     * Constants defined here outside of class because class constants can't be 
     * the result of any operation (concatenation)
     */
	define('PHPTVDB_URL', 'http://thetvdb.com/');
    define('PHPTVDB_API_URL', PHPTVDB_URL.'api/');
    define('PHPTVDB_SECURE_API_URL', 'https://api.thetvdb.com/');
	 
	class TVDB {

		/**
		 * Base url for TheTVDB
		 *
		 * @var string
		 */
		
		CONST baseUrl = PHPTVDB_URL;
		
		/**
		 * Base url for api requests
		 */
		
		CONST apiUrl = PHPTVDB_API_URL;
		
		CONST secureApiUrl = PHPTVDB_SECURE_API_URL;
		
		/**
		 * API key for thetvdb.com
		 *
		 * @var string
		 */
		
		CONST apiKey = PHPTVDB_API_KEY;
		CONST userName = PHPTVDB_USER_NAME;
		CONST userKey = PHPTVDB_USER_KEY;
	
		/**
		 * Fetches data via curl and returns result
		 * 
		 * @access protected
		 * @param $url string The url to fetch data from
		 * @return string The data
		 **/
		protected function fetchData($url) {
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_HEADER, 1);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		
			$response = curl_exec($ch);
			
			$httpCode = curl_getinfo($ch ,CURLINFO_HTTP_CODE);
			$headerSize = curl_getinfo($ch,CURLINFO_HEADER_SIZE);
            $data = substr( $response, $headerSize );
			curl_close($ch);
			
			#print $data;
			if($httpCode != 200) {
			    return false;
			}
			
			return $data;
		}
		
		protected function fetchPrivateData($url) {
			# data needs to be POSTed to the Play url as JSON.
			# (some code from http://www.lornajane.net/posts/2011/posting-json-data-with-php-curl)
			
			$data = array("apikey" => self::apiKey, "username" => self::userName, "userkey" => self::userKey);
			$data_string = json_encode($data);

			$ch = curl_init('https://api.thetvdb.com/login');
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'Content-Type: application/json',
				'Accept: application/json',
				'Content-Length: ' . strlen($data_string))
			);
			curl_setopt($ch, CURLOPT_TIMEOUT, 5);
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);

			//execute post
			$result = curl_exec($ch);

			//close connection
			curl_close($ch);

			
			$tokenPassed = 0;
			$token = '';
			if (substr_count($result,'{"token":"') === 1 && substr_count($result, '"') === 4 && substr_count($result, ':') === 1 && substr_count($result, '{') === 1 && substr_count($result, '}') === 1) {
				$iterateJSON = new RecursiveIteratorIterator(
					new RecursiveArrayIterator(
						json_decode($result, TRUE)
					),
					RecursiveIteratorIterator::SELF_FIRST
				);

				/* make DOUBLE SURE we have what we think we have */
				foreach ($iterateJSON as $key => $val) {
					if(!is_array($val)) {
						if ($key === "token") {
							$tokenPassed = 1;
							$token = $val;
							break;
						}
					}
				}
			}
			if ($tokenPassed === 1) {
				//setup the request, you can also use CURLOPT_URL
				$ch = curl_init($url);

				// Returns the data/output as a string instead of raw data
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

				//Set your auth headers
				curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				   'Content-Type: application/json',
				   'Authorization: Bearer ' . $token
				   ));

				// get stringified data/output. See CURLOPT_RETURNTRANSFER
				$data = curl_exec($ch);

				// get info about the request
				$info = curl_getinfo($ch);
				
				// close curl resource to free up system resources
				curl_close($ch);
				
				return $data;
			}
		}
		/**
		 * Fetches data from thetvdb.com api based on action
		 *
		 * @access protected
		 * @param $params An array containing parameters for the request to thetvdb.com
		 * @return string The data from thetvdb.com
		 **/
		protected function request($params) {
			
			switch($params['action']) {
				
				case 'show_by_id':
					$showId = $params['show_id'];
					$url = self::secureApiUrl.'series/'.$showId;
					$data = self::fetchPrivateData($url);
					return $data;
				break;
				
				case 'get_episode':
					$episodeId = $params['episode_id'];
					$url = self::secureApiUrl.'episodes/'.$episodeId;
					$data = self::fetchPrivateData($url);
					return $data;
				break;
				
				case 'get_show_episodes':
					$showId = $params['show_id'];
					$url = self::secureApiUrl.'series/'.$showId.'/episodes';
					$data = self::fetchPrivateData($url);
					return $data;
				break;
				
				case 'search_tv_shows':
					$showName = urlencode($params['show_name']);
					$url = self::apiUrl."/GetSeries.php?seriesname=$showName";
					$data = self::fetchData($url);
					return $data;
				break;
				
				default:
					return false;
				break;
			}
		}
		
		
		/**
		 * Removes indexes from an array if they are zero length after trimming
		 *
		 * @param array $array The array to remove empty indexes from
		 * @return array An array with all empty indexes removed
		 **/
		public function removeEmptyIndexes($array) {
			
			$length = count($array);
			
			for ($i=$length-1; $i >= 0; $i--) { 
				if(trim($array[$i]) == ''){
					unset($array[$i]);
				}
			}
			
			sort($array);
			return $array;
		}
	}
?>