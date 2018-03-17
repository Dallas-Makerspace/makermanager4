# Maker Manager 4


### URL Routes
- endpoints - All of these routes require WHMCS authentication before access
  - addonActivate - Create/Updates an addon account, gives it a fake entry until user scans a badge
  - addonCancel - "Suspends" a badge, disables AD addon account
  - clientAdd - Webhook from whmcs that creates / updates a user in the local database, and the active directory 
  - clientChangePassword - Webhook, handles a password change update to AD, also handles if the account doesn't exist in AD
  - clientEdit
  - invoicePaid
  - moduleCreate
  - moduleSuspend
  - moduleTerminate
  - moduleUnsuspend
  
  
### Test Active Directory Setup
```
docker run \
  --volume /test_ldap_data/schema:/etc/ldap/schema \
  osixia/openldap:1.2.0 --copy-service --loglevel debug

```