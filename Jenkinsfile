pipeline {
    agent any

    environment {
        CC_EMAIL = 'srengty@gmail.com'
        GIT_URL = 'https://github.com/Caffeine26/FinalDevOP.git'
        BRANCH = 'main'
    }

    options {
        pollSCM('H/5 * * * *')  // Poll every 5 minutes
    }

    stages {
        stage('Checkout') {
            steps {
                checkout([$class: 'GitSCM', branches: [[name: "*/${BRANCH}"]], userRemoteConfigs: [[url: "${GIT_URL}"]]])
            }
        }

        stage('Build') {
            steps {
                sh 'composer install --no-interaction --prefer-dist --optimize-autoloader'
                sh 'npm install'
                sh 'npm run build'
            }
        }

        stage('Test') {
            steps {
                sh 'php artisan test'
            }
        }

        stage('Deploy') {
            steps {
                sh 'ansible-playbook task3.yaml'
            }
        }
    }

    post {
        failure {
            script {
                def commitEmail = sh(script: "git log -1 --pretty=format:'%ae'", returnStdout: true).trim()
                emailext(
                    to: commitEmail,
                    cc: env.CC_EMAIL,
                    subject: "Build Failed: ${env.JOB_NAME} #${env.BUILD_NUMBER}",
                    body: "Build failed for ${env.JOB_NAME} #${env.BUILD_NUMBER}. Check Jenkins for details."
                )
            }
        }
    }
}
