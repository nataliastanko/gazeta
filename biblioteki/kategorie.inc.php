<?php
	/**
	 * Funkcje do obs³ugi wy¶wietlania i edycji kategorii
	 *
	 * @package kategorie.inc.php
	 * @link http://wierzba.wzks.uj.edu.pl/~stanko/Gazeta
	 * @copyright 2009 Natalia Stanko
	 * @author Natalia Stanko <anithaly@gmail.com>
	 * @since 1.0.0 10.01.2009
	 * @version 1.0.0 10.01.2009
	 */      



/**
 * Dodanie nowej kategorii do bazy danych.
 *
 * @param array $dane Tablica danych do zapisania do bazy
 * @return integer Wynik zapytania do bazy danych
 */
function dodajKategorie($dane) {
	if( !sqlPolacz() ) {
		return false;
	}
	else {
		$dane = sqlPrzygotuj($dane);  
				                          
		$zapytanie = 'INSERT INTO kategoria (nazwa) VALUES (\'' . $dane['nazwa'] . '\');';
		if( !sqlZapytanie($zapytanie) ) {
			blad('Nie uda³o siê utworzyæ nowej kategorii.');
			return false;
		}
		else {
			komunikat('Kategoria zosta³a dodana!');
			return true;
		}
	}
}                  

    
/**
 * Pobranie listy kategorii
 *
 * @return array Wynik pobrania danych
 */
function pobierzKategorie() {
	if ( !sqlPolacz() ) {
		return false;
	}
	else {
		$zapytanie = 'SELECT * FROM kategoria ORDER BY nazwa ASC';
		$wynik = sqlZapytanie($zapytanie);
		if (!$wynik) {
			blad('Zapytanie nie uda³o siê');
			return false;
		}
		elseif ( mysql_num_rows($wynik) <1 ) {
			blad('Zapytanie nie zwróci³o ¿adnych wyników');
			return false;
		}
		else {
			$dane = array();
			while ( $rekord = mysql_fetch_assoc($wynik) ) {
				$dane[$rekord['id_kat']] = $rekord['nazwa'];
			}
			// zwolnienie pamiêci zajmowanej przez wyniki
			mysql_free_result($wynik);
			return $dane;
		}
	}
}      


/**
 * Pobranie jednej kategorii
 * 
 * @param integer $id_kat Id kategorii do pobrania
 * @return array Wynik pobrania danych
 */
function pobierzJednaKategorie($id_kat){
	if ( !sqlPolacz() ) {
		return false;
	}
	else {
		$zapytanie = "SELECT * FROM kategoria WHERE id_kat = '$id_kat';";
		$wynik = sqlZapytanie($zapytanie);
		if (!$wynik) {
			blad('Zapytanie nie uda³o siê');
			return false;
		}
		elseif ( mysql_num_rows($wynik) < 1 ) {
			blad('Zapytanie nie zwróci³o ¿adnych wyników');
			return false;
		}
		else {
			$rekord = mysql_fetch_assoc($wynik);
			// zwolnienie pamiêci zajmowanej przez wynik:
			mysql_free_result($wynik);
			return $rekord;
		}
	}  
}


/**
 * Zmienia kategoriê w bazie danych
 *
 * @param array $dane Tablica danych do zapisania do bazy
 * @return integer Wynik zapytania do bazy danych
 */
function zmienKategorie($dane) {
	if( !sqlPolacz() ) {
		return false;
	}
	else {
		$dane = sqlPrzygotuj($dane);  
				
		$zapytanie = "UPDATE kategoria 
		  SET nazwa = '$dane[nazwa]'
		  WHERE id_kat = '$dane[id_kat]';";
     $wynik = sqlZapytanie($zapytanie);
     if(!$wynik){
				blad('Nie uda³o siê zapisaæ zmian');
			 return false;
		  }
		 else { 
      komunikat('Kategoria zosta³a zmieniona.');        	
	    return true;
	  }

  }
}

     
/**
 * Usuwa kategoriê z bazy danych
 * przepisuje artyku³y z usuniêtej kategorii do kategorii domy¶lnej
 *
 * @param array $dane Tablica danych do zapisania do bazy
 * @return integer Wynik zapytania do bazy danych
 */

function usunKategorie($id_kat) {
	if( !sqlPolacz() ) {
		return false;
	}
	else {  
	    	// nie pozwol na usuniecie domyslnej kategorii
		if($id_kat == 1){
       		blad('Nie mozna usun±æ domy¶lnej kategorii');
     		return false;
		 }                                              
		                          		 
     // usun wybrana kategorie                 		
     $zapytanie1 = "DELETE FROM kategoria WHERE id_kat = '$id_kat';";
     $wynik1 = sqlZapytanie($zapytanie1);
     if(!$wynik1){   
       // jesli blad
       blad('Nie udalo sie usun±æ kategorii');
			 return false;
		  }
		 else {
		   // jesli sie udalo 
		   // przepisz artykuly z usuwanej kategorii do kategorii domyslnej		        
  		 $zapytanie2 = "UPDATE artykul SET id_kat = '1' WHERE id_kat = '$id_kat';";
       $wynik2 = sqlZapytanie($zapytanie2);		 		   
       komunikat('Kategoria zosta³a usunieta');
	     return true;
	   }

  }
}  

