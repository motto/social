<?php
//defined( '_MOTTO' ) or die( 'Restricted access' );
/*
Link::kiszed('index.phph=rrr&task=123&h=erfwer&ffg=sdfs','task,h,lll');
Link::kiszed(link,'task,id'); //ha a linkben nincs kérdőjel mögé tesz egy ?gt=0 -t
Link::src_thumb($src)  //képnév elé illeszti a thumb/ -ot
*/


class STR
{
	static public function to_tomb($string, $tagolo1 = ',', $tagolo2 = ':'){
//pl.:$string='class:hhh,id:azon,name:név'
		$tx1 = explode($tagolo1, $string);
		foreach ($tx1 as $mezo) {
			$tx2 = explode($tagolo2, $mezo);
			$tomb[$tx2[0]] = $tx2[1];
		}
		return $tomb;
	}

static public function webnev($string,$hosz=20)
	{$webnev='';
		$hungarianABC = array( 'á','é','í','ó','ö','ő','ú','ü','ű','Á','É','Í','Ó','Ö','Ő','Ú','Ü','Ű','&','#','@','$','%','/','\\');
		$englishABC = array( 'a','e','i','o','o','o','u','u','u','A','E','I','O','O','O','U','U','U','e','e','e','e','e','e','e');
		$string=str_replace($hungarianABC, $englishABC, $string);
		$webabc = array( 'a','e','i','o','u','b','c','d','f','g','h','j','k','l','m','n','p','_','q','r','s','z','v','w','x','y','t','0','1','2','3','4','5','6','7','8','9');
		$string = strtolower( $string);
		for ($n = 0; $n < strlen($string); ++$n)
		{if($n<$hosz){if (in_array($string{$n},$webabc)){$webnev=$webnev.$string{$n};}}}
		return $webnev;
	}
}

class TOMB {
	/**
	 * ['id'=>'user1','nev'=>'otto']
	 * ból:[user1=>['id'=>'user1','nev'=>'otto']
	 * a kulcsmező értékét kiemeli sor kulcsnak;
	 * ha több egyforma érték is van, felülírja az ORDER BY-nak megfelellően
	 */
	static public function mezobol_kulcs(array $tomb, $kulcsmezo='id'){
		$tomb2=array();
		foreach($tomb as $sor )
		{	$sorindex= $sor[$kulcsmezo];
			$tomb2[$sorindex]=$sor;
		}

		return $tomb2;
	}
static public function to_string($tomb)
{
	$str = '';
	foreach ($tomb as $key => $value)
	{
		if (is_array($value))
		{
			$str =$str.self::to_string($value);
		}
		else
		{
			$str = $str . $key . ': ' . $value . '\n </br>';
		}
	}
	return $str;
}
static public function kiir($tomb){
	foreach($tomb as $key=>$value){
		if(is_array($value)){self::kiir($value);}else{echo $key.': '.$value.'\n </br>';}}
}
}

/**
 * link kezelő
 *
 */
class LINK
{
	/**
	 * a kép neve elé teszi a /thumb-ot (thumb elérési útját állítja elő
	 * @param $src
	 * @return string
	 */
static public function thumb_src($src)
{ 
///$path_parts = pathinfo('/www/htdocs/inc/lib.inc.php');
 //$path_parts['dirname'] /www/htdocs/inc
 //$path_parts['basename'] lib.inc.php
 //$path_parts['extension'] php
 //$path_parts['filename'] lib.inc
 $path_parts = pathinfo($src);
 $ujsrc=$path_parts['dirname'].'/thumb/'.$path_parts['basename'];
 return  $ujsrc;
}


static public function kiszed($link,$kiszed='')
{
	$linktomb=explode('&',parse_url($link, PHP_URL_QUERY));
	if(is_array($linktomb))
	{	$get_resz='';
		foreach($linktomb as $tag)
		{
			$altag = explode('=', $tag);
			if (($altag[0] != $kiszed))
			{
				$get_resz = $get_resz . $altag[0] . '='$altag[0].'&';
			}
		}
	}
	if($get_resz=='')
	{return parse_url($url, PHP_URL_PATH);}
	else
	{return parse_url($url, PHP_URL_PATH).'?'.$get_resz;}

}

static public function get_cserel($link,$cserel)
{
$csereT=explode('=',$cserel);
$link2=Link::kiszed($link,$csereT[0]);

return $link2.'&'.$csereT[0].'='.$csereT[1];
}
static public function link_cserel($cserel)
{
	$link2=self::get_cserel($_SERVER['REQUEST_URI'],$cserel);
	return $link2;
}

}



	
?>