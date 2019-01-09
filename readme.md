# Maker Manager 4

## Getting Going
Installation of MakerManager can be as easy or as complicated as you choose, since it integrates with many various systems you can just ignore what you don't want ot configure. 

### Installation
*This assumes a modern PHP stack is running in your development environment...*

1. `git clone git@github.com:Dallas-Makerspace/makermanager4.git`
2. `cd makermanager4`
3. `composer install`
4. Config local `.env` with the integrations you want 
4. Load either an existing production DB or `database/empty.sql`
5. `php artisan serve`

### URL Routes
- endpoints - All of these routes require WHMCS authentication before access
  - addonActivate - Create/Updates an addon account, gives it a fake entry until user scans a badge
  - addonCancel - "Suspends" a badge, disables AD addon account
  - clientAdd - Webhook from whmcs that creates / updates a user in the local database, and the active directory 
  - clientChangePassword - Webhook, handles a password change update to AD, also handles if the account doesn't exist in AD
  - clientEdit - Updates local maker manager database with new client data from WHMCS, also updates ActiveDirectory
  - invoicePaid - Currently does nothing
#### Modules are primary account bound, incoming data creates a badge directly tied to the account holder
  - moduleCreate - Modules are primary account bound, incoming data creates a badge directly tied to the account holder
  - moduleSuspend - Disable all badges and active directory accounts associated with the service
  - moduleTerminate - Disable all badges and active directory accounts associated with the service and delete all immediate badge records
  - moduleUnsuspend - Enable all badges and active directory accounts associated with the service
  
  
### Test Active Directory Setup
```
docker run \
  --volume /test_ldap_data/schema:/etc/ldap/schema \
  osixia/openldap:1.2.0 --copy-service --loglevel debug

```