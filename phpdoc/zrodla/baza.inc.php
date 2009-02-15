<?php
	/**
	 * Funkcje do obs³ugi po³aczenia z baz± danych
	 *
	 * @package baza.inc.php
	 * @link http://wierzba.wzks.uj.edu.pl/~stanko/Gazeta
	 * @copyright 2009 Natalia Stanko
	 * @author Natalia Stanko <anithaly@gmail.com>
	 * @since 1.0.0 10.01.2009
	 * @version 1.0.0 10.01.2009
	 */      


	 /**
	  * Utworzenie po³±czenia i wybór bazy danych.
	  */
	 function sqlPolacz() {
		$GLOBALS['sqlUchwyt'] = mysql_pconnect($GLOBALS['sql']['host'], $GLOBALS['sql']['uzytkownik'], $GLOBALS['sql']['haslo']);
		if ( !$GLOBALS['sqlUchwyt'] ) {
	 		blad('Nie uda³o siê po³±czyæ z baz± danych');
			return false;
		}
		elseif (! mysql_select_db($GLOBALS['sql']['baza']) ) {
	 		blad('Nie uda³o siê wybraæ bazy danych');
			return false;
		}
		else {
			mysql_query('SET NAMES latin2');
			return $GLOBALS['sqlUchwyt'];
		}
	}
	
	/**
	 * Przygotowanie danych do zapisu do bazy.
	 *
	 * @param array $daneDoZapisu Tablica pól jakie maj± zostaæ zapisane do bazy danych
	 * @return array Tablica danych przygotowanych do zapisu do bazy
	 */
	function sqlPrzygotuj($daneDoZapisu) {
		foreach ($daneDoZapisu as $klucz => $wartosc) {              
      // Zabezpiecza parametry przekazywane do zapisu (np. wstwia \ przed ')
			$daneDoZapisu[$klucz] = mysql_real_escape_string($wartosc);
		}
		return $daneDoZapisu;
	}
	
	/**
	 * Wykonanie zapytania do bazy danych.
	 *
	 * @param string $zapytanie Zapytanie do bazy danych
	 * @return integer Wynik zapytania do bazy danych
	 */
	function sqlZapytanie($zapytanie) {
		$wynik = @mysql_query($zapytanie);
		if(!$wynik) {
			return false;
		}
		else {
			return $wynik;
		}
	}