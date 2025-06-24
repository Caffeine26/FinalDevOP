pipeline {
    agent any

    environment {
        CC_EMAIL = 'sorsonit06@gmail.com'
        GIT_URL = 'https://github.com/Caffeine26/FinalDevOP.git'
        BRANCH = 'main'
    }

    triggers {
        pollSCM('H/5 * * * *')
    }

    stages {
        stage('Checkout') {
            steps {
                checkout([$class: 'GitSCM', branches: [[name: "*/${BRANCH}"]],
                          userRemoteConfigs: [[url: "${GIT_URL}"]]])
            }
        }

        stage('Build') {
            steps {
                sh 'composer install --no-interaction --prefer-dist --optimize-autoloader'
                sh 'npm install'
                sh 'npm run build'
            }
        }

        // stage('Test') {
        //     steps {
        //         sh 'php artisan test'
        //     }
        // }

        // stage('Deploy') {
        //     steps {
        //         sh 'ansible-playbook task3.yaml'
        //     }
        // }
    }

    post {
        success {
            script {
                def commitEmail = sh(script: "git log -1 --pretty=format:'%ae'", returnStdout: true).trim()
                emailext(
                    to: commitEmail,
                    cc: env.CC_EMAIL,
                    subject: "✅ Build Success: ${env.JOB_NAME} #${env.BUILD_NUMBER}",
                    body: """\
Build succeeded for ${env.JOB_NAME} #${env.BUILD_NUMBER}.
Project: ${env.GIT_URL}
Check Jenkins console: ${env.BUILD_URL}
"""
                )
            }
        }

        failure {
            script {
                def commitEmail = sh(script: "git log -1 --pretty=format:'%ae'", returnStdout: true).trim()
                emailext(
                    to: commitEmail,
                    cc: env.CC_EMAIL,
                    subject: "❌ Build Failed: ${env.JOB_NAME} #${env.BUILD_NUMBER}",
                    body: """\
Build failed for ${env.JOB_NAME} #${env.BUILD_NUMBER}.
Project: ${env.GIT_URL}
Check Jenkins console: ${env.BUILD_URL}
"""
                )
            }
        }
    }
}
