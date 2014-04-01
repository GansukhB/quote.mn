<?php
class MySQL 
{
	private $db_host    = "localhost";  // server name
	private $db_user    = "root";       	// user name
	private $db_pass    = "";           // password
	private $db_dbname  = "quote_db";           // database name
	private $db_charset = "utf8";          
	private $db_pcon    = false;        

	const SQLVALUE_BIT      = "bit";
	const SQLVALUE_BOOLEAN  = "boolean";
	const SQLVALUE_DATE     = "date";
	const SQLVALUE_DATETIME = "datetime";
	const SQLVALUE_NUMBER   = "number";
	const SQLVALUE_T_F      = "t-f";
	const SQLVALUE_TEXT     = "text";
	const SQLVALUE_TIME     = "time";
	const SQLVALUE_Y_N      = "y-n";

	private $active_row     = -1;       // current row
	private $error_desc     = "";       // last mysql error string
	private $error_number   = 0;        // last mysql error number
	private $in_transaction = false;    // used for transactions
	private $last_insert_id;            // last id of record inserted
	private $last_result;               // last mysql query result
	private $last_sql       = "";       // last mysql query
	private $mysql_link     = 0;        
	private $time_diff      = 0;        
	private $time_start     = 0;        

	public $ThrowExceptions = false;

	public function __construct($connect = true, $database = null, $server = null, $username = null, $password = null, $charset = null) 
	{
		if ($database !== null) 
		{
			$this->db_dbname  = $database;
		}
		if ($server   !== null) 
		{
			$this->db_host    = $server;
		}
		if ($username !== null) 
		{
			$this->db_user    = $username;
		}
		if ($password !== null) 
		{	
			$this->db_pass    = $password;
		}
		if ($charset  !== null) 
		{
			$this->db_charset = $charset;
		}
		if (strlen($this->db_host) > 0 && strlen($this->db_user) > 0) 
		{
			if ($connect) $this->Open();
		}
	}

	public function __destruct() 
	{
		$this->Close();
	}

	public function AutoInsertUpdate($tableName, $valuesArray, $whereArray) 
	{
		$this->ResetError();
		$this->SelectRows($tableName, $whereArray);
		if (! $this->Error()) 
		{
			if ($this->HasRecords()) 
			{
				return $this->UpdateRows($tableName, $valuesArray, $whereArray);
			}else
			{
				return $this->InsertRow($tableName, $valuesArray);
			}
		}else 
		{
			return false;
		}
	}

	public function BeginningOfSeek() 
	{
		$this->ResetError();
		if ($this->IsConnected()) 
		{
			if ($this->active_row < 1) 
			{
				return true;
			}else 
			{
				return false;
			}
		}else 
		{
			$this->SetError("No connection");
			return false;
		}
	}

	static private function BuildSQLColumns($columns, $addQuotes = true, $showAlias = true) 
	{
		if ($addQuotes) 
		{
			$quote = "`";
		}else 
		{
			$quote = "";
		}
		switch (gettype($columns)) 
		{
			case "array":
				$sql = "";
				foreach ($columns as $key => $value) 
				{
					if (strlen($sql) == 0) 
					{
						$sql = $quote . $value . $quote;
					}else 
					{
						$sql .= ", " . $quote . $value . $quote;
					}
					if ($showAlias && is_string($key) && (! empty($key))) 
					{
						$sql .= ' AS "' . $key . '"';
					}
				}
				return $sql;
				break;
			case "string":
				return $quote . $columns . $quote;
				break;
			default:
				return false;
				break;
		}
	}

	static public function BuildSQLDelete($tableName, $whereArray = null) 
	{
		$sql = "DELETE FROM `" . $tableName . "`";
		if (! is_null($whereArray)) 
		{
			$sql .= self::BuildSQLWhereClause($whereArray);
		}
		return $sql;
	}

	static public function BuildSQLInsert($tableName, $valuesArray) 
	{
		$columns = self::BuildSQLColumns(array_keys($valuesArray));
		$values  = self::BuildSQLColumns($valuesArray, false, false);
		$sql = "INSERT INTO `" . $tableName .
			   "` (" . $columns . ") VALUES (" . $values . ")";
		return $sql;
	}

	static public function BuildSQLSelect($tableName, $whereArray = null, $columns = null, $sortColumns = null, $sortAscending = true, $limit = null) 
	{
		if (! is_null($columns)) 
		{
			$sql = self::BuildSQLColumns($columns);
		}else 
		{
			$sql = "*";
		}
		$sql = "SELECT " . $sql . " FROM `" . $tableName . "`";
		if (is_array($whereArray)) 
		{
			$sql .= self::BuildSQLWhereClause($whereArray);
		}
		if (! is_null($sortColumns)) 
		{
			$sql .= " ORDER BY " .
					self::BuildSQLColumns($sortColumns, true, false) .
					" " . ($sortAscending ? "ASC" : "DESC");
		}
		if (! is_null($limit)) 
		{
			$sql .= " LIMIT " . $limit;
		}
		return $sql;
	}

	static public function BuildSQLUpdate($tableName, $valuesArray, $whereArray = null) 
	{
		$sql = "";
		foreach ($valuesArray as $key => $value) 
		{
			if (strlen($sql) == 0) 
			{
				$sql = "`" . $key . "` = " . $value;
			}else 
			{
				$sql .= ", `" . $key . "` = " . $value;
			}
		}
		$sql = "UPDATE `" . $tableName . "` SET " . $sql;
		if (is_array($whereArray)) 
		{
			$sql .= self::BuildSQLWhereClause($whereArray);
		}
		return $sql;
	}

	static public function BuildSQLWhereClause($whereArray) 
	{
		$where = "";
		foreach ($whereArray as $key => $value) 
		{
			if (strlen($where) == 0) 
			{
				if (is_string($key)) 
				{
					$where = " WHERE `" . $key . "` = " . $value;
				}else 
				{
					$where = " WHERE " . $value;
				}
			}else
			{
				if (is_string($key)) 
				{
					$where .= " AND `" . $key . "` = " . $value;
				}else 
				{
					$where .= " AND " . $value;
				}
			}
		}
		return $where;
	}

	public function Close() 
	{
		$this->ResetError();
		$this->active_row = -1;
		$success = $this->Release();
		if ($success) 
		{
			$success = @mysql_close($this->mysql_link);
			if (! $success) 
			{
				$this->SetError();
			}else 
			{
				unset($this->last_sql);
				unset($this->last_result);
				unset($this->mysql_link);
			}
		}
		return $success;
	}

	public function DeleteRows($tableName, $whereArray = null) 
	{
		$this->ResetError();
		if (! $this->IsConnected()) 
		{
			$this->SetError("No connection");
			return false;
		}else 
		{
			$sql = self::BuildSQLDelete($tableName, $whereArray);
			if (! $this->Query($sql)) 
			{
				return false;
			}else 
			{
				return true;
			}
		}
	}

	public function EndOfSeek() 
	{
		$this->ResetError();
		if ($this->IsConnected()) 
		{
			if ($this->active_row >= ($this->RowCount())) 
			{
				return true;
			}else 
			{
				return false;
			}
		}else 
		{
			$this->SetError("No connection");
			return false;
		}
	}

	public function Error() 
	{
		$error = $this->error_desc;
		if (empty($error)) 
		{
			if ($this->error_number <> 0) 
			{
				$error = "Unknown Error (#" . $this->error_number . ")";
			}else 
			{
				$error = false;
			}
		}else 
		{
			if ($this->error_number > 0) 
			{
				$error .= " (#" . $this->error_number . ")";
			}
		}
		return $error;
	}

	public function ErrorNumber() 
	{
		if (strlen($this->error_desc) > 0)
		{
			if ($this->error_number <> 0)
			{
				return $this->error_number;
			} else 
			{
				return -1;
			}
		}else 
		{
			return $this->error_number;
		}
	}

	static public function GetBooleanValue($value) 
	{
		if (gettype($value) == "boolean") 
		{
			if ($value == true) 
			{
				return true;
			}else 
			{
				return false;
			}
		}elseif (is_numeric($value)) 
		{
			if ($value > 0) 
			{
				return true;
			}else
			{
				return false;
			}
		}else 
		{
			$cleaned = strtoupper(trim($value));

			if ($cleaned == "ON") 
			{
				return true;
			}elseif ($cleaned == "SELECTED" || $cleaned == "CHECKED") 
			{
				return true;
			}elseif ($cleaned == "YES" || $cleaned == "Y") 
			{
				return true;
			}elseif ($cleaned == "TRUE" || $cleaned == "T") 
			{
				return true;
			}else 
			{
				return false;
			}
		}
	}

	public function GetColumnComments($table) 
	{
		$this->ResetError();
		$records = mysql_query("SHOW FULL COLUMNS FROM " . $table);
		if (! $records) 
		{
			$this->SetError();
			return false;
		}else 
		{
			$columnNames = $this->GetColumnNames($table);
			if ($this->Error()) 
			{
				return false;
			}else 
			{
				$index = 0;
				while ($array_data = mysql_fetch_array($records)) 
				{
					$columns[$index] = $array_data[8];
					$columns[$columnNames[$index++]] = $array_data[8];
				}
				return $columns;
			}
		}
	}

	public function GetColumnCount($table = "") 
	{
		$this->ResetError();
		if (empty($table)) 
		{
			$result = mysql_num_fields($this->last_result);
			if (! $result) $this->SetError();
		}else 
		{
			$records = mysql_query("SELECT * FROM " . $table . " LIMIT 1");
			if (! $records) 
			{
				$this->SetError();
				$result = false;
			}else 
			{
				$result = mysql_num_fields($records);
				$success = @mysql_free_result($records);
				if (! $success) 
				{
					$this->SetError();
					$result = false;
				}
			}
		}
		return $result;
	}

	public function GetColumnDataType($column, $table = "") 
	{
		$this->ResetError();
		if (empty($table)) 
		{
			if ($this->RowCount() > 0) 
			{
				if (is_numeric($column)) 
				{
					return mysql_field_type($this->last_result, $column);
				}else 
				{
					return mysql_field_type($this->last_result, $this->GetColumnID($column));
				}
			}else 
			{
				return false;
			}
		}else 
		{
			if (is_numeric($column)) $column = $this->GetColumnName($column, $table);
			$result = mysql_query("SELECT " . $column . " FROM " . $table . " LIMIT 1");
			if (mysql_num_fields($result) > 0) 
			{
				return mysql_field_type($result, 0);
			}else 
			{
				$this->SetError("The specified column or table does not exist, or no data was returned", -1);
				return false;
			}
		}
	}

	public function GetColumnID($column, $table = "") 
	{
		$this->ResetError();
		$columnNames = $this->GetColumnNames($table);
		if (! $columnNames) 
		{
			return false;
		}else
		{
			$index = 0;
			$found = false;
			foreach ($columnNames as $columnName) 
			{
				if ($columnName == $column) 
				{
					$found = true;
					break;
				}
				$index++;
			}
			if ($found) 
			{
				return $index;
			}else 
			{
				$this->SetError("Column name not found", -1);
				return false;
			}
		}
	}

	public function GetColumnLength($column, $table = "") 
	{
		$this->ResetError();
		if (empty($table)) 
		{
			if (is_numeric($column)) 
			{
				$columnID = $column;
			}else 
			{
				$columnID = $this->GetColumnID($column);
			}
			if (! $columnID) 
			{
				return false;
			}else 
			{
				$result = mysql_field_len($this->last_result, $columnID);
				if (! $result) 
				{
					$this->SetError();
					return false;
				}else 
				{
					return $result;
				}
			}
		}else 
		{
			$records = mysql_query("SELECT " . $column . " FROM " . $table . " LIMIT 1");
			if (! $records) 
			{
				$this->SetError();
				return false;
			}
			$result = mysql_field_len($records, 0);
			if (! $result) 
			{
				$this->SetError();
				return false;
			}else 
			{
				return $result;
			}
		}
	}

	public function GetColumnName($columnID, $table = "") 
	{
		$this->ResetError();
		if (empty($table)) 
		{
			if ($this->RowCount() > 0) 
			{
				$result = mysql_field_name($this->last_result, $columnID);
				if (! $result) $this->SetError();
			}else 
			{
				$result = false;
			}
		}else 
		{
			$records = mysql_query("SELECT * FROM " . $table . " LIMIT 1");
			if (! $records) 
			{
				$this->SetError();
				$result = false;
			}else 
			{
				if (mysql_num_fields($records) > 0) 
				{
					$result = mysql_field_name($records, $columnID);
					if (! $result) $this->SetError();
				}else 
				{
					$result = false;
				}
			}
		}
		return $result;
	}

	public function GetColumnNames($table = "") 
	{
		$this->ResetError();
		if (empty($table)) {
			$columnCount = mysql_num_fields($this->last_result);
			if (! $columnCount) 
			{
				$this->SetError();
				$columns = false;
			}else 
			{
				for ($column = 0; $column < $columnCount; $column++) 
				{
					$columns[] = mysql_field_name($this->last_result, $column);
				}
			}
		}else 
		{
			$result = mysql_query("SHOW COLUMNS FROM " . $table);
			if (! $result) 
			{
				$this->SetError();
				$columns = false;
			}else 
			{
				while ($array_data = mysql_fetch_array($result)) 
				{
					$columns[] = $array_data[0];
				}
			}
		}

		return $columns;
	}

	public function GetHTML($showCount = true, $styleTable = null, $styleHeader = null, $styleData = null) 
	{
		if ($styleTable === null) 
		{
			$tb = "border-collapse:collapse;empty-cells:show";
		}else 
		{
			$tb = $styleTable;
		}
		if ($styleHeader === null) 
		{
			$th = "border-width:1px;border-style:solid;background-color:navy;color:white";
		}else 
		{
			$th = $styleHeader;
		}
		if ($styleData === null) 
		{
			$td = "border-width:1px;border-style:solid";
		}else 
		{
			$td = $styleData;
		}

		if ($this->last_result) 
		{
			if ($this->RowCount() > 0) 
			{
				$html = "";
				if ($showCount) $html = "Record Count: " . $this->RowCount() . "<br />\n";
				$html .= "<table style=\"$tb\" cellpadding=\"2\" cellspacing=\"2\">\n";
				$this->MoveFirst();
				$header = false;
				while ($member = mysql_fetch_object($this->last_result)) 
				{
					if (!$header) 
					{
						$html .= "\t<tr>\n";
						foreach ($member as $key => $value) 
						{
							$html .= "\t\t<td style=\"$th\"><strong>" . htmlspecialchars($key) . "</strong></td>\n";
						}
						$html .= "\t</tr>\n";
						$header = true;
					}
					$html .= "\t<tr>\n";
					foreach ($member as $key => $value) 
					{
						$html .= "\t\t<td style=\"$td\">" . htmlspecialchars($value) . "</td>\n";
					}
					$html .= "\t</tr>\n";
				}
				$this->MoveFirst();
				$html .= "</table>";
			}else 
			{
				$html = "No records were returned.";
			}
		}else
		{
			$this->active_row = -1;
			$html = false;
		}
		return $html;
	}

	public function GetJSON() 
	{
		if ($this->last_result) 
		{
			if ($this->RowCount() > 0) 
			{
				for ($i = 0, $il = mysql_num_fields($this->last_result); $i < $il; $i++) 
				{
					$types[$i] = mysql_field_type($this->last_result, $i);
				}
				$json = '[';
				$this->MoveFirst();
				while ($member = mysql_fetch_object($this->last_result)) 
				{
					$json .= json_encode($member) . ",";
				}
				$json .= ']';
				$json = str_replace("},]", "}]", $json);
			}else 
			{
				$json = 'null';
			}
		}else 
		{
			$this->active_row = -1;
			$json = 'null';
		}
		return $json;
	}

	public function GetLastInsertID() 
	{
		return $this->last_insert_id;
	}

	public function GetLastSQL() 
	{
		return $this->last_sql;
	}

	public function GetTables() 
	{
		$this->ResetError();
		$records = mysql_query("SHOW TABLES");
		if (! $records) 
		{
			$this->SetError();
			return FALSE;
		}else 
		{
			while ($array_data = mysql_fetch_array($records)) 
			{
				$tables[] = $array_data[0];
			}

			if (count($tables) > 0) 
			{
				return $tables;
			}else 
			{
				return FALSE;
			}
		}
	}

	public function GetXML() 
	{
		$doc = new DomDocument('1.0'); // ,'UTF-8');

		$root = $doc->createElement('root');
		$root = $doc->appendChild($root);

		if (is_resource($this->last_result)) 
		{
			$root->setAttribute('rows', ($this->RowCount() ? $this->RowCount() : 0));
			$root->setAttribute('query', $this->last_sql);
			$root->setAttribute('error', "");

			$rowCount = 0;
			while ($row = mysql_fetch_assoc($this->last_result)) 
			{
				$rowCount = $rowCount + 1;

				$element = $doc->createElement('row');
				$element = $root->appendChild($element);
				$element->setAttribute('index', $rowCount);

				foreach ($row as $fieldname => $fieldvalue) 
				{
					$child = $doc->createElement($fieldname);
					$child = $element->appendChild($child);

					$fieldvalue = htmlspecialchars($fieldvalue);
					$value = $doc->createTextNode($fieldvalue);
					$value = $child->appendChild($value);
				} 
			}
		}else 
		{
			$root->setAttribute('rows', 0);
			$root->setAttribute('query', $this->last_sql);
			if ($this->Error()) 
			{
				$root->setAttribute('error', $this->Error());
			}else 
			{
				$root->setAttribute('error', "No query has been executed.");
			}
		}

		return $doc->saveXML();
	}

	public function HasRecords($sql = "") 
	{
		if (strlen($sql) > 0)
		{
			$this->Query($sql);
			if ($this->Error()) 
			{
				return false;
			}
		}
		if ($this->RowCount() > 0) 
		{
			return true;
		}else 
		{
			return false;
		}
	}

	public function InsertRow($tableName, $valuesArray) 
	{
		$this->ResetError();
		if (! $this->IsConnected()) 
		{
			$this->SetError("No connection");
			return false;
		}else 
		{
			$sql = self::BuildSQLInsert($tableName, $valuesArray);
			if (! $this->Query($sql)) 
			{
				return false;
			}else 
			{
				return $this->GetLastInsertID();
			}
		}
	}

	public function IsConnected() 
	{
		if (gettype($this->mysql_link) == "resource") 
		{
			return true;
		}else 
		{
			return false;
		}
	}

	static public function IsDate($value) 
	{
		$date = date('Y', strtotime($value));
		if ($date == "1969" || $date == '') 
		{
			return false;
		}else 
		{
			return true;
		}
	}

	public function Kill($message = "") 
	{
		if (strlen($message) > 0) 
		{
			exit($message);
		}else 
		{
			exit($this->Error());
		}
	}

	public function MoveFirst() 
	{
		$this->ResetError();
		if (! $this->Seek(0)) 
		{
			$this->SetError();
			return false;
		}else 
		{
			$this->active_row = 0;
			return true;
		}
	}

	public function MoveLast() 
	{
		$this->ResetError();
		$this->active_row = $this->RowCount() - 1;
		if (! $this->Error()) 
		{
			if (! $this->Seek($this->active_row)) 
			{
				return false;
			}else 
			{
				return true;
			}
		}else
		{
			return false;
		}
	}

	public function Open($database = null, $server = null, $username = null, $password = null, $charset = null, $pcon = false) 
	{
		$this->ResetError();

		if ($database !== null) 
		{
			$this->db_dbname  = $database;
		}
		if ($server   !== null) 
		{
			$this->db_host    = $server;
		}
		if ($username !== null) 
		{
			$this->db_user    = $username;
		}
		if ($password !== null) 
		{
			$this->db_pass    = $password;
		}
		if ($charset  !== null) 
		{
			$this->db_charset = $charset;
		}
		
		if (is_bool($pcon))     
		{
			$this->db_pcon    = $pcon;
		}
		$this->active_row = -1;

		if ($pcon) 
		{
			$this->mysql_link = @mysql_pconnect($this->db_host, $this->db_user, $this->db_pass);
		}else 
		{
			$this->mysql_link = @mysql_connect($this->db_host, $this->db_user, $this->db_pass);
		}
		if (! $this->IsConnected()) 
		{
			$this->SetError();
			return false;
		}else 
		{
			if (strlen($this->db_dbname) > 0) 
			{
				if (strlen($this->db_charset) == 0) 
				{
					if (! $this->SelectDatabase($this->db_dbname)) 
					{
						return false;
					}else 
					{
						return true;
					}
				}else 
				{
					if (! $this->SelectDatabase($this->db_dbname, $this->db_charset)) 
					{
						return false;
					}else 
					{
						return true;
					}
				}
			}else 
			{
				return true;
			}
		}
	}

	public function Query($sql) 
	{
		$this->ResetError();
		$this->last_sql = $sql;
		$this->last_result = @mysql_query($sql, $this->mysql_link);
		if(! $this->last_result) 
		{
			$this->active_row = -1;
			$this->SetError();
			return false;
		}else 
		{
			if (strpos(strtolower($sql), "insert") === 0) 
			{
				$this->last_insert_id = mysql_insert_id();
				if ($this->last_insert_id === false) 
				{
					$this->SetError();
					return false;
				}else 
				{
					$numrows = 0;
					$this->active_row = -1;
					return $this->last_result;
				}
			}else if(strpos(strtolower($sql), "select") === 0) 
			{
				$numrows = mysql_num_rows($this->last_result);
				if ($numrows > 0) 
				{
					$this->active_row = 0;
				}else 
				{
					$this->active_row = -1;
				}
				$this->last_insert_id = 0;
				return $this->last_result;
			}else 
			{
				return $this->last_result;
			}
		}
	}

	public function QueryArray($sql, $resultType = MYSQL_BOTH) 
	{
		$this->Query($sql);
		if (! $this->Error()) 
		{
			return $this->RecordsArray($resultType);
		}else 
		{
			return false;
		}
	}

	public function QuerySingleRow($sql) 
	{
		$this->Query($sql);
		if ($this->RowCount() > 0) 
		{
			return $this->Row();
		}else 
		{
			return false;
		}
	}

	public function QuerySingleRowArray($sql, $resultType = MYSQL_BOTH) 
	{
		$this->Query($sql);
		if ($this->RowCount() > 0) {
			return $this->RowArray(null, $resultType);
		} else {
			return false;
		}
	}

	public function QuerySingleValue($sql) 
	{
		$this->Query($sql);
		if ($this->RowCount() > 0 && $this->GetColumnCount() > 0) {
			$row = $this->RowArray(null, MYSQL_NUM);
			return $row[0];
		} else {
			return false;
		}
	}

	public function QueryTimed($sql) 
	{
		$this->TimerStart();
		$result = $this->Query($sql);
		$this->TimerStop();
		return $result;
	}

	public function Records() 
	{
		return $this->last_result;
	}

	public function RecordsArray($resultType = MYSQL_BOTH) 
	{
		$this->ResetError();
		if ($this->last_result) 
		{
			if (! mysql_data_seek($this->last_result, 0)) 
			{
				$this->SetError();
				return false;
			} else 
			{
				//while($member = mysql_fetch_object($this->last_result)){
				while ($member = mysql_fetch_array($this->last_result, $resultType))
				{
					$members[] = $member;
				}
				mysql_data_seek($this->last_result, 0);
				$this->active_row = 0;
				return $members;
			}
		}else 
		{
			$this->active_row = -1;
			$this->SetError("No query results exist", -1);
			return false;
		}
	}

	public function Release() 
	{
		$this->ResetError();
		if (! $this->last_result) 
		{
			$success = true;
		}else 
		{
			$success = @mysql_free_result($this->last_result);
			if (! $success) $this->SetError();
		}
		return $success;
	}

	private function ResetError() 
	{
		$this->error_desc = '';
		$this->error_number = 0;
	}

	public function Row($optional_row_number = null) 
	{
		$this->ResetError();
		if (! $this->last_result) 
		{
			$this->SetError("No query results exist", -1);
			return false;
		} elseif ($optional_row_number === null) 
		{
			if (($this->active_row) > $this->RowCount()) 
			{
				$this->SetError("Cannot read past the end of the records", -1);
				return false;
			}else 
			{
				$this->active_row++;
			}
		}else 
		{
			if ($optional_row_number >= $this->RowCount()) 
			{
				$this->SetError("Row number is greater than the total number of rows", -1);
				return false;
			}else 
			{
				$this->active_row = $optional_row_number;
				$this->Seek($optional_row_number);
			}
		}
		$row = mysql_fetch_object($this->last_result);
		if (! $row) 
		{
			$this->SetError();
			return false;
		}else 
		{
			return $row;
		}
	}

	public function RowArray($optional_row_number = null, $resultType = MYSQL_BOTH) 
	{
		$this->ResetError();
		if (! $this->last_result) 
		{
			$this->SetError("No query results exist", -1);
			return false;
		} elseif ($optional_row_number === null) 
		{
			if (($this->active_row) > $this->RowCount()) 
			{
				$this->SetError("Cannot read past the end of the records", -1);
				return false;
			}else 
			{
				$this->active_row++;
			}
		} else 
		{
			if ($optional_row_number >= $this->RowCount()) 
			{
				$this->SetError("Row number is greater than the total number of rows", -1);
				return false;
			} else 
			{
				$this->active_row = $optional_row_number;
				$this->Seek($optional_row_number);
			}
		}
		$row = mysql_fetch_array($this->last_result, $resultType);
		if (! $row) 
		{
			$this->SetError();
			return false;
		} else 
		{
			return $row;
		}
	}

	public function RowCount() {
		$this->ResetError();
		if (! $this->IsConnected()) {
			$this->SetError("No connection", -1);
			return false;
		} elseif (! $this->last_result) 
		{
			$this->SetError("No query results exist", -1);
			return false;
		} else 
		{
			$result = @mysql_num_rows($this->last_result);
			if (! $result) 
			{
				$this->SetError();
				return false;
			}else 
			{
				return $result;
			}
		}
	}

	public function Seek($row_number) 
	{
		$this->ResetError();
		$row_count = $this->RowCount();
		if (! $row_count) 
		{
			return false;
		}elseif ($row_number >= $row_count) 
		{
			$this->SetError("Seek parameter is greater than the total number of rows", -1);
			return false;
		}else 
		{
			$this->active_row = $row_number;
			$result = mysql_data_seek($this->last_result, $row_number);
			if (! $result) 
			{
				$this->SetError();
				return false;
			}else 
			{
				$record = mysql_fetch_row($this->last_result);
				if (! $record) 
				{
					$this->SetError();
					return false;
				}else 
				{
					mysql_data_seek($this->last_result, $row_number);
					return $record;
				}
			}
		}
	}

	public function SeekPosition() 
	{
		return $this->active_row;
	}

	public function SelectDatabase($database, $charset = "") 
	{
		$return_value = true;
		if (! $charset) $charset = $this->db_charset;
		$this->ResetError();
		if (! (mysql_select_db($database))) 
		{
			$this->SetError();
			$return_value = false;
		}else
		{
			if ((strlen($charset) > 0)) 
			{
				if (! (mysql_query("SET CHARACTER SET '{$charset}'", $this->mysql_link))) 
				{
					$this->SetError();
					$return_value = false;
				}
			}
		}
		return $return_value;
	}

	public function SelectRows($tableName, $whereArray = null, $columns = null, $sortColumns = null,  $sortAscending = true, $limit = null) 
	{
		$this->ResetError();
		if (! $this->IsConnected()) 
		{
			$this->SetError("No connection");
			return false;
		} else 
		{
			$sql = self::BuildSQLSelect($tableName, $whereArray, $columns, $sortColumns, $sortAscending, $limit);
			if (! $this->Query($sql)) 
			{
				return $this->last_result;
			}else 
			{
				return true;
			}
		}
	}

	public function SelectTable($tableName) 
	{
		return $this->SelectRows($tableName);
	}

	private function SetError($errorMessage = "", $errorNumber = 0) 
	{
		try 
		{
			if (strlen($errorMessage) > 0) 
			{
				$this->error_desc = $errorMessage;
			}else 
			{
				if ($this->IsConnected()) 
				{
					$this->error_desc = mysql_error($this->mysql_link);
				} else 
				{
					$this->error_desc = mysql_error();
				}
			}
			if ($errorNumber <> 0) 
			{
				$this->error_number = $errorNumber;
			} else 
			{
				if ($this->IsConnected()) 
				{
					$this->error_number = @mysql_errno($this->mysql_link);
				} else 
				{
					$this->error_number = @mysql_errno();
				}
			}
		} catch(Exception $e) 
		{
			$this->error_desc = $e->getMessage();
			$this->error_number = -999;
		}
		if ($this->ThrowExceptions) 
		{
			if (isset($this->error_desc) && $this->error_desc != NULL) 
			{
				throw new Exception($this->error_desc . ' (' . __LINE__ . ')');
			}
		}
	}

	static public function SQLBooleanValue($value, $trueValue, $falseValue, $datatype = self::SQLVALUE_TEXT) 
	{
		if (self::GetBooleanValue($value)) 
		{
		   $return_value = self::SQLValue($trueValue, $datatype);
		} else 
		{
		   $return_value = self::SQLValue($falseValue, $datatype);
		}
		return $return_value;
	}

	static public function SQLFix($value) 
	{
		return @addslashes($value);
	}

	static public function SQLUnfix($value) 
	{
		return @stripslashes($value);
	}

	static public function SQLValue($value, $datatype = self::SQLVALUE_TEXT) 
	{
		$return_value = "";

		switch (strtolower(trim($datatype))) 
		{
			case "text":
			case "string":
			case "varchar":
			case "char":
			{
				if (strlen($value) == 0) 
				{
					$return_value = "NULL";
				} else 
				{
					if (get_magic_quotes_gpc()) 
					{
						$value = stripslashes($value);
					}else
					{ 
						$value = addslashes($value); 
					} 
					$return_value = "'" . str_replace("'", "''", $value) . "'";
				}
				break;
			}
			case "number":
			case "integer":
			case "int":
			case "double":
			case "float":
			{
				if (is_numeric($value)) 
				{
					$return_value = $value;
				} else 
				{
					$return_value = "NULL";
				}
				break;
			}
			case "boolean":  
			case "bool":
			case "bit":
			{
				if (self::GetBooleanValue($value)) 
				{
				   $return_value = "1";
				} else {
				   $return_value = "0";
				}
				break;
			}
			case "y-n":  
				if (self::GetBooleanValue($value)) 
				{
					$return_value = "'Y'";
				} else 
				{
					$return_value = "'N'";
				}
				break;
			case "t-f":  
				if (self::GetBooleanValue($value)) 
				{
					$return_value = "'T'";
				} else 
				{
					$return_value = "'F'";
				}
				break;
			case "date":
				if (self::IsDate($value)) 
				{
					$return_value = "'" . date('Y-m-d', strtotime($value)) . "'";
				} else 
				{
					$return_value = "NULL";
				}
				break;
			case "datetime":
				if (self::IsDate($value)) 
				{
					$return_value = "'" . date('Y-m-d H:i:s', strtotime($value)) . "'";
				} else 
				{
					$return_value = "NULL";
				}
				break;
			case "time":
				if (self::IsDate($value)) 
				{
					$return_value = "'" . date('H:i:s', strtotime($value)) . "'";
				} else 
				{
					$return_value = "NULL";
				}
				break;
			default:
				exit("ERROR: Invalid data type specified in SQLValue method");
		}
		return $return_value;
	}

	public function TimerDuration($decimals = 4) 
	{
		return number_format($this->time_diff, $decimals);
	}

	public function TimerStart() 
	{
		$parts = explode(" ", microtime());
		$this->time_diff = 0;
		$this->time_start = $parts[1].substr($parts[0],1);
	}

	public function TimerStop() 
	{
		$parts  = explode(" ", microtime());
		$time_stop = $parts[1].substr($parts[0],1);
		$this->time_diff  = ($time_stop - $this->time_start);
		$this->time_start = 0;
	}

	public function TransactionBegin() 
	{
		$this->ResetError();
		if (! $this->IsConnected()) 
		{
			$this->SetError("No connection");
			return false;
		} else 
		{
			if (! $this->in_transaction) 
			{
				if (! mysql_query("START TRANSACTION", $this->mysql_link)) 
				{
					$this->SetError();
					return false;
				} else 
				{
					$this->in_transaction = true;
					return true;
				}
			} else 
			{
				$this->SetError("Already in transaction", -1);
				return false;
			}
		}
	}

	public function TransactionEnd() 
	{
		$this->ResetError();
		if (! $this->IsConnected()) 
		{
			$this->SetError("No connection");
			return false;
		} else 
		{
			if ($this->in_transaction) 
			{
				if (! mysql_query("COMMIT", $this->mysql_link)) 
				{
					$this->SetError();
					return false;
				} else 
				{
					$this->in_transaction = false;
					return true;
				}
			} else 
			{
				$this->SetError("Not in a transaction", -1);
				return false;
			}
		}
	}

	public function TransactionRollback() 
	{
		$this->ResetError();
		if (! $this->IsConnected()) 
		{
			$this->SetError("No connection");
			return false;
		} else 
		{
			if(! mysql_query("ROLLBACK", $this->mysql_link)) 
			{
				$this->SetError("Could not rollback transaction");
				return false;
			} else 
			{
				$this->in_transaction = false;
				return true;
			}
		}
	}

	public function TruncateTable($tableName) 
	{
		$this->ResetError();
		if (! $this->IsConnected()) 
		{
			$this->SetError("No connection");
			return false;
		} else 
		{
			$sql = "TRUNCATE TABLE `" . $tableName . "`";
			if (! $this->Query($sql)) 
			{
				return false;
			} else 
			{
				return true;
			}
		}
	}

	public function UpdateRows($tableName, $valuesArray, $whereArray = null) 
	{
		$this->ResetError();
		if (! $this->IsConnected()) 
		{
			$this->SetError("No connection");
			return false;
		} else 
		{
			$sql = self::BuildSQLUpdate($tableName, $valuesArray, $whereArray);
			if (! $this->Query($sql)) 
			{
				return false;
			} else 
			{
				return true;
			}
		}
	}
}
?>