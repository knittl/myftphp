<?
// iterator class
// must be concrete?
class mfp_iterator implements Iterator {
	private $array = array();
	
	public function __construct($array)	{
		if (is_array($array)) $this->array = $array;
	}

	public function rewind() { reset($this->array); }
	public function current() { return current($this->array); }
	public function key() { return key($this->array); }
	public function next() { return next($this->array); }
	public function valid() {	return $this->current() !== FALSE; }
}
?>