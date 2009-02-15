{* Wy¶wietla liste artyku³ów *}
{* plik: artykuly.tpl *}

<h1>Twoje artyku³y</h1>
<div class="akcje">
  <a href="artykuly.php?akcja=dodaj">Dodaj artykul</a>
</div>

{* sprawdza czy ilosc elementow w tablicy z artykulami > 0 *}
{if $artykuly}
<table class="admin">
  <thead>
    <tr>
      <th class="id">Id</th> 
      {if $uzytkownik.admin}
        <th>Redaktor</th>
      {/if}
      <th>Tytul</th>
      <th>Tresc</th>
      <th>Data publikacji</th>
      <th>Kategoria</th>
      <th>Akcje</th>
    </tr>
  </thead>
  <tbody>
    {foreach from=$artykuly item=artykul}
      <tr>
        <td>{$artykul.id_art}</td>
        {* zapytanie wyswietlajace liste artykulow zwraca login redaktora*}
        {if $uzytkownik.admin}
          <td>{$artykul.login}</td>
        {/if}
        <td>{$artykul.tytul}</td>
        <td>{$artykul.tresc|truncate:100}</td>
        <td>{$artykul.data_godz}</td>
        <td>{$artykul.nazwa}</td> 
        <td>
          <a href="artykuly.php?akcja=edytuj&amp;id_artykul={$artykul.id_art}">Edycja</a> |  
          {* domyslnie jest false po return (false=anuluj) *}
          <a href="artykuly.php?akcja=usun&amp;id_artykul={$artykul.id_art}" onclick="return confirm('Czy jeste¶ pewny');">Usuñ</a>
        </td>        
      </tr>
    {/foreach}
  </tbody>
</table>
{else}
  <p>Nie ma jeszcze ¿adnych artyku³ów w bazie.</p>
{/if}
