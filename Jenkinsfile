// Mailing functions
def success() {
    def imageUrl = 'https://semaphoreci.com/wp-content/uploads/2020/02/cic-cd-explained.jpg'
    def imageWidth = '800px'
    def imageHeight = 'auto'

    echo "Sending success email..."
    emailext(
        body: """
        <html>
        <body>
            <p>The Jenkins job was successful.</p>
            <p>You can view the build at: <a href="${BUILD_URL}">${BUILD_URL}</a></p>
            <p><img src="${imageUrl}" alt="Your Image" width="${imageWidth}" height="${imageHeight}"></p>
        </body>
        </html>
        """,
        subject: "Jenkins Build - Success",
        to: 'medoussemaboussida@gmail.com',
        from: 'medoussemaboussida@gmail.com',
        replyTo: 'medoussemaboussida@gmail.com',
        mimeType: 'text/html'
    )
    echo "Success email sent."
}

def failure() {
    def imageUrl = 'https://miro.medium.com/v2/resize:fit:4800/format:webp/1*ytlj68SIRGvi9mecSDb52g.png'
    def imageWidth = '800px'
    def imageHeight = 'auto'

    echo "Sending failure email..."
    emailext(
        body: """
        <html>
        <body>
            <p>Oops! The Jenkins job Failed.</p>
            <p>You can view the build at: <a href="${BUILD_URL}">${BUILD_URL}</a></p>
            <p><img src="${imageUrl}" alt="Your Image" width="${imageWidth}" height="${imageHeight}"></p>
        </body>
        </html>
        """,
        subject: "Jenkins Build - Failure",
        to: 'medoussemaboussida@gmail.com',
        from: 'medoussemaboussida@gmail.com',
        replyTo: 'medoussemaboussida@gmail.com',
        mimeType: 'text/html'
    )
    echo "Failure email sent."
}

pipeline {
    agent any
    stages {
        stage('Checkout GIT') {
            steps {
                echo 'Pulling ...'
                git branch: 'main',
                    url: 'https://github.com/medoussemaboussida/Laravel_TheStarks_5TWIN7.git'
            }
        }
        stage('Install Composer') {
            steps {
                sh '''
                    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
                    composer --version
                '''
            }
        }
        stage('Composer Install') {
            steps {
                sh 'composer install --no-dev --optimize-autoloader'
            }
        }
        stage('Tests - PHPUnit') {
            steps {
                sh './vendor/bin/phpunit --coverage-clover coverage.xml'
            }
        }
        stage('Build Assets') {
            steps {
                sh 'npm install && npm run build'
            }
        }
        stage('PHPStan Analysis') {
            steps {
                sh './vendor/bin/phpstan analyse'
            }
        }
        stage("SonarQube Analysis") {
            steps {
                withSonarQubeEnv('scanner') {
                    sh 'sonar-scanner'
                }
            }
        }
        stage('Start Prometheus') {
            steps {
                sh 'docker start prometheus'
                echo 'Prometheus started.'
            }
        }
        stage('Start Grafana') {
            steps {
                sh 'docker start grafana'
                echo 'Grafana started.'
            }
        }
    }
    // Mailing functions
    post {
        success {
            script {
                success()
            }
        }
        failure {
            script {
                failure()
            }
        }
    }
}