# Maker Manager 4


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