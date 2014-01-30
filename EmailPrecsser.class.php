<?php
require_once 'lib/ganon.php';
require_once 'lib/class.csstidy.php';
error_reporting(E_ERROR | E_WARNING | E_PARSE);

class EmailPrecsser{
	public $html = '';

	public function precss($source, $is_url = false, $base_url = null, $css = null){
		$html_with_inline_css = '';
		if($is_url){
			$html = file_get_dom($source);
		}
		else{
			$html = str_get_dom($source);
		}
		foreach($html("*") as $e){
			if(!empty($e->href)){
				if(!$this->isValidUrl($e->href)){
					$e->href = $base_url.'/'.$e->href;
				}
			}
			if(!empty($e->src)){
				if(!$this->isValidUrl($e->src)){
					$e->src = $base_url.'/'.$e->src;
				}
			}
		}
		if(empty($css)){
			$css = $this->parseCss($this->extractCssFromHtml($html("html", 0)->html(), false, false, $base_url));
		}
		else{
			$css = $this->parseCss($css);
		}
		if(!empty($css)){
			foreach($css as $selector=>$rules){
				//break selector into pieces
				$selector_pieces = explode(",", $selector);
				$rewrited_pieces = array();
				for($i = 0; $i < count($selector_pieces); $i++){
					//break each piece into more pieces on white space
					$small_pieces = preg_split('/\s+/', $selector_pieces[$i]);
					$rewrited_small_pieces = array();
					for($j = 0; $j < count($small_pieces); $j++){
						//check if the piece has multible classes
						preg_match_all("/((?:\w)*)((?:\.[-0-9a-zA-Z]+){2,})/i", $small_pieces[$j], $matches);
						if(!empty($matches[2])){
							//rewrite each match as tag[class='']
							for($m = 0; $m < count($matches[2]); $m++){
								$rewrited_small_pieces[$j] = $matches[1][$m].'[class=\''.trim(str_replace('.', ' ', $matches[2][$m])).'\']';
							}
						}
						else{
							$rewrited_small_pieces[$j] = $small_pieces[$j];
						}
					}
					$rewrited_pieces[$i] = implode(" ", $rewrited_small_pieces);
				}
				//apply rules to each piece
				foreach($rewrited_pieces as $piece){
					foreach($html($piece) as $element){
						foreach($rules as $name=>$value){
							$element->style .= $name.': '.$value.'; ';
						}
					}
				}
			}
		}

		$html_with_inline_css = '<!DOCTYPE html><html><head></head>'.$html("body", 0)->html().'</html>';
		return $html_with_inline_css;
	}	

	public function extractCssFromHtml($source, $is_url = false, $ignore_inline = false, $base_url = null){
		$css_str = '';
		if($is_url){
			$html = file_get_dom($source);
		}
		else{
			$html = str_get_dom($source);
		}
		foreach($html('link[type="text/css"]') as $css_file){
			$css_file_url = $css_file->href;
			if(!$this->isValidUrl($css_file_url)){
				$css_file_url = $base_url.'/'.$css_file_url;
			}
			$css_str .= trim(file_get_contents($css_file_url));
		}
		if(!$ignore_inline){
			foreach($html('style') as $css_block){
				$css_str .= $css_block->getInnerText();
			}
		}
		return $css_str;
	}	

	public function parseCss($css){
		if($this->isValidUrl($css)){
			$css_str = file_get_contents($css);
		}
		else{
			$css_str = $css;
		}
		$css_obj = new csstidy();
		$css_obj->set_cfg('remove_last_;',TRUE);
		$css_obj->parse($css_str);
		return reset($css_obj->css);
	}

	private function isValidUrl($url){
		return preg_match('|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i', $url);
  }
}

/*
			foreach($css as $selector=>$rules){
				$selector_pieces = preg_split('/\s+/', $selector);
				for($i = 0; $i < count($selector_pieces); $i++){
					preg_match_all("/((?:\w)*)((?:\.[-0-9a-zA-Z]+){2,})/i", $selector_pieces[$i], $matches);
					if(!empty($matches[2])){
						for($j = 0; $j < count($matches[2]); $j++){
							$rewrites[$i] = $matches[1][$j].'[class=\''.trim(str_replace('.', ' ', $matches[2][$j])).'\']';
						}
					}
					else{
						$rewrites[$i] = $selector_pieces[$i];
					}
				}
				$selector_str = implode(" ", $rewrites);
				foreach($html($selector_str) as $element){
					foreach($rules as $name=>$value){
						$element->style .= $name.': '.$value.'; ';
					}
				}
			}
*/
?>
