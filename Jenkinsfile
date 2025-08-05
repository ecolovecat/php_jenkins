pipeline {
    agent any

    stages {
        stage('Clone code') {
            steps {
                git url: 'https://github.com/ecolovecat/php_jenkins.git', branch: 'main'
            }
        }

        stage('Check PHP Syntax') {
            steps {
                sh 'find . -name "*.php" -exec php -l {} \\;'
            }
        }

        stage('Deploy to /var/www/html/LoginSystem') {
            steps {
                sh 'rm -rf /var/www/html/LoginSystem'
                sh 'cp -r . /var/www/html/LoginSystem'
            }
        }
    }
}
