# FilesSyncGo für Contao CMS

Diese Erweiterung ermöglicht die manuelle Auslösung der Contao-Dateisynchronisierung über eine geschützte HTTP-Schnittstelle (URL). Dies ist besonders nützlich, um nach automatisierten Datei-Uploads (z. B. via FTP) die Datenbank-Synchronisierung von Contao anzustoßen.

## Features

- **HTTP-Endpunkt**: Stellt die Route `/filessyncgo` zur Verfügung
- **Sicherheit**: Zugriffsschutz über einen konfigurierbaren Token
- **Missbrauchsschutz**: Integrierter Rate-Limiter (IP-basiert), um Überlastung durch zu viele Anfragen zu verhindern
- **Contao 5 Ready**: Vollständig kompatibel mit Contao 5.3+ 

## Konfiguration

### Token festlegen

Der Zugriff auf die Schnittstelle erfordert einen Token. Diesen kannst du im Contao-Backend unter **System → Einstellungen** im Bereich "FilesSync" definieren.

### Rate-Limiter (Optional)

Standardmäßig ist ein Rate-Limiter aktiv, der maximal 5 Anfragen pro Minute pro IP-Adresse erlaubt. Die Konfiguration erfolgt bundle-intern, kann aber bei Bedarf über die `config/config.yaml` der App überschrieben werden.

## Verwendung

Um die Synchronisierung auszulösen, rufe die URL mit deinem definierten Token als GET-Parameter auf:
https://deine-domain.tld/filessyncgo?token=DEIN_DEFINIERTER_TOKEN


### Rückgabewerte

**200 OK** – Synchronisierung erfolgreich gestartet

```json
{"success":true,"message":"File sync triggered."}
401 Unauthorized – Token fehlt oder ist ungültig

{"error":"Invalid token."}
429 Too Many Requests – Zu viele Anfragen in kurzer Zeit

{"error":"Too many requests. Please try again later."}
```

#### Technische Details
Route: /filessyncgo (Name: syncFiles)
Anforderung: PHP ^8.2, Contao ^5.3

### Lizenz
LGPL-3.0-or-later