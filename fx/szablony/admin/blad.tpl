{* strona komunikatu b³êdu *}
{* plik: blad.tpl *}

<h1>Wyst±pi³ b³±d przy wy¶wietlaniu strony.</h1>
{foreach from=$bledy item=blad}
  <p class="error">{$blad}</p>
{/foreach}
