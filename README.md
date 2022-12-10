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
- type `php artisan key:generate` and hit `enter`
