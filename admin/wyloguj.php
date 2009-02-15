<?php
	/**
	 * Wylogowanie u¿ytkownika 
	 *
	 * @package wyloguj.php
	 * @link http://wierzba.wzks.uj.edu.pl/~stanko/Gazeta
	 * @copyright 2009 Natalia Stanko
	 * @author Natalia Stanko <anithaly@gmail.com>
	 * @since 1.0.0 10.01.2009
	 * @version 1.0.0 10.01.2009
	 */      

/*ustawienie nazwy sesji:
(ta operacja jest konieczna w sytuacji gdy na jedym serwerze mamy kilka witryn WWW korzystaj±cych z ciasteczek */

  @session_name('redaktor');
  session_start();  
	$szablony = 'admin';
	include '../biblioteki/konfiguracja.inc.php';

  if ( isset($_SESSION['uzytkownik']) && count($_SESSION['uzytkownik'])>0 ) {

    // uzytkownik jest zalogowany
    wyrejestrujSesja('uzytkownik');

    $GLOBALS['strona']['status']['komunikat'] = 'Zosta³e¶ wylogowany';
    $GLOBALS['strona']['zawartosc'] = 'logowanie.tpl';

  }
  // b³±d autoryzacji 
  else{ 
  
  	blad('Nast±pi³a próba nieautoryzowanego dostêpu');
    	$GLOBALS['strona']['zawartosc'] = 'blad.tpl';
    	@session_destroy();

 }

  // przeslanie wyniku dzialania skryptu do szablonow:
	$GLOBALS['szablon'] -> assign($GLOBALS['strona']);
	$GLOBALS['szablon'] -> display($GLOBALS['strona']['szablon']);
?>
