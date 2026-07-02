pipeline {
    agent any

    stages {
        stage('Prepare Environment') {
            steps {
                sh 'whoami'
                sh 'git config --global --add safe.directory "$WORKSPACE"'
                sh 'cp .env.docker .env'
                sh 'grep -q "^APP_KEY=" .env || printf "\\nAPP_KEY=\\n" >> .env'
            }
        }

        stage('Check Project') {
            steps {
                sh 'pwd'
                sh 'test -f composer.json'
                sh 'test -f package.json'
                sh 'test -f artisan'
            }
        }

        stage('Check Tools') {
            steps {
                sh 'php -v'
                sh 'composer --version'
                sh 'node -v'
                sh 'npm -v'
            }
        }

        stage('Install PHP Dependencies') {
            steps {
                sh 'composer install --no-interaction --prefer-dist'
            }
        }

        stage('Prepare Laravel') {
            steps {
                sh 'php artisan key:generate --force'
                sh 'php artisan config:clear'
                sh 'php artisan cache:clear'
            }
        }

        stage('Install Node Dependencies') {
            steps {
                sh 'npm install'
            }
        }

        stage('Build Assets') {
            steps {
                sh 'rm -rf public/build && mkdir -p public/build && chmod -R 777 public/build'
                sh 'npm run build'
            }
        }

        stage('Test') {
            steps {
                sh 'php artisan test'
            }
        }
    }
}
