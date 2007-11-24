<?
// collection class for (files/dirs/)anything?
// concrete!
// implements iteratorAggregate, aggregates mfp_iterator

class mfp_list implements IteratorAggregate {
	protected $items = array();
	protected $count = 0;

	// getIterator() required by IteratorAggregate interface:
	// aggregates iterator class
	public function getIterator() { return new mfp_iterator($this->items); }

	// calls function with each item  !!!security
	// doesn't work with language constructs like:
	// 	echo, print, unset, isset, empty, include, require, return, ...
	public function __call($f, $args) {
		// applies $method to every $item in $this->list
		array_map($f, $this->items);
		// foreach($this) because of iterator
		/*foreach($this as $item) {
			$f($item);
		}*/
	}

	// adds single item to array
	public function add($item) { $this->items[$this->count++] = $item; }
	// pushes items to array, uses $this->add($item) internally :)
	// push(item1, item2, item3, item...)
	public function push($args) {
		$args = func_get_args();
		foreach($args as $arg) {
			$this->add($arg);
		}
	}
	/*public function unset($item) {
		//no need atm;
	}*/

	// sort list items, experimental -- but seems to work quite reasonable
	//
	// list [item1 [prop1,prop2,prop3],
	//       item2 [prop1,prop2,prop3],
	//       item3 [prop1,prop2,prop3]]
	// $list->sort('+prop2'): sorts list by ascending prop2.
	public function sort($param, $insensitive = true) {
		if(!(empty($param) || empty($this->list))) {
			$tosort = substr($param, 1);
			$tosort = array_key_exists($tosort, $this->list[0]) ? $tosort : 'name';
			$order  = $param{0};
			$order  = $order == '-' ? SORT_DESC : SORT_ASC;
			// array needs to be restructured for this
			// switch rows <-> columns
			// $this works because of iterator
			foreach ($this as $item => $props) {
				foreach($props as $prop => $val) {
					${$prop}[$item] = $insensitive ? strtolower($val) : $val;
				}
			}
			array_multisort($$tosort, $order, $this->list);
		}
	}
}
?>