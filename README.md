# Webhook resolver for GitLab CI
Tool to react on gitlab webhook 

#### Dependencies and used Frameworks
* PHP >= 8
* Composer v2
* Laravel Lumen 9

#### Installation guide
* Deploy to webserver with running PHP version 8.0 or higher
* Run `composer install` in app directory
* Change webroot to `app/public`
* Copy `.env.example` to `.env`
  * Fill all fields beginning with `API_TOKEN` with unique generated string (this token you will need to activate the webhook in GitLab)
  * Adjust the SMTP config for your usage
  * Set `APP_LANGUAGE` to `en` or `de`
* Activate webhook in GitLab, e.g. with this URL: `https://yourdomain.com/pipeline-event/mail?API_TOKEN=add_here_the_token_from_before`