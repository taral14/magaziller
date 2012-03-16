<?php
class TranslitFormatter extends CApplicationComponent  {

    public function formatUrl($str){
        $tr = array(
          "А"=>"a","Б"=>"b","В"=>"v","Г"=>"g",
          "Д"=>"d","Е"=>"e","Ж"=>"j","З"=>"z","И"=>"i",
          "Й"=>"y","К"=>"k","Л"=>"l","М"=>"m","Н"=>"n",
          "О"=>"o","П"=>"p","Р"=>"r","С"=>"s","Т"=>"t",
          "У"=>"u","Ф"=>"f","Х"=>"h","Ц"=>"ts","Ч"=>"ch",
          "Ш"=>"sh","Щ"=>"sch","Ъ"=>"","Ы"=>"yi","Ь"=>"",
          "Э"=>"e","Ю"=>"yu","Я"=>"ya","а"=>"a","б"=>"b",
          "в"=>"v","г"=>"g","д"=>"d","е"=>"e","ж"=>"j",
          "з"=>"z","и"=>"i","й"=>"y","к"=>"k","л"=>"l",
          "м"=>"m","н"=>"n","о"=>"o","п"=>"p","р"=>"r",
          "с"=>"s","т"=>"t","у"=>"u","ф"=>"f","х"=>"h",
          "ц"=>"ts","ч"=>"ch","ш"=>"sh","щ"=>"sch","ъ"=>"y",
          "ы"=>"yi","ь"=>"","э"=>"e","ю"=>"yu","я"=>"ya",
          " "=> "-", "."=> "", "/"=> "-"
        );
 
        if (preg_match('/[^A-Za-z0-9_\-]/', $str)) {
            $str = strtr($str,$tr);
            $str = preg_replace('#[^A-Za-z0-9_\-]#', '', $str);
            $str = preg_replace('#(\-{2,})#', '-', $str);
            $str = preg_replace('#(\s{2,})#', ' ', $str);
        }

        return $str;
    }

    public function formatText($str) {
        $tr = array(
          "А"=>"a","Б"=>"b","В"=>"v","Г"=>"g",
          "Д"=>"d","Е"=>"e","Ж"=>"j","З"=>"z","И"=>"i",
          "Й"=>"y","К"=>"k","Л"=>"l","М"=>"m","Н"=>"n",
          "О"=>"o","П"=>"p","Р"=>"r","С"=>"s","Т"=>"t",
          "У"=>"u","Ф"=>"f","Х"=>"h","Ц"=>"ts","Ч"=>"ch",
          "Ш"=>"sh","Щ"=>"sch","Ъ"=>"","Ы"=>"yi","Ь"=>"",
          "Э"=>"e","Ю"=>"yu","Я"=>"ya","а"=>"a","б"=>"b",
          "в"=>"v","г"=>"g","д"=>"d","е"=>"e","ж"=>"j",
          "з"=>"z","и"=>"i","й"=>"y","к"=>"k","л"=>"l",
          "м"=>"m","н"=>"n","о"=>"o","п"=>"p","р"=>"r",
          "с"=>"s","т"=>"t","у"=>"u","ф"=>"f","х"=>"h",
          "ц"=>"ts","ч"=>"ch","ш"=>"sh","щ"=>"sch","ъ"=>"y",
          "ы"=>"yi","ь"=>"","э"=>"e","ю"=>"yu","я"=>"ya",
        );

        $str = strtr($str,$tr);
        return $str;
    }

    public function formatFileName($str) {
		$tr = array(
			'а' => 'a',   'б' => 'b',   'в' => 'v',
			'г' => 'g',   'д' => 'd',   'е' => 'e',
			'ё' => 'e',   'ж' => 'zh',  'з' => 'z',
			'и' => 'i',   'й' => 'y',   'к' => 'k',
			'л' => 'l',   'м' => 'm',   'н' => 'n',
			'о' => 'o',   'п' => 'p',   'р' => 'r',
			'с' => 's',   'т' => 't',   'у' => 'u',
			'ф' => 'f',   'х' => 'h',   'ц' => 'c',
			'ч' => 'ch',  'ш' => 'sh',  'щ' => 'sch',
			'ь' => '',    'ы' => 'y',   'ъ' => '',
			'э' => 'e',   'ю' => 'yu',  'я' => 'ya',

			'А' => 'A',   'Б' => 'B',   'В' => 'V',
			'Г' => 'G',   'Д' => 'D',   'Е' => 'E',
			'Ё' => 'E',   'Ж' => 'Zh',  'З' => 'Z',
			'И' => 'I',   'Й' => 'Y',   'К' => 'K',
			'Л' => 'L',   'М' => 'M',   'Н' => 'N',
			'О' => 'O',   'П' => 'P',   'Р' => 'R',
			'С' => 'S',   'Т' => 'T',   'У' => 'U',
			'Ф' => 'F',   'Х' => 'H',   'Ц' => 'C',
			'Ч' => 'Ch',  'Ш' => 'Sh',  'Щ' => 'Sch',
			'Ь' => '',    'Ы' => 'Y',   'Ъ' => '',
			'Э' => 'E',   'Ю' => 'Yu',  'Я' => 'Ya',
		);
        $str=strtr($str, $tr);
        $str=preg_replace('~[^-a-z0-9_]+~u', '_', $str);
        $str=trim($str, "_");

        return $str;
    }

}