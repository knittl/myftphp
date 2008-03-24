<?
// collection class for (files/dirs/)anything?
// concrete!
// implements iteratorAggregate, aggregates mfp_iterator
// > allows foreach(mfp_list as $item)

class mfp_list implements IteratorAggregate {
	protected $items = array();
	protected $count = 0;

	// construct list with given array
	public function mfp_list(array $a = array()) {
		$this->append($a);
	}

	// getIterator() required by IteratorAggregate interface:
	// aggregates iterator class
	public function getIterator() { return new mfp_iterator($this->items); }

	// calls function with each item  !!!security !!!revise
	// doesn't work with language constructs like:
	// 	array, echo, empty, eval, exit, isset, list, print, unset, include, require, ...
	public function __call($f, $args) {
		// applies $method to every $item in $this->list
		$this->items = array_map($f, $this->items);
		// foreach($this) because of iterator
		/*foreach($this as $item) {
			$f($item);
		}*/
		/*foreach($this as $item) {
			$item->$f; // with classes
		}*/	}

	// clears list
	public function clear() {
		$this->items = array();
		$this->count = 0;
	}
	// adds single item to array
	public function add($item) { $this->items[$this->count++] = $item; }
	// pushes several items at one time into list, uses $this->add($item) internally :)
	// push(item1, item2, item3, item...)
	public function push($args) {
		$args = func_get_args();
		foreach($args as $arg) {
			$this->add($arg);
		}
	}
	// append external array
	public function append(array $a) {
		$this->items = array_merge($this->items, array_values($a));
		$this->count += count($a);
	}
	/*public function unset($item) {
		//no need atm;
	}*/

	// sort list items per column, experimental -- but seems to work quite reasonable
	//
	// list [item1 [prop1,prop2,prop3],
	//       item2 [prop1,prop2,prop3],
	//       item3 [prop1,prop2,prop3]]
	// $list->sort('+prop2'): sorts list by ascending prop2.
	public function sort($param, $insensitive = true) {
		if(!(empty($param) || empty($this->items))) {
			$tosort = substr($param, 1);
			// $this->items[0] is pattern of saved struct. should be the same for every other item too
			$tosort = array_key_exists($tosort, $this->items[0]) ? $tosort : 'name';
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
			array_multisort($$tosort, $order, $this->items);
		}
	}
	
	// returns length of $this->items
	public function count() {
		return $this->count;
	}
	// simply returns array
	public function getArray() {
		return $this->items;
	}
}
?>