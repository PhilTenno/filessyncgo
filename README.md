# FilesSyncGo for Contao CMS
This extension enables the manual triggering of Contao file synchronization via a protected HTTP interface (URL). This is especially useful for initiating Contao’s database synchronization after automated file uploads (e.g., via FTP).

## Features
HTTP endpoint: Provides the route /filessyncgo
Security: Access protection via a configurable token
Abuse protection: Integrated rate limiter (IP-based) to prevent overload from too many requests
Contao 5 Ready: Fully compatible with Contao 5.3+

### Configuration
#### Set token
Access to the interface requires a token. You can define it in the Contao backend under System → Settings in the "FilesSync" section.

#### Rate limiter (optional)
By default, a rate limiter is enabled that allows a maximum of 5 requests per minute per IP address. The configuration is handled internally by the bundle, but can be overridden via the app’s config/config.yaml if needed.

### Usage
To trigger synchronization, call the URL with your defined token as a GET parameter:
https://your-domain.tld/filessyncgo?token=YOUR_DEFINED_TOKEN

#### Return values
200 OK – Synchronization started successfully

{"success":true,"message":"File sync triggered."}
401 Unauthorized – Token is missing or invalid

{"error":"Invalid token."}
429 Too Many Requests – Too many requests in a short period of time

{"error":"Too many requests. Please try again later."}

#### Technical details
Route: /filessyncgo (Name: syncFiles)
Requirement: PHP ^8.2, Contao ^5.3

#### License
LGPL-3.0-or-later