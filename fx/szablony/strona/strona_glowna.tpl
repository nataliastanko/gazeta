{* Szablon strony glownej *}
{* plik: strona_glowna.tpl *}

  
  <h2>Najnowsze artyku³y</h2>
  
  {foreach from=$artykuly item=a}
  {* a to 1 artykul - tablica asocjacyjna *}
  {* id_art,tresc,data_godz,nazwa - nazwa kategorii,login - login redaktora *}
    <div class="artykul">
      <h3>{$a.tytul}</h3>
      <p>{$a.tresc|truncate:100:"..."} <a href="index.php?artykul={$a.id_art}">czytaj wiêcej</a></p>
      
      <span class="szczegoly">
        Dodane przez <strong>{$a.login}</strong>,  {$a.data_godz} w kategorii {$a.nazwa}
      </span>    
    </div>
  {/foreach} 
  <hr/>
  <a href="index.php?przedzial=2">Starsze artyku³y</a>
  



