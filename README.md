# Webudvikling bachelorprojekt - Homerunner Statusside
Read me filen har en guide til opsætning af projekt i Docker samt hvordan frontend og backend applikationer kan køre enkeltvis.

---

### **Docker Opsætning**

Følg nedenstående trin for at starte projektet i Docker.

#### **1. Forbered miljøvariabler**
- Gå til `frontend`-mappen:
  - Opret en `.env`-fil og kopier indholdet fra `.env.example`.
- Gå til `backend`-mappen:
  - Opret en `.env`-fil og kopier indholdet fra `.env.example`.

#### **2. Kør Docker-kommandoer**
1. Navigér til backend-mappen:
   ```bash
   cd backend
   composer install
   php artisan key:generate
   cd ..
   ```
2. Byg og start Docker-containere:
   ```bash
   docker compose build
   docker compose up
   ```

---
## For at køre applikationerne enkeltvis
### **Frontend Opsætning**
#### **1. Forbered miljøvariabler**
- I `frontend`-mappen:
  - Opret en `.env`-fil og kopier indholdet fra `.env.example`.

#### **2. Kør frontend-kommandoer**
- Åbn terminalen, navigér til `frontend`-mappen, og kør følgende:
  ```bash
  npm install
  npm run dev
  ```

### **Backend Opsætning**
#### **1. Forbered miljøvariabler**
- I `backend`-mappen:
  - Opret en `.env`-fil og kopier indholdet fra `.env.example`.

#### **2. Kør backend-kommandoer**
- Åbn terminalen, navigér til `backend`-mappen, og kør følgende:
  ```bash
  composer install
  php artisan key:generate
  php artisan migrate
  php artisan db:seed
  ```

---

## **Yderligere Information**
- Sørg for, at Docker er installeret og kører korrekt på din maskine.
- Projektet kræver Node.js og Composer for at kunne bygge og køre frontend og backend udenfor Docker.

