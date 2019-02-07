<?php
##################################################################
#	Program: 		TheTVDB Guide (RESTful)                      #
#	Author: 		Luis Gustavo Rodriguez (drlouie)             #
#	Copyright: 	    (c) 2018 Luis G. Rodriguez                   #
#	Licensing:		MIT License                                  #
#                                                                #
#	About                                                        #
#        Type:          RESTful_User class                       #
##################################################################
##################################################################################
# Permission is hereby granted, free of charge, to any person obtaining a copy   #
# of this software and associated documentation files (the "Software"), to deal  #
# in the Software without restriction, including without limitation the rights   #
# to use, copy, modify, merge, publish, distribute, sublicense, and/or sell      #
# copies of the Software, and to permit persons to whom the Software is          #
# furnished to do so, subject to the following conditions:                       #
#                                                                                #
# The above copyright notice and this permission notice shall be included in all #
# copies or substantial portions of the Software.                                #
#                                                                                #
# THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR     #
# IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,       #
# FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE    #
# AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER         #
# LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,  #
# OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE  #
# SOFTWARE.                                                                      #
##################################################################################
class User {

    // Connection instance
    private $connection;

    // table name
    private $table_name = "thetvdb";

    public function __construct($connection){
        $this->connection = $connection;
    }
    public function create($CookieName){
		/* [GUID/UID generator aka bakeMyCanvasCartCookie] simple GUID-esque random string, nothing special, just enough to meet the quick need */
		$inUID = $this->generateRandomString(55);
		$dateCap = date("Y-m-d H:i:s");
		$insert = mysqli_query($this->connection, "INSERT INTO " . $this->table_name . " (UserID, UID, Created) VALUES (Null, '$inUID', '$dateCap')");
		$expire=time()+60*60*24*365;
		setcookie("$CookieName", "$inUID", $expire, "/");
		return $inUID;
    }
    public function read($id){
		$query = mysqli_query($this->connection, "SELECT UserState FROM " . $this->table_name . " WHERE UID = '$id'");
		$contents = mysqli_fetch_array($query);
		$contents = str_replace("\\'","'",$contents);
		return $contents;
    }
	public function update($id,$add,$title) {
		$query = mysqli_query($this->connection, "SELECT UserState FROM " . $this->table_name . " WHERE UID = '$id'");
		$contents = mysqli_fetch_array($query)[0];
		$title = str_replace('"','\"',$title);
		$title = str_replace(":","&#58;",$title);
		if (!!$contents && strstr($contents,'[')) {
			if (!strstr($contents,'[series:{"' . $add . '":"')) {
				$contents = $contents . ',[series:{"' . $add . '":"' .  $title . '"}]';
			}
		}
		else {
			$contents = '[series:{"' . $add . '":"' .  $title . '"}]';
		}
		$contents = addslashes($contents);
		$dateCap = date("Y-m-d H:i:s");
		$query = mysqli_query($this->connection, "UPDATE LOW_PRIORITY " . $this->table_name . " SET UserState = '$contents', LastUpdated = '$dateCap' WHERE UID = '$id'");
		$result = mysqli_fetch_array($query);
		return $add;
	}
	public function delete($id, $rem) {
		
		$query = mysqli_query($this->connection, "SELECT UserState FROM " . $this->table_name . " WHERE UID = '$id'");
		$contents = mysqli_fetch_array($query)[0];
		
		$allContents = explode(',',$contents);
		$newContents;
		$newData;
		if (!!$allContents) {
			foreach ($allContents as $item) {
				if (!strstr($item,'"'.$rem.'":')) {
					$newData .= $item;
				}
			}
		}
		$newContents = str_replace('][','],[',$newData);
		$newContents = addslashes($newContents);
		$dateCap = date("Y-m-d H:i:s");
		$query = mysqli_query($this->connection, "UPDATE LOW_PRIORITY " . $this->table_name . " SET UserState = '$newContents', LastUpdated = '$dateCap' WHERE UID = '$id'");
		$result = mysqli_fetch_array($query);
		return "Removed";
	}
	
	private function generateRandomString($length = 10) {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}
}
