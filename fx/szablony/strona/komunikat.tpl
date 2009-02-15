{* Szablon komunikatu *}
{* plik: komunikat.tpl *}

{if $status.komunikat }
  <div id="komunikat">{$status.komunikat}</div>    
  {literal}
  <script type="text/javascript" charset="utf-8">
    $('#komunikat').click(function(){
      $(this).slideToggle('fast');
    })
  </script>
  {/literal}
{/if}
