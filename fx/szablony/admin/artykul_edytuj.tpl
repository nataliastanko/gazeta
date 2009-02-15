{* Formularz edycji artyku³u *}
{* plik: artykul_edytuj.tpl *}

<form action="artykuly.php" method="post">
  <fieldset>
    <legend>Edycja artykulu</legend>
    <div>
      <label for="tytul">Tytu³ artyku³u</label>
      <input type="text" name="tytul" value="{$artykul.tytul}" id="tytul"/>
    </div>
    <div>
      <label for="tresc">Tre¶æ</label>
      <textarea name="tresc" id="tresc" cols="50" rows="5">{$artykul.tresc}</textarea>
    </div>                                                    
    <div>
      <label for="id_kat">Kategoria artyku³</label>
      <select name="id_kat">    
        {* pola options potrzebuja jednowymiarowej tablicy asocjacyjnej*}
        {html_options options=$kategorie selected=$artykul.id_kat}
      </select>
    </div>
    {if $status.bledyFormularza}    
      <ul class="bledy">
        {foreach from=$status.bledyFormularza key=pole item=blad}
          <li><strong>{$pole}:</strong> {$blad}</li>
        {/foreach}        
      </ul>                    
    {/if}
    <div>        
      <input type="hidden" name="id_art" value="{$artykul.id_art}" id="id_art"/>
      <input type="submit" name="edytuj" value="Zapisz zmiany" id="edytuj"/>
    </div>
  </fieldset>
</form>