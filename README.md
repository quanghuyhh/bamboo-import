# Config environment
- Config database to connect v1

    `DB_REMOTE_HOST`

    `DB_REMOTE_PORT`

    `DB_REMOTE_DATABASE`

    `DB_REMOTE_USERNAME`

    `DB_REMOTE_PASSWORD`

---
# Import data in portal
- Create `Bamboo` account holder
```bash
php artisan import:portal-account-holder
```

- Import Organizations
```bash
php artisan import:portal-organization
```

- Import Users
```bash
php artisan import:portal-user
```

---

# Import data in sales
- Import distribution list
```bash
php artisan import:distribution
```

- Import Clients
```bash
php artisan import:client
```

- Import Categories
```bash
php artisan import:category
```
