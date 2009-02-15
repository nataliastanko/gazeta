<?php
	/**
	 * Administracja i zarz±dzanie artyku³ami
	 *
	 * @package artykuly.php
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

	// sprawdzenie czy uzytkownik jest zalogowany                              
	if ( isset($_SESSION['uzytkownik']) && count($_SESSION['uzytkownik']) > 0){
	  $GLOBALS['strona']['uzytkownik'] = $_SESSION['uzytkownik'];
	}
	
	// jesli zalogowany i admin to ma dostep do edycji artyku³ów
	if ( isset($_SESSION['uzytkownik']) && count($_SESSION['uzytkownik']) > 0) {

	// domyslny szablon: artykuly
	$GLOBALS['strona']['zawartosc'] = 'artykuly.tpl';          

	// wywolanie jednej z ponizszych AKCJI:
	

  	// wyswietlenie formularza dodawania nowego artykulu   	
  	if(isset($_GET['akcja']) && $_GET['akcja'] == 'dodaj'){ 	
  		// pobiera liste kategorii do wyswietlenia jako SELECT przy dodawaniu artykulu  
  	  	$GLOBALS['strona']['kategorie'] = pobierzKategorie();
  	 	// ustawia szablon
  		$GLOBALS['strona']['zawartosc'] = 'artykul_dodaj.tpl';          		
  	}
	

  	// zapisywanie nowego artyku³u do bazy danych		  
  	elseif( isset($_POST['dodaj'])){
   		
   		// pobranie, sprawdzenie i  przetworzenie danych z formularza 
  		$GLOBALS['do_pobrania'] = array('tytul','tresc','id_kat');		
  		$GLOBALS['strona']['daneFormularza'] = pobierzZFormularza($_POST, $GLOBALS['do_pobrania']);  
  		$GLOBALS['do_sprawdzenia'] = array('tytul','tresc');
    	sprawdzFormularz($GLOBALS['strona']['daneFormularza'], $GLOBALS['do_sprawdzenia']);

   	// jesli wyst±pi³y b³êdy to wyswietl formularz ponownie
   	if( count($GLOBALS['strona']['status']['bledyFormularza']) > 0){            
        $GLOBALS['strona']['kategorie'] = pobierzKategorie(); 	    
        $GLOBALS['strona']['zawartosc'] = 'artykul_dodaj.tpl';          		 	    
   	 } else{                                      
   	 // jest wszystko by³o ok, dodaj artyku³ do bazy
        $wynik = dodajArtykul($GLOBALS['strona']['daneFormularza']); 	    
        
   	  }
		
  	}		                            	
   
    	// Wyswietlenie formularza edycji wybranego artyku³u
  	elseif(isset($_GET['akcja']) && $_GET['akcja'] == 'edytuj'){ 
	 		
  	if(isset($_GET['id_artykul']) && is_numeric($_GET['id_artykul'])){    
	    
  	   	$id_art = $_GET['id_artykul'];
	    
  	   	// pobierz artyku³, wszystkie kategorie              
  	    	$GLOBALS['strona']['artykul'] = pobierzJedenArtykul($id_art);  
  	    	$GLOBALS['strona']['kategorie'] = pobierzKategorie();
  	  	 // wyswietl formualrz edycji
  		$GLOBALS['strona']['zawartosc'] = 'artykul_edytuj.tpl';          			    
  	  } else{
  	    $GLOBALS['strona']['status']['komunikat'] = 'B³±d, nie podano Id artyku³u lub Id w niepoprawnym formacie';
  	  }
  	}
   
    	// zapisywanie zmian w istniejacym artykule
  	elseif( isset($_POST['edytuj'])){

   		// pobranie, sprawdzenie i  przetworzenie danych z formularza 
  		$GLOBALS['do_pobrania'] = array('tytul','tresc','id_kat','id_art');		
  		$GLOBALS['strona']['daneFormularza'] = pobierzZFormularza($_POST, $GLOBALS['do_pobrania']);  

  		$GLOBALS['do_sprawdzenia'] = array('tytul','tresc');
    	sprawdzFormularz($GLOBALS['strona']['daneFormularza'], $GLOBALS['do_sprawdzenia']);

   	  // jesli bledy to wyswietl formularz ponownie
   	  if( count($GLOBALS['strona']['status']['bledyFormularza']) > 0){ 
   	  	$GLOBALS['strona']['artykul'] = $GLOBALS['strona']['daneFormularza'];
		$GLOBALS['strona']['kategorie'] = pobierzKategorie(); 	    
		$GLOBALS['strona']['zawartosc'] = 'artykul_edytuj.tpl';          		 	    
   	  } else{                                      
   	    // jest ok, dodaj artyku³ do bazy
        $wynik = zmienArtykul($GLOBALS['strona']['daneFormularza']); 	    
   	  }

  	}
   
    // usuniêcie artyku³u
  	elseif(isset($_GET['akcja']) && $_GET['akcja'] == 'usun'){ 
  	  if(isset($_GET['id_artykul']) && is_numeric($_GET['id_artykul'])){ 
  	    $id_art =  $_GET['id_artykul'];
  	    // usuwa wybrany artyku³
  	    usunArtykul($id_art);
  	  }
  	}  		                            		


		// domy¶lna akcja (je¶li nie ustawiono wczesniej inaczej
    // wy¶wietlenie listy artyku³ów
  	if ($GLOBALS['strona']['zawartosc'] == 'artykuly.tpl'){
  	  if($_SESSION['uzytkownik']['admin']){
  	  	// dla administratora wszystkie
  	    $GLOBALS['strona']['artykuly'] = pobierzArtykuly();  
  	  } else{
  	  	// dla redaktora, tylko jego
        $GLOBALS['strona']['artykuly'] = pobierzArtykulyRedaktora($_SESSION['uzytkownik']['id_redaktor']);  	    
  	  }
  	}
	             
	} 
	
	// brak autoryzacji
	else{
    $GLOBALS['strona']['status']['bledy'][] = 'Brak autoryzacji';          
	  $GLOBALS['strona']['zawartosc'] = 'blad.tpl';          
  }            
 
	// przeslanie wyniku dzialania skryptu do szablonow:

	// przekazanie zmiennych
	$GLOBALS['szablon'] -> assign($GLOBALS['strona']);
	// wyswietlenie szablonu
	$GLOBALS['szablon'] -> display($GLOBALS['strona']['szablon']);
	
?>
