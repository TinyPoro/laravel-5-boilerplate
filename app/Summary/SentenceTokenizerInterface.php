<?php
/**
 * Created by PhpStorm.
 * User: hocvt
 * Date: 3/28/18
 * Time: 14:52
 */

namespace App\Summary;


interface SentenceTokenizerInterface {
	
	/**
	 * SentenceTokenizerInterface constructor.
	 */
	public function __construct($language = 'vi');
	
	public function setContent($content);
	
	public function getSentences();
	
}