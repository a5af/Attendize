SSO api
---
- /login/sso?user=username&token=********

Limited Documentation available at https://www.attendize.com/documentation.php. Github will be updated with more comprehensive documentation soon.

Docker dev environment
---

To run a docker dev entionment do the following:

```
git clone https://github.com/Attendize/Attendize
cd Attendize
cp .env.example .env
chmod -R a+w storage
chmod -R a+w public/user_content
docker-compose build
docker run --rm -v $(pwd):/app composer/composer install
docker-compose up -d
docker-compose run php php artisan attendize:install
```

Attendize will be available at `http://localhost:8080` and maildev at `http://localhost:1080`
