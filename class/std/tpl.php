<?php
 /**
	*	Standard Template Presentation Class
  *
  * Ability for stdClass to be interated for repeated items.
	*
	* @author Christopher Seufert <seufert@gmail.com>
	* @version $Revision: 605 $
	* @package std
	*/
class stdTpl implements Iterator {
	/**
	 * Core Attributes - These attributes are ALWAYS included, even if appedned
   * to template file. Associative array [n][ATTR] = value.
	 */
	protected $coreattr;
	/**
	 * Normal Attributes - These attributes are included when in the template.
	 * Associative Array [n][ATTR] = value.
	 */
	protected $attr;
  /**
   * Position of Iterator
   */
  protected $pos, $max;
	/**
	 * Tpl Attributes - These attributes are read from the template
	 */
	protected $attrlist;
	/**
	 * Template - This is the template loaded into a string
	 */
	protected $tpl;
	/**
	 * Flag Attributes - True/False conditional flags for display blocks
   * Associative Array [n][FLAG] = true/false.
	 */
	protected $flag;
	/**
	 * Sub Templates
	 */
	protected $sub;
  /**
   * Name of Template
   * @var string 
   */
  protected $view;

	/**
	 * Constructor - Create a new stdTpl Object
	 *
	 * @param string The Template as a string
	 * @param array Options array
	 */
	private function __construct($tpl) {
		$this->tpl = $tpl;
    $this->pos = 0;
    $this->max = -1;
		$this->coreattr = array(0=>Array());
		$this->attr = array(0=>Array());
		$this->flag = array(0=>Array());
		$this->attrlist = array();
		$this->flaglist = array();
    $this->sub = array(0=>Array());
    preg_match_all("/__SUB_([A-Z0-9\-]*?)_/", $this->tpl, $m2);
    $sub = array();
    foreach($m2[1] as $match)
      $sub[] = strtolower($match);
    
    while(count($sub)) {
      $k = array_shift($sub);
      $regex = "/__SUB_(".strtoupper($k).")_(.*)_SUB_".strtoupper($k)."__/s";
      if(!preg_match($regex, $this->tpl, $m3))
          throw new Exception("Unable to find closing tag for $k SUB Template");
      $this->sub[0][$k] = new self($m3[2]);
      foreach($this->sub[0][$k]->sub[0] as $k=>$v) {
        unset($sub[array_search($k, $sub)]);
      }
      $this->tpl = preg_replace($regex,"__PRESUB_$1__", $this->tpl);
    }
		preg_match_all("/__IS(NOT){0,1}_([A-Z0-9\-]*?)_/",$this->tpl,$m);
		foreach($m[2] as $match)
			$this->flaglist[] = strtolower($match);
		preg_match_all("/__([A-Z0-9\-]*?)__/",$this->tpl,$m);
		foreach($m[1] as $match)
			$this->attrlist[] = strtolower($match);
	}

 /**
 	*	Open a Template from skin
 	* @param string	$class Class Name
 	* @param string	$name Template Name
  *
	* @return stdTpl Object
	*/
	static function open($class, $file) {
    ///TODO: Skin Selection code
    $path = "skin/default/".$class."/".$file.".html";
    if(!file_exists($path))
      throw new Exception("Unable to find Template File $class/$file.html");
    $tpl = file_get_contents($path);
		$o = new stdTpl($tpl);
    $o->view = $file;
    $o->setAttr(array("TPL"=>$class . "." . $file));
		return $o;
	}
  
  /**
   * Iterator Function - Get current row
   * @return stdTpl Template Object
   */
  public function current() {
    return $this;
  }

  /**
   * Iterator Function - Get key of current row
   * @return int Position
   */
  public function key() {
    return $this->pos;
  }

  /**
   * Iterator Function - Move to next row
   */
  public function next() {
    $this->pos++;
  }

  /**
   * Iterator Function - Move to first row
   */
  public function rewind() {
    $this->pos = 0;
  }

  /**
   * Iterator Funciton - Check current row is available
   * @return bool Position is valid
   */
  public function valid() {
    return ($this->pos <= $this->max);
  }

 /**
 	*	Loads a Template from a string
 	*
 	* @param string	Template as String
	* @return stdTpl Object
	*/
	static function load($tpls) {
		return new stdTpl($tpls);
	}

  /**
   *
   * @param string Sub Template
   * @return stdTpl Template object for Sub Template
   */
  function getSubTpl($name) {
    $name = strtolower($name);
    if(!isset($this->sub[$this->pos])) {
      $this->sub[$this->pos] = array();
      foreach($this->sub[0] as $k=>$v) {
        $this->sub[$this->pos][$k] = new self($v->tpl);
      }
    }
    if(!isset($this->sub[$this->pos][$name]))
            return false;
    return $this->sub[$this->pos][$name];
  }

 /**
	* @return Array of all Attributes found in the current template
	*/
	function getAttr() { return $this->attrlist; }

  /**
	* @return Array of all Flags found in the current template
	*/
	function getFlag() { return $this->flaglist; }
  
  /**
   * @return String of view name 
   */
  function getView() { return $this->view; }
 /**
 	* Add/Set Core Attributes.<br>
 	* Core attributes are attr's that _HAVE_ to be displayed, if a key in the template is not found
 	* they will be appended to the template
	* @param array index is key, data is replacement string
	* @param bool Overwrite all atributes with these ones
	*/
	function setCoreAttr($attr, $clear = FALSE) {
    throw new Exception("Current unable to set core attributes");
    if($this->pos > $this->max) $this->max = $this->pos;
    $a = array();
		foreach($attr as $k=>$v)
			$a[strtolower($k)] = $v;
    if($clear or !isset($this->coreattr[$this->pos]))
      $this->coreattr[$this->pos] = $a;
		else
			$this->coreattr[$this->pos] = array_merge($this->coreattr[$this->pos],$a);
	}

 /**
  * Add/Set Attribute
	* @param Array index is key, data is replacement string
	* @param bool Overwrite all atributes with these ones
	*/
	function setAttr($attr, $clear = FALSE) {
    if($this->pos > $this->max) $this->max = $this->pos;
    $a = array();
		foreach($attr as $k=>$v)
			$a[strtolower($k)] = $v;
		if($clear or !isset($this->attr[$this->pos]))
			$this->attr[$this->pos] = $a;
		else
			$this->attr[$this->pos] = array_merge($this->attr[$this->pos],$a);
	}

	function setFlag($flag,$v) {
    if($this->pos > $this->max) $this->max = $this->pos;
    $flag = strtolower($flag);
		$this->flag[$this->pos][$flag] = $v;
	}

 	/**
  	* Magic Method for string Conversion
  	*
	* @return Object converted to the correct output string
	*/
	function __toString() { return $this->toString(); }

 /**
  * Method for Conversion to a String
  *
	* @return Object converted to the correct output string
	*/
	function toString() {
		$o = "";
    $this->rewind();
    while($this->valid()) {
      $out = $this->tpl;
      foreach($this->flaglist as $v) {
        $f = (isset($this->flag[$this->pos][strtolower($v)])?
                                 $this->flag[$this->pos][strtolower($v)]:false);
        $out = preg_replace("/__IS_".strtoupper($v)."_(.*?)_IS_".strtoupper($v)."__/s", ($f?"$1":""), $out);
        $out = preg_replace("/__ISNOT_".strtoupper($v)."_(.*?)_ISNOT_".strtoupper($v)."__/s", ($f?"":"$1"), $out);
      }
      $out = preg_replace_callback('/__([A-Z0-9\-]+)__/s',array($this,'cbAttr'),$out);
      $out = preg_replace_callback('/__PRESUB_([A-Z0-9\-]+)__/',array($this,'cbSub'),$out);
      $o .= $out;
      $this->next();
    }
		return $o;
	}

  protected function cbAttr($match) {
    if(isset($this->attr[$this->pos][strtolower($match[1])]))
      return $this->attr[$this->pos][strtolower($match[1])];
    return "";
  }

  protected function cbSub($match) {
    if(isset($this->sub[$this->pos][strtolower($match[1])]))
      return $this->sub[$this->pos][strtolower($match[1])]->toString();
    return "";
  }

} ?>