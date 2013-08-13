<?php
/* 
 * stdDBIter
 * Standardised Iterator for Database result sets
 *
 * @author Christopher Seufert <seufert@gmail.com>
 * @package komma
 * @version $Revision $
 */

abstract class stdDBIter implements Iterator {
  /**
   * MySQL Result
   * @var resource MySQL Result
   */
  protected $result;
  /**
   * Iterator Item
   * @var mixed
   */
  protected $item;
  /**
   * Total record count
   * @var integer 
   */
  protected $count;
  /**
   * Object that performs query
   * @var object
   */
  protected $object;
  /**
   * Create new DB Iterator
   * 
   * @param resource $result MySQL Result Set
   */
  function __construct($obj) {
    $this->object = $obj;
    $this->result = $this->object->getResult();
    $this->count = mysql_num_rows($this->result);
  }

  /**
   * Iterator Function to move to next record
   */
  public function next() {
    $this->getNext();
  }
  /**
   * Resets list, back to first item
   */
  public function rewind() {
    if($this->count < 1) return;
    mysql_data_seek($this->result, 0);
    $this->getNext();
  }
  /**
   * Seek to any position in results
   * @param int $i Position
   */
  public function seek($i) {
    if($this->count < 1) return;
    if($this->count <= $i) Throw New Exception("Cannot seek past end of results");
    mysql_data_seek($this->result, $i - 1);
    $this->getNext();
  }
  /**
   * Move list pointer to last item
   */
  public function toLast() {
    if($this->count < 1) return;
    mysql_data_seek($this->result, $this->count - 1);
    $this->getNext();
  }
  /**
   * User function to retreive the next result, and process it into $item
   */
  abstract protected function getNext();  
  /**
   * Return the Current Item that the iterator points to
   * @return kommaRequest
   */
  public function current() {
    return $this->item;
  }
  /**
   * Retreives key (id) for this item
   * @return mixed Current ID/Position 
   */
  public function key() {
    return $this->item->getID();
  }
  /**
   * Returns whether current item is a real item, or EOL
   * 
   * @return bool Current item is valid 
   */
  public function valid() {
    if($this->count < 1) return FALSE;
    return $this->item !== FALSE;
  }
  
  public function getCount() {
    return $this->count;
  }

}
?>