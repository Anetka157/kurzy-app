# Kurzy App

## Jak spustit projekt

Pro spuštění aplikace na vašem počítači proveďte následující kroky v terminálu:

1. **Klonování repozitáře:**
   ```bash
   git clone https://github.com/Anetka157/kurzy-app.git
   cd kurzy-app
   ```

2. **Instalace závislostí:**
   ```bash
   composer install
   ```

3. **Nastavení prostředí:**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Příprava databáze (SQLite):**
   ```bash
   touch database/database.sqlite
   php artisan migrate
   ```

5. **Spuštění lokálního serveru:**
   ```bash
   php artisan serve
   ```
   Aplikace nyní běží na adrese `http://127.0.0.1:8000`.

## 🧪 Spuštění testů
Pro ověření funkčnosti aplikace můžete spustit automatické testy:
```bash
php artisan test
```
