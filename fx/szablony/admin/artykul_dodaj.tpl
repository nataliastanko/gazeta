{* Formularz dodawania artyku³u *}
{* plik: artykul_dodaj.tpl *}

<form action="artykuly.php" method="post">
  <fieldset>
    <legend>Dodaj nowy artyku³</legend>
    <div>
      <label for="tytul">Tytu³ artyku³u</label>
      <input type="text" name="tytul" value="{$daneFormularza.tytul}" id="tytul"/>
    </div>
    <div>
      <label for="tresc">Tre¶æ</label>
      <textarea name="tresc" id="tresc" cols="50" rows="5">{$daneFormularza.tresc}</textarea>
    </div>                                                    
    <div>
      <label for="id_kat">Wybierz kategoriê</label>
      <select name="id_kat"> 
        {html_options options=$kategorie}
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
      <input type="submit" name="dodaj" value="Utwórz nowy artyku³" id="dodaj"/>
    </div>
  </fieldset>
</form>