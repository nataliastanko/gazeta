<?php
	/**
	 * Funkcje do obs³ugi wy¶wietlania i edycji komentarzy
	 *
	 * @package komentarze.inc.php
	 * @link http://wierzba.wzks.uj.edu.pl/~stanko/Gazeta
	 * @copyright 2009 Natalia Stanko
	 * @author Natalia Stanko <anithaly@gmail.com>
	 * @since 1.0.0 10.01.2009
	 * @version 1.0.0 10.01.2009
	 */      

 /**
  * Dodanie nowego komentarza do artyku³u do bazy danych.
  *
  * @param array $dane Tablica danych do zapisania do bazy
  * @return integer Wynik zapytania do bazy danych
  */
 function dodajKomentarz($dane) {
 	if( !sqlPolacz() ) {
 		return false;
 	}
 	else {
 		$dane = sqlPrzygotuj($dane);  

 		$zapytanie = "INSERT INTO komentarz (tresc,podpis,email,data_kom,id_art) VALUES (
 			'$dane[tresc]',
 			'$dane[podpis]',
 			'$dane[email]',			
 			NOW(),
 			'$dane[id_art]'
 		 )";  		 

 		if( ! sqlZapytanie($zapytanie) ) {
 			blad('Nie udalo sie dodac nowego komentarza');
 			return false;
 		}
 		else {             
      komunikat('Komentarz zosta³ dodany'); 
	 	  return true;
    }       
 	}
 }



 /**
  * Pobranie listy komentarz
  *  - dla wybranego artyku³u
  *  - wszystkich dla panelu administratora gdy nie podano Id artyku³u
  *
  * @param integer $id_art=null Id artyku³u dla którego pobieramy komentarze
  * @return array Wynik zapytania do bazy danych
  */
 function pobierzKomentarze($id_art = null){
 	if ( !sqlPolacz() ) {
 		return false;
 	}
 	else {         
 	  if($id_art != null){
 		  $zapytanie = "SELECT * FROM komentarz WHERE id_art = $id_art ORDER BY data_kom ASC";
 		} else{
      $zapytanie = "SELECT * FROM komentarz ORDER BY data_kom ASC"; 		  
 		}
 		$wynik = sqlZapytanie($zapytanie);
 		if (!$wynik) {
 			blad('Nie uda³o siê pobraæ komentarzy');
 			return false;
 		}
 		else {
 			$dane = array();
 			while ( $rekord = mysql_fetch_assoc($wynik) ) {
 				$dane[] = $rekord;
 			}
 			// zwolnienie pamiêci zajmowanej przez wyniki
 			mysql_free_result($wynik);
 			return $dane;
 		}
 	}   
 }   
 

 /**
  * Usuwa komentarz z bazy danych.
  *
  * @param integer $id_kom Id komentarza do usuniêcia
  * @return integer Wynik zapytania do bazy danych
  */
 function usunKomentarz($id_kom) {
 	if( !sqlPolacz() ) {
 		return false;
 	}
 	else {

 		$zapytanie = "DELETE FROM komentarz WHERE id_kom = $id_kom;";
    $wynik = sqlZapytanie($zapytanie);
      if(!$wynik){   
        // jesli blad
 			 blad('Nie udalo sie usunac komentarza');
 			 return false;
 		  }
 		 else {  
      komunikat('Komentarz zosta³ usuniety');
 	    return true;
 	   }

   }
 } 
 
 