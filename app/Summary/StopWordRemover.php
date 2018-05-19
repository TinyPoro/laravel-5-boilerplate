<?php
/**
 * Created by PhpStorm.
 * User: hocvt
 * Date: 3/27/18
 * Time: 14:59
 */

namespace App\Summary;


use voku\helper\StopWords;

class StopWordRemover {
	
	protected $stop_words = [];
	
	/**
	 * StopWordRemover constructor.
	 *
	 * @param string $language
	 */
	public function __construct($language) {
		$stopword = new StopWords();
		$words = $stopword->getStopWordsFromLanguage($language);
		foreach ($words as $word){
			$this->stop_words[] = " " . $word . " ";
		}
	}
	
	public function remove($content){
		$content = str_ireplace($this->stop_words, " ", $content);
		$content = trim( $content);
		$content = preg_replace( "/\s\s+/", " ", $content);
		return $content;
	}
	
}