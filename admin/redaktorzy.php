<?php
	/**
	 * Administracja i zarz±dzanie redaktorami
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
	
	// uzytkownik jest zalogowany                              
	if ( isset($_SESSION['uzytkownik']) && count($_SESSION['uzytkownik']) > 0){
	  $GLOBALS['strona']['uzytkownik'] = $_SESSION['uzytkownik'];
	}
	
	// jesli zalogowany i admin to ma dostep do edycji redaktorów
	if ( isset($_SESSION['uzytkownik']) && count($_SESSION['uzytkownik']) > 0 && $_SESSION['uzytkownik']['admin'] == 1) {
   
    	//domyslnie wyswietl liste redaktorow    
	$GLOBALS['strona']['zawartosc'] = 'redaktorzy.tpl';          
    
    	// wyswietlenie formularza dodawania nowego redaktora	
	if(isset($_GET['akcja']) && $_GET['akcja'] == 'dodaj'){ 
	$GLOBALS['strona']['zawartosc'] = 'redaktor_dodaj.tpl';          		
	} 
	
	 // dodanie nowego redaktora (zapisanie do bazy danych)
	 elseif( isset($_POST['dodaj'])){
	  
  		$GLOBALS['do_pobrania'] = array('login','haslo','email','bio');		
  		$GLOBALS['strona']['daneFormularza'] = pobierzZFormularza($_POST, $GLOBALS['do_pobrania']);  

  		$GLOBALS['do_sprawdzenia'] = array('login','haslo','email');
    		sprawdzDaneRedaktora($GLOBALS['strona']['daneFormularza'], $GLOBALS['do_sprawdzenia']);

   	  	// jesli bledy to wyswietl formularz ponownie
   	 	if( count($GLOBALS['strona']['status']['bledyFormularza']) > 0){            
  		  $GLOBALS['strona']['zawartosc'] = 'redaktor_dodaj.tpl';          		
   	  	} else{                                      
   	    	// jest ok, dodaj redaktora do bazy
        	$wynik = dodajRedaktora($GLOBALS['strona']['daneFormularza']); 	    
   	  	}
	  
	  }
	      
	// edycja redaktora (wy¶wietlenie formularza edycji redaktora)
	elseif(isset($_GET['akcja']) && $_GET['akcja'] == 'edytuj'){ 

	   	if(isset($_GET['id_redaktor']) && is_numeric($_GET['id_redaktor'])){    	    
        	$id_redaktor = $_GET['id_redaktor'];
	      
	     	// pobiera redaktora z bazy danych do edycji
	     	$GLOBALS['strona']['redaktor'] = pobierzJednegoRedaktora($id_redaktor);  
		    $GLOBALS['strona']['zawartosc'] = 'redaktor_edytuj.tpl';          			    
	    	} else{
	      	$GLOBALS['strona']['status']['komunikat'] = 'Nie podano Id redaktora lub Id w niepoprawnym formacie';
	    	}
	  }
	
	 // zapisanie zmian w redaktorze po edycji
	 elseif( isset($_POST['edytuj']) && isset($_POST['id_redaktor'])){
    
    		$GLOBALS['do_pobrania'] = array('login','haslo','email','bio','id_redaktor','admin');		
    		$GLOBALS['strona']['daneFormularza'] = pobierzZFormularza($_POST, $GLOBALS['do_pobrania']);  
        
        	if($GLOBALS['strona']['daneFormularza']['haslo'] != ''){
    		  $GLOBALS['do_sprawdzenia'] = array('login','haslo','email');
    		} else{
         	$GLOBALS['do_sprawdzenia'] = array('login','email');		  
    		}                   

      		sprawdzDaneRedaktora($GLOBALS['strona']['daneFormularza'], $GLOBALS['do_sprawdzenia']);

     	 	 // jesli bledy to wyswietl formularz ponownie
     	 	 if( count($GLOBALS['strona']['status']['bledyFormularza']) > 0){            
     	 	 $GLOBALS['strona']['redaktor'] = pobierzJednegoRedaktora($_POST['id_redaktor']);
    		 $GLOBALS['strona']['zawartosc'] = 'redaktor_edytuj.tpl';          		
     	  	} else{                                      
     	    	// jest ok, zapisz zmiany w bazie danych
         	$wynik = zmienRedaktora($GLOBALS['strona']['daneFormularza']); 	    
     	  	}
   		
	}	
		
	// usuwanie redaktora
	elseif(isset($_GET['akcja']) && $_GET['akcja'] == 'usun'){ 
	    if(isset($_GET['id_redaktor']) && is_numeric($_GET['id_redaktor'])){ 
	      $id_redaktor =  $_GET['id_redaktor'];	      
	      usunRedaktora($id_redaktor);                            	      
	    }
	}  		                            		
	
	// przywracanie redaktora
	elseif(isset($_GET['akcja']) && $_GET['akcja'] == 'przywroc'){ 
	    if(isset($_GET['id_redaktor']) && is_numeric($_GET['id_redaktor'])){ 
	      $id_redaktor =  $_GET['id_redaktor'];
	      // przywraca redaktora
	      przywrocRedaktora($id_redaktor);
	    }
	}
	  
	// jesli szablon do wyswietlenia to lista redaktorow to:
	if($GLOBALS['strona']['zawartosc'] == 'redaktorzy.tpl'){
      	// pobierz redaktorow z bazy danych
      	$GLOBALS['strona']['redaktorzy'] = pobierzRedaktorow();	               
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
