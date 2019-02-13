<?php

/**
 * VPS-NET-WEB DB-MYSQL Class
 *
 * Original idea from {@link http://php.justinvincent.com Justin Vincent (justin@visunet.ie)}
 *
 * @package VPS-NET-WEB
 * @subpackage DB-MYSQL
 * @final
 */


	if ( !defined('VPSSQL_DB_NAME') )
		define("VPSSQL_DB_NAME", "vpsnetcom");			// <-- mysql db table
	if ( !defined('VPSSQL_DB_USER') )
		define("VPSSQL_DB_USER", "vpsnetcom");			// <-- mysql db user
	if ( !defined('VPSSQL_DB_PASSWORD') )
		define("VPSSQL_DB_PASSWORD", "YOUR-MySQL-PASSWORD");		// <-- mysql db password
	if ( !defined('VPSSQL_DB_HOST') )
		define("VPSSQL_DB_HOST", "localhost");	// <-- mysql server host

	define("VPSSQL_VERSION","1.9");
	define("OBJECT","OBJECT",true);
	define("ARRAY_A","ARRAY_A",true);
	define("ARRAY_N","ARRAY_N",true);

	class db {

		var $trace = false;      // same as $debug_code
		var $debug_code = false;  // same as $trace
		var $parse_errors = true;
		var $count_queries = 0;	
		var $final_query;
		var $column_info;
		var $debug_requested;
		var $vardump_requested;

		/**
		 * DB Constructor - connects to the server and selects a database
		**/

		function db($dbuser, $dbpassword, $dbname, $dbhost)
		{

			$this->dbh = @mysql_connect($dbhost,$dbuser,$dbpassword);

			if ( ! $this->dbh )
			{
				$this->print_error("<ol><b>Error establishing a database connection!</b><li>Are you sure you have the correct user/password?<li>Are you sure that you have typed the correct hostname?<li>Are you sure that the database server is running?</ol>");
			}


			$this->select($dbname);

		}

		/**
		 * Select a DB (if another one needs to be selected)
		**/

		function select($db)
		{
			if ( !@mysql_select_db($db,$this->dbh))
			{
				$this->print_error("<ol><b>Error selecting database <u>$db</u>!</b><li>Are you sure it exists?<li>Are you sure there is a valid database connection?</ol>");
			}
		}

		/**
		 * Format a string correctly for safe insert under all PHP conditions
		**/
		
		function escape($str)
		{
			return mysql_escape_string(stripslashes($str));				
		}

		/**
		 * Print SQL/DB error.
		**/

		function print_error($str = "")
		{
			
			// All errors to global error array $VPSSQL_ERROR..
			global $VPSSQL_ERROR;

			// If no defined error string use mysql default..
			if ( !$str )
			{
				$str = mysql_error($this->dbh);
				$error_no = mysql_errno($this->dbh);
			}
			
			// Log this error to global array..
			$VPSSQL_ERROR[] = array 
							(
								"query"      => $this->final_query,
								"error_str"  => $str,
								"error_no"   => $error_no
							);

			// if error output is on
			if ( $this->parse_errors )
			{
				// If there is an error note it
				print "<blockquote><font face=arial size=2 color=ff0000>";
				print "<b>SQL/DB Error --</b> ";
				print "[<font color=000077>$str</font>]";
				print "</font></blockquote>";
			}
			else
			{
				return false;	
			}
		}

		/**
		 * Turn error handling on or off..
		**/

		function parse_errors()
		{
			$this->parse_errors = true;
		}
		
		function hide_errors()
		{
			$this->parse_errors = false;
		}

		/**
		 * Kill cached query results
		**/

		function flush()
		{

			// destroy
			$this->last_result = null;
			$this->column_info = null;
			$this->final_query = null;

		}

		/**
		 * Basic Query	- see docs for more detail
		**/

		function query($query)
		{
			
			// For regex
			$query = trim($query); 
			
			// init return
			$return_val = 0;

			// flush cached
			$this->flush();

			// Log function call
			$this->func_call = "\$db->query(\"$query\")";

			// track last query for debug..
			$this->final_query = $query;

			// query using std mysql_query function..
			$this->result = @mysql_query($query,$this->dbh);
			$this->count_queries++;

			// if error note it
			if ( mysql_error() )
			{
				$this->print_error();
				return false;
			}
			
			// query = insert, delete, update, replace
			if ( preg_match("/^(insert|delete|update|replace)\s+/i",$query) )
			{
				$this->rows_affected = mysql_affected_rows();
				
				// note the insert_id
				if ( preg_match("/^(insert|replace)\s+/i",$query) )
				{
					$this->insert_id = mysql_insert_id($this->dbh);	
				}
				
				// return rows affected
				$return_val = $this->rows_affected;
			}
			// query = select
			else
			{
				
				// note column info
				$i=0;
				while ($i < @mysql_num_fields($this->result))
				{
					$this->column_info[$i] = @mysql_fetch_field($this->result);
					$i++;
				}
				
				// store results
				$num_rows=0;
				while ( $row = @mysql_fetch_object($this->result) )
				{
					// store results as objects in main array
					$this->last_result[$num_rows] = $row;
					$num_rows++;
				}

				@mysql_free_result($this->result);

				// log the amount rows returned from query
				$this->num_rows = $num_rows;
				
				// return rows selected
				$return_val = $this->num_rows;
			}

			// if debug CODE is on
			$this->trace || $this->debug_code ? $this->debug() : null ;

			return $return_val;

		}

		/**
		 * Get one variable from the DB - see docs for more detail
		**/

		function get_var($query=null,$x=0,$y=0)
		{

			$this->func_call = "\$db->get_var(\"$query\",$x,$y)";

			// if new query run it, else use cached results..
			if ( $query )
			{
				$this->query($query);
			}

			// get var from cached results using x,y vals
			if ( $this->last_result[$y] )
			{
				$values = array_values(get_object_vars($this->last_result[$y]));
			}

			// return value if one else return null
			return (isset($values[$x]) && $values[$x]!=='')?$values[$x]:null;
		}


		/**
		 * Get one row from the DB - see docs for more detail
		**/

		function get_row($query=null,$output=OBJECT,$y=0)
		{

			$this->func_call = "\$db->get_row(\"$query\",$output,$y)";

			if ( $query )
			{
				$this->query($query);
			}

			// output is object, return object using the row offset
			if ( $output == OBJECT )
			{
				return $this->last_result[$y]?$this->last_result[$y]:null;
			}
			// output is associative array, return it
			elseif ( $output == ARRAY_A )
			{
				return $this->last_result[$y]?get_object_vars($this->last_result[$y]):null;
			}
			// output is numerical array, return it
			elseif ( $output == ARRAY_N )
			{
				return $this->last_result[$y]?array_values(get_object_vars($this->last_result[$y])):null;
			}
			// invalid output type
			else
			{
				$this->print_error(" \$db->get_row(string query, output type, int offset) -- Output type must be one of: OBJECT, ARRAY_A, ARRAY_N");
			}

		}

		/**
		 * Get ONE column from cached result set based on the X index, see docs for usage and info
		**/

		function get_col($query=null,$x=0)
		{

			if ( $query )
			{
				$this->query($query);
			}

			// extract column values
			for ( $i=0; $i < count($this->last_result); $i++ )
			{
				$new_array[$i] = $this->get_var(null,$x,$i);
			}

			return $new_array;
		}

		/**
		 * Return the the query as a result set - see docs for more details
		**/

		function get_results($query=null, $output = OBJECT)
		{

			$this->func_call = "\$db->get_results(\"$query\", $output)";

			if ( $query )
			{
				$this->query($query);
			}

			// return array of objects, every row = object
			if ( $output == OBJECT )
			{
				return $this->last_result;
			}
			elseif ( $output == ARRAY_A || $output == ARRAY_N )
			{
				if ( $this->last_result )
				{
					$i=0;
					foreach( $this->last_result as $row )
					{

						$new_array[$i] = get_object_vars($row);

						if ( $output == ARRAY_N )
						{
							$new_array[$i] = array_values($new_array[$i]);
						}

						$i++;
					}

					return $new_array;
				}
				else
				{
					return null;
				}
			}
		}


		/**
		 * get column meta data info from last query
		**/

		function get_column_info($info_type="name",$col_offset=-1)
		{

			if ( $this->column_info )
			{
				if ( $col_offset == -1 )
				{
					$i=0;
					foreach($this->column_info as $col )
					{
						$new_array[$i] = $col->{$info_type};
						$i++;
					}
					return $new_array;
				}
				else
				{
					return $this->column_info[$col_offset]->{$info_type};
				}

			}

		}

		/**
		 * Dumps the contents of any input variable to screen in a nicely formatted and easy to understand way - any type: Object, Var or Array
		**/

		function vardump($mixed='')
		{

			echo "<p><table><tr><td bgcolor=ffffff><blockquote><font color=000090>";
			echo "<pre><font face=arial>";

			if ( ! $this->vardump_requested )
			{
				echo "<font color=800080><b>VPSSQL</b> (v".VPSSQL_VERSION.") <b>Variable Dump..</b></font>\n\n";
			}

			$var_type = gettype ($mixed);
			print_r(($mixed?$mixed:"<font color=red>No Value / False</font>"));
			echo "\n\n<b>Type:</b> " . ucfirst($var_type) . "\n";
			echo "<b>Last Query</b> [$this->count_queries]<b>:</b> ".($this->final_query?$this->final_query:"NULL")."\n";
			echo "<b>Last Function Call:</b> " . ($this->func_call?$this->func_call:"None")."\n";
			echo "<b>Last Rows Returned:</b> ".count($this->last_result)."\n";
			echo "</font></pre></font></blockquote></td></tr></table>".$this->donation();
			echo "\n<hr size=1 noshade color=dddddd>";

			$this->vardump_requested = true;

		}

		// alias to vardump function
		function dumpvar($mixed)
		{
			$this->vardump($mixed);
		}

		/**
		 * Displays the last query string that was sent to the database & a table listing results (if there were any). (abstracted into a seperate file to save server overhead).
		**/

		function debug()
		{

			echo "<blockquote>";

			// only show VPSSQL credits once..
			if ( ! $this->debug_requested )
			{
				echo "<font color=800080 face=arial size=2><b>VPSSQL</b> (v".VPSSQL_VERSION.") <b>Debug..</b></font><p>\n";
			}
			echo "<font face=arial size=2 color=000099><b>Query</b> [$this->count_queries] <b>--</b> ";
			echo "[<font color=000000><b>$this->final_query</b></font>]</font><p>";

				echo "<font face=arial size=2 color=000099><b>Query Result..</b></font>";
				echo "<blockquote>";

			if ( $this->column_info )
			{

				/**
				 * Results top rows
				**/

				echo "<table cellpadding=5 cellspacing=1 bgcolor=555555>";
				echo "<tr bgcolor=eeeeee><td nowrap valign=bottom><font color=555599 face=arial size=2><b>(row)</b></font></td>";


				for ( $i=0; $i < count($this->column_info); $i++ )
				{
					echo "<td nowrap align=left valign=top><font size=1 color=555599 face=arial>{$this->column_info[$i]->type} {$this->column_info[$i]->max_length}</font><br><span style='font-family: arial; font-size: 10pt; font-weight: bold;'>{$this->column_info[$i]->name}</span></td>";
				}

				echo "</tr>";

				/**
				 * print main results
				**/

			if ( $this->last_result )
			{

				$i=0;
				foreach ( $this->get_results(null,ARRAY_N) as $one_row )
				{
					$i++;
					echo "<tr bgcolor=ffffff><td bgcolor=eeeeee nowrap align=middle><font size=2 color=555599 face=arial>$i</font></td>";

					foreach ( $one_row as $item )
					{
						echo "<td nowrap><font face=arial size=2>$item</font></td>";
					}

					echo "</tr>";
				}

			} /* if last result */
			else
			{
				echo "<tr bgcolor=ffffff><td colspan=".(count($this->column_info)+1)."><font face=arial size=2>No Results</font></td></tr>";
			}

			echo "</table>";

			} /* if column_info */
			else
			{
				echo "<font face=arial size=2>No Results</font>";
			}

			echo "</blockquote></blockquote>".$this->donation()."<hr noshade color=dddddd size=1>";


			$this->debug_requested = true;
		}

		/**
		 * ask for donation
		**/

		function donation()
		{
			return "";	
		}

	}

$db = new db(VPSSQL_DB_USER, VPSSQL_DB_PASSWORD, VPSSQL_DB_NAME, VPSSQL_DB_HOST);

?>
