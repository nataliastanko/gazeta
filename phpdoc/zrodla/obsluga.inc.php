<?php
	/**
	 * Podstawowe funkcje do obs�ugi aplikacji
	 *
	 * @package obsluga.inc.php
	 * @link http://wierzba.wzks.uj.edu.pl/~stanko/Gazeta
	 * @copyright 2009 Natalia Stanko
	 * @author Natalia Stanko <anithaly@gmail.com>
	 * @since 1.0.0 10.01.2009
	 * @version 1.0.0 10.01.2009
	 */      

/**
 * Wstawienie do tablicy bled�w formularza informacji o b�dnie wype�nionym polu wraz z opisem.
 *
 * @param string $pole Nazwa b�dnie wype�nionego pola
 * @param string $opisBledu Opis b��du
 */
function bladFormularza($pole, $opisBledu = 'Nieprawid�owa warto�� w polu.') {
	// jesli juz istnieje tablica z bledami formularza to dopisuje do niej
	if ( isset($GLOBALS['strona']['status']['bledyFormularza']) ) {        
		// jesli ju� istnieje b��d dla danego pola
	  if(isset($GLOBALS['strona']['status']['bledyFormularza'][$pole])){
	  	// to dopisuje do tego pola
      $GLOBALS['strona']['status']['bledyFormularza'][$pole] = $GLOBALS['strona']['status']['bledyFormularza'][$pole] . '<br/>' . $opisBledu;
	  } else{
	  	// w przeciwnym wypadku dopisuje pole z b��dem do tablicy
	    $GLOBALS['strona']['status']['bledyFormularza'] = $GLOBALS['strona']['status']['bledyFormularza'] + array($pole => $opisBledu);  
	  }
		
	}
	// jesli nie to tworzy now� tablic� z b��dami
	else {
		$GLOBALS['strona']['status']['bledyFormularza'] = array($pole => $opisBledu);
	}
}
                                                                                      

/**
 * Wstawienie do tablicy b��d�w komunikatu z b��dem
 *
 * @param string $opis Opis b��du
 */
function blad($opis) {
	$GLOBALS['strona']['bledy'][] = $opis;	
}

/**
 * Ustawienie komunikatu
 *
 * @param string $opis Tre�� komunikatu
 */
function komunikat($opis) {
	$GLOBALS['strona']['status']['komunikat'] = $opis;	
}



/**
 * Pr�ba zalogowania u�ytkownika w systemie
 *
 * @param array $dane tablica z danymi pochodz�cymi z formularza logowania
 * @return integer Wynik autoryzacji
 */
function zalogujUzytkownika($dane) { 
	if ( !sqlPolacz() ) {
		return false; 
	} 
	else {
		$dane = sqlPrzygotuj($dane); //real_escape_string
		$haslo = md5($dane['haslo']);
		$zapytanie = "SELECT * FROM redaktor WHERE login='$dane[login]' AND	haslo = '$haslo'";
		$wynik = sqlZapytanie($zapytanie);
		if (!$wynik) {       
			blad('Nie uda�o si� po��czy� z baz� danych');
			return false;
		}
		elseif ( mysql_num_rows($wynik) != 1 ) {
			blad('Nast�pi�a pr�ba nieautoryzowanego dost�pu do danych.');
			return false;
		}
		else {
			return mysql_fetch_assoc($wynik);
		}
	}
}

/**
 * Zapisanie danych do sesji.
 *
 * @param array $daneDoZapisania Tablica z danymi jakie maj� zosta� zapisane do sesji
 * @param string $tablicaDocelowa Tablica, do kt�rej zostan� zapisane dane
 *
 */
function zapiszDoSesji($daneDoZapisania, $tablicaDocelowa='') {
	if( $tablicaDocelowa != '' ) {
		foreach( $daneDoZapisania as $klucz => $wartosc ) {
			$_SESSION[$tablicaDocelowa][$klucz] = $wartosc;
		}
	}
	else {
		foreach( $daneDoZapisania as $klucz => $wartosc ) {
			$_SESSION[$klucz] = $wartosc;
		}
	}
}

/**
 * Wyciagniecie danych z sesji i przekazanie do szablonu.
 *
 * @param string $daneSesyjne Nazwa tablicy z jakiej maj� zosta� pobrane dane
 * @param string $tablicaSzablonu Nazwa tablicy do jakiej maja zosta� zapisane dane
 */
function przekazDoSzablonu($daneSesyjne, $tablicaSzablonu ) {
	foreach($_SESSION[$daneSesyjne] as $klucz => $wartosc ) {
		$GLOBALS['strona'][$tablicaSzablonu][$klucz] = $wartosc;
	}
}

/**
 * Przygotowanie zmiennych pochodz�cych z formularza do przetworzenia przez skrypt.
 *
 * @param array $pola Tablica zawieraj�ca dane pochodz�ce z formularza
 * @param array $wymagane Tablica zawieraj�ca informacje jakie pola w formularzu maj� zosta� przetworzone
 *
 * @return array Tablica przetworzonych p�l
 */
function pobierzZFormularza($pola, $wymagane) {
	foreach ($wymagane as $klucz) {
	  // if isset($_POST['nazwa'])
		if ( isset($pola[$klucz]) && $pola[$klucz] != '' ) {
			$wartosc = $pola[$klucz];
			
			// jesli php dodaje slashe przed zmiennymi wyslanymi przez POST, GET to je wycinamy			
			if(get_magic_quotes_gpc()){
		    $wartosc = stripslashes($wartosc);
		  } 		  
		  // wyczysc spacje na poczatku i koncu
		  $wartosc = trim($wartosc);		  
		  // zabezpiecz przed wstawianiem HTML		  
		  $wartosc = htmlspecialchars($wartosc);

			// ostatecznie przypisz wartosc do zwrocenia
			$dane[$klucz] = $wartosc;
		}           
		else {
			$dane[$klucz] = '';
		}
	}
	return $dane;
}



/**
 * Wyrejestrowanie danych z sesji.
 *
 * $param string $nazwaTablicy Nazwa tablicy zawieraj�cej dane do wyrejestrowania
 */
function wyrejestrujSesja($nazwaTablicy) {
  foreach($_SESSION[$nazwaTablicy] as $klucz => $wartosc ) {
    unset($_SESSION[$nazwaTablicy][$klucz]);
 }
}
   
