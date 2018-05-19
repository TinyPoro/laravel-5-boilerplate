<?php
namespace App\Summary;

class SentenceTokenizer implements SentenceTokenizerInterface {
	private $content = null;
	
	/**
	 * SentenceTokenizer constructor.
	 */
	public function __construct( $language = 'vi' ) {
	}
	
	
	public function setContent( $content ) {
		$this->content = $content;
	}
	
	public function getSentences() {
		
		if ( ! trim( $this->content ) ) {
			return [];
		}
		
		$contentParts = preg_split( "/([\.\!\?])+/", $this->content, - 1, PREG_SPLIT_DELIM_CAPTURE );
		
		$sentences = [];
		
		for ( $i = 0; $i < count( $contentParts ); $i += 2 ) {
			
			if ( ! isset( $contentParts[ $i + 1 ] ) ) {
				break;
			}
			
			$sentence = $contentParts[ $i ] . $contentParts[ $i + 1 ];
			$sentence = $this->trim( $sentence );
			$sentences[] = $sentence;
		}
		
		return $sentences;
	}

	public function trim($content){
		$content = trim($content);
		$content = str_replace(PHP_EOL, '', $content);

		return $content;
	}
	
}

?>
