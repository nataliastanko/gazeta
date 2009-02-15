{* G³ówny szablon witryny *}
{* plik: index.tpl *}
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<title>{$tytul}</title>                                             
		<link rel="stylesheet" href="fx/css/style.css" type="text/css" media="screen" title="no title" charset="utf-8"/>
		<script src="fx/js/jquery-1.2.6.min.js" type="text/javascript" charset="utf-8"></script>
	</head>
	<body>         
	  <div id="strona">       
  	  <div id="naglowek">
  	   <h1><a href="index.php">¦wiat i ludzie</a></h1>
  	  </div>
     	 {if isset($status.komunikat)}
	      {include file=komunikat.tpl}
	    {/if}
	     
	    <div id="tresc">
	      <div id="glowny">
      		{if isset($bledy)}
      			{include file="blad.tpl"}
      		{else}  		    		  
    			  {include file=$zawartosc}
    			{/if}	       
	      </div>
	      <div id="boczny">
	        <div class="box">
	         <h2>Wyszukaj</h2>
       	   <form action="index.php" method="get" class="wyszukiwarka">
       	     <fieldset>
       	       <input type="text" class="text" value="" name="szukaj" id="szukaj"/>
       	       <input type="submit" class="submit" value="Szukaj"/>
       	     </fieldset>
       	   </form>	       
       	  </div>   
       	  <div class="box">
       	    <h2>Kategorie</h2>
            <ul class="kategorie">
              {foreach from=$kategorie key=id item=nazwa}
                <li><a href="index.php?kategoria={$id}&amp;przedzial=1">{$nazwa}</a></li>
              {/foreach}
            </ul>             	    
       	  </div>
      	</div>
	      <br class="clear"/>
	    </div>
      
      <div id="stopka">
     	   <span>&copy; Gazeta internetowa - Projekt zaliczeniowy PHP - Natalia Stanko, 2009</span>
     	   <span>
     	     <a href="http://validator.w3.org/check?uri=referer">Valid XHTML Strict 1.0</a>,
     	     <a href="http://jigsaw.w3.org/css-validator/">Valid CSS</a>          
     	   </span>
     	   <span>| <a href="admin/index.php">Panel administratora</a></span>
      </div>
    </div>	              
	</body>
</html>
