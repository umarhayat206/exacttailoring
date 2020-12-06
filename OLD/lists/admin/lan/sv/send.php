<?php

## notes to translators:
# do not translate anything in square brackets: eg [RSS]

$lan = array (
  'noaccess' => 'Inget sådant utskick finns, eller så har du inte behörighet till det',
  'htmlusedwarning' => 'Varning: Du indikerade att innehållet inte var HTML, men det fanns några HTML-taggar i det. Detta kan orsaka fel',
  'adding' => 'Lägger till',
  'longmimetype' => 'Mime-typ är längre än 255 tecken, detta är problematiskt',
  'addingattachment' => 'Lade till bilaga ',
  'uploadfailed' => 'Uppladdad fil togs inte emot korrekt, tom fil',
  'saved' => 'Utskick sparat',
  'added' => 'Utskick tillagt',
  'queued' => 'Utskick har köats för sändning',
  'processqueue' => 'Bearbeta utskickskön',
  'errorsubject' => 'Tyvärr, du använde otillåtna tecken i ämnesfältet.',
  'errorfrom' => 'Tyvärr, du använde otillåtna tecken i från-fältet.',
  'enterfrom' => 'Vänligen ange en från-rad.',
  'entermessage' => 'Vänligen ange ett meddelande',
  'entersubject' => 'Vänligen ange ett ämne',
  'duplicateattribute' => 'Fel: du kan endast använda ett attribut i en regel',
  'selectlist' => 'Vänligen välj listan(-orna) som meddelandet ska sändas till',
  'notargetemail' => 'Inga mål-e-postadresser har listats för testning.',
  'emailnotfound' => 'E-postadresser att skicka testutskick till hittades inte.',
  'sentemailto' => 'Sände testutskick till',
  'removedattachment' => 'Tog bort bilaga ',
  'existingcriteria' => 'Befintliga kriterier',
  'remove' => 'Ta bort',
  'calculating' => 'Beräknar',
  'calculate' => 'Beräkna',
  'content' => 'Innehåll',
  'format' => 'Format',
  'attach' => 'Bifoga',
  'scheduling' => 'Schemaläggning',
  'criteria' => 'Kriterier',
  'lists' => 'Listor',
  'unsavedchanges' => 'Varning, du har osparade förändringar\nKlicka på OK för att fortsätta eller Avbryt för att vara kvar på den här sidan\nså att du kan spara förändringarna.',
  'whatisprepare' => 'Vad är att förbereda ett utskick',
  'subject' => 'Ämne',
  'fromline' => 'Från-rad',
  'embargoeduntil' => 'Hindras att skickas före',
  'repeatevery' => 'Upprepa utskick varje',
  'norepetition' => 'ingen repetition',
  'hour' => 'Timme',
  'day' => 'Dag',
  'week' => 'Vecka',
  'repeatuntil' => 'Upprepa tills',
  'format' => 'Format',
  'autodetect' => 'Autodetektera',
  'sendas' => 'Sänd som',
  'html' => 'HTML',
  'text' => 'text',
  'pdf' => 'PDF',
//  'textandhtml' => 'Text and HTML', //obsolete by bug 0009687
  'textandpdf' => 'Text och PDF',
  'usetemplate' => 'Använd mall',
  'selectone' => 'välj en',
  'rssintro' => 'Om du vill använda det här utskicket som mallen för sändandet av RSS-feeds
    välj frekvensen för dess användande och använd [RSS] i ditt meddelande för att indikera vara postlistan ska vara.',
  'none' => 'ingen',
  'message' => 'Meddelande',
  'expand' => 'utvidga',
  'plaintextversion' => 'Vanlig text-version av meddelandet',
  'messagefooter' => 'Meddelandefot',
  'messagefooterexplanation1' => 'Använd <b>[UNSUBSCRIBE]</b> för att infoga den personliga avanmälnings-URL-adressen för varje medlem.',
  'messagefooterexplanation2' => 'Använd <b>[PREFERENCES]</b> för att infoga den personliga URL-adressen där medlemmen kan uppdatera sina detaljer.',
  'messagefooterexplanation3' => 'Använd <b>[FORWARD]</b> för att lägga till en peronaliserad URL-adress för att vidarebefordra utskicket till någon annan.',
  'messagefooterexplanation' => 'Använd <b>[UNSUBSCRIBE]</b> för att infoga den personliga avanmälnings-URL-adressen för varje medlem.
  <br/>Använd <b>[PREFERENCES]</b> för att infoga den personliga URL-adressen där medlemmen kan uppdatera sina detaljer.',
  'addattachments' => 'Lägg till bilagor till meddelandet',
  'uploadlimits' => 'Uppladdningen har följande gränser, satta av servern',
  'maxtotaldata' => 'Högsta storlek för varje datamängd sänd till servern',
  'maxfileupload' => 'Högsta storlek för varje individuell fil',
  'currentattachments' => 'Nuvarande bilagor',
  'filename' => 'filnamn',
  'desc' => 'beskr',# short for description
  'size' => 'storl',
  'file' => 'fil',
  'del' => 'ta bort', # short for delete
  'newattachment' => 'Ny bilaga',
  'addandsave' => 'Lägg till (och spara)',
  'pathtofile' => 'Sökväg till filen på servern',
  'attachmentdescription' => 'Beskrivning för bilaga',
  'delchecked' => 'Ta bort förkryssade',
  'sendtestmessage' => 'Sänd testmeddelande',
  'toemailaddresses' => ' till e-postadress(er)',
  'sendtestexplain' => '(kommaseparerade adresser - alla måste vara medlemmar)',
  'criteriaexplanation' => '
        <p class="information"><b>Välj kriterier för detta utskick:</b></p>
        <ol>
        <li>för att använda ett kriterium, kryssa i rutan bredvid det</li>
        <li>använd sedan radioknappen bredvid attributet som du vill använda</li>
        <li>välj sedan värdena på attributen du vill sända utskicket till
        <i>Obs:</i> Utskick kommer sändas till personer som matchar <i>Kriterium 1</i> <b>OCH</b> <i>Kriterium 2</i> och så vidare </li>
        </ol>
        ',
  'criterion' => 'Kriterium',
  'usethisone' => 'Använd det här',
  'or' => 'eller', # "alternative" ie this or this
  'is' => 'är',
  'isnot' => 'är inte',
  'isbefore' => 'är före', # date and time wise
  'isafter' => 'är efter', # date and time wise
  'nocriteria' => 'Det finns för närvarande inga tillgängliga attribut för utskickssändning. Utskicket kommer gå till alla medlemmar på de valda listorna.',
  'checked' => 'Ikryssad', # as for checkbox
  'unchecked' => 'Icke ikryssad', # as for checkbox
  'buggywithie' => 'Varning, den här funktionaliteten är buggig och opålitlig med Internet Explorer.\nDet är bättre att använde Mozilla Firefox eller Opera\nAlternativt stäng av STACKED_ATTRIBUTE_SELECTION i din config-fil', # Don't translate STACKED_ATTRIBUTE_SELECTION
  'matchallrules' => 'Matcha alla de här reglerna',
  'matchanyrules' => 'Matcha någon av de här reglerna',
  'addcriterion' => 'Lägg till kriterium',
  'saveasdraft' => 'Spara utskick som utkast',
  'savechanges' => 'Spara förändringar',
  'selectattribute' => 'välj attribut',
  'dd-mm-yyyy' => 'dd-mm-yyyy', # it's essential that the format is the same (ie dd-mm-yyyy)

  # above is all from send_core

  'selectlists' => 'Vänligen välj listorna som du vill sända utskicket till',
  'alllists' => 'Alla listor',
  'listactive' => 'aktiv',
  'listnotactive' => 'inaktiv',
  'selectexcludelist' => 'Välj listorna som ska uteslutas.',
  'excludelistexplain' => 'Utskicket kommer skickas till medlemmar som är medlemmar i listorna ovan,
  om de inte är medlem i någon av listorna som du väljer här.',
  'nolistsavailable' => 'Tyvärr, det finns för närvarande inga listor tillgängliga',
  'sendmessage' => 'Sänd meddelande till valda sändlistor',
  'warnnopearhttprequest' => 'Du försöker sända en extern URL, men PEAR::HTTP/Request är inte tillgänglig, så detta kommer misslyckas',
  #


  ### new in 2.9.5
  'Misc' => 'Blandat',
  'email to alert when sending of this message starts' => 'e-postadresser att larma till när sändningen av det här utskicket påbörjas',
  'email to alert when sending of this message has finished' => 'e-postadresser att larma till när sändningen av det här utskicket har avslutats',
  'separate multiple with a comma' => '(separera flera med kommatecken)',
  'operator' => 'operatör',
  'values' => 'värden',
  '%d users apply' => '%d medlemmar matchas',

  # new in 2.10.1
  'reload' => 'ladda om',

  ## new in 2.11.2
  'use [FORWARD] to add a personalised URL to forward the message to someone else.' => 'Använd <b>[FORWARD]</b> för att lägga till en personaliserad URL-adress för att vidarebefordra utskicket till någon annan.',
  'PGP' => 'PGP',
  'Sign message' => 'Signera utskick',
  'Select email to sign with' => 'Välj e-postadress att signera med',
  'Enter pass phrase' => 'Ange lösenordsfras',
  'Encrypt message' => 'Kryptera utskick',
  'When a message cannot be encrypted because the public key cannot be found' => 'När ett utskick inte kan krypteras då den publika nyckeln inte kan hittas',
  'Send it anyway, but unencrypted' => 'Sänd det ändå, men okrypterat',
  'Do not send it' => 'Sänd det inte',
  'All Active Lists' => 'Alla aktiva listor',
  
  ## 2.11.5
  'No RSS' => 'Ingen RSS', 
  'Daily' => 'Dagligen', 
  'Weekly' => 'Veckovis',
  'Monthly' => 'Månadsvis',
  'start a new message' => 'påbörja ett nytt utskick',
  'Choose an existing draft message to work on' => 'Välj ett befintligt utskicksutkast att jobba på',
  

  ## forgotten 
  'All Active Lists' => 'Alla aktiva listor',

);

?>
