{* strona komunikatu b��du *}
{* plik: blad.tpl *}

<h1>Wyst�pi� b��d przy wy�wietlaniu strony.</h1>
{foreach from=$bledy item=blad}
  <p class="error">{$blad}</p>
{/foreach}
