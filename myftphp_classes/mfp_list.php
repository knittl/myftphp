<?php
// collection class for (files/dirs/)anything?
// basically an enhanced array
// concrete!
// implements iteratorAggregate, aggregates mfp_iterator
// > allows foreach(mfp_list as $item)

class mfp_list implements IteratorAggregate {
	protected $list  = array();
	protected $count = 0;

	// construct list with given array
	public function __construct(array $a = array()) {
		$this->append($a);
	}

	// getIterator() required by IteratorAggregate interface:
	// aggregates iterator class
	public function getIterator() { return new mfp_iterator($this->list); }

	// calls function on each item
	// important: passed parameters are passed by value
	// doesn't work with language constructs like:
	// array, echo, empty, eval, exit, isset, list, print, unset, include, require, ...
	// TODO: use return value of call_user_func_array?
	public function __call($f, $a) {
		// applies $f to every $item in $this->list with parameters contained in $a
		foreach($this->list as &$item) {
			// by-reference to allow manipulation
			array_unshift($a, $item); // add $item as first function parameter
			#$item = call_user_func_array($f, $a); // call function and save result back
			call_user_func_array($f, $a); // call function, but do not care about return value
			array_shift($a); // remove $item from array
		}
		// return new array
		return $this->list;
	}

	// returns serialized list array
	public function __toString() {
		return serialize($this->list);
	}

	// serialize only array
	public function __sleep() {
		return array('list');
	}
	// re-count list
	public function __wakeup() {
		$this->count = count($this->list);
	}

	// same as __call, but calls method on object-references
	public function method($f) {
		$a = func_get_args();
		array_shift($a); // remove first element: $f
		foreach($this->list as &$item) {
			// by-reference to allow manipulation
			// $list->item->$f($a[0], $a[1], ...)
			call_user_func_array(array($item, $f), $a);
		}
		// return new array
		return $this->list;
	}

	// clears list
	public function clear() {
		$this->list = array();
		$this->count = 0;
	}
	// adds one or more items to array
	public function add($items) {
		foreach(func_get_args() as $item) {
			$this->list[$this->count++] = $item;
		}
	}
	// appends external array(s)
	public function append(array $a) {
		foreach(func_get_args() as $a) {
			$this->list = array_merge($this->list, array_values($a));
			$this->count += count($a);
		}
	}

	// sort list items per column, experimental -- but seems to work quite reasonable
	//
	// list [item1 [prop1,prop2,prop3],
	//       item2 [prop1,prop2,prop3],
	//       item3 [prop1,prop2,prop3]]
	// $list->sort('+prop2'): sorts list by ascending prop2.
	// see <http://php.net/array_multisort> for more info
	public function sort($param, $insensitive = true) {
		if(!(empty($param) || empty($this->list))) {
			$sortby = substr($param, 1);
			// $this->items[0] is pattern of saved struct. should be the same for every other item too
			//$sortby = array_key_exists($tosort, $this->list[0]) ? $tosort : 'name';
			$order  = $param{0};
			$order  = $order == '-' ? SORT_DESC : SORT_ASC;
			// array needs to be restructured for this
			// switch rows <-> columns
			foreach ($this->list as $item => $props) {
				foreach($props as $prop => $val) {
					${$prop}[$item] = $insensitive ? strtolower($val) : $val;
				}
			}
			array_multisort($$sortby, $order, $this->list);
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
