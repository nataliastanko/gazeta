<?php
	/**
	 * Funkcje do obs�ugi wy�wietlania i edycji redaktor�w
	 *
	 * @package redaktorzy.inc.php
	 * @link http://wierzba.wzks.uj.edu.pl/~stanko/Gazeta
	 * @copyright 2009 Natalia Stanko
	 * @author Natalia Stanko <anithaly@gmail.com>
	 * @since 1.0.0 10.01.2009
	 * @version 1.0.0 10.01.2009
	 */      
	 
	 

 /**
  * Dodanie nowego redaktora do bazy danych.
  *
  * @param array $dane Tablica danych do zapisania do bazy
  * @return integer Wynik zapytania do bazy danych
  */
 function dodajRedaktora($dane) {
 	if( !sqlPolacz() ) {
 		return false;
 	}
 	else {
 		$dane = sqlPrzygotuj($dane);  

		// zakoduj has�o
 		$dane['haslo'] = md5($dane['haslo']);                          
 		$zapytanie = "INSERT INTO redaktor (login,haslo,email,data_dolaczenia,bio) VALUES (
 			'$dane[login]',
 			'$dane[haslo])',
 			'$dane[email]',
 			NOW(),
 			'$dane[bio]'
 		 )";


 		if( !sqlZapytanie($zapytanie) ) {
 			blad('Nie uda�o si�utworzy� redaktora');
 			return false;
 		}
 		else {
 			komunikat('Redator zosta� dodany');
 			return true;
 		}
 	}
 }


 /**
  * Pobiera list� redaktor�w z bazy danych
  *
  * @return array Wynik zapytania do bazy danych
  */

 function pobierzRedaktorow(){
 	if ( !sqlPolacz() ) {
 		return false;
 	}
 	else {
 		$zapytanie = 'SELECT * FROM redaktor ORDER BY login ASC';
 		$wynik = sqlZapytanie($zapytanie);
 		if (!$wynik) {
 			blad('Zapytanie nie powiod�o si�');
 			return false;
 		}
 		elseif ( mysql_num_rows($wynik) <1 ) {
	 		blad('Zapytanie nie zwr�ci�o �adnych rezultat�w');
 			return false;
 		}
 		else {
 			$dane = array();
 			while ( $rekord = mysql_fetch_assoc($wynik) ) {
 				$dane[] = $rekord;
 			}
 			// zwolnienie pami�ci zajmowanej przez wynik:
 			mysql_free_result($wynik);
 			return $dane;
 		}
 	}   
 }  


 /**
  * Pobiera jednego redaktora z bazy danych
  *
  * @param integer $id_redaktor Id redaktora do pobrania z bazy danych
  * @return array Wynik zapytania do bazy danych
  */
 function pobierzJednegoRedaktora($id_redaktor){
 	if ( !sqlPolacz() ) {
 		return false;
 	}
 	else {
 		$zapytanie = "SELECT * FROM redaktor WHERE id_redaktor = '$id_redaktor'";
 		$wynik = sqlZapytanie($zapytanie);
 		if (!$wynik) {
	 		blad('Zapytanie nie powiod�o si�');
 			return false;
 		}
 		elseif ( mysql_num_rows($wynik) <1 ) {
	 		blad('Zapytanie nie zwr�ci�o �adnych rezultat�w');
 			return false;
 		}
 		else {

 			$rekord = mysql_fetch_assoc($wynik);

 			// zwolnienie pami�ci zajmowanej przez wynik:
 			mysql_free_result($wynik);
 			return $rekord;
 		}
 	}   
 }  


 /**
  * Zmienienie redaktora w bazie danych
  *
  * @param array $dane Tablica danych do zapisania do bazy
  * @return integer Wynik zapytania do bazy danych
  */
 function zmienRedaktora($dane) {
 	if( !sqlPolacz() ) {
 		return false;
 	}
 	else {
 		$dane = sqlPrzygotuj($dane);  

		// je�li by�o przekazane has�o to aktualizujemy go
    if($dane['haslo'] != ''){
      		$dane['haslo'] = md5($dane['haslo']);   
               // klucze bez ' ' bo w stringu s� ju�, nie ��czymy ci�g�w kropkami
   		$zapytanie = "UPDATE redaktor 
   		  SET login = '$dane[login]', email = '$dane[email]', bio = '$dane[bio]', admin = '$dane[admin]', haslo = '$dane[haslo]'
   		  WHERE id_redaktor = '$dane[id_redaktor]';";
    } else{
   		$zapytanie = "UPDATE redaktor 
   		  SET login = '$dane[login]', email = '$dane[email]', bio = '$dane[bio]', admin = '$dane[admin]'
   		  WHERE id_redaktor = '$dane[id_redaktor]';";      
    }
 		
    $wynik = sqlZapytanie($zapytanie);
    if(!$wynik){
		 		blad('Nie uda�o si� zapisa� zmian');
			 	return false;
		 }
		 else { 
			komunikat('Redaktor zosta��zmieniony');
	    return true;
	  }

  }
 }  



 /**
  * Oznaczanie redaktora jako usuni�tego
  *
  * @param integer $id_redaktor Id redaktora do usuni�cia
  * @return integer Wynik zapytania do bazy danych
  */
 function usunRedaktora($id_redaktor) {
 	if( !sqlPolacz() ) {
 		return false;
 	}
 	else {		                                                                		
 		$zapytanie = "UPDATE redaktor
 		SET usuniety = '1'
 		WHERE id_redaktor = '$id_redaktor'";
      $wynik = sqlZapytanie($zapytanie);
      if(!$wynik){   
        // jesli blad
 			 blad('Nie udalo sie oznaczyc redaktora jako usunietego');
 			 return false;
 		  }
 		 else {                   
       komunikat('Redaktor zosta� oznaczony jako usuni�ty');
 	     return true;
 	  }

   }
 }  

 /**
  * Przywraca usuni�tego redaktora
  *
  * @param integer $id_redaktor Id redaktora do przywrocenia
  * @return integer Wynik zapytania do bazy danych
  */
 function przywrocRedaktora($id_redaktor) {
 	if( !sqlPolacz() ) {
 		return false;
 	}
 	else {		                                                                		
 		$zapytanie = "UPDATE redaktor
 		SET usuniety = '0'
 		WHERE id_redaktor = '$id_redaktor'";
      $wynik = sqlZapytanie($zapytanie);
      if(!$wynik){   
        // jesli blad
 			 blad('Nie udalo sie przywr�ci� redaktora');
 			 return false;
 		  }
 		 else {                   
       komunikat('Redaktor zosta� przywr�cony');
 	     return true;
 	  }

   }
 }  	 
