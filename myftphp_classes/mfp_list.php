<?php
// collection class for (files/dirs/)anything?
// basically an enhanced array
// concrete!
// implements iteratorAggregate, aggregates mfp_iterator
// > allows foreach(mfp_list as $item)

class mfp_list implements IteratorAggregate {
	protected $list = array();
	protected $count = 0;

	// construct list with given array
	public function __construct(array $a = array()) {
		$this->append($a);
	}

	// getIterator() required by IteratorAggregate interface:
	// aggregates iterator class
	public function getIterator() { return new mfp_iterator($this->list); }

	// TODO
	// calls function with each item  !!!security !!!revise
	// doesn't work with language constructs like:
	// array, echo, empty, eval, exit, isset, list, print, unset, include, require, ...
	public function __call($f, $args) {
		// applies $method to every $item in $this->list
		$this->list = array_map($f, $this->list);
	}

	// clears list
	public function clear() {
		$this->list = array();
		$this->count = 0;
	}
	// adds single item to array
	public function add($item) {
		$this->list[$this->count++] = $item;
	}
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
		$this->list = array_merge($this->list, array_values($a));
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
		if(!(empty($param) || empty($this->list))) {
			$tosort = substr($param, 1);
			// $this->items[0] is pattern of saved struct. should be the same for every other item too
			$tosort = array_key_exists($tosort, $this->list[0]) ? $tosort : 'name';
			$order  = $param{0};
			$order  = $order == '-' ? SORT_DESC : SORT_ASC;
			// array needs to be restructured for this
			// switch rows <-> columns
			foreach ($this->list as $item => $props) {
				foreach($props as $prop => $val) {
					${$prop}[$item] = $insensitive ? strtolower($val) : $val;
				}
			}
			array_multisort($$tosort, $order, $this->list);
		}
	}
	
	// returns count of list
	public function count() {
		return $this->count;
	}
	// simply returns array
	public function getArray() {
		return $this->list;
	}
}
?>