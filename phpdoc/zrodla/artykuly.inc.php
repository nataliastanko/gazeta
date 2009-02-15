<?php
	/**
	 * Funkcje do obs³ugi wy¶wietlania i edycji artyku³ów
	 *
	 * @package artykuly.inc.php
	 * @link http://wierzba.wzks.uj.edu.pl/~stanko/Gazeta
	 * @copyright 2009 Natalia Stanko
	 * @author Natalia Stanko <anithaly@gmail.com>
	 * @since 1.0.0 10.01.2009
	 * @version 1.0.0 10.01.2009
	 */      

 
/**
 * Pobiera artyku³y jednego redaktora
 *
 * @param integer $id_redaktor Id redaktora, którego artyku³y pobieramy
 * @return array Wynik zapytania do bazy danych
 */ 
 function pobierzArtykulyRedaktora($id_redaktor){
 	if ( !sqlPolacz() ) {
 		return false;
 	}
 	else {

		// pobiera liste artyku³ów
 		$zapytanie = "SELECT artykul.* , redaktor_artykul.* , kategoria.*
 		  FROM artykul INNER JOIN redaktor_artykul INNER JOIN kategoria 
 		  WHERE artykul.id_art = redaktor_artykul.id_art     		    
 		    AND redaktor_artykul.id_redaktor = $id_redaktor 
 		    AND artykul.id_kat = kategoria.id_kat
	    ORDER BY data_godz DESC"; 		    

    
 		$wynik = sqlZapytanie($zapytanie);
 		if (!$wynik) {
 			blad('Nie uda³o siê pobraæ listy artyku³ów');
 			return false;
 		}
 		else {
 			$dane = array();
 			while ( $rekord = mysql_fetch_assoc($wynik) ) {
 				$dane[] = $rekord;
 			}
 			// zwolnienie pamiêci zajmowanej przez wynik:
 			mysql_free_result($wynik);
 			return $dane;
 		}
 	}   
 } 

	/**
	 * Pobiera jeden artyku³
	 *
	 * @param integer $id_art Id artyku³u do pobrania
	 * @return array Wynik zapytania do bazy danych
	 */
 function pobierzJedenArtykul($id_art){
 	if ( !sqlPolacz() ) {
 		return false;
 	}
 	else {	//z³±czenie
		$zapytanie = "SELECT artykul.*, redaktor_artykul.*, redaktor.login, kategoria.nazwa 
		FROM artykul artykul, redaktor_artykul redaktor_artykul, redaktor redaktor, kategoria kategoria  
		WHERE artykul.id_art=$id_art 
		AND redaktor_artykul.id_art=artykul.id_art 
		AND kategoria.id_kat=artykul.id_kat";


 		$wynik = sqlZapytanie($zapytanie);
 		if (!$wynik) {
 			blad('Nie uda³o siê po³±czyæ z baz± danych.');
 			return false;
 		}
 		else {		 
 			$dane = mysql_fetch_assoc($wynik);			
 			mysql_free_result($wynik);
 			return $dane;
 		}
 	}  
 }


 /**
  * Dodanie nowego artykulu do bazy danych.
  *
  * @param array $dane Tablica danych do zapisania do bazy
  * @return integer Wynik zapytania do bazy danych
  */
 function dodajArtykul($dane) {
 	if( !sqlPolacz() ) {
 		return false;
 	}
 	else {
 		$dane = sqlPrzygotuj($dane);  

 		$zapytanie = "INSERT INTO artykul (tytul,tresc,data_godz,id_kat) VALUES (
 			'$dane[tytul]',
 			'$dane[tresc]',
 			NOW(),
 			'$dane[id_kat]'
 		 )";

 		if( ! sqlZapytanie($zapytanie) ) {
 			blad('Nie udalo sie dodac nowego artykulu');
 			return false;
 		}
 		else {             
 		  // mysql_insert_id() - funkcja zwraca ID z ostatniej operacji w MySQL
 		  $nowy_art_id = mysql_insert_id();   
 		  $red_id = $_SESSION['uzytkownik']['id_redaktor'];
 		  // dodaj wpis do tabelki laczacej redaktorow i artykuly     
       $zapytanie2 = "INSERT INTO redaktor_artykul (id_redaktor,id_art) VALUES( '$red_id', '$nowy_art_id')";	                    
        // wykonaj drugie zapytanie  
        $wynik = sqlZapytanie($zapytanie2);
        if(!$wynik){
          blad('Nie udalo sie dodac wpisu do tabeli redaktor_artykul');
        } else{
          komunikat('Artyku³ zosta³ dodany'); 
 			   return true;
        }

 		}
 	}
 }


 /**
  * Zapisanie zmian w edytowanym artykule do bazy danych
  *
  * @param array $dane Tablica danych do zapisania do bazy
  * @return integer Wynik zapytania do bazy danych
  */
 function zmienArtykul($dane) {
 	if( !sqlPolacz() ) {
 		return false;
 	}
 	else {
 		$dane = sqlPrzygotuj($dane);  

 		$zapytanie = "UPDATE artykul 
 		SET tytul = '$dane[tytul]', tresc = '$dane[tresc]', id_kat = '$dane[id_kat]'
 		WHERE id_art = '$dane[id_art]';";

     		$wynik = sqlZapytanie($zapytanie);
      		if(!$wynik){
 			 blad('Nie udalo sie zapisaæ zmian');
 			 return false;
 		  }
 		else { 
     		komunikat('Artyku³ zosta³ zmieniony');
 	    	return true;
 	  }

   }
 }  

 /**
  * Usuwanie  artykulu z bazy danych.
  *
  * @param array $id_art Id artyku³u do usuniêcia
  * @return integer Wynik zapytania do bazy danych
  */
  
 function usunArtykul($id_art) {
 	if( !sqlPolacz() ) {
 		return false;
 	}
 	else {

 		$zapytanie = "DELETE FROM artykul WHERE id_art = $id_art;";
     $zapytanie2 = "DELETE FROM redaktor_artykul WHERE id_art = $id_art;";
      $zapytanie3 = "DELETE FROM komentarz WHERE id_art = $id_art;";
      $wynik = sqlZapytanie($zapytanie);
      if(!$wynik){   
        // jesli blad
 		blad('Nie udalo sie usunac artykulu');
 		return false;
 		  }
 		 else {  
 		  // usuniencie wpisu redaktor_artykul z tabeli z³±czeniowej  
 		  $wynik2 = sqlZapytanie($zapytanie2);
 		  // usuniêcie komentarzy przypisanych do usuwanego artyku³u                           
 		  $wynik3 = sqlZapytanie($zapytanie3);                            		  
 		  if($wynik2){ 
         	komunikat('Artyku³ zosta³ usuniety');        	
       		} else{
          	blad('Nie udalo sie usunac wpisu z tabeli artykul_redaktor');         
       }
 	    return true;
 	  }

   }
 }


/**
 * Pobiera artyku³y z bazy danych
 *
 * @param integer $ile=null ilosc artykulow na strone, jesli null - nie stronicuj
 * @param integer $id_kat=null id kategorii z ktorej pobrac artykuly
 * @param integer $przedzial=1 numer przedzialu, jesli nie podane to 1, czyli od poczatku
 * @return array Wyniki zapytania z bazy danych
 */
 
	// je¶li nie s± przekazywane wszystkie parametry, to wartosci domyslne:
 function pobierzArtykuly($ile = null,$id_kat = null,$przedzial = 1){
 	if ( !sqlPolacz() ) {
 		return false;
 	}
 	else {
     /*
      przedzial 1: -> LIMIT 0,3  to 3 ostatnie
      przedzial 2: -> LIMIT 3,3  to 3 ostatnie zaczynaj±c od 3. artyku³u (3. pozycji)
      przedzial 3: -> LIMIT 6,3
     */

	//zwyk³a paginacja niezaleznie od kategorii
     if($ile != null && $przedzial != null){
       $sqlLimit = " LIMIT ". ($przedzial - 1) * $ile . ", ". $ile;
     }
     else{
       $sqlLimit = "";
     }

 		// pobiera liste artyku³ów powiazan± z ich redaktorami i z kategoriami
 		if($id_kat == null){
   		$zapytanie = "SELECT artykul.* , redaktor_artykul.* , redaktor.id_redaktor, redaktor.login, kategoria.*
   		  FROM artykul INNER JOIN redaktor_artykul INNER JOIN redaktor INNER JOIN kategoria 
   		  WHERE artykul.id_art = redaktor_artykul.id_art 
   		    AND redaktor_artykul.id_redaktor = redaktor.id_redaktor
   		    AND artykul.id_kat = kategoria.id_kat
   		  ORDER BY data_godz DESC" . $sqlLimit;
    }
 		// pobiera liste artyku³ów powiazan± z ich redaktorami w danej kategorii
     else{
   		$zapytanie = "SELECT artykul.* , redaktor_artykul.* , redaktor.id_redaktor, redaktor.login
   		  FROM artykul INNER JOIN redaktor_artykul INNER JOIN redaktor 
   		  WHERE artykul.id_art = redaktor_artykul.id_art 
   		    AND redaktor_artykul.id_redaktor = redaktor.id_redaktor
   		    AND artykul.id_kat = '$id_kat'
   		  ORDER BY data_godz DESC" . $sqlLimit;   		    
    }      

 		$wynik = sqlZapytanie($zapytanie);
 		if (!$wynik) {
 			blad('Nie uda³o siê pobraæ listy artyku³ów');
 			return false;
 		}
 		else {
 			$dane = array();
 			while ( $rekord = mysql_fetch_assoc($wynik) ) {
 				$dane[] = $rekord;
 			}
 			// zwolnienie pamiêci zajmowanej przez wynik:
 			mysql_free_result($wynik);
 			return $dane;
 		}
 	}   
 } 
 

 /**
  * Wyszukiwanie artyku³ów po tre¶ci
  *
  * @param string $szukane szukana fraza
  * @return array $dane Tablica ze znalezionymi artyku³ami
  */
 function wyszukajArtykuly($szukane) {
 	if( !sqlPolacz() ) {
 		return false;
 	}
 	else {

 		//$zapytanie = "SELECT * FROM artykul WHERE tytul LIKE '%$szukane%' OR tresc LIKE '%$szukane%';";
		$zapytanie="SELECT artykul.* , redaktor_artykul.* , redaktor.id_redaktor, redaktor.login, kategoria.*      
		FROM artykul INNER JOIN redaktor_artykul INNER JOIN redaktor INNER JOIN kategoria       
		WHERE artykul.id_art = redaktor_artykul.id_art         
		AND redaktor_artykul.id_redaktor = redaktor.id_redaktor        
		AND artykul.id_kat = kategoria.id_kat and (tytul like '%$szukane%' or tresc like '%$szukane%')";

		$wynik = sqlZapytanie($zapytanie);
		if (!$wynik) {
			blad('Nie uda³o siê wyszuaæ artyku³ów');
			return false;
		}
		else {
			$dane = array();
			// dopóki istnieje wynik
			while ( $rekord = mysql_fetch_assoc($wynik) ) {
				$dane[] = $rekord;
			}
			// zwolnienie pamiÍci zajmowanej przez wynik:
			mysql_free_result($wynik);

			return $dane;
		}
	}   
} 
