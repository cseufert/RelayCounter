<?php
/**
 * Standard Database Helper Class
 *
 * @package std
 * @version $Revision: 447 $
 * @author Christopher Seufert <seufert@gmail.com>
 */
class stdDB {
  /**
   * MySQL Link Identifier
   * @var resource MySql Link Identifier
   */
  protected static $link;

  /**
   * Execute a MySQL Query
   * @param string $q SQL Query String
   * @return resource MySQL Result
   */
  static function query($q) {
    $r = @mysql_query($q,self::$link);
    if(!$r) {
      if(!isset(self::$link) || mysql_errno(self::$link) == 2006) { //Lost Connection
        self::connect();
        $r = mysql_query($q, self::$link);
        if(!$r) {
          throw new Exception("Query Failed to execute\n".
                  mysql_error(self::$link)."\n$q", mysql_errno(self::$link));
        } else
          return $r;
      } else {
        throw new Exception("Query Failed to execute\n".
                mysql_error(self::$link)."\n$q", mysql_errno(self::$link));
      }
    }
    return $r;
  }

  /**
   * Escape text for insertion into mysql query
   *
   * @param string $s String to escape
   * @return string Escaped String
   */
  static function escape($s) {
    if(!isset(self::$link)) self::connect();
    return mysql_real_escape_string($s);
  }
  /**
   * Return number of rows from MySQL Query
   * @param resource MySQL Result $r
   * @return int
   */
  static function numRows($r) {
    if(!isset(self::$link)) self::connect();
    if(!is_resource($r))
      throw new Exception ("$r is not a resource.");
    if(!$tot = mysql_num_rows($r))
      throw new Exception ("Unable to get total number of rows from result $r");
    return $tot;
  }
  /**
   * Perform SQL Insert query and return insert id
   *
   * @param string $q SQL Query String for INSERT Query
   * @return id Insert ID from Primary Key
   */
  static function insert($q) {
    self::query($q);
    return mysql_insert_id(self::$link);
  }

  /**
   * Peform SQL Insert, by creating the query from assoc array
   * 
   * @param string $table SQL Table Name
   * @param array $cols Associative array of column data (col => data)
   * @return int Auto Number ID
   */
  static function insertArray($table, $cols) {
    if(!count($cols)) return false;
    $q = "INSERT INTO `$table` SET ".self::arrayToSQL($cols);
    return self::insert($q);
  }

  /**
   * Peform SQL Update, by creating query from assoc array
   * 
   * @param string $table SQL Table Name
   * @param array $cols Associative array of column data (col => data)
   * $param string $where SQL Where clause
   */
  static function updateArray($table, $cols, $where ) {
    if(!count($cols)) return false;
    $q = "UPDATE `$table` SET ".self::arrayToSQL($cols)." WHERE $where";
    return self::query($q);
  }

  static function deleteArray($table, $cols) {
    if(!count($cols)) return false;
    $q = "DELETE FROM `$table` WHERE ".self::arrayToSQL($cols, " AND ");
    return self::query($q);
  }
  
  
  static protected function arrayToSQL($cols, $delim = ", ") {
    $col = array();
    foreach($cols as $k=>$v) {
      if(is_object($v)) {
        if($v instanceOf stdDate)
          $col[] = "`$k` = '".$v->toSQLDate()."'";
        elseif($v instanceOf inUser)      
          $col[] = "`$k` = '".$v->getUID()."'";
        elseif(property_exists($v, "getID"))      
          $col[] = "`$k` = '".$v->id."'";
        elseif(method_exists($v, "__toString"))
          $col[] = "`$k` = '".self::escape($v->__toString())."'";
        else
          Throw New Exception("Unable to convert object to text.\n".
                                    print_r($v,true));
      } elseif($v == "now()") {
        $col[] = "`$k` = now()";
      } else
        $col[] = "`$k` = '".self::escape($v)."'";
    }
    return implode($delim, $col);
  }
  /**
   * Perform SQL SELECT query, only returning the first row
   *
   * @param string $q SQL Query string for SELECT Query
   * @return Array Assiciative Array of columns from first query result
   */
  static function selectOne($q) {
    return mysql_fetch_assoc(self::query($q));
  }

  /**
   * Connect to SQL Database
   * 
   * @return bool True on already connected
   */
  static function connect() {

    if(isset(self::$link) && mysql_ping(self::$link))
        return true;
    self::$link = mysql_connect(stdConf::getValue("std.db.host",true),
                                stdConf::getValue("std.db.user",true),
                                stdConf::getValue("std.db.pass",true),
                                true);
    mysql_select_db(stdConf::getValue("std.db.db",true), self::$link);
  }

}

?>
