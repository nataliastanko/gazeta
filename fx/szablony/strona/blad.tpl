{* strona komunikatu b��du *}
{* plik: blad.tpl *}
<h1>B��d!</h1>
{foreach from=$bledy item=blad}
  <p class="error">{$blad}</p>
{/foreach}
