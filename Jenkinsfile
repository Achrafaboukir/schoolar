pipeline {
    agent any

    environment {
        PROJECT_DIR = '/workspace/schoolar'
    }

    stages {
        stage('Prepare Environment') {
            steps {
                sh 'whoami'
                sh 'git config --global --add safe.directory ${PROJECT_DIR}'
                sh 'cd ${PROJECT_DIR} && cp .env.docker .env'
                sh 'cd ${PROJECT_DIR} && grep -q "^APP_KEY=" .env || printf "\\nAPP_KEY=\\n" >> .env'
                sh 'cd ${PROJECT_DIR} && php artisan key:generate --force'
                sh 'cd ${PROJECT_DIR} && php artisan config:clear'
                sh 'cd ${PROJECT_DIR} && php artisan cache:clear'
            }
        }

        stage('Check Project') {
            steps {
                sh 'cd ${PROJECT_DIR} && pwd'
                sh 'cd ${PROJECT_DIR} && test -f composer.json'
                sh 'cd ${PROJECT_DIR} && test -f package.json'
                sh 'cd ${PROJECT_DIR} && test -f artisan'
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
                sh 'cd ${PROJECT_DIR} && composer install --no-interaction --prefer-dist'
            }
        }

        stage('Install Node Dependencies') {
            steps {
                sh 'cd ${PROJECT_DIR} && npm install'
            }
        }

        stage('Build Assets') {
            steps {
                sh 'cd ${PROJECT_DIR} && rm -rf public/build && mkdir -p public/build && chmod -R 777 public/build'
                sh 'cd ${PROJECT_DIR} && npm run build'
            }
        }

        stage('Test') {
            steps {
                sh 'cd ${PROJECT_DIR} && php artisan test'
            }
        }
    }
}
