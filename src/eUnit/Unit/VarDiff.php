<?php
namespace eUnit\Unit;

trait VarDiff {
	public function diff($from, $to) {
		$buffer= "--- Expected\n+++ Actual\n";
		$diff = $this->diffToArray($from, $to);
		
		$inOld = false;
		$i     = 0;
		$old   = array();
		
		foreach ($diff as $line) {
			if ($line[1] ===  0 /* OLD */) {
				if ($inOld === false) {
					$inOld = $i;
				}
			}
			elseif ($inOld !== false) {
				if (($i - $inOld) > 5) {
					$old[$inOld] = $i - 1;
				}
		
				$inOld = false;
			}
		
			++$i;
		}
		
		$start = isset($old[0]) ? $old[0] : 0;
		$end   = count($diff);
		$i     = 0;
		
		if ($tmp = array_search($end, $old)) {
			$end = $tmp;
		}
		
		$newChunk = true;
		
		for ($i = $start; $i < $end; $i++) {
			if (isset($old[$i])) {
				$buffer  .= "\n";
				$newChunk = true;
				$i        = $old[$i];
			}
		
			if ($newChunk) {
				$buffer  .= "@@ @@\n";
				$newChunk = false;
			}
		
			if ($diff[$i][1] === 1 /* ADDED */) {
				$buffer .= '+' . $diff[$i][0] . "\n";
			}
			elseif ($diff[$i][1] === 2 /* REMOVED */) {
				$buffer .= '-' . $diff[$i][0] . "\n";
			}
			else {
				$buffer .= ' ' . $diff[$i][0] . "\n";
			}
		}
		
		return $buffer;
	}
	
	public function diffToArray($from, $to) {
		preg_match_all('(\r\n|\r|\n)', $from, $fromMatches);
		preg_match_all('(\r\n|\r|\n)', $to, $toMatches);
		
		if (is_string($from)) {
			$from = preg_split('(\r\n|\r|\n)', $from);
		}
		
		if (is_string($to)) {
			$to = preg_split('(\r\n|\r|\n)', $to);
		}
		
		$start      = array();
		$end        = array();
		$fromLength = count($from);
		$toLength   = count($to);
		$length     = min($fromLength, $toLength);
		
		for ($i = 0; $i < $length; ++$i) {
			if ($from[$i] === $to[$i]) {
				$start[] = $from[$i];
				unset($from[$i], $to[$i]);
			}
			else {
				break;
			}
		}
		
		$length -= $i;
		
		for ($i = 1; $i < $length; ++$i) {
			if ($from[$fromLength - $i] === $to[$toLength - $i]) {
				array_unshift($end, $from[$fromLength - $i]);
				unset($from[$fromLength - $i], $to[$toLength - $i]);
			}
			else {
				break;
			}
		}
		
		$common = $this->longestCommonSubsequence(array_values($from), array_values($to));
		
		$diff = array();
		$line = 0;
		
		if (isset($fromMatches[0]) && $toMatches[0] &&
		count($fromMatches[0]) === count($toMatches[0]) &&
		$fromMatches[0] !== $toMatches[0]) {
			$diff[] = array('#Warning: Strings contain different line endings!', 0);
		}
		
		foreach ($start as $token) {
			$diff[] = array($token, 0 /* OLD */);
		}
		
		reset($from);
		reset($to);
		
		foreach ($common as $token) {
			while ((($fromToken = reset($from)) !== $token)) {
				$diff[] = array(array_shift($from), 2 /* REMOVED */);
			}
		
			while ((($toToken = reset($to)) !== $token)) {
				$diff[] = array(array_shift($to), 1 /* ADDED */);
			}
		
			$diff[] = array($token, 0 /* OLD */);
		
			array_shift($from);
			array_shift($to);
		}
		
		while (($token = array_shift($from)) !== NULL) {
			$diff[] = array($token, 2 /* REMOVED */);
		}
		
		while (($token = array_shift($to)) !== NULL) {
			$diff[] = array($token, 1 /* ADDED */);
		}
		
		foreach ($end as $token) {
			$diff[] = array($token, 0 /* OLD */);
		}
		
		return $diff;
	}
	
	protected function longestCommonSubsequence(array $from, array $to) {
		$common     = array();
		$matrix     = array();
		$fromLength = count($from);
		$toLength   = count($to);
		
		for ($i = 0; $i <= $fromLength; ++$i) {
			$matrix[$i][0] = 0;
		}
		
		for ($j = 0; $j <= $toLength; ++$j) {
			$matrix[0][$j] = 0;
		}
		
		for ($i = 1; $i <= $fromLength; ++$i) {
			for ($j = 1; $j <= $toLength; ++$j) {
				$matrix[$i][$j] = max(
						$matrix[$i-1][$j],
						$matrix[$i][$j-1],
						$from[$i-1] === $to[$j-1] ? $matrix[$i-1][$j-1] + 1 : 0
				);
			}
		}
		
		$i = $fromLength;
		$j = $toLength;
		
		while ($i > 0 && $j > 0) {
			if ($from[$i-1] === $to[$j-1]) {
				array_unshift($common, $from[$i-1]);
				--$i;
				--$j;
			}
			elseif ($matrix[$i][$j-1] > $matrix[$i-1][$j]) {
				--$j;
			}
			else {
				--$i;
			}
		}
		
		return $common;
	}
}
?>