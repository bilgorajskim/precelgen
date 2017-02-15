<?php
ob_start();
	if (isset($_GET['debug'])) {
		ini_set('display_errors', 'On');
	}

	ini_set('max_execution_time', 0);
	if (file_exists("uploads")) {
		if (is_dir("uploads"))
			chmod('uploads', 0777);
		else { mkdir("uploads", 0777); }
	} else { mkdir("uploads", 0777); }

	if (file_exists("precle")) {
		if (is_dir("precle"))
			chmod('precle', 0777);
		else { mkdir("precle", 0777); }
	} else { mkdir("precle", 0777); }

//---------------------------------------------------

///////////////////////////////////////////////////////////// 
	/*
	 * Name:    phpSEO
	 * URL:     http:/neo22s.com/phpseo
	 * Version: v0.4
	 * Date:    02/10/2011
	 * Author:  Chema Garrido
	 * Support: http:/neo22s.com/phpseo
	 * License: GPL v3
	 * Notes:   Based on http://neo22s.com/seo-functions-for-php/
	 */

	class phpSEO
	{

		//private variables
		private $text; //text to work with
		private $maxDescriptionLen = 220; //max len for the meta description
		private $maxKeywords = 25; //mix number of keywords to return
		private $minWordLen = 4; //min len for a word
		private $charset = 'UTF-8'; //default charset to use
		//banned words in english feel free to change them
		private $bannedWords = array('able', 'about', 'above', 'act', 'add', 'afraid', 'after', 'again', 'against', 'age', 'ago', 'agree', 'all', 'almost', 'alone', 'along', 'already', 'also', 'although', 'always', 'am', 'amount', 'an', 'and', 'anger', 'angry', 'animal', 'another', 'answer', 'any', 'appear', 'apple', 'are', 'arrive', 'arm', 'arms', 'around', 'arrive', 'as', 'ask', 'at', 'attempt', 'aunt', 'away', 'back', 'bad', 'bag', 'bay', 'be', 'became', 'because', 'become', 'been', 'before', 'began', 'begin', 'behind', 'being', 'bell', 'belong', 'below', 'beside', 'best', 'better', 'between', 'beyond', 'big', 'body', 'bone', 'born', 'borrow', 'both', 'bottom', 'box', 'boy', 'break', 'bring', 'brought', 'bug', 'built', 'busy', 'but', 'buy', 'by', 'call', 'came', 'can', 'cause', 'choose', 'close', 'close', 'consider', 'come', 'consider', 'considerable', 'contain', 'continue', 'could', 'cry', 'cut', 'dare', 'dark', 'deal', 'dear', 'decide', 'deep', 'did', 'die', 'do', 'does', 'dog', 'done', 'doubt', 'down', 'during', 'each', 'ear', 'early', 'eat', 'effort', 'either', 'else', 'end', 'enjoy', 'enough', 'enter', 'even', 'ever', 'every', 'except', 'expect', 'explain', 'fail', 'fall', 'far', 'fat', 'favor', 'fear', 'feel', 'feet', 'fell', 'felt', 'few', 'fill', 'find', 'fit', 'fly', 'follow', 'for', 'forever', 'forget', 'from', 'front', 'gave', 'get', 'gives', 'goes', 'gone', 'good', 'got', 'gray', 'great', 'green', 'grew', 'grow', 'guess', 'had', 'half', 'hang', 'happen', 'has', 'hat', 'have', 'he', 'hear', 'heard', 'held', 'hello', 'help', 'her', 'here', 'hers', 'high', 'hill', 'him', 'his', 'hit', 'hold', 'hot', 'how', 'however', 'I', 'if', 'ill', 'in', 'indeed', 'instead', 'into', 'iron', 'is', 'it', 'its', 'just', 'keep', 'kept', 'knew', 'know', 'known', 'late', 'least', 'led', 'left', 'lend', 'less', 'let', 'like', 'likely', 'likr', 'lone', 'long', 'look', 'lot', 'make', 'many', 'may', 'me', 'mean', 'met', 'might', 'mile', 'mine', 'moon', 'more', 'most', 'move', 'much', 'must', 'my', 'near', 'nearly', 'necessary', 'neither', 'never', 'next', 'no', 'none', 'nor', 'not', 'note', 'nothing', 'now', 'number', 'of', 'off', 'often', 'oh', 'on', 'once', 'only', 'or', 'other', 'ought', 'our', 'out', 'please', 'prepare', 'probable', 'pull', 'pure', 'push', 'put', 'raise', 'ran', 'rather', 'reach', 'realize', 'reply', 'require', 'rest', 'run', 'said', 'same', 'sat', 'saw', 'say', 'see', 'seem', 'seen', 'self', 'sell', 'sent', 'separate', 'set', 'shall', 'she', 'should', 'side', 'sign', 'since', 'so', 'sold', 'some', 'soon', 'sorry', 'stay', 'step', 'stick', 'still', 'stood', 'such', 'sudden', 'suppose', 'take', 'taken', 'talk', 'tall', 'tell', 'ten', 'than', 'thank', 'that', 'the', 'their', 'them', 'then', 'there', 'therefore', 'these', 'they', 'this', 'those', 'though', 'through', 'till', 'to', 'today', 'told', 'tomorrow', 'too', 'took', 'tore', 'tought', 'toward', 'tried', 'tries', 'trust', 'try', 'turn', 'two', 'under', 'until', 'up', 'upon', 'us', 'use', 'usual', 'various', 'verb', 'very', 'visit', 'want', 'was', 'we', 'well', 'went', 'were', 'what', 'when', 'where', 'whether', 'which', 'while', 'white', 'who', 'whom', 'whose', 'why', 'will', 'with', 'within', 'without', 'would', 'yes', 'yet', 'you', 'young', 'your', 'br', 'img', 'p', 'lt', 'gt', 'quot', 'copy',
			'się', 'dla', 'bo', 'ale', 'na', 'w', 'o', 'i', 'u', 'a', 'czy', 'to', 'jak', 'jest', 'nie', 'ma', 'nic', 'by', 'nim', 'iż', 'takie', 'które', 'są', 'aby', 'tego', 'takiego', 'takiej', 'go', 'od');

		//private $bannedWords=array();

		function phpSEO($text = '', $charset = 'UTF-8')
		{ //constructor
			$this->setText($text);
			$this->charset = $charset;
		}

		///SEO for meta description
		function getMetaDescription($len = null)
		{ //returns a text with meta description
			$this->setDescriptionLen($len); //by param set len
			return mb_substr($this->getText(), 0, $this->getDescriptionLen(), $this->charset); //shrink X chars
		}

		function getKeyWords($mKw = null)
		{ //from the given text
			$this->setMaxKeywords($mKw); //by param max keywords
			$text = $this->getText();
			$text = str_replace(array('–', '(', ')', '+', ':', '.', '?', '!', '_', '*', '-', '"'), '', $text); //replace not valid character
			$text = str_replace(array(' ', '.'), ',', $text); //replace for comas

			//erase minor words, banned words and count

			$wordCounter = array(); //array to keep word->number of repetitions

			$arrText = explode(',', $text);
			unset($text);
			foreach ($arrText as $value) {
				$value = trim($value); //bye spaces
				if (strlen($value) >= $this->getMinWordLen() && !in_array($value, $this->getBannedWords())) { //no smaller than X and not in banned
					//I can count how many time we ad and update the record in an array
					if (array_key_exists($value, $wordCounter)) { //if the key exists we ad 1 more
						$wordCounter[$value] = $wordCounter[$value] + 1;
					} else $wordCounter[$value] = 1;
					//creating the key
				}
			}
			unset($arrText);

			uasort($wordCounter, array($this, 'cmp')); //sort from bigger to smaller

			$i = 1; //start countg how many keywords
			$keywords = '';
			foreach ($wordCounter as $key => $value) {
				$keywords .= $key . ', ';
				if ($i < $this->getMaxKeywords()) $i++; //to control the limit of keywords to display
				else break;
				//we did all of them! bye!
			}
			unset($wordCounter);

			$keywords = substr($keywords, 0, -2); //erase last coma

			return $keywords;
		}

		//config params:
		/////////$text
		function setText($text)
		{
			$text = html_entity_decode($text, ENT_QUOTES, $this->charset);
			$text = strip_tags($text); //erases any html markup
			$text = preg_replace('/\s\s+/', ' ', $text); //erase possible duplicated white spaces
			$text = str_replace(array('\r\n', '\n', '+'), ',', $text); //replace possible returns
			$text = trim($text);
			$text = mb_strtolower($text, $this->charset); //everything to lower case
			$this->text = $text; //set text
		}

		function getText()
		{
			return $this->text;
		}

		/////////////$maxDescriptionLen
		function setDescriptionLen($len)
		{
			if (is_numeric($len)) $this->maxDescriptionLen = $len;

			if (strlen($this->getText()) > $this->maxDescriptionLen) {
				$text = mb_substr($this->getText(), 0, $this->maxDescriptionLen);
				//the len depends on the last char, so we dont cut word in two parts without meaning.
				while (mb_substr($text, $this->maxDescriptionLen, 1, $this->charset) != ' ') {
					$this->maxDescriptionLen--;
				}
			}
		}

		function getDescriptionLen()
		{
			return $this->maxDescriptionLen;
		}

		//////////////maxKeywords
		function setMaxKeywords($len)
		{
			if (is_numeric($len)) $this->maxKeywords = $len;
		}

		function getMaxKeywords()
		{
			return $this->maxKeywords;
		}

		////////////minWordLen
		function setMinWordLen($len)
		{
			if (is_numeric($len)) $this->minWordLen = $len;
		}

		function getMinWordLen()
		{
			return $this->minWordLen;
		}

		////////////bannedWords
		function setBannedWords($words)
		{
			if (isset($words)) {
				$arrText = explode(',', $words);
				if (is_array($arrText)) $this->bannedWords = $arrText;
			}
		}

		function getBannedWords()
		{
			return $this->bannedWords;
		}

		//end config params

		//function tools:
		private function countWordArray($search, $array)
		{ //count the $search word in the given array
			if (is_array($array) && $search != '') {
				$count = 0;
				foreach ($array as $e) if ($e == $search) $count++;

				return $count;
			} else return false;
		}

		private function cmp($a, $b)
		{ //sort for uasort descendent numbers
			if ($a == $b) return 0;

			return ($a < $b) ? 1 : -1;
		}
		//end function tools

	}

//funkcja wywolywana przez funkcje synonimuj, majaca na celu wybranie jednego synonimu sposrod przeslanych
	function  wylosuj2($do_podmiany)
	{
		$fraza = wylosuj3($do_podmiany);
		$fraza = explode('|', $do_podmiany[1]);

		return $fraza[array_rand($fraza)];
	}

//funkcja wywolywana przez funkcje synonimuj, majaca na celu wybranie jednego synonimu sposrod przeslanych
	function  wylosuj($do_podmiany)
	{
		$fraza = explode('|', $do_podmiany[1]);

		return $fraza[array_rand($fraza)];
	}

//funkcja synonimuj wybiera fragmenty z synonimami z tekstu i przekazuje je do losowania
	function synonimuj3($text)
	{
		return preg_replace_callback('/\{(.*?)\}/', wylosuj, $text);
	}

//funkcja synonimuj wybiera fragmenty z synonimami z tekstu i przekazuje je do losowania
	function synonimuj2($text)
	{
		$text = synonimuj3($text);

		return preg_replace_callback('/\{(.*?)\}/', wylosuj, $text);
	}

//funkcja synonimuj wybiera fragmenty z synonimami z tekstu i przekazuje je do losowania
	function synonimuj($text)
	{
		$text = synonimuj2($text);

		return preg_replace_callback('/\{(.*?)\}/', wylosuj, $text);
	}

	class SEOMixer
	{
		public $input;
		public $output;
		public $limit = 1;
		private $braces = array("{", "}");
		private $delimiter = "|";

		function __construct($input)
		{
			$this->input = $input;
		}

		function mixAll()
		{
			$this->output = $this->input;
			while (strpos($this->output, $this->braces['1']) !== false) {
				$closed = strpos($this->output, $this->braces['1']);
				$substr = substr($this->output, 0, $closed + 1);
				$from = strrpos($substr, $this->braces['0']);
				$substr = substr($substr, $from);
				$_substr = $this->mixText($substr);
				$this->output = str_replace($substr, $_substr, $this->output);
				$substr = "";
				$_substr = "";
			}

			return;
		}

		function mixText($text)
		{
			$text = str_ireplace($this->braces, "", $text);
			$elements = explode($this->delimiter, $text);

			return $elements[array_rand($elements)];
		}

		function mix()
		{
			$this->mixAll();

			return stripslashes($this->output);
		}
	}

	function str_replace2($find, $replacement, $subject, $limit = 0)
	{
		if ($limit == 0)
			return str_replace($find, $replacement, $limit);
		$ptn = '/' . preg_quote($find) . '/';

		return preg_replace($ptn, $replacement, $subject, $limit);
	}

	function color_inverse($color)
	{
		$color = str_replace('#', '', $color);
		if (strlen($color) != 6) {
			return '000000';
		}
		$rgb = '';
		for ($x = 0; $x < 3; $x++) {
			$c = 255 - hexdec(substr($color, (2 * $x), 2));
			$c = ($c < 0) ? 0 : dechex($c);
			$rgb .= (strlen($c) < 2) ? '0' . $c : $c;
		}

		return '#' . $rgb;
	}


	function color_like($color)
	{
		$color = str_replace('#', '', $color);
		if (strlen($color) != 6) {
			return '000000';
		}
		$rgb = '';
		for ($x = 0; $x < 3; $x++) {
			$c = 255 - hexdec(substr($color, (1.1 * $x), 2));
			$c = ($c < 0) ? 0 : dechex($c);
			$rgb .= (strlen($c) < 2) ? '0' . $c : $c;
		}

		return '#' . $rgb;
	}

	function adjustBrightness($hex, $steps)
	{
		// Steps should be between -255 and 255. Negative = darker, positive = lighter
		$steps = max(-255, min(255, $steps));

		// Format the hex color string
		$hex = str_replace('#', '', $hex);
		if (strlen($hex) == 3) {
			$hex = str_repeat(substr($hex, 0, 1), 2) . str_repeat(substr($hex, 1, 1), 2) . str_repeat(substr($hex, 2, 1), 2);
		}

		// Get decimal values
		$r = hexdec(substr($hex, 0, 2));
		$g = hexdec(substr($hex, 2, 2));
		$b = hexdec(substr($hex, 4, 2));

		// Adjust number of steps and keep it inside 0 to 255
		$r = max(0, min(255, $r + $steps));
		$g = max(0, min(255, $g + $steps));
		$b = max(0, min(255, $b + $steps));

		$r_hex = str_pad(dechex($r), 2, '0', STR_PAD_LEFT);
		$g_hex = str_pad(dechex($g), 2, '0', STR_PAD_LEFT);
		$b_hex = str_pad(dechex($b), 2, '0', STR_PAD_LEFT);

		return '#' . $r_hex . $g_hex . $b_hex;
	}

	function poemCut($string, $max_length, $end = "...")
	{
		if (strlen($string) > $max_length) {
			$string = substr($string, 0, $max_length);
			$pos = strrpos($string, " ");
			if ($pos === false) {
				return substr($string, 0, $max_length) . $end;
			}

			return substr($string, 0, $pos) . $end;
		} else {
			return $string;
		}
	}

	function _substr($str, $length, $minword = 3)
	{
		$sub = '';
		$len = 0;

		foreach (explode(' ', $str) as $word) {
			$part = (($sub != '') ? ' ' : '') . $word;
			$sub .= $part;
			$len += strlen($part);

			if (strlen($word) > $minword && strlen($sub) >= $length) {
				break;
			}
		}

		return $sub . (($len < strlen($str)) ? '...' : '');
	}

	function str_replace_count($search, $replace, $subject, $times)
	{

		$subject_original = $subject;

		$len = strlen($search);
		$pos = 0;
		for ($i = 1; $i <= $times; $i++) {
			$pos = strpos($subject, $search, $pos);

			if ($pos !== false) {
				$subject = substr($subject_original, 0, $pos);
				$subject .= $replace;
				$subject .= substr($subject_original, $pos + $len);
				$subject_original = $subject;
			} else {
				break;
			}
		}

		return ($subject);

	}

	function startsWith($haystack, $needle)
	{
		return !strncmp($haystack, $needle, strlen($needle));
	}
	
	function get_google_images($keyword) {
		$keyword = str_replace(' ', '+', $keyword);
		
		$contents = file_get_contents("http://google.pl/search?hl=pl&q=".$keyword."&um=1&ie=UTF-8&tbm=isch");
		$dom = new DOMDocument(); 
		@$dom->loadHTML($contents);
		$links = array(); 
		foreach ($dom->getElementsByTagName('a') as $link) {
			$img = explode('?imgurl=', $link->getAttribute('href'));
			$img = explode('&imgrefurl=', $img[1]);
			$img = $img[0];
			if ($img) $links[] = $img;
		}
		return $links;
	}

	if ($_POST) {
		// Zespajamy wszystkie teksty w całość
		$tekst = '{';
		for ($i = 0; $i < 100; $i++) {
			if ($_POST['article_'.$i]) {
				if ($i != 0) $tekst .= '|';
				$tekst .= $_POST['article_'.$i];
			}
		}
		$tekst .= '}';
		
		$file_tmp = $_FILES['links']['tmp_name'];
		$file_name = $_FILES['links']['name'];
		if(is_uploaded_file($file_tmp)) {
			move_uploaded_file($file_tmp, "uploads/{$file_name}");
			$linki_dir = $file_name;
		}
		if ($linki_dir) $linki = explode("\n", file_get_contents("uploads/{$linki_dir}"));
			else $linki = explode("\n", $_POST['links']);

		for ($i = 0; $i < count($linki); $i++) {
			if (substr($linki[$i], 0, 7) != 'http://') $linki[$i] = "http://" . $linki[$i];
		}

		$stekst = new SEOMixer($tekst);
		$stekst = $stekst->mix();
		$tytuly = new SEOMixer($_POST['titles']);
		$seo = new phpSEO($stekst);
		$klucze = htmlspecialchars(stripslashes($seo->getKeyWords()));
		$klucze_a = explode(' ', $klucze);
		$opis = htmlspecialchars(stripslashes($seo->getMetaDescription()));
		$slowa_linki = stripslashes($seo->getKeyWords(count($linki)));
		$slowa_linki = explode(', ', $slowa_linki);
		$klucz = stripslashes($seo->getKeyWords(1));
		$tekst = explode(' ', $tekst);
		$tekst = implode(' ', $tekst);
		$ile_na_stronie = $_POST['per_page'];
		$anchory = explode("\n", $_POST['anchors']);
		$linki_na_tekst = $_POST['links_per_text'];

		$dlugosc = strlen($tekst);
		$stekst = new SEOMixer($tekst);
		$stekst = $stekst->mix();
		$ile_kawalkow = ceil(count($linki) / $linki_na_tekst);
		$dlugosc_kawalka = $dlugosc / count($linki);
		
		$zipdir = time();
		
		// Obrazki
		if ($_POST['enable_images']) {
			$obrazki = get_google_images($_POST['images_keyword']);
		}
		
		for ($i = 0; $i < $ile_kawalkow; $i++) {
			//$kawalek = substr($tekst, $dlugosc_kawalka * $i, $dlugosc_kawalka);
			//$kawalek = substr( $tekst, $dlugosc_kawalka * $i, strrpos( substr( $tekst, $dlugosc_kawalka * $i, $dlugosc_kawalka), ' ' ) );
			srand(time() + $i);
			$kawalek = new SEOMixer($tekst);
			$kawalek = $kawalek->mix();
			$kseo = new phpSEO($kawalek);
			$slowa_linki = stripslashes($kseo->getKeyWords($linki_na_tekst));
			$slowa_linki = explode(', ', $slowa_linki);
			//if ($anchory[$linki[$i]]) $slowa_linki[0] = $anchory[$linki[$i]];
			//if ($anchory[$linki[$i+1]]) $slowa_linki[1] = $anchory[$linki[$i+1]];
			if ($_POST['titles']) $ktitle = $tytuly->mix();
			else $ktitle = $kseo->getMetaDescription(32);

			for ($y = 0; $y <= $linki_na_tekst; $y++) {
				if ($linki[$i + $y]) $kawalek = str_replace_count('' . $slowa_linki[$y] . '', addslashes('<a href="' . $linki[$i + $y] . '">' . $slowa_linki[$y] . '</a>'), $kawalek, 1);
				$kawalek = stripslashes($kawalek);
			}
			
			$kawalek = '<img src="'.basename($obrazki[$i]).'" alt="" style="width: 100px; float: left" />' . $kawalek;
			
			$kawalki[$i]['tytul'] = $ktitle;
			$kawalki[$i]['tresc'] = $kawalek;
		}
		$tekst = null;


		foreach ($klucze_a as $strong) {
			$tekst = str_replace(' ' . $strong . ' ', ' <strong>' . $strong . '</strong> ', $tekst);
		}

		$tekst = stripslashes($tekst);

		$h1 = poemCut($stekst, 24);
		$h2 = poemCut($stekst, 48);

		$podstrony = ceil($ile_kawalkow / $ile_na_stronie);
		mkdir('precle/' . $zipdir);
		$zip = new ZipArchive();
		$filename = "precle/" . $zipdir . ".zip";

		if ($zip->open($filename, ZIPARCHIVE::CREATE) !== TRUE) {
			exit("cannot open <$filename>\n");
		}

		$extension = ".html";
		if (strpos($_POST['head_code'], "<?") !== false) $extension = ".php";
		if (strpos($_POST['body_code'], "<?") !== false) $extension = ".php";

		$linki_menu = "<a href='index". $extension ."'>Strona 1</a> ";
		for ($i = 0; $i < ($podstrony - 1); $i++) {
			$linki_menu .= "<a href='page" . ($i + 2) . $extension . "'>Strona " . ($i + 2) . "</a> ";
		}
		
		if ($_POST['enable_images']) {
			foreach ($obrazki as $obrazek) {
				file_put_contents("precle/" . $zipdir . "/" . basename($obrazek), file_get_contents($obrazek));
				$zip->addFile("precle/" . $zipdir . "/" . basename($obrazek), basename($obrazek));
			}
		}

		if ($_POST['file_names']) {
		$slowa_menu = explode("\n", $_POST['file_names']);
		for ($i = 0; $i < count($slowa_menu); $i++) {
			$mixer = new SEOMixer($slowa_menu[$i]);
			$slowa_menu[$i] = $mixer->mix();
		}
		} else $slowa_menu = $slowa_linki;

		$nav = array();
		for ($i = 0; $i < ($ile_kawalkow / $ile_na_stronie) - 1; $i++) {
			$nav[$i]['link'] = 'page' . ($i + 2) . $extension;
			if ($slowa_menu[$i]) $nav[$i]['etykieta'] = $slowa_menu[$i];
				else $nav[$i]['etykieta'] = $slowa_menu[count($slowa_menu) - $i];
		}

		for ($y = 0; $y < $podstrony; $y++) {
			$tekst = Array();
			// Podział kawałków na strony
			for ($i = $y * $ile_na_stronie; $i < ($y * $ile_na_stronie + $ile_na_stronie); $i++) {
				$tekst[] = $kawalki[$i];
			}
			/*
			$nav = array();
			$unikalne_linki = array_unique($linki);
			for ($i = 0; $i < count($unikalne_linki) - 1; $i++) {
				$nav[$i]['link'] = $linki[$i];
				$nav[$i]['etykieta'] = $slowa_linki[$i];
			}
			*/

			if (($ile_kawalkow - $y * $ile_na_stronie) > $ile_na_stronie) {
				$dalej = 'page' . ($y + 2) . $extension;
			} else $dalej = null;

			$title = implode(' ', $klucze_a);
			$title = str_replace(',', '', $title);
			$title = poemCut($title, 30, '');

			if (file_exists("szablony/" . $_POST['template'] . "/index.tpl")) $template_dir = "szablony/" . $_POST['template'] . "/index.tpl";
			elseif (file_exists("szablony/" . $_POST['template'] . "/szablon.tpl")) $template_dir = "szablony/" . $_POST['template'] . "/szablon.tpl"; elseif (file_exists("szablony/" . $_POST['template'] . "/template.tpl")) $template_dir = "szablony/" . $_POST['template'] . "/template.tpl";

			define('ROOT', dirname(__FILE__));
			define('SMARTY_DIR', ROOT . '/libs/');
			define('SMARTY_TEMPLATES', ROOT . '/szablony/');
			define('SMARTY_CACHE', ROOT . '/cache/');
			define('SMARTY_TEMPLATE_C', ROOT . '/cache/');
			require_once(SMARTY_DIR . 'Smarty.class.php');
			$smarty = new smarty($template_dir);
			$smarty->assign("tytul", $title);
			$smarty->assign("h1", $title);
			//$smarty->assign("h2", $h2);
			$smarty->assign("teksty", $tekst);
			$smarty->assign("nastepna_strona", $dalej);
			$smarty->assign("menu", $nav);
			$smarty->assign("nawigacja", $nav);
			$smarty->assign("head",
				"<meta charset='utf-8' />
<meta name='keywords' content='" . $klucze . "' />
<meta name='description' content='" . $opis . "' />
<title>" . $title . "</title>" . $_POST['head_code']);
			$smarty->assign("body", $_POST['body_code']);
			$strona = $smarty->fetch($template_dir);
			$results = scandir("szablony/" . $_POST['template'] . "/");
			foreach ($results as $result) {
				if ($result === '.' or $result === '..' or $result === 'index.tpl'
					or $result === 'szablon.tpl' or $result === 'template.tpl'
					or $result === 'index.html'
				) continue;
				copy("szablony/" . $_POST['template'] . "/" . $result, 'precle/' . $zipdir . '/' . $result);
				$zip->addFile("szablony/" . $_POST['template'] . "/" . $result, $result);
			}
			for ($i = 1; $i <= $_POST['files_amount']; $i++) {
				$file_tmp = $_FILES['file_'.$i]['tmp_name'];
				$file_name = $_FILES['file_'.$i]['name'];
				if(is_uploaded_file($file_tmp)) {
					move_uploaded_file($file_tmp, "uploads/{$file_name}");
					copy("uploads/{$file_name}", 'precle/' . $zipdir . '/' . $file_name);
					$zip->addFile("uploads/{$file_name}", $file_name);
				}
			}
			if ($y == 0) {
				file_put_contents('precle/' . $zipdir . '/index' . $extension, $strona);
				$zip->addFile("precle/" . $zipdir . "/index" . $extension, "index" . $extension);
			} else {
				file_put_contents('precle/' . $zipdir . '/page' . ($y + 1) . $extension, $strona);
				$zip->addFile("precle/" . $zipdir . "/page" . ($y + 1) . $extension, "page" . ($y + 1) . $extension);
			}

		}
		$zip->close();

		// OPCJA 1 - pobieranie
		if ($_POST['generate']) {
			header("Content-disposition: attachment; filename=" . $zipdir . ".zip");
			header('Content-type: application/octet-stream');
			header('Accept-charset: utf-8');
			echo file_get_contents('precle/' . $zipdir . '.zip');
			exit();
		}

		// OPCJA 2 - wysyłanie na serwery FTP
		if ($_POST['send']) {
			for ($i = 1; $i <= $_POST['hosts_amount']; $i++) {
				echo "zaczynam upload ".$_POST['host_'.$i].$_POST['user_'.$i].$_POST['password_'.$i].$_POST['port_'.$i].$_POST['domain_'.$i];
				if ($_POST['host_'.$i] && $_POST['user_'.$i] && $_POST['password_'.$i] && $_POST['port_'.$i] && $_POST['domain_'.$i]) {
					$files = scandir('precle/' . $zipdir . "/");
					echo "na serwer ";
					// nawiązanie połączenia lub zakończenie działania skryptu
					$conn_id = ftp_connect($_POST['host_'.$i]) or die("Nie można połączyć się z ".$_POST['host_'.$i]);
					foreach ($files as $file) {

						// próba logowania
						if (ftp_login($conn_id, $_POST['user_'.$i], $_POST['password_'.$i])) {
							ftp_chdir($conn_id, "/domains/".$_POST['domain_'.$i]."/public_html/".$_POST['directory_'.$i]);
							if ($_POST['directory_'.$i]) ftp_chdir($conn_id, $_POST['directory_'.$i]);
							ftp_put($conn_id, $file, 'precle/' . $zipdir . '/' . $file, FTP_BINARY);
						} else {
							echo "Nie można zalogować się jako ".$_POST['user_'.$i];
						}
					}
					$pwd = ftp_pwd($conn_id);
					$ftp_links[] = "ftp://".$_POST['user_'.$i].":".$_POST['password_'.$i]."@".$_POST['host_'.$i]."".$pwd."/index".$extension;
					$http_links[] = "http://".$_POST['domain_'.$i]."/".$_POST['directory_'.$i]."/index".$extension;
					// zamknięcie połączenia
					ftp_close($conn_id);
				}
			}
			?>
<html>
<head>
	<meta charset="utf-8"/>
	<title>Generator precli</title>
	<style>
		body {
			width: 780px;
			margin: 0px auto;
			font-family: Arial;
			color: #111;
		}

		h1, h2 {
			font-family: Helvetica;
			color: #555;
		}

		h1 {
			color: #333;
		}

		section {
			position: relative;
			float: left;
			width: 780px;
			margin-bottom: 20px;
			background: #fafafa;
			border: solid 1px grey;
			border-radius: 5px;
			padding: 9px;
			box-sizing: border-box;
			-moz-box-sizing: border-box;
		}

		section h2 {
			margin: 0px;
			color: maroon;
			text-transform: uppercase;
		}

		.left, .right {
			position: relative;
			width: 380px;
			min-height: 100px;
			float: left;
		}

		.left {
			left: 0px;
		}

		.right {
			left: 0px;
		}

		input[type="submit"] {
			-moz-box-shadow: inset 0px 1px 0px 0px #f29c93;
			-webkit-box-shadow: inset 0px 1px 0px 0px #f29c93;
			box-shadow: inset 0px 1px 0px 0px #f29c93;
			background-color: #fe1a00;
			-moz-border-radius: 6px;
			-webkit-border-radius: 6px;
			border-radius: 6px;
			border: 1px solid #d83526;
			display: inline-block;
			color: #ffffff;
			font-family: arial;
			font-size: 28px;
			font-weight: bold;
			padding: 6px 24px;
			text-decoration: none;
			text-shadow: 1px 1px 0px #b23e35;
		}

		input[type="submit"]:hover {
			background-color: #ce0100;
		}

		input[type="submit"]:active {
			position: relative;
			top: 1px;
		}

		textarea {
			width: 100%;
			height: 150px;
			box-sizing: border-box;
			-moz-box-sizing: border-box;
			resize: none;
			font-family: Corbel;
			border-radius: 5px;
			border: solid 1px #555;
			padding: 5px 10px;
		}

		textarea:focus {
			box-shadow: inset 0px 0px 5px #222;
			transition: all 0.3s ease;
		}

		input[type="number"] {
			box-sizing: border-box;
			-moz-box-sizing: border-box;
			padding: 2px;
			border: solid 1px #555;
			border-radius: 5px;
		}

		#final {
			text-align: center;
		}
	</style>
	<script src="http://code.jquery.com/jquery.min.js"></script>
</head>
<body>
	<head>
		<hgroup>
			<h1>Generator precli</h1>

			<h2>v1.3 © hf.</h2>
		</hgroup>
	</head>
	<article>
		<section>
			<h2>Precel został wysłany</h2>
			<strong>Linki FTP:</strong><br />
			<?php foreach ($ftp_links as $link): ?>
			<a href="<?= $link ?>"><?= $link ?></a><br />
			<?php endforeach; ?>
			<strong>Linki HTTP:</strong><br />
			<?php foreach ($http_links as $link): ?>
			<a href="<?= $link ?>"><?= $link ?></a><br />
			<?php endforeach; ?><br />
			<a href="precelgen.php">Wygeneruj nowy precel</a>
		</section>
	</article>
</body>
</html>
			<?php
			exit();
		}
	}
?>
<html>
<head>
	<meta charset="utf-8"/>
	<title>Generator precli</title>
	<style>
		body {
			width: 780px;
			margin: 0px auto;
			font-family: Arial;
			color: #111;
		}

		h1, h2 {
			font-family: Helvetica;
			color: #555;
		}

		h1 {
			color: #333;
		}

		section {
			position: relative;
			float: left;
			width: 780px;
			margin-bottom: 20px;
			background: #fafafa;
			border: solid 1px grey;
			border-radius: 5px;
			padding: 9px;
			box-sizing: border-box;
			-moz-box-sizing: border-box;
		}

		section h2 {
			margin: 0px;
			color: maroon;
			text-transform: uppercase;
		}

		.left, .right {
			position: relative;
			width: 380px;
			min-height: 100px;
			float: left;
		}

		.left {
			left: 0px;
		}

		.right {
			left: 0px;
		}

		input[type="submit"] {
			-moz-box-shadow: inset 0px 1px 0px 0px #f29c93;
			-webkit-box-shadow: inset 0px 1px 0px 0px #f29c93;
			box-shadow: inset 0px 1px 0px 0px #f29c93;
			background-color: #fe1a00;
			-moz-border-radius: 6px;
			-webkit-border-radius: 6px;
			border-radius: 6px;
			border: 1px solid #d83526;
			display: inline-block;
			color: #ffffff;
			font-family: arial;
			font-size: 28px;
			font-weight: bold;
			padding: 6px 24px;
			text-decoration: none;
			text-shadow: 1px 1px 0px #b23e35;
		}

		input[type="submit"]:hover {
			background-color: #ce0100;
		}

		input[type="submit"]:active {
			position: relative;
			top: 1px;
		}

		textarea {
			width: 100%;
			height: 150px;
			box-sizing: border-box;
			-moz-box-sizing: border-box;
			resize: none;
			font-family: Corbel;
			border-radius: 5px;
			border: solid 1px #555;
			padding: 5px 10px;
		}

		textarea:focus {
			box-shadow: inset 0px 0px 5px #222;
			transition: all 0.3s ease;
		}

		input[type="number"], input[type="text"] {
			box-sizing: border-box;
			-moz-box-sizing: border-box;
			padding: 2px;
			border: solid 1px #555;
			border-radius: 5px;
		}

		table input[type="text"] {
			box-sizing: border-box;
			-moz-box-sizing: border-box;
			padding: 2px;
			border: solid 1px #555;
			border-radius: 5px;
			width: 93px;
		}

		#final {
			text-align: center;
		}
	</style>
	<script src="http://code.jquery.com/jquery.min.js"></script>
</head>
<body>
<head>
	<hgroup>
		<h1>Generator precli</h1>
		
		Jeśli czegoś nie wiesz, zajrzyj do <a href="instrukcja.html">instrukcji obsługi</a>!</h2>
	</hgroup>
</head>
<article>
	<form action="precelgen.php" method="POST" enctype="multipart/form-data">
		<section>
			<h2>1. Treść</h2>

			<div class="left">
				Wpisz tekst z synonimami który ma pojawić
				się na stronie. Używaj synonimów w formacie
				{opcja1|opcja2|opcja3}
			</div>
			<div class="right">
				<div id="articles">
					<textarea name="article_0" required></textarea><br />
				</div>
				<a href="#" onclick="add_article(); return false;">Dodaj kolejny</a>
				<script>
					var articles = 1;
					function add_article() {
						if (articles < 100) {
							$('#articles').last().append('<textarea name="article_' + articles + '" required></textarea><br />');
							articles++;
						} else alert("Nie możesz dodać więcej niż 100 artykułów. Przykro mi :-(");
					}
				</script>
			</div>
		</section>
		<section>
			<h2>2. Linki</h2>

			<div class="left">
				Wpisz linki które mają się znaleźć na stronie.
				Adresy muszą być w formacie http://domena.pl.
				Linki wpisuj w oddzielnych liniach.
			</div>
			<div class="right">
				<textarea name="links"></textarea><br />
				Lub wyślij plik z linkami:<br />
				<input type="file" name="links" />
			</div>
		</section>
		<section>
			<h2>3. Tytuły tekstów</h2>

			<div class="left">
				Wpisz tekst z synonimami używany do generowania tytułów.
			</div>
			<div class="right">
				<textarea name="titles"></textarea>
			</div>
		</section>
		<section>
			<h2>4. Nazwy podstron</h2>

			<div class="left">
				Wpisz słowa kluczowe używane do generowania nazw podstron. Każde słowo kluczowe w nowej linijce. Dozwolone synonimy.
			</div>
			<div class="right">
				<textarea name="file_names"></textarea>
			</div>
		</section>
		<section>
			<h2>5. Dodatkowy kod</h2>

			<div class="left">
				Możesz dołączć do wygenerowanego dokumentu własny kod HTML, JS albo PHP.
				Jeśli zostanie wpisany kod PHP, rozszerzenie dokumentu zmieni się na .php
			</div>
			<div class="right">
				<label for="head_code">Kod w HEAD</label>
				<textarea name="head_code"></textarea>
				<label for="body_code">Kod w BODY</label>
				<textarea name="body_code"></textarea>
			</div>
		</section>
		<section>
			<h2>6. Dodatkowe pliki</h2>

			<div class="left">
				Jeśli dodałeś do dokumentu kod, który wymaga jakiegoś pliku, możesz go dołączyć.
			</div>
			<div class="right">
				<input type="hidden" name="files_amount" id="files_amount" value="1">
				<div id="files">
					<input type="file" name="file_1" />
				</div>
				<script>
					var counter = 1;
					function addfile() {
						counter++;
						$("#files").last().append("<input type='file'' name='file_"+counter+"'' />");
						$("#files_amount").val(counter);
					}
				</script>
				<a href="#" onclick='addfile(); return false;'>Dodaj kolejny</a>
			</div>
		</section>
		<section>
			<h2>7. Obrazy</h2>

			<div class="left">
				Wzbogać zawartość precla poprzez umieszczenie obrazów. Do wyszukania pasujących grafik zostanie użyte Google Images. 
				<b>Uwaga!</b> Ta opcja znacznie wydłuża czas generowania dokumentu.
			</div>
			<div class="right">
				<input type="checkbox" value="1" name="enable_images" onclick="if (this.value == 1) { document.getElementById('images_keyword').required = 'required'; } else { document.getElementById('images_keyword').required = false; }"/>
				<label for="enable_images">Dodaj obrazki</label><br/>
				<label for="images_keyword">Słowo kluczowe używane do wyszukania obrazków</label><br/>
				<input type="text" name="images_keyword" id="images_keyword" />
			</div>
		</section>
		<section>
			<h2>8. Ustawienia</h2>

			<div class="left">
				Możesz dostosować generator zmieniając te ustawienia lub pozostawić je w domyślnych wartościach.
			</div>
			<div class="right">
				<label for="per_page">Teksty na stronę</label><br/>
				<input type="number" name="per_page" value="5" min="1"/><br/>
				<label for="links_per_text">Linki na tekst</label><br/>
				<input type="number" name="links_per_text" value="2" min="1"/><br/>
				<label for="template">Szablon strony</label><br/>

				<?php
				$results = scandir("szablony/");
				if ($results) {
					?>
					<select name="template">
						<?php
						foreach ($results as $result) {
							if ($result === '.' or $result === '..') continue;
							?>
							<option><?=$result?></option>
							<?php
						}
						?>
					</select><br/>
					<?php
				} else {
					?>
					Nie znaleziono szablonów!
					<?php
				}
				?>
			</div>
		</section>
		<section>
			<h2>9. Wygeneruj precla</h2>

			<div class="left">
				Pobrane pliki skopiuj na serwer WWW.
				MySQL nie jest wymagane.<br/>
			</div>
			<div class="right" id="final">
				<input type="submit" name="generate" id="sendbutton" value="Wygeneruj" <?php if (!$results) { ?> disabled <?php } ?> />
			</div>
		</section>
		<section>
			<h2>10. .. lub wyślij na FTP</h2>
			<div class="left" style="width: 30%">
				Możesz też wysłać precla na serwer FTP. Wpisz dane do serwerów poniżej.
			</div>
			<div class="right" style="width: 70%">
				<input type="hidden" name="hosts_amount" id="hosts_amount" value="1">
				<table>
					<thead>
					<tr>
						<th>
							Host
						</th>
						<th>
							Użytkownik
						</th>
						<th>
							Hasło
						</th>
						<th>
							Port
						</th>
						<th>
							Domena
						</th>
						<th>
							Katalog
						</th>
					</tr>
					</thead>
					<tbody id="ftp_hosts">
					<tr>
						<td>
							<input type="text" name="host_1" />
						</td>
						<td>
							<input type="text" name="user_1" />
						</td>
						<td>
							<input type="text" name="password_1" />
						</td>
						<td>
							<input type="text" name="port_1" style="width: 40px" value="21" />
						</td>
						<td>
							<!-- <input type="text" name="directory_0" style="width: 220px" value="/domains/domena.pl/public_html" /> !-->
							<input type="text" name="domain_1" />
						</td>
						<td>
							<input type="text" name="directory_1" />
						</td>
					</tr>
					</tbody>
					<script>
						var counter = 1;
						function addhost() {
							counter++;
							$("#ftp_hosts").last().append("<tr id='a_"+counter+"' ></tr>");
							$("#a_"+counter).html('<td><input type="text" name="host_'+ counter +'" id="host_'+ counter +'" /></td><td><input type="text" name="user_'+ counter +'" id="user_'+ counter +'" /></td><td><input type="text" name="password_'+ counter +'" id="password_'+ counter +'" /></td><td><input type="text" name="port_'+ counter +'" id="port_'+ counter +'" style="width: 40px" value="21" /></td><td><input type="text" name="domain_'+ counter +'" id="domain_'+ counter +'" /></td><td><input type="text" name="directory_'+ counter +'" id="directory_'+ counter +'" /></td>');
							$("#hosts_amount").val(counter);
						}

						function import_hosts() {
							var raw_data = $("#import").val();
							var hosts = raw_data.split("\n");
							var katalog = "";
							for (var i=0;i < hosts.length;i++) {
								var host_data = hosts[i].split(" ");
								if (host_data[0] == undefined) host_data[0] = '';
								if (host_data[1] == undefined) host_data[1] = '';
								if (host_data[2] == undefined) host_data[2] = '';
								if (host_data[3] == undefined) host_data[3] = '';
								if (host_data[4] == undefined) host_data[4] = '';
								if (host_data[5] == undefined) host_data[5] = '';
								$("#ftp_hosts").last().append("<tr id='a_"+counter+"' ></tr>");
								$("#a_"+counter).html('<td><input type="text" name="host_'+ counter +'" id="host_'+ counter +'" value="'+ host_data[0] +'" /></td><td><input type="text" name="user_'+ counter +'" id="user_'+ counter +'" value="'+ host_data[1] +'" /></td><td><input type="text" name="password_'+ counter +'" id="password_'+ counter +'" value="'+ host_data[2] +'" /></td><td><input type="text" name="port_'+ counter +'" id="port_'+ counter +'" style="width: 40px" value="'+ host_data[3] +'" /></td><td><input type="text" name="domain_'+ counter +'" id="domain_'+ counter +'" value="'+ host_data[4] +'" /></td><td><input type="text" name="directory_'+ counter +'" id="directory_'+ counter +'" value="'+ host_data[5] +'" /></td>');
								counter++;
							}
						}
						function export_hosts() {
							var data = "";
							for (var i=0;i < counter;i++) {
								if ((i != 0) || ((i == 0) && ($("#host_0").val()))) {
									data += $("#host_"+i).val()+ " " +$("#user_"+i).val()+ " " +$("#password_"+i).val()+ " " +$("#port_"+i).val()+ " " +$("#domain_"+i).val()+ "\n";
								}
							}
							$("#export").val(data);
						}
					</script>
				</table>
				<a href="#" onclick='addhost(); return false;'>Dodaj kolejny</a><br />
				<textarea name="import" id="import"></textarea>
				<a href="#" onclick='import_hosts(); return false;'>Importuj</a>
				<textarea name="export" id="export"></textarea>
				<a href="#" onclick='export_hosts(); return false;'>Eksportuj</a><br />
				<div style="padding: 20px; text-align: center">
				<input type="submit" name="send" id="sendbutton" value="Wyślij" />
				</div>
			</div>
		</section>
	</form>
</article>
</body>
</html>