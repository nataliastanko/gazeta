{* G³ówny szablon witryny *}
{* plik: index.tpl *}
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<title>{$tytul}</title>                                             
		<link rel="stylesheet" href="../fx/css/admin.css" type="text/css" charset="utf-8"/>
		<script src="../fx/js/jquery-1.2.6.min.js" type="text/javascript" charset="utf-8"></script>
	</head>
	<body>      
	  <div id="strona">
		
  		<div id="naglowek">
        
      {if $uzytkownik.admin}
        <span class="witaj">Witaj {$uzytkownik.login}</span>
        <ul>                                                         
          <li><a href="artykuly.php">Zarz±dzaj artyku³ami</a></li>                    
          <li><a href="redaktorzy.php">Zarz±dzaj redaktorami</a></li>
          <li><a href="kategorie.php">Zarz±dzaj kategoriami</a></li>
          <li><a href="komentarze.php">Moderacja komentarzy</a></li>
          <li><a href="wyloguj.php" title="Wyloguj siê">Wyloguj siê</a></li>
        </ul>  		  
      {elseif $uzytkownik}
        <span class="witaj">Witaj {$uzytkownik.login}</span>
        <ul>                                                         
          <li><a href="artykuly.php">Twoje artyku³y</a></li>          
          <li><a href="wyloguj.php" title="Wyloguj siê">Wyloguj siê</a></li>          
        </ul>       
      {else}
        <span class="witaj"><a href="index.php">Zaloguj siê!</a></span>
      {/if}     
  		</div>
      
      {if isset($status.komunikat)}
	      {include file=komunikat.tpl}
	    {/if}
		  
  		<div id="tresc">

    		{if isset($bledy)}
    			{include file="blad.tpl"}
    		{else}  		    		  
  			  {include file=$zawartosc}
  			{/if}
  		</div>

	  
  	  <div id="stopka">
  	   <span>&copy; Gazeta internetowa - Projekt zaliczeniowy PHP - Natalia Stanko, 2009</span>
   	   <span>
   	     <a href="http://validator.w3.org/check?uri=referer">Valid XHTML Strict 1.0</a>,
   	     <a href="http://jigsaw.w3.org/css-validator/">Valid CSS</a>          
   	   </span>
   	   <span>| <a href="../index.php">Strona gazety</a></span>   	   
  	  </div>
    </div>	  
	</body>
</html>
