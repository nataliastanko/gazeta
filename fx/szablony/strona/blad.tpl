{* strona komunikatu b³êdu *}
{* plik: blad.tpl *}
<h1>B³±d!</h1>
{foreach from=$bledy item=blad}
  <p class="error">{$blad}</p>
{/foreach}
