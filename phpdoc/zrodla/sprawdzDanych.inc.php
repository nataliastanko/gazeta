<?php
	/**
	 * Funkcje do sprawdzania poprawno¶ci danych z formularzy
	 *
	 * @package artykuly.php
	 * @link http://wierzba.wzks.uj.edu.pl/~stanko/Gazeta
	 * @copyright 2009 Natalia Stanko
	 * @author Natalia Stanko <anithaly@gmail.com>
	 * @since 1.0.0 10.01.2009
	 * @version 1.0.0 10.01.2009
	 */      


	/**
	 * Funkcja sprawdzaj±ca czy zosta³y wype³nione wymagane pola formularza
	 *
	 * @param array $polaFormularza Tablica zawieraj±ca pola formularza
	 * @param array $wymaganePola Tablica zawieraj±ca informacje jakie pola (klucze) w formularzu s± wymagane
	 */
	function wymagajDanych($polaFormularza, $wymaganePola) {
		foreach ($wymaganePola as $klucz) {
			if ( !isset($polaFormularza[$klucz]) || $polaFormularza[$klucz] == '' ) {
				bladFormularza($klucz,'pole jest wymagane');
			}
		}
	}                     
	
	/**
	 * Sprawdzenie poprawno¶ci pola
	 *
	 * @param string $pole Nazwa pola w fomularzu
	 * @param string $wartosc Warto¶æ pola w formularzu
	 * @param int $dlugosc Maksymalna dlugosc pola
	 */
	function sprawdzPole($pole, $wartosc, $dlugosc) { 
    if ( !ereg("^[0-9A-Za-z¡ÆÊ£ÑÓ¦¯¬±æê³ñó¶¿¼ \.,!\-\?:;]+$",$wartosc) ) { 
			bladFormularza($pole, 'Pole zawiera nieprawid³owe znaki');
		}
		if ( strlen($wartosc) < 2 ) {
			bladFormularza($pole, 'Ci±g wprowadzony w polu jest za krótki');
		}
		elseif ( strlen($wartosc) > $dlugosc ) {
			bladFormularza($pole, 'Ci±g wprowadzony w polu jest za d³ugi');
		}                                               
	}

	/**
	 * Sprawdzenie poprawno¶ci pola tresci 
	 *
	 * @param string $pole Nazwa pola w fomularzu
	 * @param string $wartosc Warto¶æ pola w formularzu
	 * @param int $dlugosc Maksymalna dlugosc pola
	 */
	function sprawdzTresc($pole, $wartosc, $dlugosc) { 
		if ( strlen($wartosc) < 2 ) {
			bladFormularza($pole, 'Ci±g wprowadzony w polu jest za krótki');
		}
		elseif ( strlen($wartosc) > $dlugosc ) {
			bladFormularza($pole, 'Ci±g wprowadzony w polu jest za d³ugi');
		}                                               
	}


/**
 * Funkcja sprawdzaj±ca poprawno¶æ danych w formularzu
 *
 * @param array $dane Tablica zawieraj±ca dane pochodz±ce z formularza
 * @param array $wymaganePola Tablica zawieraj±ca informacje jakie pola w formularzu s± wymagane do sprawdzenia
 */
function sprawdzFormularz($dane, $wymaganePola) {
	wymagajDanych($dane, $wymaganePola); 

	foreach($wymaganePola as $klucz){
	  if($klucz == 'tresc'){
	    sprawdzTresc($klucz,$dane[$klucz],10000);
	  } 
	  elseif ($klucz == 'email'){
      sprawdzEmailUzytkownika($dane['email']); 	  	    
	  } 
	  else{
      sprawdzPole($klucz,$dane[$klucz],255);
	  }
	}
}


/* Sprawdzenie poprawno¶ci pola login dla formularza dodawania redaktora
 *
 * @param string $pole Warto¶æ pola login (idenfyfikator u¿ytkownika)
 *
 */
function sprawdzLoginUzytkownika($pole) {
	if ( !preg_match('/^[a-zA-Z0-9]+$/',$pole) ) {
		bladFormularza('login', 'Pole login zawiera nieprawid³owe znaki');
	}
	elseif ( ( strlen($pole) < 4 ) || ( strlen($pole)> 16 ) ) {
		bladFormularza('login', 'Pole login ma nieprawid³ow± d³ugo¶æ');
	}
}  

/* Sprawdzenie poprawno¶ci pola email dla formularza dodawania redaktora
 *
 * @param string $pole Warto¶æ pola email
 * 
 */
function sprawdzEmailUzytkownika($pole) {
	if ( !preg_match('/\w{1,}[@][\w\-]{1,}([.]([\w\-]{1,})){1,3}$/',$pole) ) {
		bladFormularza('email', 'Niepoprawny format adresu email');
	}
	elseif ( ( strlen($pole) < 7 ) || ( strlen($pole)> 128 ) ) {
		bladFormularza('email', 'Niepoprawna d³ugo¶æ adresu email');
	}
}

/**
/* Sprawdzenie poprawno¶ci pola has³o dla formularza dodawania redaktora
 *
 * @param string $pole Warto¶æ pola has³o
 *
 */  
 
function sprawdzHasloUzytkownika($pole) { 
	if ( !preg_match('/^[a-zA-Z0-9]+$/',$pole) ) {
		bladFormularza('haslo', 'Has³o zawiera nieprawid³owe znaki');
	}                                      

	if ( ( strlen($pole) < 4 ) || ( strlen($pole)> 16 ) ) {
		bladFormularza('haslo', 'Has³o ma nieprawid³ow± d³ugo¶æ (proszê podaæ od 4 do 16 znaków)');
	}          

  	if ( !preg_match('/[a-zA-Z]/', $pole) ) {
		bladFormularza('haslo', 'Has³o musi zawieraæ conajmniej jedn± literê');
	}
	
	if ( !preg_match('/[0-9]/', $pole) ) {
		bladFormularza('haslo', 'Has³o musi zawieraæ conajmniej jedn± cyfrê');
	}
}

/**
 * Funkcja sprawdzajaca formularz logowania.
 *
 * @param array $dane Tablica zawierajaca dane pochodzace z formularza
 * @param array $wymaganePola Tablica zawierajaca liste wymaganych pól
 */
function sprawdzDaneRedaktora($dane, $wymaganePola) {
	wymagajDanych($dane, $wymaganePola);
	sprawdzLoginUzytkownika($dane['login']);
	// jesli w wymaganych polach jest has³o to sprawd¼ has³o
	if(in_array('haslo',$wymaganePola)){  	  
	  sprawdzHasloUzytkownika($dane['haslo']);   
	}	
	// je¶li w wymaganych polach jest email to sprawd¼ email
	if(in_array('email',$wymaganePola)){  	  
    	sprawdzEmailUzytkownika($dane['email']); 	  
	}
} 
