<?php
	/**
	 * Wy¶wietlanie:
	 * - strony g³ównej i archiwum dla u¿ytkowników
	 * - artyku³ów i komentarzy
	 * - kategorii, artyku³ów w kategoriach
	 * - wyników wyszukiwania
	 * Dodawanie komentarzy
	 *
	 * @package artykuly.php
	 * @link http://wierzba.wzks.uj.edu.pl/~stanko/Gazeta
	 * @copyright 2009 Natalia Stanko
	 * @author Natalia Stanko <anithaly@gmail.com>
	 * @since 1.0.0 10.01.2009
	 * @version 1.0.0 10.01.2009
	 */      

	// do³±czenie pliku konfiguracyjnego
	include 'biblioteki/konfiguracja.inc.php';
  
  // wyswietlenie artyku³ów w danej kategorii
  if(isset($_GET['kategoria'])){
  	if(is_numeric($_GET['kategoria'])){
	   	 $id_kat = $_GET['kategoria'];
		// w kategorii te¿ stronicowanie (archiwum)
		$przedzial = $_GET['przedzial']; 
		$GLOBALS['strona']['przedzial'] = $przedzial;     
  	  	$GLOBALS['strona']['artykuly'] = pobierzArtykuly(3,$id_kat,$przedzial);             
	   	$GLOBALS['strona']['kategoria'] = pobierzJednaKategorie($id_kat);    
  	 	$GLOBALS['strona']['zawartosc'] = 'artykuly.tpl';                	
  	} else{
  		$GLOBALS['strona']['status']['komunikat'] = 'Niepoprawny identyfikator kategorii';	
	  	$GLOBALS['strona']['zawartosc'] = 'blad.tpl';
  	}
  }           
   
  // wyswietlenie artyku³u i jego komentarzy
  elseif(isset($_GET['artykul'])  && !isset($_POST['dodaj_komentarz']) ){
		if(is_numeric($_GET['artykul'])){
			$id_art = $_GET['artykul'];                 
	    		$GLOBALS['strona']['artykul'] = pobierzJedenArtykul($id_art);
  	 		$GLOBALS['strona']['komentarze'] = pobierzKomentarze($id_art);
    			$GLOBALS['strona']['zawartosc'] = 'artykul.tpl';        		
		} else{
  		$GLOBALS['strona']['status']['komunikat'] = 'Niepoprawny identyfikator kategorii';	
	  	$GLOBALS['strona']['zawartosc'] = 'blad.tpl';		
		}    
  }
   
  // dodanie komentarza do artyku³u
  elseif(isset($_GET['artykul']) && isset($_POST['dodaj_komentarz'])){    
  
  		// pobierz i przetwórz dane z formularza
		$GLOBALS['do_pobrania'] = array('tresc','email','podpis','id_art');		
		$GLOBALS['strona']['daneFormularza'] = pobierzZFormularza($_POST, $GLOBALS['do_pobrania']);  

		$GLOBALS['do_sprawdzenia'] = array('tresc','email','podpis');
  		sprawdzFormularz($GLOBALS['strona']['daneFormularza'], $GLOBALS['do_sprawdzenia']);
 		// je¶li nie by³o b³êdów
 		if(! count($GLOBALS['strona']['status']['bledyFormularza']) > 0){            
 		// jest ok, dodaj komentarz do bazy danych
     		$wynik = dodajKomentarz($GLOBALS['strona']['daneFormularza']); 	    
     		// wyczysc dane formularzz
     		$GLOBALS['strona']['daneFormularza'] = null;
 	  	}
    
    // wyswietl ponownie artykul i komentarze
    $id_art = $_POST['id_art'];
    $GLOBALS['strona']['artykul'] = pobierzJedenArtykul($id_art); 
    $GLOBALS['strona']['komentarze'] = pobierzKomentarze($id_art);    
    $GLOBALS['strona']['zawartosc'] = 'artykul.tpl';        
  }
  
  // wy¶wietlenie wyników wyszukiwania
  elseif(isset($_GET['szukaj']) && $_GET['szukaj'] != ''){
    $szukane = $_GET['szukaj'];
    $GLOBALS['strona']['artykuly'] = wyszukajArtykuly($szukane);
    $GLOBALS['strona']['szukanaFraza'] = $szukane;
    $GLOBALS['strona']['zawartosc'] = 'artykuly.tpl';                 
  }                                                                
  
  // wy¶wietlenie artyku³ów jako archiwum
  elseif(isset($_GET['przedzial'])){
    $przedzial = $_GET['przedzial'];                                  
    $GLOBALS['strona']['zawartosc'] = 'artykuly.tpl';                     
    $GLOBALS['strona']['artykuly'] = pobierzArtykuly(3,null,$przedzial);
    $GLOBALS['strona']['przedzial'] = $przedzial;                     
  }
  
  // wy¶wietlenie strony g³ownej, 3 artyku³y
  else{                                                 
    $GLOBALS['strona']['artykuly'] = pobierzArtykuly(3,null,1);                 
    $GLOBALS['strona']['zawartosc'] = 'strona_glowna.tpl';    
  }
 
  // za ka¿dym razem pobieramy listê kategorii do wy¶wietlenia w bocznej kolumnie 
  $GLOBALS['strona']['kategorie'] = pobierzKategorie();

	// przeslanie wyniku dzialania skryptu do szablonow:

	// przekazanie zmiennych
	$GLOBALS['szablon'] -> assign($GLOBALS['strona']);
	// wyswietlenie szablonu
	$GLOBALS['szablon'] -> display($GLOBALS['strona']['szablon']);
	
?>
