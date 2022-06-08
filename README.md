# Piattaforma di gioco AR
Questa piattaforma permette dal portale di registrare nuovi utenti, collegarsi nel sistema con le proprie credenziali d’accesso, avviare nuove partite, visualizzare le
statistiche di gioco e il resoconto di ogni partita con, tra l’altro, l’implementazione di mappe dinamiche e interattive.
Il portale è interamente accessibile da browser web ed’è stato realizzato in
HTML, CSS e JavaScript lato client e PHP e SQL lato server.

## Interfaccia utente
L’interfaccia utente è stata studiata in modo da risultare semplice e intuitiva a
chiunque e può riassumersi in un’elegante finestra galleggiante su uno sfondo
dinamico. Questa scelta permette di semplificare notevolmente lo sviluppo in
quanto solo lo sfondo è responsive e la finestra è di dimensioni fisse, mantenendo tuttavia un’aspetto gradevole per l’utente.
### Autenticazione e registrazione
Dalla pagina principale è possibile scegliere se accedere alla pagina di autenticazione
oppure di registrazione. Dalla prima è possibile accedere alla piattaforma tramite le
proprie credenziali generate autonomamente dalla pagina di registrazione.
### Profilo 
Dal profilo l’utente oltre a visualizzare il proprio nome può cancellare il proprio account
(previa nuova verifica delle credenziali), disconnettersi (i dati salvati all’interno del
browser dal sito vengono cancellati definitivamente) e può infine avviare una partita.
Sempre in questa pagina, e come in tutte le
successive, si è mantenuta la stessa grafica
in un’ottica di coerenza e fluidità tra le varie
pagine.
### Nuova partita
All’avvio di una nuova partita viene chiesto al browser di chiedere all’utente l’autorizzazione per l’accesso ai dati, e in particolare alle coordinate, forniti dal GPS (Global Positioning System). Se il dispositivo dell’utente non è in possesso di quest’ultimo sensore
verrà esplicata all’utente l’impossibilità di accedere al gioco.
Successivamente, previa accettazione per il fornimento delle coordinate GPS, viene avviata la ricerca di una partita libera. Se necessario, viene richiesta la creazione di una
nuova partita e si rimane in ascolto finché il server non comunica l’avvio della partita..
### Partita in corso
Una che si è entrati in una partita viene mostrata una schermata che riassume i dati
della partita in corso. È possibile uscire dalla partita in corso e, se si è l’ultimo a uscirne,
la partita viene automaticamente cancellata anche lato server.
### Recapitolo partita
Quando la partita è conclusa viene mostrato il vincitore, il perdente e la mappa della
zona geografica in cui si è svolta la partita.
È dopodiché possibile tornare al profilo e alla schermata iniziale.

## Linguaggi e frameworks
### Linguaggi
Il progetto è stato interamente realizzato in HTML, CSS e JavaScript lato cliente e
PHP e SQL lato server.
La realizzazione di un applicativo web anziché un software nativo rende il servizio accessibile da qualunque dispositivo che abbia accesso a internet e sul quale
sia scaricato un browser web.
### Frameworks 
L’intero progetto - sia front end che back end - è stato realizzato in completa autonomia. Per la gestione della mappa dinamica viene utilizzato il framework
Apple MapKit JS (https://developer.apple.com/maps/web/).
### Server
Il server esegue una versione di NGINX come server web eseguita su piattaforma Linux Debian 10 che gira su un’istanza virtuale AWS.

