<?php
namespace App\Summary;

class SummaryTool {
	
	private $content;
	private $stop_word_remover;
	private $sentence_tokenizer;
	private $tokenizer;
	private $sentences = [
//		[// đoạn 1
//			"câu 1",
//			"câu 2",
//		],
//		[// đoạn 2
//			"câu 1",
//			"câu 2",
//		],
	];
	private $ranking = [
//		"0.0" => 1,
//		"0.1" => 2,
//		"1.0" => 3,
//		"1.1" => 1,
	];
	private $keywords = [
//		[
//			"keyword" => "tài liệu",
//			"words" => ["tài","liệu"],
//			"length" => 2,
//			"ratio" => 2,//float, số này sẽ được nhân
//		]
	];
	
	private $titles = [
		[
//			"title" => "Luận văn tốt nghiệp ngành thủy sản",
//			"words" => ["Luận","văn","tốt","nghiệp","ngành","thủy","sản"],
//			"length" => 2,
//			"ratio" => 1.2,//float
		]
	];
	
	public function __construct( $content, $language = 'vi', SentenceTokenizerInterface $sentenceTokenizer = null) {
		$this->content = $content;
		
		$this->stop_word_remover = new StopWordRemover( $language );
		if ( $sentenceTokenizer == null ) {
			$this->sentence_tokenizer = new SentenceTokenizer( $language );
		} else {
			$this->sentence_tokenizer = $sentenceTokenizer;
		}
		
		// prepare sentences
		$paragraphs = $this->getParagraphs( $content);
		foreach ($paragraphs as $k => $paragraph){
			$this->sentences[$k] = $this->getSentences( $paragraph);
		}
		
		// compute rank
//		$this->computeSentencesRanks();
	}
	
	/**
	 * @param string|array $keyword
	 * @param int $ratio
	 *
	 * @throws \Exception
	 */
	public function addKeyword($keyword, $ratio = 0){
		if(is_array( $keyword)){
			foreach ($keyword as $v){
				$this->addKeyword( $v[0], $v[1]);
			}
		}elseif ($ratio == 0){
			throw new \Exception("keyword must be an array or string with none zero ratio");
		}else{
			$_keyword = trim( $keyword);
			$_words = explode( " ", $_keyword);
			$_length = count( $_words);
			$this->keywords[] = [
				'keyword' => trim( $keyword),
				'words' => $_words,
				'length' => $_length,
				'ratio' => $ratio,
			];
		}
	}
	
	/**
	 * @param string|array $title
	 * @param int $ratio
	 *
	 * @throws \Exception
	 */
	public function addTitle($title, $ratio = 0){
		if(is_array( $title)){
			foreach ($title as $v){
				$this->addTitle( $v[0], $v[1]);
			}
		}elseif ($ratio == 0){
			throw new \Exception("title must be an array or string with none zero ratio");
		}else{
			$_title = trim( $title);
			$_words = explode( " ", $_title);
			$_length = count( $_words);
			$this->titles[] = [
				'title' => trim( $title),
				'words' => $_words,
				'length' => $_length,
				'ratio' => $ratio,
			];
		}
	}
	
	/**
	 * Phân chia đầu vào thành các đoạn văn
	 *
	 * @param $content
	 *
	 * @return array
	 */
	private function getParagraphs( $content ) {
		return explode( PHP_EOL . PHP_EOL, $content );
	}
	
	/**
	 * Chia đoạn văn thành các câu
	 *
	 * @param $content
	 *
	 * @return array
	 */
	private function getSentences( $content ) {
		$this->sentence_tokenizer->setContent( $content );
		
		return $this->sentence_tokenizer->getSentences();
	}
	
	/**
	 * Đếm từ chung của 2 câu
	 * @param $sent1
	 * @param $sent2
	 *
	 * @return bool|int
	 */
	private function sentencesIntersection( $sent1, $sent2 ) {
		$s1 = $this->tokenize( $sent1 );
		$s2 = $this->tokenize( $sent2 );
		
		if ( count( $s1 ) + count( $s2 ) === 0 ) {
			return true;
		}
		
		$intersect = array_intersect( $s1, $s2 );
		$splicePoint = ( ( count( $s1 ) + count( $s2 ) ) / 2 );
		
		$splicedIntersect = array_splice( $intersect, 0, $splicePoint );
		
		return count( $splicedIntersect );
	}
	
	/**
	 * Tính rank của một câu với các keywords
	 *
	 * @param string $sentence
	 * @param int $current_rank
	 *
	 * @return int
	 */
	private function rankWithKeywords($sentence, $current_rank = 0){
		$addition_rank = 0;
		foreach ($this->keywords as $v){
			$addition_rank += $this->sentencesIntersection($sentence, $v['title']) * $v['ratio'];
		}
		$current_rank += $addition_rank;
		return $current_rank;
	}
	
	/**
	 * Tính rank của một câu với các title
	 *
	 * @param string $sentence
	 * @param int $current_rank
	 *
	 * @return int
	 */
	private function rankWithTitle($sentence, $current_rank = 0){
		$addition_rank = 0;
		foreach ($this->keywords as $v){
			if(strpos( $sentence, $v['keyword']) !== false){// nếu chứa từ mình cần, tăng rank bằng chiều dài nhân với ratio
				$addition_rank += $v['ratio'] * $v['length'];
			}
		}
		$current_rank += $addition_rank;
		return $current_rank;
	}
	
	private function remove_stop_word($sentences){
		$is_array = is_array($sentences);
		if(!$is_array){
			$sentences = [$sentences];
		}
		foreach ($sentences as $k => $sentence){
			$sentences[$k] = $this->stop_word_remover->remove( $sentence);
		}
		if($is_array){
			return $sentences;
		}else{
			return reset( $sentences );
		}
	}
	
	private function tokenize($string){
		if($this->tokenizer == null){
			return explode( " ", $string);
		}
	}
	
	/**
	 * Phân hạng cho các câu trong đoạn văn
	 * @param $content
	 *
	 * @return array
	 */
	public function computeSentencesRanks() {
        $stopword_removed_sentences = [];

		foreach ( $this->sentences as $k => $p ) {
			foreach ( $p as $l => $s ) {	//p:paragraph, s:sentence
				$stopword_removed_sentences[ strval( $k ) . "." . strval( $l ) ] = $this->remove_stop_word( $s );
			}
		}
		$n = count( $stopword_removed_sentences ); //tính tổng số câu
		
		$values = [];
		
		// Assign each score to each sentence
		foreach ($stopword_removed_sentences as $k => $s1){
			$values[ $k ] = 0;
			// tính rank so với cả đoạn
			foreach ($stopword_removed_sentences as $l => $s2){
				$intersection = $this->sentencesIntersection( $s1, $s2 );
				$values[ $k ] += $intersection;
			}
			// tính rank với keyword
			$values[ $k ] = $this->rankWithKeywords($s1, $values[$k]);
			// tính rank với title
            $values[ $k ] = $this->rankWithTitle($s1, $values[$k]);
		}
		
		return $values;
	}


    /**
	 * Lấy ra câu có hạng cao nhất của 1 đoạn văn
	 * @param $paragraph_number
	 * @param $rate
	 *
	 * @return null|array
	 */
	private function getBestSentences( $paragraph_number, $rate ) {
		$sentences = $this->sentences[$paragraph_number];

		if ( count( $sentences ) == 0 ) {
			return $sentences;
		}

        $n = ceil(count($sentences) * $rate);
		
		$scores = [];
		$bestSentence = null;

		$temp = false;

        foreach ( $this->ranking as $key => $sentenceScore ) {
        	if(preg_match('/^'.$paragraph_number.'\./', $key)) {
        		$temp = true;

        		$scores[] = $sentenceScore;
            }else if($temp) break;
        }

        arsort($scores);
        $best_indexs = array_slice(array_keys($scores), 0, $n);
        sort($best_indexs);

        foreach($best_indexs as $index){
            $bestSentence[] = $this->sentences[$paragraph_number][$index];
		}
		
		return $bestSentence;
	}
	
	/**
	 * Lấy các câu tốt nhất
	 * @param $rate
	 * @return array
	 */
	public function getSummaryParagraphs($rate) {
		$this->ranking = $this->computeSentencesRanks();

		$paragraphs = [];
		
		for ( $i = 0; $i < count($this->sentences); $i++) {
			$bestSentence = $this->getBestSentences( $i, $rate);

			if ( $bestSentence ) {
                $paragraphs[] = $bestSentence;
			}
		}
		
		return $paragraphs;
	}
	
	
	/**
	 * Hàm chính lấy ra các câu tóm tắt
	 * @param $rate
	 * @param $remove_stopword
	 * @return string
	 */
    public function getSummary($rate = 1, $remove_stopword = false) {
        $paragraphs = $this->getSummaryParagraphs($rate);

        $summary = "";

        foreach ( $paragraphs as $paragraph ) {
            foreach($paragraph as $sentence){
                $summary .= "$sentence ";
            }

            $summary .= PHP_EOL;
        }

        return trim( $summary );
    }

//	public function getSummary($n = 1, $remove_stopword = false) {
//        $paragraphs = $this->getSummaryParagraphs($n);
//
//		$summary = "";
//
//		foreach ( $paragraphs as $paragraph ) {
//			foreach($paragraph as $sentence){
//                $summary .= "$sentence ";
//			}
//
//			$summary .= PHP_EOL;
//		}
//
//		return trim( $summary );
//	}
	
}

?>
