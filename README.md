# Config environment
- Config database to connect v1

    `DB_REMOTE_HOST`

    `DB_REMOTE_PORT`

    `DB_REMOTE_DATABASE`

    `DB_REMOTE_USERNAME`

    `DB_REMOTE_PASSWORD`

# Install package or copy source code to other project
- install package
```bash
composer require bambooo/import-data
```

- load service provider
```
# Load service provider to bootstrap/app.php
$app->register(Bamboo\ImportData\ImportDataServiceProvider::class);
```

---
# Import data in portal
- Create `Bamboo` account holder
```bash
php artisan import:account-holder
```

- Import Organizations
```bash
php artisan import:organization
```

- Import Users
```bash
php artisan import:user
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
