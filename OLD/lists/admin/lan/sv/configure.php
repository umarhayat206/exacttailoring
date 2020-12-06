<?php
$lan = array( 
 'checklist for installation' => 'Installationschecklista',
 'cannot be empty' => 'får inte vara tomt',
 'editing' => 'Redigerar',
 'save changes' => 'Spara förändringar',
 'edit' => 'redigera',

  # added 24 May 2006
  'delete user' => 'Ta bort medlem',
  'unconfirm user' => 'ta bort bekräftelse för medlem',
  'blacklist user' => 'svartlista medlem',
  'delete user and bounce' => 'ta bort medlemm och avvisat utskick',
  'unconfirm user and delete bounce' => 'ta bort bekräftelse för medlemmen och ta bort avvisat utskick',
  'blacklist user and delete bounce' => 'svartlista medlemmen och ta bort avvisat utskick',
  'delete bounce' => 'ta bort avvisat utskick',
  'Website address (without http://)' => 'Hemsidesadress (utan http://)',
  'Domain Name of your server (for email)' => 'Din servers domännamn (för e-post)',
  'Person in charge of this system (one email address)' => 'Ansvarig person för det här systemet (en e-postadress)',
  'How often do you want to check for a new version of phplist (days)' => 'Hur ofta du vill kolla efter ny phpList-version (dagar)',
  'List of people to CC in system emails (separate by commas)' => 'Lista över personer att sända kopia till i system-mail (åtskiljda med kommatecken)',
  'Who gets the reports (email address, separate multiple emails with a comma)' => 'Dit rapporter skickas (e-postadresser, åtskilj flera e-postadresser med kommatecken)',
  'From email address for system messages' => 'Från-epostadress för systemmeddelanden',
  'What name do system messages appear to come from' => 'Namnet som systemmeddelanden ska se ut att komma från',
  'Reply-to email address for system messages' => 'Svarsepostadress för systemmeddelanden',
  'if there is only one visible list, should it be hidden in the page and automatically
    subscribe users who sign up (0/1)' => 'Om det bara finns en synlig lista, ska den då döljas på sidan och automatiskt
    befolkas med nyanmälda medlemmar? (0/1)',
  'width of a textline field (numerical)' => 'Bredd på textradsfält (numeriskt)',
  'dimensions of a textarea field (rows,columns)' => 'Dimensioner för textrutefält (rader,kolumner)',
  'Does the admin get copies of subscribe, update and unsubscribe messages (0/1)' => 'Får administratörer kopior av anmälans-, uppdaterings- och avanmälans-meddelanden? (0/1)',
  'The default subscribe page when there are multiple' => 'Standardanmälningssidan (när flera finns)',
  'The default HTML template to use when sending a message' => 'Standard-HTML-mallen att använda för nya utskick',
  'URL where users can subscribe' => 'URL-adress där nya medlemmar kan anmäla sig',
  'URL where users can unsubscribe' => 'URL-adress där medlemmar kan avanmäla sig',
  'URL where users have to confirm their subscription' => 'URL-adress där medlemmar kan bekräfta sin anmälan',
  'URL where users can update their details' => 'URL-adress där medlemmar kan uppdatera sina detaljer',
  'URL where messages can be forwarded' => 'URL-adress för vidarebefordran av utskick',
  'Subject of the message users receive when they subscribe' => 'Ämne på meddelandet som medlemmar får när de anmäler sig',
  'Message users receive when they subscribe' => 'Meddelande som medlemmar får när de anmäler sig',
  'Subject of the message users receive when they unsubscribe' => 'Ämne på meddelandet som medlemmar får när de avanmäler sig',
  'Message users receive when they unsubscribe' => 'Meddelande som medlemmar får när de avanmäler sig',
  'Subject of the message users receive after confirming their email address' => 'Ämne på meddelandet som medlemmar får efter att ha bekräftat sin e-postadress',
  'Message users receive after confirming their email address' => 'Meddelande som medlemmar får efter att ha bekräftat sin e-postadress',
  'Subject of the message users receive when they have changed their details' => 'Ämne på meddelandet som medlemmar får när de har ändrat sina detaljer',
  'Message that is sent when users change their information' => 'Meddelande som sänds när medlemmar ändrar sina detaljer',
  'Part of the message that is sent to their new email address when users change their information, and the email address has changed' => 'Del av meddelandet som sänds till deras nya e-postadress när medlemmar ändrar sina detaljer och e-postadressen har ändrats',
  'Part of the message that is sent to their old email address when users change their information, and the email address has changed' => 'Del av meddelandet som sänds till deras gamla e-postadress när medlemmar ändrar sina detaljer och e-postadressen har ändrats',
  'Subject of message to send when users request their personal location' => 'Ämne på meddelandet som sänds när medlemmar begär sin personliga URL-adress',
  'Message to send when they request their personal location' => 'Meddelande att sända när de begär sin personliga URL-adress',
  'Default footer for sending a message' => 'Standardmeddelandefot för sända meddelanden',
  'Footer used when a message has been forwarded' => 'Meddelandefot som används när ett meddelande har vidarebefordrats',
  'Header of public pages. The header should start with &lt;/head&gt; . You can add header elements, but don\'t add the title or other basic header elements.' => 'Meddelandehuvud på publika sidor. Huvudet bör börja med &lt;/head&gt; . Du kan lägga till huvudelement, men inte lägga till titel eller andra grundläggande huvudelement.',
  'Footer of public pages' => 'Sidfot på publika sidor',
  'Charset for HTML messages' => 'Teckenuppsättning för HTML-meddelanden',
  'Charset for Text messages' => 'Teckenuppsättning för textmeddelanden',
  'CSS for HTML messages without a template' => 'CSS för HTML-meddelanden utan mall',
  'Domains that only accept text emails, one per line' => 'Domäner som endast accepterar text-e-postmeddelanden, en per rad',
  'Minimum amount of items to send in an RSS feed' => 'Minsta antal poster att sända i en RSS-feed',
  'Template for text item in RSS feeds' => 'Mall för textpost i RSS-feeds',
  'Template for HTML item in RSS feeds' => 'Mall för HTML-post i RSS-feeds',
  'Maximum amount of items to send in an RSS feed' => 'Högst antal poster att sända i en RSS-feed',
  'Template for separator between feeds in RSS feeds (text)' => 'Mall för separator mellan feeds i RSS-feeds (text)',
  'Template for separator between feeds in RSS feeds (HTML)' => 'Mall för separator mellan feeds i RSS-feeds (HTML)',
  'Width in px of FCKeditor Area' => 'Bredd i pixlar för FCKeditor-rutan',
  'Height in px of FCKeditor Area' => 'Höjd i pixlar för FCKeditor-rutan',

  ## new in 2.11.

  'URL where known users can unsubscribe' => 'URL-adress där kända medlemmar kan avanmäla sig',
  'URL where unknown users can unsubscribe (blacklist)' => 'URL-adress där okända medlemmar kan avanmäla sig (svartlista)',
  'Width for Wordwrap of Text messages' => 'Bredd för textbrytning i textmeddelanden',
  'categories for lists. Separate with commas.' => 'kategorier för listor. Separera med kommatecken.',
);
?>
