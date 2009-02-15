{* Wy¶wietla artyku³ *}
{* plik: artykul.tpl *}

<h3>{$artykul.tytul}</h3>
<div class="tresc">{$artykul.tresc|nl2br}</div>    
<hr/>
<div class="szczegoly">Dodany przez <strong>{$artykul.login}</strong>,  z dat± {$artykul.data_godz} w kategorii <strong>{$artykul.nazwa}</strong></div>
   
<h2 id="komentarze">Komentarze do artyku³u:</h2>
<ol class="lista-komentarzy">
  {foreach from=$komentarze item=kom}
    <li>
      <span class="szczegoly">Dnia {$kom.data_kom} u¿ytkownik <strong>{$kom.podpis}</strong> napisa³(a):</span>
      <p>{$kom.tresc|nl2br}</p>
    </li>
  {/foreach}
</ol>

{include file=formularz_komentarza.tpl}
