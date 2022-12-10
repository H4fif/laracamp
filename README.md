# TOOLS
- php
- composer
- mysql

# HOW TO CLONE
- open terminal / cmd
- move to any directory you want to save the project to
- run this command on the terminal
```markdown
git clone git@github.com:H4fif/laracamp.git
```

# HOW TO START
## SET UP CONFIG
- make sure mysql service is running
- duplicate the file `.env.example` and name it to `.env`
- replace db configurations with prefix `DB_`
- replace google for oauth configurations with prefix `GOOGLE_CLIENT_`

## GENERATE APP KEY
- run this command
```markdown
php artisan key:generate
```


## START THE WEB
- run this command
```markdown
php artisan serve
```

# NOTE
- to enable mail functionality replace the `MAIL_` configurations in the `.env` file to match yours
