<?php
	/**
	 * Logowanie u¿ytkownika w systemie.
	 *
	 * @package index.php
	 * @link http://wierzba.wzks.uj.edu.pl/~stanko/Gazeta
	 * @copyright 2009 Natalia Stanko
	 * @author Natalia Stanko <anithaly@gmail.com>
	 * @since 1.0.0 10.01.2009
	 * @version 1.0.0 10.01.2009
	 */      

	session_name('redaktor');
	session_start();
	$szablony = 'admin';
	include '../biblioteki/konfiguracja.inc.php';

	// ustawienie szablonu strony
	$GLOBALS['strona']['zawartosc'] = 'logowanie.tpl'; 
	
	// jesli uzytkownik istnieje w sesji
	if ( isset($_SESSION['uzytkownik']) && count($_SESSION['uzytkownik'])>0 ) {	    
		  // uzytkownik jest juz zalogowany
		  $GLOBALS['strona']['uzytkownik'] = $_SESSION['uzytkownik'];
			// wyswietla powitanie
		  $GLOBALS['strona']['zawartosc'] = 'powitanie.tpl';
	}
	
	// jesli zostal wyslany formularz logowania (POST)
	elseif ( isset($_POST['wyslij']) && ($_POST['wyslij'] == '1' ) ) {
		// przetwarzamy formularz
		// okreslamy pola jakie wyciagamy z formularza i przetwarzamy
		$GLOBALS['do_pobrania'] = array('login', 'haslo');              
		
		// pobranie z formularza
		$GLOBALS['strona']['daneFormularza'] = pobierzZFormularza($_POST, $GLOBALS['do_pobrania']);
		
		// próbujemy zalogowaæ u¿ytkownika
		$GLOBALS['wynikLogowania'] = zalogujUzytkownika($GLOBALS['strona']['daneFormularza']);
		
			if ($GLOBALS['wynikLogowania'] == false ) {
				// wyst±pi³ b³±d podczas logowania u¿ytkownika
				$GLOBALS['strona']['status']['bledyFormularza'] = 'Niepoprawne login lub has³o';
				// wyswietlamy ponownie formularz logowania
				$GLOBALS['strona']['zawartosc'] = 'logowanie.tpl';   

				//zniszczenie sesji:
				@session_destroy();
			}
			else {
				// uzytkownik pomyslnie zalogowany
				// uzytkownik zapisany do sesji
				zapiszDoSesji($GLOBALS['wynikLogowania'], 'uzytkownik'); 
        
        // sprawdzenie czy uzytkownik jest usuniêty
        if($_SESSION['uzytkownik']['usuniety'] == 1){
          @session_destroy();
          $GLOBALS['strona']['status']['komunikat'] = 'Przepraszamy, ale konto zosta³o zawieszone przez administratora';
        } else{        
  				// zmienna uzytkownika przekazana do szablonu
  				$GLOBALS['strona']['uzytkownik'] = $_SESSION['uzytkownik'];
  				$GLOBALS['strona']['zawartosc'] = 'powitanie.tpl';          
        }
		}
	}
	
	// przeslanie wyniku dzialania skryptu do szablonow:
	
	// przekazanie zmiennych
	$GLOBALS['szablon'] -> assign($GLOBALS['strona']);
	// wyswietlenie szablonu
	$GLOBALS['szablon'] -> display($GLOBALS['strona']['szablon']);
	
?>
