pipeline {
    agent any

    environment {
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
    }

    post {
        success {
            script {
                emailext(
                    to: 'srengty@gmail.com,sorsonit06@gmail.com',
                    subject: "Build Success: ${env.JOB_NAME} #${env.BUILD_NUMBER}",
                    body: """\
                        Build succeeded for *${env.JOB_NAME}* #${env.BUILD_NUMBER}
                         Project: ${env.GIT_URL}
                         Console Output: ${env.BUILD_URL}
                        """
                )
            }
        }

        failure {
            script {
                emailext(
                    to: 'srengty@gmail.com,sorsonit06@gmail.com',
                    subject: " Build Failed: ${env.JOB_NAME} #${env.BUILD_NUMBER}",
                    body: """\
                        Build failed for *${env.JOB_NAME}* #${env.BUILD_NUMBER}
                        Project: ${env.GIT_URL}
                        Console Output: ${env.BUILD_URL}
                        """
                )
            }
        }
    }
}
