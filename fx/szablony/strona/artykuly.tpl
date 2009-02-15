{* Wyswietla listê artyku³ów *}
{* plik: artykuly.tpl *}

{if $szukanaFraza}
  <h1>Wyniki wyszukiwania dla frazy: {$szukanaFraza}</h1>
{elseif $kategoria}
  <h1>Artyku³y w kategorii: {$kategoria.nazwa}</h1>
{else}
  <h1>Archiwalne artyku³y</h1>
{/if} 
        
{if $artykuly}
  {foreach from=$artykuly item=a}
  {* a to 1 artykul - tablica asocjacyjna *}
  {* id_art, tresc, tytul, data_godz, nazwa - nazwa kategorii, login - login redaktora *}
    <div class="artykul">
      <h3>{$a.tytul}</h3>
      <p>{$a.tresc|truncate:100:"..."} <a href="index.php?artykul={$a.id_art}">czytaj wiêcej</a></p>
    
      <span class="szczegoly">
        Dodane przez <strong>{$a.login}</strong>,  {$a.data_godz}     
      </span>
  
    </div>
  {/foreach}

  <hr/>
		{if $kategoria}
			<a href="index.php?przedzial={$przedzial+1}&amp;kategoria={$kategoria.id_kat}">&laquo; Starsze artyku³y</a> 
	    	{if $przedzial != 1} 
	     	 	<a href="index.php?przedzial={$przedzial-1}&amp;kategoria={$kategoria.id_kat}">Nowsze artyku³y &raquo;</a>   
		{/if}

		{elseif !$szukanaFraza}
	    	<a href="index.php?przedzial={$przedzial+1}">&laquo; Starsze artyku³y</a> 
	   	 	{if $przedzial != 1} 
	    		<a href="index.php?przedzial={$przedzial-1}">Nowsze artyku³y &raquo;</a>      
	   	 	{/if}
		{/if}

{else}

  {if $szukanaFraza}
    <p>Nie znaleziono ¿adnego artyku³u dla podanej frazy</p>
	
  {elseif $kategoria}
    <p>Brak artyku³ów dla wybranej kategorii.</p>
	{if $przedzial != 1}
	<a href="index.php?przedzial={$przedzial-1}&amp;kategoria={$kategoria.id_kat}">Nowsze artyku³y &raquo;</a>
	{/if}
  {elseif $przedzial} 
    <p>Brak starszych artyku³ów.</p>
	 <a href="index.php?przedzial={$przedzial-1}">Nowsze artyku³y &raquo;</a>
  {/if}                            
  
{/if}
