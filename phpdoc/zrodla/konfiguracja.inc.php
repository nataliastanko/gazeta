<?php
	/**
	 * Plik konfiguracyjny
	 *
	 * @package konfiguracja.inc.php
	 * @link http://wierzba.wzks.uj.edu.pl/~stanko/Gazeta
	 * @copyright 2009 Natalia Stanko
	 * @author Natalia Stanko <anithaly@gmail.com>
	 * @since 1.0.0 10.01.2009
	 * @version 1.0.0 10.01.2009
	 */      
	
	 	
	// wys�anie informacji w nag��wku strony o kodowaniu stron ISO      
  header('Content-Type: text/html; charset=iso-8859-2');  

	// do��czenie plik�w obs�ugi
  include 'sprawdzDanych.inc.php';
  include 'obsluga.inc.php'; 
  include 'baza.inc.php'; 
                          
	// do��czenie plik�w obs�ugi dla element�w panelu administratora                          
  include 'redaktorzy.inc.php';  
  include 'kategorie.inc.php'; 
  include 'artykuly.inc.php';  
  include 'komentarze.inc.php';
      
	// konfiguracja �cie�ki szablon�w
	if(isset($szablony) && $szablony == 'admin'){
		// dla admin
	  $GLOBALS['sciezki']['szablony'] = '../fx/szablony/admin/';
    $GLOBALS['sciezki']['tmp'] = '../../tmp/admin';	  
		// do��czenie klasy Smarty
		include '../smarty/libs/Smarty.class.php';

	} else{
		// dla strony
	  $GLOBALS['sciezki']['szablony'] = 'fx/szablony/strona/';	  
    $GLOBALS['sciezki']['tmp'] = '../tmp/strona';	  
		include 'smarty/libs/Smarty.class.php';    
	}
	
	
	$GLOBALS['szablon'] = new Smarty();
	
	// folder z szablonami
	$GLOBALS['szablon']->template_dir = $GLOBALS['sciezki']['szablony'];
	$GLOBALS['szablon']->compile_dir = $GLOBALS['sciezki']['tmp'];
	
	// domyslny szablon strony
	$GLOBALS['strona']['szablon'] = 'index.tpl';
	
	// domy�lna zawarto��
	$GLOBALS['strona']['zawartosc'] = '404.tpl';

	//tytu� strony
	$GLOBALS['strona']['tytul'] = 'Gazeta internetowa - �wiat i ludzie';
		
	
  // konfiguracja bazy danych:

	$GLOBALS['sql']['host'] = 'localhost';
	$GLOBALS['sql']['uzytkownik'] = 'stanko';
	$GLOBALS['sql']['haslo'] = 'wi89erzbik';
	$GLOBALS['sql']['baza'] = 'php_stanko';
	
  
  /* konfiguracja na locahost
  
 	$GLOBALS['sql']['host'] = '127.0.0.1';
 	$GLOBALS['sql']['uzytkownik'] = 'root';
 	$GLOBALS['sql']['haslo'] = '';
 	$GLOBALS['sql']['baza'] = 'gazeta';
 */	
