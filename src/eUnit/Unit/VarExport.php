<?php
namespace eUnit\Unit;

trait VarExport {
	public function export($value) {
		return $this->recursiveExport($value);
	}
	
	public function recursiveExport($value, $indentation = 0, &$processedObjects = array()) {
		if ($value === NULL) {
			return 'null';
		}
		
		if ($value === TRUE) {
			return 'true';
		}
		
		if ($value === FALSE) {
			return 'false';
		}
		
		if (is_string($value)) {
			if (preg_match('/[^\x09-\x0d\x20-\xff]/', $value)) {
				return 'Binary String: 0x' . bin2hex($value);
			}
		
			return "'" .
					str_replace(array("\r\n", "\n\r", "\r"), array("\n", "\n", "\n"), $value) .
					"'";
		}
		
		$origValue = $value;
		
		if (is_object($value)) {
			if (in_array($value, $processedObjects, TRUE)) {
				return sprintf(
						'%s Object (*RECURSION*)',
						get_class($value)
				);
			}
		
			$processedObjects[] = $value;
		
			// Convert object to array
			$value = $this->toArray($value);
		}
		
		if (is_array($value)) {
			$whitespace = str_repeat('    ', $indentation);
		
			// There seems to be no other way to check arrays for recursion
			// http://www.php.net/manual/en/language.types.array.php#73936
			preg_match_all('/\n            \[(\w+)\] => Array\s+\*RECURSION\*/', print_r($value, TRUE), $matches);
			$recursiveKeys = array_unique($matches[1]);
		
			// Convert to valid array keys
			// Numeric integer strings are automatically converted to integers
			// by PHP
			foreach ($recursiveKeys as $key => $recursiveKey) {
				if ((string)(integer) $recursiveKey === $recursiveKey) {
					$recursiveKeys[$key] = (integer) $recursiveKey;
				}
			}
		
			$content = '';
		
			foreach ($value as $key => $val) {
				if (in_array($key, $recursiveKeys, TRUE)) {
					$val = 'Array (*RECURSION*)';
				}
				else {
					$val = $this->recursiveExport($val, $indentation + 1, $processedObjects);
				}
		
				$content .= $whitespace . '    ' . $this->export($key) . ' => ' . $val . "\n";
			}
		
			if (strlen($content) > 0) {
				$content = "\n" . $content . $whitespace;
			}
		
			return sprintf(
					"%s (%s)",
					is_object($origValue) ? get_class($origValue) . ' Object' : 'Array',
					$content
			);
		}
		
		if (is_double($value) && (double)(integer) $value === $value) {
			return $value . '.0';
		}
		
		return (string) $value;
	}
	
	public function shortenedString($string, $length = 40) {
		$string = $this->export($value);
		
		if (strlen($string) > $length) {
			$string = substr($string, 0, $length - 10) . '...' . substr($string, -7);
		}
		
		return str_replace("\n", '\n', $string);
	}
	
	public function shortenedExport($value) {
		if (is_string($value)) {
			return $this->shortenedString($value);
		}
		
		if (is_object($value)) {
			return sprintf('%s Object (%s)', get_class($value), count($this->toArray($value)) > 0 ? '...' : '');
		}
		
		if (is_array($value)) {
			return sprintf('Array (%s)', count($value) > 0 ? '...' : '');
		}
		
		return $this->export($value);
	}
	
	public function toArray($object) {
		$array = array();
		
		foreach ((array) $object as $key => $value) {
			// properties are transformed to keys in the following way:
		
			// private   $property => "\0Classname\0property"
			// protected $property => "\0*\0property"
			// public    $property => "property"
		
			if (preg_match('/^\0.+\0(.+)$/', $key, $matches)) {
				$key = $matches[1];
			}
		
			$array[$key] = $value;
		}
		
		// Some internal classes like SplObjectStorage don't work with the
		// above (fast) mechanism nor with reflection
		// Format the output similarly to print_r() in this case
		if ($object instanceof SplObjectStorage) {
			foreach ($object as $key => $value) {
				$array[spl_object_hash($value)] = array(
						'obj' => $value,
						'inf' => $object->getInfo(),
				);
			}
		}
		
		return $array;
	}
}
?>