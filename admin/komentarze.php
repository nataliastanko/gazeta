<?php
	/**
	 * Moderacja komentarzy
	 *
	 * @package komentarze.php
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

	// uzytkownik jest zalogowany                              
	if ( isset($_SESSION['uzytkownik']) && count($_SESSION['uzytkownik']) > 0){
	  $GLOBALS['strona']['uzytkownik'] = $_SESSION['uzytkownik'];
	}
	
	// jesli zalogowany i admin to ma dostep do edycji komentarzy
	if ( isset($_SESSION['uzytkownik']) && count($_SESSION['uzytkownik']) > 0 && $_SESSION['uzytkownik']['admin'] == 1) {
 
	
  	if(isset($_GET['akcja']) && $_GET['akcja'] == 'usun'){ 
  	  if(isset($_GET['id_kom']) && is_numeric($_GET['id_kom'])){ 
  	    $id_kom =  $_GET['id_kom'];
  	    // usuwa wybrany komentarz
  	    usunKomentarz($id_kom);
  	  }
  	}  		                            		
    
    	$GLOBALS['strona']['zawartosc'] = 'komentarze.tpl';            
	$GLOBALS['strona']['komentarze'] = pobierzKomentarze();
  
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
