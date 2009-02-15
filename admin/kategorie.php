<?php
	/**
	 * Administracja i zarz±dzanie kategoriami
	 *
	 * @package kategorie.php
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
	
	// jesli zalogowany i admin to ma dostep do edycji kategorii
	if ( isset($_SESSION['uzytkownik']) && count($_SESSION['uzytkownik']) > 0 && $_SESSION['uzytkownik']['admin'] == 1) {
    
    	// domyslny szablon, lista kategorii
		$GLOBALS['strona']['zawartosc'] = 'kategorie.tpl'; 

   	// wyswietlenie formularza dodawania nowej kategorii
  	if(isset($_GET['akcja']) && $_GET['akcja'] == 'dodaj'){  
  		$GLOBALS['strona']['zawartosc'] = 'kategoria_dodaj.tpl';          		
  	}
	
	  // dodawanie nowej kategorii (zapisanie do bazy danych)	
	  elseif(isset($_POST['dodaj'])){          	  		
  		$GLOBALS['do_pobrania'] = array('nazwa');		
  		$GLOBALS['strona']['daneFormularza'] = pobierzZFormularza($_POST, $GLOBALS['do_pobrania']);  

  		$GLOBALS['do_sprawdzenia'] = array('nazwa');    
    	sprawdzFormularz($GLOBALS['strona']['daneFormularza'], $GLOBALS['do_sprawdzenia']);
      
      	// sprawdzenie czy kategoria ju¿ istnieje
      	$GLOBALS['strona']['kategorie'] = pobierzKategorie();  
    	if(in_array($GLOBALS['strona']['daneFormularza']['nazwa'],$GLOBALS['strona']['kategorie'])){
        bladFormularza('nazwa','Istnieje ju¿ kategoria o tej nazwie');
      	}

   	// jesli bledy to wyswietl formularz ponownie
   	if( count($GLOBALS['strona']['status']['bledyFormularza']) > 0){
        $GLOBALS['strona']['zawartosc'] = 'kategoria_dodaj.tpl';          		 	    
   	  } else{                                      
   	    // jest ok, dodaj kategorie do bazy
        $wynik = dodajKategorie($GLOBALS['strona']['daneFormularza']); 	    
   	  }
	  }

   	// Wyswietlenie formularza edycji wybranej kategorii
	  elseif(isset($_GET['akcja']) && $_GET['akcja'] == 'edytuj'){ 
  	  if(isset($_GET['id_kat']) && is_numeric($_GET['id_kat'])){        
  	    $id_kat = $_GET['id_kat'];
  	    // pobierz kategoriê do edycji
  	    $GLOBALS['strona']['kategoria'] = pobierzJednaKategorie($id_kat);  
  		  $GLOBALS['strona']['zawartosc'] = 'kategoria_edytuj.tpl';          			    
  	  } else{
  	    $GLOBALS['strona']['status']['komunikat'] = 'B³±d. Nie podano Id kategorii lub Id w niepoprawnym formacie';
  	  }
	  }

    	// zmiana istniej±cej kategorii (zapisanie zmian w bazie danych)
	  elseif(isset($_POST['edytuj'])){
  		$GLOBALS['do_pobrania'] = array('nazwa','id_kat');
  		$GLOBALS['strona']['daneFormularza'] = pobierzZFormularza($_POST, $GLOBALS['do_pobrania']);  

  		$GLOBALS['do_sprawdzenia'] = array('nazwa');
    	sprawdzFormularz($GLOBALS['strona']['daneFormularza'], $GLOBALS['do_sprawdzenia']);

   	  // jesli bledy to wyswietl formularz ponownie
   	  if( count($GLOBALS['strona']['status']['bledyFormularza']) > 0){
  	    // przywracamy oryginaln± nazwê kategorii
        $GLOBALS['strona']['kategoria'] = pobierzJednaKategorie($_POST['id_kat']);  	    
        $GLOBALS['strona']['zawartosc'] = 'kategoria_edytuj.tpl';          		 	    
   	  } else{                                      
   	    // jest ok, dodaj kategorie do bazy
        $wynik = zmienKategorie($GLOBALS['strona']['daneFormularza']); 	    
   	  }

    }
       
    // usuniêcie wybranej kategorii       
	  elseif(isset($_GET['akcja']) && $_GET['akcja'] == 'usun'){ 
	    if(isset($_GET['id_kat']) && is_numeric($_GET['id_kat'])){ 
	      $id_kat =  $_GET['id_kat'];
	      // usuwa wybran± kategoriê
	      usunKategorie($id_kat);
	    }
	  }  		                            		

		// jesli zawartosc to lista kategorii to pobierz kategorie
	  if($GLOBALS['strona']['zawartosc'] == 'kategorie.tpl'){
	    $GLOBALS['strona']['kategorie'] = pobierzKategorie();  
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
